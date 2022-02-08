<?php

namespace App\Entity;

use App\Repository\AlimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlimentRepository::class)]
class Aliment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'integer')]
    private $calorie;

    #[ORM\Column(type: 'float')]
    private $proteine;

    #[ORM\Column(type: 'float')]
    private $glucide;

    #[ORM\Column(type: 'float')]
    private $lipide;

    #[ORM\Column(type: 'string', length: 255)]
    private $category;

    #[ORM\OneToMany(mappedBy: 'aliment', targetEntity: AlimentLike::class)]
    private $likes;

    #[ORM\OneToOne(mappedBy: 'aliment', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private $images;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCalorie(): ?int
    {
        return $this->calorie;
    }

    public function setCalorie(int $calorie): self
    {
        $this->calorie = $calorie;

        return $this;
    }

    public function getProteine(): ?float
    {
        return $this->proteine;
    }

    public function setProteine(float $proteine): self
    {
        $this->proteine = $proteine;

        return $this;
    }

    public function getGlucide(): ?float
    {
        return $this->glucide;
    }

    public function setGlucide(float $glucide): self
    {
        $this->glucide = $glucide;

        return $this;
    }

    public function getLipide(): ?float
    {
        return $this->lipide;
    }

    public function setLipide(float $lipide): self
    {
        $this->lipide = $lipide;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|AlimentLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(AlimentLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setAliment($this);
        }

        return $this;
    }

    public function removeLike(AlimentLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getAliment() === $this) {
                $like->setAliment(null);
            }
        }

        return $this;
    }

    //permet de savoir si cet aliment est liké par un utilisateur 
    public function isLikeByUser(User $user): bool
    {
        foreach($this->likes as $like){
            if ($like->getUser() === $user){
                
                return true;
            } 
        }

        return false;
    }

    public function getImages(): Image
    {
        return $this->images;
    }

    public function setImages(Image $images)
    {
        // unset the owning side of the relation if necessary
        if ($images === null && $this->images !== null) {
            $this->images->setAliment(null);
        }

        // set the owning side of the relation if necessary
        if ($images !== null && $images->getAliment() !== $this) {
            $images->setAliment($this);
        }

        $this->images = $images;

        return $this;
    }
}
