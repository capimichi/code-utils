<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MainEntityAttributeValueRepository")
 */
class MainEntityAttributeValue
{
    use ORMBehaviors\Translatable\Translatable;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MainEntity", inversedBy="attributeValues")
     */
    private $mainEntity;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MainEntityAttribute", inversedBy="attributeValues")
     */
    private $attribute;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getMainEntity(): ?MainEntity
    {
        return $this->mainEntity;
    }
    
    public function setMainEntity(?MainEntity $mainEntity): self
    {
        $this->mainEntity = $mainEntity;
        
        return $this;
    }
    
    public function getAttribute(): ?MainEntityAttribute
    {
        return $this->attribute;
    }
    
    public function setAttribute(?MainEntityAttribute $attribute): self
    {
        $this->attribute = $attribute;
        
        return $this;
    }
    
    public function getPosition(): ?int
    {
        return $this->position;
    }
    
    public function setPosition(?int $position): self
    {
        $this->position = $position;
        
        return $this;
    }
    
    public function getValue(): ?string
    {
        return $this->value;
    }
    
    public function setValue(?string $value): self
    {
        $this->value = $value;
        
        return $this;
    }
}
