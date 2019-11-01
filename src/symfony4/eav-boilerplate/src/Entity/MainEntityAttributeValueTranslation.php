<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MainEntityAttributeValueRepository")
 */
class MainEntityAttributeValueTranslation
{
    use ORMBehaviors\Translatable\Translation;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;
    
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
