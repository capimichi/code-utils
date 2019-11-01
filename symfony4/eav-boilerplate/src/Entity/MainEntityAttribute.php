<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainEntityAttributeRepository")
 */
class MainEntityAttribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MainEntityAttributeValue", mappedBy="attribute")
     */
    private $attributeValues;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $multiple;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MainEntityAttributeOption", mappedBy="attribute")
     */
    private $options;

    /**
     * @ORM\Column(type="boolean")
     */
    private $filterable;
    
    public function __construct()
    {
        $this->attributeValues = new ArrayCollection();
        $this->options = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(?string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getCode(): ?string
    {
        return $this->code;
    }
    
    public function setCode(?string $code): self
    {
        $this->code = $code;
        
        return $this;
    }
    
    public function getType(): ?string
    {
        return $this->type;
    }
    
    public function setType(?string $type): self
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return Collection|MainEntityAttributeValue[]
     */
    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }
    
    public function addAttributeValue(MainEntityAttributeValue $attributeValue): self
    {
        if (!$this->attributeValues->contains($attributeValue)) {
            $this->attributeValues[] = $attributeValue;
            $attributeValue->setAttribute($this);
        }
        
        return $this;
    }
    
    public function removeAttributeValue(MainEntityAttributeValue $attributeValue): self
    {
        if ($this->attributeValues->contains($attributeValue)) {
            $this->attributeValues->removeElement($attributeValue);
            // set the owning side to null (unless already changed)
            if ($attributeValue->getAttribute() === $this) {
                $attributeValue->setAttribute(null);
            }
        }
        
        return $this;
    }
    
    public function getMultiple(): ?bool
    {
        return $this->multiple;
    }
    
    public function setMultiple(bool $multiple): self
    {
        $this->multiple = $multiple;
        
        return $this;
    }
    
    /**
     * @return Collection|MainEntityAttributeOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }
    
    public function addOption(MainEntityAttributeOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setAttribute($this);
        }
        
        return $this;
    }
    
    public function removeOption(MainEntityAttributeOption $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            // set the owning side to null (unless already changed)
            if ($option->getAttribute() === $this) {
                $option->setAttribute(null);
            }
        }
        
        return $this;
    }

    public function getFilterable(): ?bool
    {
        return $this->filterable;
    }

    public function setFilterable(bool $filterable): self
    {
        $this->filterable = $filterable;

        return $this;
    }
    
}
