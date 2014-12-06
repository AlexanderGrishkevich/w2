<?php

namespace Auth\Model;

class User {

	public $id;
	public $username;
	public $display_name;
	public $email;
	public $password;
	public $state;
	public $create_date;
	public $off_date;
	public $reg_type;
	public $org_name;
	public $position;
	public $last_name;
	public $middle_name;
	public $first_name;
	public $country;
	public $city;
	public $region;
	public $zip;
	public $street;
	public $house;
	public $office;
	public $phone;
	public $unp;
	public $egr_date;
	public $egr_num;
	public $egr_org;
	public $bank;
	public $bank_code;
	public $bank_address;
	public $bank_acc;
	public $role_id;
	public $avatar;

	public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : NULL;
        $this->username = (isset($data['username'])) ? $data['username'] : NULL;
        $this->display_name = (isset($data['display_name'])) ? $data['display_name'] : NULL;
        $this->email = (isset($data['email'])) ? $data['email'] : NULL;
        $this->password = (isset($data['password'])) ? $data['password'] : NULL;
        $this->state = (isset($data['state'])) ? $data['state'] : NULL;
        $this->create_date = (isset($data['create_date'])) ? $data['create_date'] : NULL;
        $this->off_date = (isset($data['off_date'])) ? $data['off_date'] : NULL;
        $this->reg_type = (isset($data['reg_type']) ? $data['reg_type'] : null);
        $this->org_name = (isset($data['org_name']) ? $data['org_name'] : null);
        $this->position = (isset($data['position']) ? $data['position'] : null);
        $this->last_name = (isset($data['last_name']) ? $data['last_name'] : null);
        $this->first_name = (isset($data['first_name']) ? $data['first_name'] : null);
        $this->middle_name = (isset($data['middle_name']) ? $data['middle_name'] : null);
        $this->country = (isset($data['country']) ? $data['country'] : null);
        $this->city = (isset($data['city']) ? $data['city'] : null);
        $this->region = (isset($data['region']) ? $data['region'] : null);
        $this->zip = (isset($data['zip']) ? $data['zip'] : null);
        $this->street = (isset($data['street']) ? $data['street'] : null);
        $this->house = (isset($data['house']) ? $data['house'] : null);
        $this->office = (isset($data['office']) ? $data['office'] : null);
        $this->phone = (isset($data['phone']) ? $data['phone'] : null);
        $this->unp = (isset($data['unp']) ? $data['unp'] : null);
        $this->egr_org = (isset($data['egr_org']) ? $data['egr_org'] : null);
        $this->egr_num = (isset($data['egr_num']) ? $data['egr_num'] : null);
        $this->egr_date = (isset($data['egr_date']) ? $data['egr_date'] : null);
        $this->bank = (isset($data['bank']) ? $data['bank'] : null);
        $this->bank_code = (isset($data['bank_code']) ? $data['bank_code'] : null);
        $this->bank_address = (isset($data['bank_address']) ? $data['bank_address'] : null);
        $this->bank_acc = (isset($data['bank_acc']) ? $data['bank_acc'] : null);
        $this->role_id = (isset($data['role_id'])) ? $data['role_id'] : NULL;
        $this->avatar = (isset($data['avatar'])) ? $data['avatar'] : NULL;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

	public function setPassword($password) {
		$this->password = md5($password);
	}    

}