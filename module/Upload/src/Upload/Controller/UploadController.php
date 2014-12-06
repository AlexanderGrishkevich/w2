<?php

namespace Upload\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Upload\Model\UploadTable,
    Upload\Model\Upload,
    Post\Model\AttachmentTable;

class UploadController extends AbstractActionController
{
    public function indexAction()
    {
        $uploadTable = new UploadTable($this->getServiceLocator()->get('dbAdapter'));

        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        return array('uploads' => $uploadTable->getUploadsByUserId($user['id']));
    }

    public function addAction()
    {
        $postId = (int) $this->params()->fromRoute('id');
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
            $record = $this->saveFile($request, $user['id']);
            $this->saveAttachment($record->id, $postId);

            $answer = array('status' => 'ok', 'src' => $record->filepath, 'upload_id' => $record->id, 'filename' => $record->filename);
            $response->setContent(\Zend\Json\Json::encode($answer));
            $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
            return $response;
        }
        return array();
    }

    public function saveFile($request, $userId)
    {
        $ds = DIRECTORY_SEPARATOR;
        if (!is_dir('public' . $ds . 'uploads')) {
            mkdir('public' . $ds . 'uploads');
        }

        if (!empty($_FILES)) {
            $files = $request->getFiles()->toArray();
            $file = $files['file'];

            $md5UserId = md5($userId);
            $pathdir = 'public' . $ds . 'uploads' . $ds . $md5UserId . $ds;
            if (!is_dir($pathdir)) {
                mkdir($pathdir);
            }
            $ext = substr($file['name'], strpos($file['name'], '.'));
            $filename = substr($file['name'], 0, strpos($file['name'], '.'));
            $md5Filename = md5($filename . rand(0, 9999)) . $ext;
            $fullFilename = $pathdir . $md5Filename;

            /* validator's */

            move_uploaded_file($file['tmp_name'], $fullFilename);

            //save file information in db
            $uploadTable = new UploadTable($this->getServiceLocator()->get('dbAdapter'));
            $upload = new Upload();
            $upload->filename = $filename;
            $upload->filepath = 'http://' . $_SERVER['SERVER_NAME'] .
                    '/uploads' . '/' . $md5UserId . '/' . $md5Filename;
            $upload->full_filename = $fullFilename;
            $upload->user_id = $userId;
            $upload->type = $file['type'];
            $record = $uploadTable->saveUpload($upload);
            return $record;
        }
    }

    public function saveAttachment($id, $postId)
    {
        $postId = (int) $postId;
        if ($postId) {
            $attachmentTable = new AttachmentTable($this->getServiceLocator()->get('dbAdapter'));
            $attachmentTable->saveAttachment($id, $postId);
        }
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $id = (int) $postData->id;
            $uploadTable = new UploadTable($this->getServiceLocator()->get('dbAdapter'));
            if ($id) {
                $fullFilename = $uploadTable->getUploadById($id)->full_filename;
                $uploadTable->deleteUpload($id);
                $status = 'ok';
                if (file_exists($fullFilename)) {
                    unlink($fullFilename);
                }
            } else {
                $status = 'bad';
            }

            $answer = array('status' => $status);
            $response->setContent(\Zend\Json\Json::encode($answer));
            $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
            return $response;
        }
    }

}