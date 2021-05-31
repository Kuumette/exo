<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\ManyToMany(targetEntity=Label::class, inversedBy="contacts")
     */
    private $Labels;

    /**
     * @ORM\OneToMany(targetEntity=Email::class, mappedBy="contact")
     */
    private $Emails;

    public function __toString(){
        return $this->getFirstName()." ".$this->getLastName();
    }

    public function __construct()
    {
        $this->Labels = new ArrayCollection();
        $this->Emails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Label[]
     */
    public function getLabels(): Collection
    {
        return $this->Labels;
    }

    public function addLabel(Label $label): self
    {
        if (!$this->Labels->contains($label)) {
            $this->Labels[] = $label;
        }

        return $this;
    }

    public function removeLabel(Label $label): self
    {
        $this->Labels->removeElement($label);

        return $this;
    }

    /**
     * @return Collection|Email[]
     */
    public function getEmails(): Collection
    {
        return $this->Emails;
    }

    public function addEmail(Email $email): self
    {
        if (!$this->Emails->contains($email)) {
            $this->Emails[] = $email;
            $email->setContact($this);
        }

        return $this;
    }

    public function removeEmail(Email $email): self
    {
        if ($this->Emails->removeElement($email)) {
            // set the owning side to null (unless already changed)
            if ($email->getContact() === $this) {
                $email->setContact(null);
            }
        }

        return $this;
    }
}
