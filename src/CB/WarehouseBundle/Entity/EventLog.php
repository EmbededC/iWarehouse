<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventLog
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="CB\WarehouseBundle\Entity\EventLogRepository")
 */
class EventLog
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
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventLogs")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="EventType", inversedBy="eventLogs")
     * @ORM\JoinColumn(name="event_type_id", referencedColumnName="id")
     */
    private $eventType;

    /**
     * @ORM\ManyToOne(targetEntity="EventReason", inversedBy="eventLogs")
     * @ORM\JoinColumn(name="event_reason_id", referencedColumnName="id")
     */
    private $eventReason;

    /**
     * @var integer
     *
     * @ORM\Column(name="User", type="integer")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreatedAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="ObjectType", type="string", length=255)
     */
    private $objectType;

    /**
     * @var integer
     *
     * @ORM\Column(name="ObjectId", type="integer")
     */
    private $objectId;
    
    /**
     *
     * @var text
     * @ORM\Column(name="Object", type="text")
     */
    private $object;


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
     * Set user
     *
     * @param integer $user
     * @return EventLog
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return EventLog
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return EventLog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set objectType
     *
     * @param string $objectType
     * @return EventLog
     */
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;

        return $this;
    }

    /**
     * Get objectType
     *
     * @return string 
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * Set objectId
     *
     * @param integer $objectId
     * @return EventLog
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
     * Set object
     *
     * @param text $object
     * @return EventLog
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return text
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set event
     *
     * @param \CB\WarehouseBundle\Entity\Event $event
     * @return EventLog
     */
    public function setEvent(\CB\WarehouseBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \CB\WarehouseBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set eventType
     *
     * @param \CB\WarehouseBundle\Entity\EventType $eventType
     * @return EventLog
     */
    public function setEventType(\CB\WarehouseBundle\Entity\EventType $eventType = null)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return \CB\WarehouseBundle\Entity\EventType 
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set eventReason
     *
     * @param \CB\WarehouseBundle\Entity\EventReason $eventReason
     * @return EventLog
     */
    public function setEventReason(\CB\WarehouseBundle\Entity\EventReason $eventReason = null)
    {
        $this->eventReason = $eventReason;

        return $this;
    }

    /**
     * Get eventReason
     *
     * @return \CB\WarehouseBundle\Entity\EventReason 
     */
    public function getEventReason()
    {
        return $this->eventReason;
    }
}
