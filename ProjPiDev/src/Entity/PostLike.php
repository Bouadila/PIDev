<?php

namespace App\Entity;

use App\Repository\PostLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostLikeRepository::class)
 */
class PostLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=video::class, inversedBy="likes")
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?video
    {
        return $this->post;
    }

    public function setPost(?video $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
