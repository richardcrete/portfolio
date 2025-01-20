<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience implements TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\Type("DateTime")]
    private ?DateTime $startDate = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Type("DateTime")]
    private ?DateTime $endDate = null;

    #[ORM\ManyToMany(targetEntity: Tool::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'cascade')]
    #[ORM\JoinTable(name: 'experience_tool')]
    #[ORM\InverseJoinColumn(nullable: false, onDelete: 'RESTRICT')]
    private ?Collection $tools = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTools(): ?Collection
    {
        return $this->tools;
    }

    public function setTools(?Collection $tools): static
    {
        $this->tools = $tools;

        return $this;
    }
}
