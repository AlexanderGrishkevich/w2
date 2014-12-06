<?php
namespace Banner\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;

use Banner\Model\BannerTable;
 
class SimpleBannerHelper extends AbstractHelper {
    public function __invoke() {

        $dbAdapter = $this->serviceLocator->get('DbAdapter');
        $bannerTable = new BannerTable($dbAdapter);
        $banners = $bannerTable->getActiveBannersByType('simple', 6)->toArray();

        $result = array();

        foreach ($banners as $banner) {
            $result[] = array('url' => '/scripts/timthumb/timthumb.php?src=' . substr($banner['banner_url'], 6) . '&w=120&h=110', 'id' => $banner['user_id']);
        }
        
        return $this->getView()->render('partial/simple', array('banners' => $result));
    }

    public function setServiceLocator(ServiceManager $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }
}