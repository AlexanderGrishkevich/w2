<?php

namespace Category\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="category")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $category_id;

    /**
     * @ORM\Column(type="integer")  
     */
    public $user_id;

    /**
     * @ORM\Column(type="integer", nullable=true)  
     */
    public $parent_id;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    public $title;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    public $description;

    /**
     * @ORM\Column(type="text", nullable=true) 
     */
    protected $create_date;

    public function __construct($data = null) {
        if ($data) {
            $this->exchangeArray($data);
        }
    }

    public function exchangeArray($data) {
        $vars = $this->getArrayCopy();
        for ($i = 0; $i < count($vars); $i++) {
            $varName = key($vars);
            $this->$varName = (isset($data[$varName])) ? $data[$varName] : $this->$varName;
            next($vars);
        }
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function get($varName) {
        $vars = $this->getArrayCopy();
        return $vars[$varName];
    }
}
