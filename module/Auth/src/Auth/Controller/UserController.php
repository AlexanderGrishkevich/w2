<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use Auth\Model\UserTable,
    Auth\Model\User;

class UserController extends AbstractActionController {
    public function updateAvatarAction() {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
        $request = $this->getRequest();

        if (!$sm->get('AuthService')->hasIdentity()) {
            $answer = array('status' => 'error');
        } else {
            if ($request->isPost()) {
                $files = $request->getFiles()->toArray();
                $userId = $sm->get('AuthService')->getIdentity()['id'];
                $file = $this->saveAvatar($files, $userId);
                if ($file) {
                    $userTable = new UserTable($dbAdapter);
                    $userTable->updateAvatar($file, $userId);
                    $answer = array('status' => 'ok', 'filename' => $file);
                }
            }
        }

        $response = $this->getResponse();
        $response->setContent(json_encode($answer, JSON_UNESCAPED_UNICODE));
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }

    protected function saveAvatar($file, $userId) {
        $httpadapter = new \Zend\File\Transfer\Adapter\Http();
        $filesize = new \Zend\Validator\File\Size(array('min' => '1kB', 'max' => '1MB'));
        $extension = new \Zend\Validator\File\Extension(array('jpeg', 'jpg', 'png'));
        $httpadapter->setValidators(array($filesize, $extension), $file['file']['name']);
        if ($httpadapter->isValid()) {

            $pathdir = 'public/uploads/avatars/' . md5($userId);
            if (!is_dir($pathdir)) {
                mkdir($pathdir);
            }

            if (file_exists($pathdir))
                foreach (glob($pathdir . '/*') as $entry) {
                    unlink($entry);
                }

            $httpadapter->setDestination($pathdir);
            foreach ($httpadapter->getFileInfo() as $info) {
                $httpadapter->addFilter('File\Rename', 
                    array(
                        'target' => $httpadapter->getDestination() . '/' . str_replace(' ', '_', $file['file']['name']),
                        'overwrite' => true,
                        'randomize' => true
                    )
                );

                if ($httpadapter->receive($info['name'])) {
                    $newfile = $httpadapter->getFileName();
                    return str_replace('\\', '/', $newfile);
                }
            }
        }
    }

}