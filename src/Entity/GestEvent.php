<?php

namespace App\Entity;

use App\Repository\GestEventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: GestEventRepository::class)]
#[Broadcast]
class GestEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $gest_event_id = null;

    #[ORM\ManyToOne(inversedBy: 'gestEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'gestEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event_id = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGestEventId(): ?int
    {
        return $this->gest_event_id;
    }

    public function setGestEventId(int $gest_event_id): static
    {
        $this->gest_event_id = $gest_event_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getEventId(): ?Event
    {
        return $this->event_id;
    }

    public function setEventId(?Event $event_id): static
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
}
