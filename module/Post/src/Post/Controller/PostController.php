<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Form\PostForm;
use Post\Form\CommentForm;
use Post\Model\Post;
use Post\Model\PostTable;
use Post\Model\CommentTable;
use Post\Model\FavoriteTable;
use Post\Model\AttachmentTable;
use Upload\Model\UploadTable;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    public function listAction()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        $userId = (int) $this->params()->fromRoute('id', 0);
        if (!$userId) {
            return $this->redirect()->toRoute('application');
        }

        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $posts = $postTable->getPostsByUserId($userId, $user['id'], 10);

        return array(
            'id' => $userId,
            'count' => $posts->count(),
            'posts' => $posts,
            'postTable' => $postTable,
            'authUser' => $user['id']
        );
    }

    public function ajaxListAction()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        $userId = (int) $this->params()->fromQuery('user_id', null);
        $page = (int) $this->params()->fromQuery('page', null);

        $response = $this->getResponse();
        $request = $this->getRequest();

        if (!$userId || !$page) {
            $response->setContent(\Zend\Json\Json::encode(array('error' => true)));
            $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
            return $response;
        }

        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $posts = $postTable->getPostsByUserId($userId, $user['id'], 10, $page);

        if ($posts->count()) {
            $view = new ViewModel(array(
                'count' => $posts->count(),
                'posts' => $posts,
                'postTable' => $postTable,
                'authUser' => $user['id']
            ));

            $view->setTerminal($request->isXmlHttpRequest());
            $view->setTemplate('post/post/list-partial');
            return $view;
        } else {
            $response->setContent(\Zend\Json\Json::encode(array('no_posts' => true)));
            $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
            return $response;
        }
    }

    public function tagsAction()
    {
        $tag = $this->params()->fromQuery('t');
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();

        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $posts = $postTable->getPostsByTag('#' . $tag, $user['id']);

        return array(
            'count' => $posts->count(),
            'posts' => $posts,
            'postTable' => $postTable,
            'authUser' => $user['id']
        );
    }

    public function refreshAction()
    {

        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        if (!$user['id']) {
            return $this->redirect()->toUrl('/register');
        }
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $id = (int) $postData->id;
            if ($id) {
                $postTable->updatePostTime($id, $user['id']);
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'date' => date("d.m.y H:i"));
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $favoriteTable = new FavoriteTable($this->getServiceLocator()->get('dbAdapter'));
        $commentTable = new CommentTable($this->getServiceLocator()->get('dbAdapter'));
        $attachmentTable = new AttachmentTable($this->getServiceLocator()->get('dbAdapter'));
        $uploadTable = new UploadTable($this->getServiceLocator()->get('dbAdapter'));

        if ($request->isPost()) {
            $postData = $request->getPost();
            $postId = (int) $postData->id;
            $rowset = $postTable->deletePost($postId, $user['id']);
            if ($rowset) {
                $favoriteTable->deleteFavorites($postId);
                $commentTable->deleteCommentsByPostId($postId);
                //delete attachments and files
                $files = $attachmentTable->getFiles($postId);
                foreach ($files as $file) {
                    $uploadTable->deleteUpload($file->upload_id);
                    if (file_exists($file->full_filename)) {
                        unlink($file->full_filename);
                    }
                }
                
                $attachmentTable->deleteAttachmentsByPostId($postId);
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'userid' => $user['id']);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function detailsAction()
    {
        $postId = (int) $this->params()->fromRoute('id');
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();

        $commentTable = new CommentTable($this->getServiceLocator()->get('dbAdapter'));
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $post = $postTable->getPostById($postId, $user['id']);

        if (!$post) {
            return $this->redirect()->toUrl('/post/list/' . $user['id']);
        }
        $postComments = $commentTable->fetchAllCommentsByPostId($postId);
        $commentForm = new CommentForm();
        $commentForm->setData(array('post_id' => $postId, 'user_id' => $user['id']));

        $images = $postTable->getImagesByPostId($postId);
        $files = $postTable->getFilesByPostId($postId);
        return array(
            'comments' => $postComments,
            'form' => $commentForm,
            'post' => $post,
            'files' => $files,
            'images' => $images,
            'postTable' => $postTable,
            'authUser' => $user['id']
        );
    }

    public function addAction()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        if (!$user['id']) {
            return $this->redirect()->toUrl('/register');
        }
        //add new, empty, not active post and redirect on edit page
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $post = new Post();
        $post->user_id = $user['id'];
        $id = $postTable->savePost($post);
        return $this->redirect()->toUrl('/post/edit/' . $id[key($id)]);
    }

    public function editAction()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        if (!$user['id']) {
            return $this->redirect()->toUrl('/register');
        }
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));

        $postId = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();
        $postForm = new PostForm();
        $post = $postTable->getPostByIdAndUserId($postId, $user['id']);
        if (!$post) {
            return $this->redirect()->toRoute('application', array('action' => 'index'));
        }
        $postForm->bind($post);

        if ($request->isPost()) {
            $post = new Post();
            $postForm->setData($request->getPost());


            if ($postForm->isValid()) {
                $post = $postForm->getData();
                $post->user_id = $user['id'];
                $post->is_active = 1;
                $postTable->savePost($post);
                return $this->redirect()->toUrl('/post/details/' . $postId);
            }
        }
        $images = $postTable->getImagesByPostId($postId);
        $files = $postTable->getFilesByPostId($postId);
        return array(
            'form' => $postForm,
            'id' => $postId,
            'files' => $files,
            'images' => $images
        );
    }

}