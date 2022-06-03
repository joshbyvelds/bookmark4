<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\ManyToMany(targetEntity: Bookmark::class, inversedBy: 'groups')]
    private $Bookmarks;

    public function __construct()
    {
        $this->Bookmarks = new ArrayCollection();
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

    /**
     * @return Collection<int, Bookmark>
     */
    public function getBookmarks(): Collection
    {
        return $this->Bookmarks;
    }

    public function addBookmark(Bookmark $bookmark): self
    {
        if (!$this->Bookmarks->contains($bookmark)) {
            $this->Bookmarks[] = $bookmark;
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): self
    {
        $this->Bookmarks->removeElement($bookmark);

        return $this;
    }
}
