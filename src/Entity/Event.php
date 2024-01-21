<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[UniqueEntity('event_id')]
#[Broadcast]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $event_id = null;

    #[ORM\Column(length: 255)]
    private ?string $event_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $event_date = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\OneToMany(mappedBy: 'event_id', targetEntity: GestEvent::class)]
    private Collection $gestEvents;

    #[ORM\OneToMany(mappedBy: 'event_id', targetEntity: Ticket::class)]
    private Collection $tickets;

    public function __construct()
    {
        $this->gestEvents = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?int
    {
        return $this->event_id;
    }

    public function setEventId(int $event_id): static
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setEventName(string $event_name): static
    {
        $this->event_name = $event_name;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->event_date;
    }

    public function setEventDate(\DateTimeInterface $event_date): static
    {
        $this->event_date = $event_date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, GestEvent>
     */
    public function getGestEvents(): Collection
    {
        return $this->gestEvents;
    }

    public function addGestEvent(GestEvent $gestEvent): static
    {
        if (!$this->gestEvents->contains($gestEvent)) {
            $this->gestEvents->add($gestEvent);
            $gestEvent->setEventId($this);
        }

        return $this;
    }

    public function removeGestEvent(GestEvent $gestEvent): static
    {
        if ($this->gestEvents->removeElement($gestEvent)) {
            // set the owning side to null (unless already changed)
            if ($gestEvent->getEventId() === $this) {
                $gestEvent->setEventId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setEventId($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getEventId() === $this) {
                $ticket->setEventId(null);
            }
        }

        return $this;
    }
}
