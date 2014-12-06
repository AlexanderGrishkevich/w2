<?php
namespace Banner\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;

use Banner\Model\BannerTable;
 
class MainBannerHelper extends AbstractHelper {
    public function __invoke() {

        $dbAdapter = $this->serviceLocator->get('DbAdapter');
        $bannerTable = new BannerTable($dbAdapter);
        $banners = $bannerTable->getMainBanner()->toArray();

        $result = array();

        foreach ($banners as $banner) {
            $result[] = array(
                'url' => '/scripts/timthumb/timthumb.php?src=' . substr($banner['banner_url'], 6) . '&w=810&h=380', 
                'id' => $banner['user_id'], 'type' => $banner['type'],
                'likes' => $banner['count_likes']
            );
        }
        
        return $this->getView()->render('partial/main', array('banners' => $result));
    }

    public function setServiceLocator(ServiceManager $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }
}