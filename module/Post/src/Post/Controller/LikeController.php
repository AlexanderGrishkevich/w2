<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Post\Model\LikeTable;
use Post\Model\Like;

class LikeController extends AbstractActionController
{

    public function likeAction()
    {
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
                $likeTable = new LikeTable($this->getServiceLocator()->get('dbAdapter'));
                $value = $likeTable->likePost($postId, $user['id']);
                $countLikes = $likeTable->countLikes($postId);
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status, 'countLikes' => $countLikes, 'value' => $value);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        return $response;
    }

}