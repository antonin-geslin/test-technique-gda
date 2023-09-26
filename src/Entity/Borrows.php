<?php

namespace App\Entity;

use App\Repository\BorrowsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BorrowsRepository::class)]
class Borrows
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $book = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $borrowDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $returnDate = null;

    #[ORM\ManyToOne(inversedBy: 'borrows')]
    private ?User $user = null;


    public function __construct()
    {
        $this->borrowDate = new \DateTimeImmutable();
        $this->returnDate = (new \DateTimeImmutable())->modify('+2weeks');
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?string
    {
        return $this->book;
    }

    public function setBook(string $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getBorrowDate(): ?\DateTimeImmutable
    {
        return $this->borrowDate;
    }

    public function setBorrowDate(\DateTimeImmutable $borrowDate): static
    {
        $this->borrowDate = $borrowDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeImmutable
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeImmutable $returnDate): static
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
