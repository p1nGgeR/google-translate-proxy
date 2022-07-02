<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TranslationRepository::class)]
class Translation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $language;

    #[ORM\Column(type: 'text')]
    private string $text;

    #[ORM\Column(type: 'string', length: 64, unique: true)]
    private string $searchKey;

    #[ORM\ManyToMany(targetEntity: self::class)]
    #[ORM\JoinTable(name: "translation_translations")]
    #[ORM\JoinColumn(name: "source_translation_id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "target_translation_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private Collection $translations;

    public function __construct(string $language, string $text, string $searchKey)
    {
        $this->language = $language;
        $this->text = $text;
        $this->searchKey = $searchKey;
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getSearchKey(): ?string
    {
        return $this->searchKey;
    }

    public function setSearchKey(string $searchKey): self
    {
        $this->searchKey = $searchKey;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(self $translation): self
    {
        if ($translation->getLanguage() === $this->getLanguage()) {
            throw new \LogicException("Cannot add translation for the same language");
        }

        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->addTranslation($this);
        }

        return $this;
    }

    public function removeTranslation(self $translation): self
    {
        $this->translations->removeElement($translation);

        return $this;
    }

    public function getTranslationForLanguage(string $language): ?self
    {
        return $this->translations
            ->filter(fn(Translation $translation) => $translation->getLanguage() === $language)
            ->first() ?: null;
    }
}
