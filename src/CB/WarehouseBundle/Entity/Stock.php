<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CB\WarehouseBundle\Validator\Constraints as CBAssert;

/**
 * Stock
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="CB\WarehouseBundle\Entity\StockRepository")
 * @CBAssert\ValidStockObjectReference
 * 
 */
class Stock
{
    const OBJECT_TYPE_CONTAINER = 0;
    const OBJECT_TYPE_LOCATION = 1;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Containes the stock that has generated this:
     * - If this stock is created, this field is null
     * - If this stock is splitted, the parent is archived into the historical 
     * table and takes the id of the parent
     * - If this stock is merged with others stocks, the parents are archived 
     * into the historical table with the childStockid set to the new stock and 
     * takes null.
     * - If this stock is modified, the parent is archived into the historical 
     * table and takes the id of the parent
     */
    //private $parentStockId;

    /**
     * @var decimal
     *
     * @ORM\Column(name="quantity", type="decimal")
     */
    private $quantity;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="base_quantity", type="decimal")
     */
    private $baseQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="lot", type="string", length=50, nullable=true)
     */
    private $lot;

    /**
     * @var string
     *
     * @ORM\Column(name="sn", type="string", length=100, nullable=true)
     */
    private $sn;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiryDate", type="datetime")
     */
    private $expiryDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bestBeforeDate", type="datetime")
     */
    private $bestBeforeDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="recivedDate", type="datetime")
     */
    private $recivedDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="productionDate", type="datetime")
     */
    private $productionDate;
    
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="stocks")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
    /**
     * Free reference to Container.Id or Location.Id
     * 
     * @var integer
     *
     * @ORM\Column(name="objectId", type="integer")
     */
    private $objectId;
    
    /**
     * Stock type:
     * 0 - Container
     * 1 - Location
     * 
     * @var integer
     *
     * @ORM\Column(name="objectType", type="integer")
     */
    private $objectType;
    
    /**
     * @ORM\ManyToOne(targetEntity="ProductPresentations", inversedBy="stocks")
     * @ORM\JoinColumn(name="presentation_id", referencedColumnName="id")
     */
    protected $presentation;

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
     * Set quantity
     *
     * @param string $quantity
     * @return Stock
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set lot
     *
     * @param string $lot
     * @return Stock
     */
    public function setLot($lot)
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * Get lot
     *
     * @return string 
     */
    public function getLot()
    {
        return $this->lot;
    }

    /**
     * Set sn
     *
     * @param string $sn
     * @return Stock
     */
    public function setSn($sn)
    {
        $this->sn = $sn;

        return $this;
    }

    /**
     * Get sn
     *
     * @return string 
     */
    public function getSn()
    {
        return $this->sn;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->getQuantity());
    }

    /**
     * Set product
     *
     * @param \CB\WarehouseBundle\Entity\Product $product
     * @return Stock
     */
    public function setProduct(\CB\WarehouseBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \CB\WarehouseBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Stock
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
     * @return Stock
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
     * Set expiryDate
     *
     * @param \DateTime $expiryDate
     * @return Stock
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return \DateTime 
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set bestBeforeDate
     *
     * @param \DateTime $bestBeforeDate
     * @return Stock
     */
    public function setBestBeforeDate($bestBeforeDate)
    {
        $this->bestBeforeDate = $bestBeforeDate;

        return $this;
    }

    /**
     * Get bestBeforeDate
     *
     * @return \DateTime 
     */
    public function getBestBeforeDate()
    {
        return $this->bestBeforeDate;
    }

    /**
     * Set recivedDate
     *
     * @param \DateTime $recivedDate
     * @return Stock
     */
    public function setRecivedDate($recivedDate)
    {
        $this->recivedDate = $recivedDate;

        return $this;
    }

    /**
     * Get recivedDate
     *
     * @return \DateTime 
     */
    public function getRecivedDate()
    {
        return $this->recivedDate;
    }

    /**
     * Set productionDate
     *
     * @param \DateTime $productionDate
     * @return Stock
     */
    public function setProductionDate($productionDate)
    {
        $this->productionDate = $productionDate;

        return $this;
    }

    /**
     * Get productionDate
     *
     * @return \DateTime 
     */
    public function getProductionDate()
    {
        return $this->productionDate;
    }

    /**
     * Set objectId
     *
     * @param integer $objectId
     * @return Stock
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
     * @return Stock
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
     * Set baseQuantity
     *
     * @param string $baseQuantity
     * @return Stock
     */
    public function setBaseQuantity($baseQuantity)
    {
        $this->baseQuantity = $baseQuantity;

        return $this;
    }

    /**
     * Get baseQuantity
     *
     * @return string 
     */
    public function getBaseQuantity()
    {
        return $this->baseQuantity;
    }

    /**
     * Set presentation
     *
     * @param \CB\WarehouseBundle\Entity\ProductPresentations $presentation
     * @return Stock
     */
    public function setPresentation(\CB\WarehouseBundle\Entity\ProductPresentations $presentation = null)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return \CB\WarehouseBundle\Entity\ProductPresentations 
     */
    public function getPresentation()
    {
        return $this->presentation;
    }   
    
    /**
     * Compare $this attributes and $otherEntity attributes (except quantity), and return true if they are identical
     * 
     * @param type $otherEntity
     */
    public function equals(Stock $otherEntity)
    {
        if ($this->getBestBeforeDate() == $otherEntity->getBestBeforeDate() &&
            $this->getExpiryDate() == $otherEntity->getExpiryDate() &&
            $this->getLot() == $otherEntity->getLot() &&
            $this->getObjectId() == $otherEntity->getObjectId() &&
            $this->getObjectType() == $otherEntity->getObjectType() &&
            $this->getPresentation() == $otherEntity->getPresentation() &&
            $this->getProduct() == $otherEntity->getProduct() &&
            $this->getSn() == $otherEntity->getSn())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
