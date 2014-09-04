<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Event
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
     * @ORM\Column(name="Code", type="string", length=50)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;
    
    /**
     * @ORM\OneToMany(targetEntity="EventLog", mappedBy="event")
     */
    protected $eventLogs;


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
     * @return Event
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
     * Set description
     *
     * @param string $description
     * @return Event
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
     * Constructor
     */
    public function __construct()
    {
        $this->eventLogs = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCode();
    }

    /**
     * Add eventLogs
     *
     * @param \CB\WarehouseBundle\Entity\EventLog $eventLog
     * @return Product
     */
    public function addStock(\CB\WarehouseBundle\Entity\EventLog $eventLog)
    {
        $this->eventLogs[] = $eventLog;

        return $this;
    }

    /**
     * Remove eventLogs
     *
     * @param \CB\WarehouseBundle\Entity\EventLog $eventLog
     */
    public function removeStock(\CB\WarehouseBundle\Entity\EventLog $eventLog)
    {
        $this->eventLogs->removeElement($eventLog);
    }

    /**
     * Get eventLogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEventLogs()
    {
        return $this->eventLogs;
    }
}
