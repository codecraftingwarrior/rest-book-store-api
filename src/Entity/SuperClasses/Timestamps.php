<?php

namespace App\Entity\SuperClasses;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass()
 * @author ahmadou
 */
class Timestamps
{
    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable="true")
     */
    private $createdAt;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable="true")
     */
    private $updatedAt;


    /**
     * @param LifecycleEventArgs $args
     * @return void
     * @ORM\PrePersist()
     */
    public function onCreated(LifecycleEventArgs $args)
    {
        $this->setCreatedAt(new DateTime());
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     * @ORM\PreUpdate()
     */
    public function onUpdated(LifecycleEventArgs $args)
    {
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     */
    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}
