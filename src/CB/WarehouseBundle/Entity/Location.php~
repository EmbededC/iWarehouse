<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Location
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
     * @ORM\Column(name="code", type="string", length=50)
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
     * @ORM\OneToMany(targetEntity="Container", mappedBy="location")
     */
    protected $containers;
    
    /**
     * @ORM\ManyToOne(targetEntity="LocationType", inversedBy="locations")
     * @ORM\JoinColumn(name="locationType_id", referencedColumnName="id")
     */
    protected $locationType;


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
     * @return Location
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
        $this->containers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCode();
    }

    /**
     * Add containers
     *
     * @param \CB\WarehouseBundle\Entity\Container $containers
     * @return Location
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

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Location
     */
    public function setCreationDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->createdDate;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Location
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
     * @return Location
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
     * Set locationType
     *
     * @param \CB\WarehouseBundle\Entity\LocationType $locationType
     * @return Location
     */
    public function setLocationType(\CB\WarehouseBundle\Entity\LocationType $locationType = null)
    {
        $this->locationType = $locationType;

        return $this;
    }

    /**
     * Get locationType
     *
     * @return \CB\WarehouseBundle\Entity\LocationType 
     */
    public function getLocationType()
    {
        return $this->locationType;
    }
}
