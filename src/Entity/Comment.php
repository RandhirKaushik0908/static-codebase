<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[Assert\NotNull]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $comment_text = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $date_of_comment = null;

    #[ORM\Column]
    private ?int $num_of_replies = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCommentText(): ?string
    {
        return $this->comment_text;
    }

    public function setCommentText(string $comment_text): self
    {
        $this->comment_text = $comment_text;

        return $this;
    }

    public function getDateOfComment(): ?DateTimeInterface
    {
        return $this->date_of_comment;
    }

    public function setDateOfComment(DateTimeInterface $date_of_comment): self
    {
        $this->date_of_comment = $date_of_comment;

        return $this;
    }

    public function getNumOfReplies(): ?int
    {
        return $this->num_of_replies;
    }

    public function setNumOfReplies(int $num_of_replies): self
    {
        $this->num_of_replies = $num_of_replies;

        return $this;
    }


}
