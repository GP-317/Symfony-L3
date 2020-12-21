<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Controller\UserController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $blocked;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Civilite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $noTelephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Pays;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $noSecu;

    /**
     * @ORM\OneToMany(targetEntity=Souscription::class, mappedBy="user")
     */
    private $souscription;

    public function __construct()
    {
        $this->souscription = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): self
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->Civilite;
    }

    public function setCivilite(?string $Civilite): self
    {
        $this->Civilite = $Civilite;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?string $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getNoTelephone(): ?string
    {
        return $this->noTelephone;
    }

    public function setNoTelephone(?string $noTelephone): self
    {
        $this->noTelephone = $noTelephone;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(?string $Pays): self
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getNoSecu(): ?string
    {
        return $this->noSecu;
    }

    public function setNoSecu(?string $noSecu): self
    {
        $this->noSecu = $noSecu;

        return $this;
    }

    /**
     * @return Collection|Souscription[]
     */
    public function getSouscription(): Collection
    {
        return $this->souscription;
    }

    public function addSouscription(Souscription $souscription): self
    {
        if (!$this->souscription->contains($souscription)) {
            $this->souscription[] = $souscription;
            $souscription->setUser($this);
        }

        return $this;
    }

    public function removeSouscription(Souscription $souscription): self
    {
        if ($this->souscription->contains($souscription)) {
            $this->souscription->removeElement($souscription);
            // set the owning side to null (unless already changed)
            if ($souscription->getUser() === $this) {
                $souscription->setUser(null);
            }
        }

        return $this;
    }
}
