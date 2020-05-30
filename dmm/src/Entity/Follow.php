<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FollowRepository")
 */
class Follow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="follows")
     */
    private $follower;

    /**
     * @ORM\Column(type="integer")
     */
    private $followedId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $followedAt;


    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollower(): ?user
    {
        return $this->follower;
    }

    public function setFollower(?user $follower): self
    {
        $this->follower = $follower;

        return $this;
    }

    public function getFollowedId(): ?int
    {
        return $this->followedId;
    }

    public function setFollowedId(int $followedId): self
    {
        $this->followedId = $followedId;

        return $this;
    }

    public function getFollowedAt(): ?\DateTimeInterface
    {
        return $this->followedAt;
    }

    public function setFollowedAt(\DateTimeInterface $followedAt): self
    {
        $this->followedAt = $followedAt;

        return $this;
    }

}
