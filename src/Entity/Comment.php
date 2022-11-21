<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 * @package App\Entity
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private string $message;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private User $author;

    /**
     * @var Creation
     * @ORM\ManyToOne(targetEntity="Creation")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private Creation $creation;

    /**
     * @param string $message
     * @param User $author
     * @param Creation $creation
     * @return static
     */
    public static function create(string $message, User $author, Creation $creation): self
    {
        $comment = new self();
        $comment->message = $message;
        $comment->author = $author;
        $comment->creation = $creation;

        return $comment;
    }

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        
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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return Creation
     */
    public function getCreation(): Creation
    {
        return $this->creation;
    }

    /**
     * @param Creation $creation
     */
    public function setCreation(Creation $creation): void
    {
        $this->creation = $creation;
    }
}
