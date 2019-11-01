<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainEntityRepository")
 */
class MainEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MainEntityAttributeValue", mappedBy="product")
     */
    private $attributeValues;
    
    public function __construct()
    {
        $this->attributeValues = new ArrayCollection();
        $this->storeProducts = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
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
            $attributeValue->setProduct($this);
        }
        
        return $this;
    }
    
    public function removeAttributeValue(MainEntityAttributeValue $attributeValue): self
    {
        if ($this->attributeValues->contains($attributeValue)) {
            $this->attributeValues->removeElement($attributeValue);
            // set the owning side to null (unless already changed)
            if ($attributeValue->getProduct() === $this) {
                $attributeValue->setProduct(null);
            }
        }
        
        return $this;
    }
}
