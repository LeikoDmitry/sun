<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AttachmentRepository;
use App\Tools\AutoUpdateOrCreateDateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeInterface;

/**
 * @ApiResource()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass=AttachmentRepository::class)
 */
class Attachment
{
    use AutoUpdateOrCreateDateTime;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\Length(
     *     min = 2,
     *     max = 50
     * )
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $name;

    /**
     * @Assert\Length(
     *     min = 2,
     *     max = 100
     * )
     * @Assert\NotBlank
     * @ORM\Column(type="text")
     */
    private string $path;

    /**
     * @ORM\OneToOne(targetEntity=Document::class, mappedBy="attacment", cascade={"persist", "remove"})
     */
    private $document;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $updateAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): self
    {
        if ($document->getAttachment() !== $this) {
            $document->setAttachment($this);
        }

        $this->document = $document;

        return $this;
    }
}
