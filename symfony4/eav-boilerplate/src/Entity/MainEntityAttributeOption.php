<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainEntityAttributeOptionRepository")
 */
class MainEntityAttributeOption
{
    use ORMBehaviors\Translatable\Translatable;
    
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
     * @ORM\ManyToOne(targetEntity="App\Entity\MainEntityAttribute", inversedBy="options")
     */
    private $attribute;
    
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
    
    public function getAttribute(): ?MainEntityAttribute
    {
        return $this->attribute;
    }
    
    public function setAttribute(?MainEntityAttribute $attribute): self
    {
        $this->attribute = $attribute;
        
        return $this;
    }
}
