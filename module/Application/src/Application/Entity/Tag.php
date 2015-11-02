<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
#use JMS\Serializer\Annotation\Exclude;
#use JMS\Serializer\Annotation\Expose;

/** 
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag {
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    /** @ORM\Column(length=200) */
    protected $name;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Item", mappedBy="tags")
     * @Serializer\MaxDepth(2)
     */
    protected $items;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="tags")
     * @Serializer\MaxDepth(2)
     */
    protected $products;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($sName)
    {
        $this->name = $sName;
    }
    
    public function addProduct($oProduct)
    {
        $this->products[] = $oProduct;
    }
    
    
    public function addItem($oItem)
    {
        $this->items[] = $oItem;
    }
}

