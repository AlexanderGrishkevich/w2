<?php
namespace Banner\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;

use Banner\Model\BannerTable;
 
class VipBannerHelper extends AbstractHelper {
    public function __invoke() {

        $dbAdapter = $this->serviceLocator->get('DbAdapter');
        $bannerTable = new BannerTable($dbAdapter);
        $banners = $bannerTable->getActiveBannersByType('vip', 2)->toArray();

        $result = array();

        foreach ($banners as $banner) {
            $result[] = array(
                'url' => '/scripts/timthumb/timthumb.php?src=' . substr($banner['banner_url'], 6) . '&w=115&h=110',
                'id' => $banner['user_id'],
                'title' => $banner['title'],
                'price' => $banner['price']
            );
        }
        
        return $this->getView()->render('partial/vip', array('banners' => $result));
    }

    public function setServiceLocator(ServiceManager $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }
}