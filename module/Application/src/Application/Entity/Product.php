<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/** 
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks
 */
class Product {
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    protected $id;
    
     /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="product")
     **/
    protected $items;
    
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="products")
     * @ORM\JoinTable(name="products_tags")
     * @Serializer\MaxDepth(2)
     */
    protected $tags;


    /** @ORM\Column(type="datetime", name="created_at") */
    protected $createdAt;

    /** @ORM\Column(length=200, nullable=true) */
    protected $name;
    
    /** @ORM\Column(type="bigint", name="barcode_number") */
    protected $barcodeNumber;
    
    /** @ORM\Column(type="text", nullable=true) */
    protected $description;
    
    public function __construct() {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($sName)
    {
        $this->name = $sName;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt($time)
    {
        $this->createdAt = $time;
    }
    
    public function getBarcodeNumber()
    {
        return $this->barcodeNumber;
    }
    
    public function setBarcodeNumber($iNumber)
    {
        $this->barcodeNumber = $iNumber;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($sDescription)
    {
        $this->description = $sDescription;
    }
    
    public function getTags()
    {
        return $this->tags;
    }
    
    public function addTag($oTag)
    {
        $oTag->addProduct($this);
        $this->tags[] = $oTag;
    }
    
    public function getItems()
    {
        return $this->items;
    }
    
    /*public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'createdAt' => $this->getCreatedAt(),
            'name' => $this->getName(),
            'barcodeNumber' => $this->getBarcodeNumber(),
            'description' => $this->getDescription()
        );
    }*/
    
    
    /** @ORM\PrePersist */
    public function onCreate()
    {
        $this->setCreatedAt(new \DateTime());
    }
}

