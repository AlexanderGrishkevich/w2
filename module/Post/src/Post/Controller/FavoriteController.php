<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Model\FavoriteTable;
use Post\Model\PostTable;

class FavoriteController extends AbstractActionController {

    public function favoriteAction() {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        if (!$user['id']) {
            return $this->redirect()->toUrl('/register');
        }
        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $postId = (int) $postData->id;
            if ($postId) {
                $favoriteTable = new FavoriteTable($this->getServiceLocator()->get('dbAdapter'));
                $value = $favoriteTable->favoritePost($postId, $user['id']);
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'value' => $value);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function deleteAction() {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
            $favoriteData = $request->getPost();
            $postId = (int) $favoriteData->postId;
            $favoriteTable = new FavoriteTable($this->getServiceLocator()->get('dbAdapter'));
            $rowset = $favoriteTable->deleteFavorite($postId, $user['id']);
            if ($rowset) {
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

    public function listAction() {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        if (!$user['id']) {
            return $this->redirect()->toUrl('/register');
        }
        $favoriteTable = new FavoriteTable($this->getServiceLocator()->get('dbAdapter'));
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $favorites = $favoriteTable->fetchAllByUserId($user['id']);

        return array(
            'postTable' => $postTable,
            'favorites' => $favorites
        );
    }

}
