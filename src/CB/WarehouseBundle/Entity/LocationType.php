<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocationType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class LocationType
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
     * @var integer
     *
     * @ORM\Column(name="maxWeight", type="integer", nullable=true)
     */
    private $maxWeight;

    /**
     * @var integer
     *
     * @ORM\Column(name="sizeX", type="integer", nullable=true)
     */
    private $sizeX;

    /**
     * @var integer
     *
     * @ORM\Column(name="sizeY", type="integer", nullable=true)
     */
    private $sizeY;

    /**
     * @var integer
     *
     * @ORM\Column(name="sizeZ", type="integer", nullable=true)
     */
    private $sizeZ;
    
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
     * @ORM\OneToMany(targetEntity="Location", mappedBy="locationType")
     */
    protected $locations;


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
     * @return LocationType
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
     * @return LocationType
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
     * Set maxWeight
     *
     * @param integer $maxWeight
     * @return LocationType
     */
    public function setMaxWeight($maxWeight)
    {
        $this->maxWeight = $maxWeight;

        return $this;
    }

    /**
     * Get maxWeight
     *
     * @return integer 
     */
    public function getMaxWeight()
    {
        return $this->maxWeight;
    }

    /**
     * Set sizeX
     *
     * @param integer $sizeX
     * @return LocationType
     */
    public function setSizeX($sizeX)
    {
        $this->sizeX = $sizeX;

        return $this;
    }

    /**
     * Get sizeX
     *
     * @return integer 
     */
    public function getSizeX()
    {
        return $this->sizeX;
    }

    /**
     * Set sizeY
     *
     * @param integer $sizeY
     * @return LocationType
     */
    public function setSizeY($sizeY)
    {
        $this->sizeY = $sizeY;

        return $this;
    }

    /**
     * Get sizeY
     *
     * @return integer 
     */
    public function getSizeY()
    {
        return $this->sizeY;
    }

    /**
     * Set sizeZ
     *
     * @param integer $sizeZ
     * @return LocationType
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
     * Constructor
     */
    public function __construct()
    {
        $this->locations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return LocationType
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
     * @return LocationType
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
     * Add locations
     *
     * @param \CB\WarehouseBundle\Entity\Location $locations
     * @return LocationType
     */
    public function addLocation(\CB\WarehouseBundle\Entity\Location $locations)
    {
        $this->locations[] = $locations;

        return $this;
    }

    /**
     * Remove locations
     *
     * @param \CB\WarehouseBundle\Entity\Location $locations
     */
    public function removeLocation(\CB\WarehouseBundle\Entity\Location $locations)
    {
        $this->locations->removeElement($locations);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocations()
    {
        return $this->locations;
    }
    
    /**
     * @return string 
     */
    public function __toString()
    {
        return $this->name ." (". $this->description . ")";
    }
}
