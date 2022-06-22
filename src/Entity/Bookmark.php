<?php

namespace App\Entity;

use App\Repository\BookmarkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookmarkRepository::class)]
class Bookmark
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 500)]
    private $location;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $subtitle;

    #[ORM\Column(type: 'text')]
    private $details;

    #[ORM\Column(type: 'integer')]
    private $clicks;

    #[ORM\Column(type: 'date')]
    private $last_visit;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'Bookmarks')]
    private $categories;

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'Bookmarks')]
    private $groups;

    #[ORM\Column(type: 'string', length: 8)]
    private $bg_color;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bg_image;

    #[ORM\Column(type: 'string', length: 255)]
    private $icon;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookmarks')]
    #[ORM\JoinColumn(nullable: false)]
    private $User;

    #[ORM\Column(type: 'boolean')]
    private $favorite;

    #[ORM\Column(type: 'string', length: 8, nullable: true)]
    private $icon_color;

    #[ORM\Column(type: 'date')]
    private $created;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getClicks(): ?int
    {
        return $this->clicks;
    }

    public function setClicks(int $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function increaseVisitCount(): self
    {
        $this->clicks++;
        return $this;
    }

    public function getLastVisit(): ?\DateTimeInterface
    {
        return $this->last_visit;
    }

    public function setLastVisit(\DateTimeInterface $last_visit): self
    {
        $this->last_visit = $last_visit;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addBookmark($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeBookmark($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addBookmark($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            $group->removeBookmark($this);
        }

        return $this;
    }

    public function getBgColor(): ?string
    {
        return $this->bg_color;
    }

    public function setBgColor(string $bg_color): self
    {
        $this->bg_color = $bg_color;

        return $this;
    }

    public function getBgImage(): ?string
    {
        return $this->bg_image;
    }

    public function setBgImage(?string $bg_image): self
    {
        $this->bg_image = $bg_image;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function isFavorite(): ?bool
    {
        return $this->favorite;
    }

    public function setFavorite(bool $favorite): self
    {
        $this->favorite = $favorite;

        return $this;
    }

    public function getIconColor(): ?string
    {
        return $this->icon_color;
    }

    public function setIconColor(?string $icon_color): self
    {
        $this->icon_color = $icon_color;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
