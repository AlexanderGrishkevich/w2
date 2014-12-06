<?php
// TODO refactor
namespace Location\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel;

use Location\Model\CountryTable,
	Location\Model\RegionTable,
	Location\Model\CityTable;

class LocationController extends AbstractActionController {
	
	public function getCountryAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$countryTable = new CountryTable($dbAdapter);
		
		$countries = $countryTable->fetchAllToArray();

		$response = $this->getResponse();
 		$response->setContent(json_encode($countries, JSON_UNESCAPED_UNICODE));
		$response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
 		return $response;	
	}

	public function getRegionAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$regionTable = new RegionTable($dbAdapter);
		
		$regions = $regionTable->fetchAllByCountryId($this->params()->fromPost('country_id'));

		$response = $this->getResponse();
 		$response->setContent(json_encode($regions->toArray(), JSON_UNESCAPED_UNICODE));
		$response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
 		return $response;	
	}

	public function getCityAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$cityTable = new CityTable($dbAdapter);
		
		$cities = $cityTable->fetchAllByRegionId($this->params()->fromPost('region_id'));

		$response = $this->getResponse();
 		$response->setContent(json_encode($cities->toArray(), JSON_UNESCAPED_UNICODE));
		$response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
 		return $response;	
	}
        
        public function getRegionByTitleAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$regionTable = new RegionTable($dbAdapter);
		
		$regions = $regionTable->fetchAllByCountryTitle($this->params()->fromPost('country'));

		$response = $this->getResponse();
 		$response->setContent(json_encode($regions->toArray(), JSON_UNESCAPED_UNICODE));
		$response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
 		return $response;	
	}

	public function getCityByTitleAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$cityTable = new CityTable($dbAdapter);
		
		$cities = $cityTable->fetchAllByRegionTitle($this->params()->fromPost('region'));

		$response = $this->getResponse();
 		$response->setContent(json_encode($cities->toArray(), JSON_UNESCAPED_UNICODE));
		$response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
 		return $response;	
	}
}