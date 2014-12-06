<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;
use Dialog\Model\DialogTable; 
use Auth\Model\UserTable;
 
class UserWidget extends AbstractHelper {
    public function __invoke(){
        $this->authService = $this->serviceLocator->get('AuthService');
        if($this->authService->hasIdentity()){
            $userTable = new UserTable($this->serviceLocator->get('DbAdapter'));
            $user = $userTable->getUser($this->authService->getIdentity()['id']);
            
            $dialogTable = new DialogTable($this->serviceLocator->get('DbAdapter'));
            $countMessages = $dialogTable->getNewDialogsCountByUserId($user->id);
            
            $avatar = '/scripts/timthumb/timthumb.php?src=' . substr($user->avatar ? $user->avatar : 'public/img/no-avatar.png', 6) . '&w=50&h=50'; //remove public in path name

            return $this->getView()->render('partial/user', array('user' => $user, 'avatar' => $avatar, 'count' => $countMessages));
        }
        else {
            return $this->getView()->render('partial/user', array(''));
        }
    }

    public function setServiceLocator(ServiceManager $serviceLocator){
        $this->serviceLocator = $serviceLocator;
    }
}