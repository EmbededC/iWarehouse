<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ContainerType
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
     * @ORM\Column(name="sizeX", type="integer")
     */
    private $sizeX;

    /**
     * @var integer
     *
     * @ORM\Column(name="sizeY", type="integer")
     */
    private $sizeY;

    /**
     * @var integer
     *
     * @ORM\Column(name="sizeZ", type="integer")
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
     * @ORM\OneToMany(targetEntity="Container", mappedBy="containerType")
     */
    protected $containers;


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
     * @return ContainerType
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
     * @return ContainerType
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
     * @return ContainerType
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
     * @return ContainerType
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
     * @return ContainerType
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
     * @return ContainerType
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return ContainerType
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
     * @return ContainerType
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
        $this->containers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add containers
     *
     * @param \CB\WarehouseBundle\Entity\Container $containers
     * @return ContainerType
     */
    public function addContainer(\CB\WarehouseBundle\Entity\Container $containers)
    {
        $this->containers[] = $containers;

        return $this;
    }

    /**
     * Remove containers
     *
     * @param \CB\WarehouseBundle\Entity\Container $containers
     */
    public function removeContainer(\CB\WarehouseBundle\Entity\Container $containers)
    {
        $this->containers->removeElement($containers);
    }

    /**
     * Get containers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContainers()
    {
        return $this->containers;
    }
}
