<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MairieRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MairieRepository::class)]
#[ApiResource(
    operations:[
        new GetCollection(
            normalizationContext: ["groups"=>["mairie:read:collection"]],
        ),
        new Get(
            normalizationContext: ["groups"=>["mairie:read"]],
        ),
        new Post(
            normalizationContext: ["groups"=>["mairie:read"]],
        ),
        new Delete(
        )
        ],
    order:[
        'codePostal','label'
    ]
    
)]
#[ApiFilter(SearchFilter::class, properties: ['codePostal' => 'exact', 'ville' => 'exact', 'departement.region' => 'exact', 'departement.label' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['label' => 'ASC', 'codePostal' => 'ASC'])]

class Mairie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["mairie:read","mairie:read:collection"])]
    private ?int $id = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 6)]
    private ?string $codeInsee = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 5)]
    private ?string $codePostal = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 180)]
    private ?string $label = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 255,nullable: true)]
    private ?string $siteWeb = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 25,nullable: true)]
    private ?string $telephone = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 255,nullable: true)]
    private ?string $email = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 20,nullable: true)]
    private ?string $latitude = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\Column(length: 20,nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateMaj = null;

    #[Groups(["mairie:read","mairie:read:collection"])]
    #[ORM\ManyToOne(inversedBy: 'mairies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departement $departement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeInsee(): ?string
    {
        return $this->codeInsee;
    }

    public function setCodeInsee(string $codeInsee): static
    {
        $this->codeInsee = $codeInsee;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(string $siteWeb): static
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getDateMaj(): ?\DateTimeInterface
    {
        return $this->dateMaj;
    }

    public function setDateMaj(\DateTimeInterface $dateMaj): static
    {
        $this->dateMaj = $dateMaj;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }
}
