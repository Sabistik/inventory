<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/** 
 * @ORM\Entity
 * @ORM\Table(name="item")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Item {
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    /**
    * @ORM\ManyToOne(targetEntity="Product", inversedBy="items")
    * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
    * @Serializer\MaxDepth(3)
    **/
    protected $product;
    
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="items")
     * @ORM\JoinTable(name="items_tags")
     * @Serializer\MaxDepth(2)
     */
    protected $tags;

    /** @ORM\Column(type="datetime", name="created_at") */
    protected $createdAt;
    
    /** @ORM\Column(type="datetime", name="deleted_at", nullable=true) */
    protected $deletedAt;
    
    /** @ORM\Column(type="date", name="expiration_date", nullable=true) */
    protected $expirationDate;
    
    /**
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id", nullable=true)
     **/
    protected $place;
    
    /** @ORM\Column(type="text", nullable=true) */
    protected $note;
    
    /** @ORM\Column(type="boolean") */
    protected $opened;
    
    public function __construct() {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    
    public function getProduct()
    {
        return $this->product;
    }
    
    public function setProduct($oProduct)
    {
        $this->product = $oProduct;
    }
    
    public function getTags()
    {
        return $this->tags;
    }
    
    public function addTag($oTag)
    {
        $oTag->addItem($this);
        $this->tags[] = $oTag;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt($oDataTime)
    {
        $this->createdAt = $oDataTime;
    }
    
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
    
    public function setDeletedAt($oDataTime)
    {
        $this->deletedAt = $oDataTime;
    }
    
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }
    
    public function setExpirationDate($oDataTime)
    {
        $this->expirationDate = $oDataTime;
    }
    
    public function getPlace()
    {
        return $this->place;
    }
    
    public function setPlace($oPlace)
    {
        $this->place = $oPlace;
    }
    
    public function getNote()
    {
        return $this->note;
    }
    
    public function setNote($sNote)
    {
        $this->note = $sNote;
    }
    
    public function getOpened()
    {
        return $this->opened;
    }
    
    public function setOpened($bOpened)
    {
        $this->opened = $bOpened;
    }
    
    
    /** @ORM\PrePersist */
    public function onCreate()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setOpened(false);
    }
    
    /*public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'product' => $this->getProduct()->toArray(),
            'tags' => '', // @TODO
            'createdAt' => $this->getCreatedAt(),
            'deletedAt' => $this->getDeletedAt(),
            'expirationDate' => $this->getExpirationDate(),
            'place' => '', // @TODO
            'note' => $this->getNote(),
            'opened' => $this->getOpened(),
        );
    }*/
    
}

