<?php

namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="place")
 */
class Place {
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    /** @ORM\Column(length=200) */
    protected $name;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($sName)
    {
        $this->name = $sName;
    }
    
}

