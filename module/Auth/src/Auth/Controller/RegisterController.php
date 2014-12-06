<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel;

use Auth\Form\Register\BaseForm,
	Auth\Form\Register\IndividualForm,
	Auth\Form\Register\LegalForm;

use Auth\Model\User,
	Auth\Model\UserTable;

use Auth\Form\Register\Filter\BaseFilter,
    Auth\Form\Register\Filter\IndividualFilter,
    Auth\Form\Register\Filter\LegalFilter;

use Location\Model\CountryTable,
	Location\Model\RegionTable,
	Location\Model\CityTable;

class RegisterController extends AbstractActionController {

	protected $authservice;

    public function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }
	
	public function showRegisterAction() {
		return new ViewModel();
	}

	public function physicalRegisterAction() {
		$form = new BaseForm();
		$form->get('country')->setOptions(array('value_options' => $this->populateCountry()));
		return new ViewModel(array('form' => $form));
	}

	public function individualRegisterAction() {
		$form = new IndividualForm();
		$form->get('country')->setOptions(array('value_options' => $this->populateCountry()));
		return new ViewModel(array('form' => $form));
	}

	public function legalRegisterAction() {
		$form = new LegalForm();
		$form->get('country')->setOptions(array('value_options' => $this->populateCountry()));
		return new ViewModel(array('form' => $form));
	}

	public function processIndividualAction() {
		if (!$this->request->isPost()) {
			return $this->redirect()->toRoute(NULL, array('controller' => 'register', 'action' => 'individual-register'));
		}

		$post = $this->request->getPost();
		$form = new IndividualForm();
		$form->setInputFilter($this->getServiceLocator()->get('IndividualFilter'));
		$form->get('country')->setOptions(array('value_options' => $this->populateCountry()));
		$form->get('region')->setOptions(array('value_options' => $this->populateRegion()));
		$form->get('city')->setOptions(array('value_options' => $this->populateCity()));
		$form->setData($post);

		if (!$form->isValid()) {
			$model = new ViewModel(array('error' => true, 'form' => $form));
			$model->setTemplate('auth/register/individual-register');
			return $model;
		}

		$data = $form->getData();
		$data['role_id'] = 2;
		$data['state'] = 0;
		$data['display_name'] = $data['org_name'];

		if ($this->createUser($data)) {
			$this->auth($data['email'], $data['password']);
			//return $this->redirect()->toRoute(NULL , array('controller' => 'register','action' => 'confirm'));
		}
	}

	public function processLegalAction() {
		if (!$this->request->isPost()) {
			return $this->redirect()->toRoute(NULL, array('controller' => 'register', 'action' => 'legal-register'));
		}

		$post = $this->request->getPost();
		$form = new LegalForm();
		$form->setInputFilter($this->getServiceLocator()->get('LegalFilter'));
		$form->get('country')->setOptions(array('value_options' => $this->populateCountry()));
		$form->get('region')->setOptions(array('value_options' => $this->populateRegion()));
		$form->get('city')->setOptions(array('value_options' => $this->populateCity()));
		$form->setData($post);

		if (!$form->isValid()) {
			$model = new ViewModel(array('error' => true, 'form' => $form));
			$model->setTemplate('auth/register/legal-register');
			return $model;
		}

		$data = $form->getData();
		$data['role_id'] = 3;
		$data['state'] = 0;
		$data['display_name'] = $data['org_name'];

		if ($this->createUser($data)) {
			$this->auth($data['email'], $data['password']);
			//return $this->redirect()->toRoute(NULL , array('controller' => 'register','action' => 'confirm'));
		}
	}

	public function processPhysicalAction() {
		if (!$this->request->isPost()) {
			return $this->redirect()->toRoute(NULL, array('controller' => 'register', 'action' => 'physical-register'));
		}

		$post = $this->request->getPost();
		$form = new BaseForm();
		$form->setInputFilter($this->getServiceLocator()->get('BaseFilter'));
		$form->get('country')->setOptions(array('value_options' => $this->populateCountry()));
		$form->get('region')->setOptions(array('value_options' => $this->populateRegion()));
		$form->get('city')->setOptions(array('value_options' => $this->populateCity()));
		$form->setData($post);

		if (!$form->isValid()) {
			$model = new ViewModel(array('error' => true, 'form' => $form));
			$model->setTemplate('auth/register/physical-register');
			return $model;
		}

		$data = $form->getData();
		$data['role_id'] = 1;
		$data['state'] = 0;

		if ($this->createUser($data)) {
			$this->auth($data['email'], $data['password']);
			//return $this->redirect()->toRoute(NULL , array('controller' => 'register','action' => 'confirm'));
		}
	}

	public function confirmAction() {
		$viewModel = new ViewModel();
		return $viewModel;
	}

	protected function auth($email, $password) {
		$this->getAuthService()->getAdapter()
            ->setIdentity($email)
            ->setCredential($password);
                                        
        $result = $this->getAuthService()->authenticate();
        $user = $this->getAuthService()->getAdapter()->getResultRowObject();
 
        if ($result->isValid()) {
            $userDataArray = array('id' => $user->id, 'email' => $user->email, 'role' => $user->role_id, 'name' => $user->first_name);
            $this->getAuthService()->getStorage()->write($userDataArray);
            return $this->redirect()->toRoute('home', array());
        }
	}

	protected function populateCountry() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$countryTable = new CountryTable($dbAdapter);

		$arr = array();
		$arr[] = '';
        foreach ($countryTable->fetchAll() as $key => $value) {
            $arr[$value->id] = $value->title;
        }
		return $arr;
	}

	protected function populateRegion() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$regionTable = new RegionTable($dbAdapter);

		$arr = array();
		$arr[] = '';
        foreach ($regionTable->fetchAll() as $key => $value) {
            $arr[$value->id] = $value->title;
        }
		return $arr;
	}

	protected function populateCity() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$cityTable = new CityTable($dbAdapter);

		$arr = array();
		$arr[] = '';
        foreach ($cityTable->fetchAll() as $key => $value) {
            $arr[$value->id] = $value->title;
        }
		return $arr;
	}

	protected function createUser(array $data) {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$user = new User();
		$userTable = new userTable($dbAdapter);
		$user->exchangeArray($data);
		$userTable->saveUser($user);
		return true;
	}
}