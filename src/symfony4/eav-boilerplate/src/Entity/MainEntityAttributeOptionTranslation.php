<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainEntityAttributeOptionRepository")
 */
class MainEntityAttributeOptionTranslation
{
    use ORMBehaviors\Translatable\Translation;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $name;
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(?string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
}
