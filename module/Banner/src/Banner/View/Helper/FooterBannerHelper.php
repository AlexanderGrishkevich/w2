<?php
namespace Banner\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;

use Banner\Model\BannerTable;
 
class footerBannerHelper extends AbstractHelper {
    public function __invoke() {

        $dbAdapter = $this->serviceLocator->get('DbAdapter');
        $bannerTable = new BannerTable($dbAdapter);
        $banners = $bannerTable->getActiveBannersByType('footer', 10)->toArray();

        $result = array();

        foreach ($banners as $banner) {
            $result[] = array('url' => '/scripts/timthumb/timthumb.php?src=' . substr($banner['banner_url'], 6) . '&w=145&h=35', 'id' => $banner['user_id']);
        }
        
        return $this->getView()->render('partial/footer', array('banners' => $result));
    }

    public function setServiceLocator(ServiceManager $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }
}