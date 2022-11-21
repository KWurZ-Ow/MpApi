<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Creation
 * @package App\Entity
 * @ORM\Entity
 */
class Creation
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Groups({"get"})
     */
    private ?int $id = null;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Groups({"get"})
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    private ?string $content = null;

    /**
     * @var User[]|Collection
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="creation_likes")
     */
    private Collection $likedBy;

    /**
     * @param string $content
     * @return static
     */
    public static function create(string $content): self
    {
        $creation = new self();
        $creation->content = $content;

        return $creation;
    }

    /**
     * Creation constructor.
     */
    public function __construct()
    {
        $this->likedBy = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return User[]|Collection
     */
    public function getLikedBy(): Collection
    {
        return $this->likedBy;
    }

    /**
     * @param User $user
     */
    public function likeBy(User $user): void
    {
        if ($this->likedBy->contains($user)) {
            return;
        }

        $this->likedBy->add($user);
    }

    /**
     * @param User $user
     */
    public function dislikeBy(User $user): void
    {
        if (!$this->likedBy->contains($user)) {
            return;
        }

        $this->likedBy->removeElement($user);
    }
}
