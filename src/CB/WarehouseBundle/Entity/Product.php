<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSA;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=50, unique = true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDesc", type="string", length=255, nullable=true)
     */
    private $shortDesc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lot_required_in_reception", type="boolean")
     */
    private $lotRequiredInReception;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lot_required_in_expedition", type="boolean")
     */
    private $lotRequiredInExpedition;

    /**
     * @var boolean
     *
     * @ORM\Column(name="snRequiredInReception", type="boolean")
     */
    private $snRequiredInReception;

    /**
     * @var boolean
     *
     * @ORM\Column(name="snRequiredInExpedition", type="boolean")
     */
    private $snRequiredInExpedition;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedDate", type="datetime", nullable=true)
     */
    private $updatedDate;

    /**
     * @ORM\OneToMany(targetEntity="Stock", mappedBy="product")
     * @JMSA\Exclude
     */
    protected $stocks;
    
    /**
     * @ORM\OneToMany(targetEntity="ProductPresentations", mappedBy="product")
     * @JMSA\Exclude
     */
    protected $presentations;
    
    /**
     * @ORM\ManyToOne(targetEntity="ProductBaseUnit", inversedBy="products")
     * @ORM\JoinColumn(name="baseUnit_id", referencedColumnName="id")
     * @JMSA\MaxDepth(1)
     */
    protected $baseUnit;
    
    /**
     * @var string
     * 
     * Attribute with a regular expression to validate the stock lot
     *
     * @ORM\Column(name="lotMask", type="string", length=255, nullable=true)
     */
    private $lotMask;
    
    /**
     * @var string
     * 
     * Attribute with a regular expression to validate the stock serial number
     *
     * @ORM\Column(name="snMask", type="string", length=255, nullable=true)
     */
    private $snMask;


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
     * @return Product
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
     * @return Product
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
     * Set shortDesc
     *
     * @param string $shortDesc
     * @return Product
     */
    public function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;

        return $this;
    }

    /**
     * Get shortDesc
     *
     * @return string 
     */
    public function getShortDesc()
    {
        return $this->shortDesc;
    }

    /**
     * Set lotRequiredInReception
     *
     * @param boolean $lotRequiredInReception
     * @return Product
     */
    public function setLotRequiredInReception($lotRequiredInReception)
    {
        $this->lotRequiredInReception = $lotRequiredInReception;

        return $this;
    }

    /**
     * Get lotRequiredInReception
     *
     * @return boolean 
     */
    public function getLotRequiredInReception()
    {
        return $this->lotRequiredInReception;
    }

    /**
     * Set lotRequiredInExpedition
     *
     * @param boolean $lotRequiredInExpedition
     * @return Product
     */
    public function setLotRequiredInExpedition($lotRequiredInExpedition)
    {
        $this->lotRequiredInExpedition = $lotRequiredInExpedition;

        return $this;
    }

    /**
     * Get lotRequiredInExpedition
     *
     * @return boolean 
     */
    public function getLotRequiredInExpedition()
    {
        return $this->lotRequiredInExpedition;
    }

    /**
     * Set snRequiredInReception
     *
     * @param boolean $snRequiredInReception
     * @return Product
     */
    public function setSnRequiredInReception($snRequiredInReception)
    {
        $this->snRequiredInReception = $snRequiredInReception;

        return $this;
    }

    /**
     * Get snRequiredInReception
     *
     * @return boolean 
     */
    public function getSnRequiredInReception()
    {
        return $this->snRequiredInReception;
    }

    /**
     * Set snRequiredInExpedition
     *
     * @param boolean $snRequiredInExpedition
     * @return Product
     */
    public function setSnRequiredInExpedition($snRequiredInExpedition)
    {
        $this->snRequiredInExpedition = $snRequiredInExpedition;

        return $this;
    }

    /**
     * Get snRequiredInExpedition
     *
     * @return boolean 
     */
    public function getSnRequiredInExpedition()
    {
        return $this->snRequiredInExpedition;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stocks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->presentations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add stocks
     *
     * @param \CB\WarehouseBundle\Entity\Stock $stocks
     * @return Product
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Product
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
     * @return Product
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
     * Add presentations
     *
     * @param \CB\WarehouseBundle\Entity\ProductPresentations $presentations
     * @return Product
     */
    public function addPresentation(\CB\WarehouseBundle\Entity\ProductPresentations $presentations)
    {
        $this->presentations[] = $presentations;

        return $this;
    }

    /**
     * Remove presentations
     *
     * @param \CB\WarehouseBundle\Entity\ProductPresentations $presentations
     */
    public function removePresentation(\CB\WarehouseBundle\Entity\ProductPresentations $presentations)
    {
        $this->presentations->removeElement($presentations);
    }

    /**
     * Get presentations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPresentations()
    {
        return $this->presentations;
    }

    /**
     * Set baseUnit
     *
     * @param \CB\WarehouseBundle\Entity\ProductBaseUnit $baseUnit
     * @return Product
     */
    public function setBaseUnit(\CB\WarehouseBundle\Entity\ProductBaseUnit $baseUnit = null)
    {
        $this->baseUnit = $baseUnit;

        return $this;
    }

    /**
     * Get baseUnit
     *
     * @return \CB\WarehouseBundle\Entity\ProductBaseUnit 
     */
    public function getBaseUnit()
    {
        return $this->baseUnit;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Product
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set lotMask
     *
     * @param string $lotMask
     * @return Product
     */
    public function setLotMask($lotMask)
    {
        $this->lotMask = $lotMask;

        return $this;
    }

    /**
     * Get lotMask
     *
     * @return string 
     */
    public function getLotMask()
    {
        return $this->lotMask;
    }

    /**
     * Set snMask
     *
     * @param string $snMask
     * @return Product
     */
    public function setSnMask($snMask)
    {
        $this->snMask = $snMask;

        return $this;
    }

    /**
     * Get snMask
     *
     * @return string 
     */
    public function getSnMask()
    {
        return $this->snMask;
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
