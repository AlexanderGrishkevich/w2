<?php
//TODO refactor
namespace Banner\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel;

use Banner\Model\Banner,
	Banner\Model\BannerTable;

use Banner\Form\BannerForm,
	Banner\Form\VipBannerForm,
	Banner\Form\SaleBannerForm;

class BannerController extends AbstractActionController {
	
	public function indexAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$userId = $sm->get('AuthService')->getIdentity()['id'];
        $bannerTable = new BannerTable($dbAdapter);
        $banners = $bannerTable->getBannersByUserId($userId)->toArray();

        $result = array();

        foreach ($banners as $key => $banner) {
        	switch ($banner['type']) {
        		case 'simple':
        			$result['simple'] = true;
        			break;
        		case 'footer':
        			$result['footer'] = true;
        			break;
        		case 'vip':
        			$result['vip'] = true;
        			break;
        		default:
        			break;
        	}
        }

		return new ViewModel(array('currentBanner' => $result));
	}

	public function addSimpleAction() {
		$form = new BannerForm();
		return new ViewModel(array('form' => $form));
	}
        
	public function addVipAction() {
		$form = new VipBannerForm();
		return new ViewModel(array('form' => $form));
	}

	public function addFooterAction() {
		$form = new BannerForm();
		return new ViewModel(array('form' => $form));
	}

	public function processSimpleAction() {
		$sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
		$form = new BannerForm();

	    $request = $this->getRequest();
	    if ($request->isPost()) {
	        $post = array_merge_recursive(
	            $request->getPost()->toArray(),
	            $request->getFiles()->toArray()
	        );

	        $form->setData($post);
	        if ($form->isValid()) {
	            $data = $form->getData();

	            $userId = $sm->get('AuthService')->getIdentity()['id'];
	            $file = $this->saveBanner($data, 'simple', $userId);

	           	$banner = new Banner();
	           	$banner->exchangeArray($data);
	           	$banner->banner_url = $file;
	           	$banner->type = 'simple';
	           	$banner->user_id = $userId;
	            
	            $bannerTable = new BannerTable($dbAdapter);
                $bannerTable->insertOrUpdateBanner($banner, $userId, 'simple');

	            return $this->redirect()->toRoute('banner');
	        }
	    }
    }

    public function processFooterAction() {
		$sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
		$form = new BannerForm();

	    $request = $this->getRequest();
	    if ($request->isPost()) {
	        $post = array_merge_recursive(
	            $request->getPost()->toArray(),
	            $request->getFiles()->toArray()
	        );

	        $form->setData($post);
	        if ($form->isValid()) {
	            $data = $form->getData();

	            $userId = $sm->get('AuthService')->getIdentity()['id'];
	            $file = $this->saveBanner($data, 'footer', $userId);
	            if ($file) {
					$banner = new Banner();
		           	$banner->exchangeArray($data);
		           	$banner->banner_url = $file;
		           	$banner->type = 'footer';
		           	$banner->user_id = $userId;
		            
		            $bannerTable = new BannerTable($dbAdapter);
	                $bannerTable->insertOrUpdateBanner($banner, $userId, 'footer');

		            return $this->redirect()->toRoute('banner');	            	
	            }
	        }
	    }    	
    }

    public function processVipAction() {
		$sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
		$form = new VipBannerForm();

	    $request = $this->getRequest();
	    if ($request->isPost()) {
	        $post = array_merge_recursive(
	            $request->getPost()->toArray(),
	            $request->getFiles()->toArray()
	        );

	        $form->setData($post);
	        if ($form->isValid()) {
	            $data = $form->getData();

	            $userId = $sm->get('AuthService')->getIdentity()['id'];
	            $file = $this->saveBanner($data, 'vip', $userId);

	           	$banner = new Banner();
	           	$banner->exchangeArray($data);
	           	$banner->banner_url = $file;
	           	$banner->type = 'vip';
	           	$banner->user_id = $userId;
	            
	            $bannerTable = new BannerTable($dbAdapter);
                $bannerTable->insertOrUpdateBanner($banner, $userId, 'vip');

	            return $this->redirect()->toRoute('banner');
	        }
	    }    	
    }

    protected function saveBanner($file, $type, $userId) {
		$httpadapter = new \Zend\File\Transfer\Adapter\Http(); 
        $filesize  = new \Zend\Validator\File\Size(array('max' => '1MB'));
        $extension = new \Zend\Validator\File\Extension(array('jpeg', 'jpg', 'png'));
        $httpadapter->setValidators(array($filesize, $extension), $file['file']['name']);
        if ($httpadapter->isValid()) {

            $pathdir = 'public/uploads/banners/' . md5($userId) . '/' . $type;
   
            if (!is_dir($pathdir)) {
            	mkdir($pathdir, 0777, true);
            }      

            if (file_exists($pathdir)) {
	            foreach (glob($pathdir . '/*') as $entry) {
	                unlink($entry);
	            }           	
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
            
                if($httpadapter->receive($info['name'])) {
                    $newfile = $httpadapter->getFileName(); 
                    return str_replace('\\', '/', $newfile); 
                }
            }
		}
    }

}