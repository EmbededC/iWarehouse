<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPresentations
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProductPresentations
{
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var decimal
     *
     * @ORM\Column(name="baseUnitQuantity", type="decimal")
     */
    private $baseUnitQuantity;
    
        /**
     * @var decimal
     *
     * @ORM\Column(name="weight", type="decimal")
     */
    private $weight;

    /**
     * @var decimal
     *
     * @ORM\Column(name="sizeX", type="decimal")
     */
    private $sizeX;

    /**
     * @var decimal
     *
     * @ORM\Column(name="sizeY", type="decimal")
     */
    private $sizeY;

    /**
     * @var decimal
     *
     * @ORM\Column(name="sizeZ", type="integer")
     */
    private $sizeZ;


    /**
     * @var boolean
     *
     * @ORM\Column(name="canDivide", type="boolean")
     */
    private $canDivide;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isPreferred", type="boolean")
     */
    private $isPreferred;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isBase", type="boolean")
     */
    private $isBase;

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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="presentations")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
    /**
     * @ORM\OneToMany(targetEntity="Stock", mappedBy="presentation")
     */
    protected $stocks;


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
     * Set name
     *
     * @param string $name
     * @return ProductPresentations
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ProductPresentations
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return ProductPresentations
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
     * Constructor
     */
    public function __construct()
    {
        $this->stocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set product
     *
     * @param \CB\WarehouseBundle\Entity\Product $product
     * @return ProductPresentations
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
     * Set weight
     *
     * @param string $weight
     * @return ProductPresentations
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set sizeX
     *
     * @param string $sizeX
     * @return ProductPresentations
     */
    public function setSizeX($sizeX)
    {
        $this->sizeX = $sizeX;

        return $this;
    }

    /**
     * Get sizeX
     *
     * @return string 
     */
    public function getSizeX()
    {
        return $this->sizeX;
    }

    /**
     * Set sizeY
     *
     * @param string $sizeY
     * @return ProductPresentations
     */
    public function setSizeY($sizeY)
    {
        $this->sizeY = $sizeY;

        return $this;
    }

    /**
     * Get sizeY
     *
     * @return string 
     */
    public function getSizeY()
    {
        return $this->sizeY;
    }

    /**
     * Set sizeZ
     *
     * @param integer $sizeZ
     * @return ProductPresentations
     */
    public function setSizeZ($sizeZ)
    {
        $this->sizeZ = $sizeZ;

        return $this;
    }

    /**
     * Get sizeZ
     *
     * @return integer 
     */
    public function getSizeZ()
    {
        return $this->sizeZ;
    }

    /**
     * Set canDivide
     *
     * @param boolean $canDivide
     * @return ProductPresentations
     */
    public function setCanDivide($canDivide)
    {
        $this->canDivide = $canDivide;

        return $this;
    }

    /**
     * Get canDivide
     *
     * @return boolean 
     */
    public function getCanDivide()
    {
        return $this->canDivide;
    }

    /**
     * Set isPreferred
     *
     * @param boolean $isPreferred
     * @return ProductPresentations
     */
    public function setIsPreferred($isPreferred)
    {
        $this->isPreferred = $isPreferred;

        return $this;
    }

    /**
     * Get isPreferred
     *
     * @return boolean 
     */
    public function getIsPreferred()
    {
        return $this->isPreferred;
    }

    /**
     * Set isBase
     *
     * @param boolean $isBase
     * @return ProductPresentations
     */
    public function setIsBase($isBase)
    {
        $this->isBase = $isBase;

        return $this;
    }

    /**
     * Get isBase
     *
     * @return boolean 
     */
    public function getIsBase()
    {
        return $this->isBase;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return ProductPresentations
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Set baseUnitQuantity
     *
     * @param string $baseUnitQuantity
     * @return ProductPresentations
     */
    public function setBaseUnitQuantity($baseUnitQuantity)
    {
        $this->baseUnitQuantity = $baseUnitQuantity;

        return $this;
    }

    /**
     * Get baseUnitQuantity
     *
     * @return string 
     */
    public function getBaseUnitQuantity()
    {
        return $this->baseUnitQuantity;
    }

    /**
     * Add stocks
     *
     * @param \CB\WarehouseBundle\Entity\Stock $stocks
     * @return ProductPresentations
     */
    public function addStock(\CB\WarehouseBundle\Entity\Stock $stocks)
    {
        $this->stocks[] = $stocks;

        return $this;
    }

    /**
     * Remove stocks
     *
     * @param \CB\WarehouseBundle\Entity\Stock $stocks
     */
    public function removeStock(\CB\WarehouseBundle\Entity\Stock $stocks)
    {
        $this->stocks->removeElement($stocks);
    }

    /**
     * Get stocks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStocks()
    {
        return $this->stocks;
    }
    
    /**
     * @return string 
     */
    public function __toString()
    {
        return $this->name ." (". $this->description . ")";
    }
}
