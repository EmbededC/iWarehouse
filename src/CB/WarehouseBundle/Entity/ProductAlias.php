<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CB\WarehouseBundle\Validator\Constraints as CBAssert;

/**
 * ProductAlias
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @CBAssert\ValidProductAliasObjectReference
 */
class ProductAlias
{
    const OBJECT_TYPE_PRODUCT = 0;
    const OBJECT_TYPE_PRESENTATION = 1;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, unique = true)
     */
    private $code;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedDate", type="datetime")
     */
    private $updatedDate;
    
    
    /**
     * Free reference to Product.Id or ProductPresentation.Id
     * 
     * @var integer
     *
     * @ORM\Column(name="objectId", type="integer")
     */
    private $objectId;
    
    /**
     * Alias type:
     * 0 - Product 
     * 1 - Presentation
     * 
     * @var integer
     *
     * @ORM\Column(name="objectType", type="integer")
     */
    private $objectType;
    


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return ProductAlias
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return ProductAlias
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set updatedDate
     *
     * @param \DateTime $updatedDate
     * @return ProductAlias
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    /**
     * Get updatedDate
     *
     * @return \DateTime 
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * Set objectId
     *
     * @param integer $objectId
     * @return ProductAlias
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Get objectId
     *
     * @return integer 
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Set objectType
     *
     * @param integer $objectType
     * @return ProductAlias
     */
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;

        return $this;
    }

    /**
     * Get objectType
     *
     * @return integer 
     */
    public function getObjectType()
    {
        return $this->objectType;
    }
    
    /**
     * @return string 
     */
    public function __toString()
    {
        return $this->code;
    }
    
    /**
     * Constructor
     */
    public function __construct() {
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->setCreatedDate(new \DateTime());
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->setUpdatedDate(new \DateTime());
    }
}
