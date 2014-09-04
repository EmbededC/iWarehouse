<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventLog
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @var integer
     *
     * @ORM\Column(name="Event", type="integer")
     */
    private $event;

    /**
     * @var integer
     *
     * @ORM\Column(name="EventType", type="integer")
     */
    private $eventType;

    /**
     * @var integer
     *
     * @ORM\Column(name="EventReason", type="integer")
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
     * @ORM\Column(name="Object", type="integer")
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
     * Set event
     *
     * @param integer $event
     * @return EventLog
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return integer 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set eventType
     *
     * @param integer $eventType
     * @return EventLog
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return integer 
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set eventReason
     *
     * @param integer $eventReason
     * @return EventLog
     */
    public function setEventReason($eventReason)
    {
        $this->eventReason = $eventReason;

        return $this;
    }

    /**
     * Get eventReason
     *
     * @return integer 
     */
    public function getEventReason()
    {
        return $this->eventReason;
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
     * Set object
     *
     * @param integer $object
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
     * @return integer 
     */
    public function getObject()
    {
        return $this->object;
    }
}
