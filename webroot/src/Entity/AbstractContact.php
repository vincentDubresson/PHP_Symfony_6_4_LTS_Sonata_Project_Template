<?php

namespace App\Entity;

use App\Repository\AbstractContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AbstractContactRepository::class)]
#[ORM\Table(name: 'user')]
#[InheritanceType('SINGLE_TABLE')]
class AbstractContact implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire.')]
    #[Assert\Length(max: 255, maxMessage: 'Le prénom ne doit pas dépasser 255 caractères.')]
    private string $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire.')]
    #[Assert\Length(max: 255, maxMessage: 'Le nom ne doit pas dépasser 255 caractères.')]
    private string $lastname;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: 'L\'adresse email est obligatoire.')]
    #[Assert\Length(max: 180, maxMessage: 'L\'adresse email ne doit pas dépasser 180 caractères.')]
    #[Assert\Email(message: 'L\'adresse email "{{ value }}" n\'est pas valide.')]
    private string $email;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank(message: 'Le numéro de téléphone est obligatoire.')]
    #[Assert\Regex(
        pattern: '^(?:(?:\+?33[ .-]?)?(?:(?:[1-9])(?:[ .-]?)){4}(?:[1-9]))|(?:0[ .-]?(?:(?:[1-9])(?:[ .-]?)){4}(?:[1-9]))$',
        message: 'Le numéro de téléphone doit correspondre aux formats suivants : +33.1.02.03.04.05, +33 1 02 03 04 05, +33102030405, 01.02.03.04.05, 01 02 03 04 05, 0102030405.'
    )]
    private string $phone;

    #[ORM\Column(type: 'boolean')]
    private bool $enable = false;

    #[ORM\Column(type: 'boolean')]
    private bool $visible = false;

    public function __toString()
    {
        return "$this->firstname $this->lastname";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): static
    {
        $this->enable = $enable;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }
}
