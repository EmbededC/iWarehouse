<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Container
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Container
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
     * @ORM\Column(name="updatedDate", type="datetime", nullable=true)
     */
    private $updatedDate;
        
    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="containers")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;
    
    /**
     * @ORM\ManyToOne(targetEntity="ContainerType", inversedBy="containers")
     * @ORM\JoinColumn(name="containerType_id", referencedColumnName="id")
     */
    protected $containerType;


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
     * @return Container
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
     * Constructor
     */
    public function __construct()
    {
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCode();
    }

    /**
     * Set location
     *
     * @param \CB\WarehouseBundle\Entity\Location $location
     * @return Container
     */
    public function setLocation(\CB\WarehouseBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \CB\WarehouseBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Container
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
     * @return Container
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
     * Set containerType
     *
     * @param \CB\WarehouseBundle\Entity\ContainerType $containerType
     * @return Container
     */
    public function setContainerType(\CB\WarehouseBundle\Entity\ContainerType $containerType = null)
    {
        $this->containerType = $containerType;

        return $this;
    }

    /**
     * Get containerType
     *
     * @return \CB\WarehouseBundle\Entity\ContainerType 
     */
    public function getContainerType()
    {
        return $this->containerType;
    }
}
