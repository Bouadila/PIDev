<?php

namespace App\Entity;
use App\Entity\User;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("video")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ("video")
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ("video")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups ("video")
     * @Assert\NotBlank()
     */
    private $publishDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups ("video")
     */
    private $votes;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ("video")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="yes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups ("video")
     * @Assert\NotBlank()
     */
    private $id_cand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ("video")
     */
    private $domaine;

    /**
     * @ORM\OneToMany(targetEntity=PostLike::class, mappedBy="post")
     * @Groups("video")
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getVotes(): ?string
    {
        return $this->votes;
    }

    public function setVotes(?string $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdCand(): ?User
    {
        return $this->id_cand;
    }

    public function setIdCand(?User $id_cand): self
    {
        $this->id_cand = $id_cand;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * @return Collection|PostLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(PostLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPost($this);
        }

        return $this;
    }

    public function removeLike(PostLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPost() === $this) {
                $like->setPost(null);
            }
        }

        return $this;
    }

    /**
     * permet de savoir si cet video est like par un user
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user) : bool
    {

        foreach ($this->likes as $like){
            if($like->getUser() === $user ) return true;
        }
        return false;

    }
}
