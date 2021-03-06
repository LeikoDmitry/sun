<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AttachmentRepository;
use App\Tools\AutoUpdateOrCreateDateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\AttachmentController;
use DateTimeInterface;

/**
 * @ApiResource(
 *     routePrefix="documents",
 *     collectionOperations={
 *         "post"={
 *             "controller"=AttachmentController::class,
 *             "deserialize"=false,
 *             "validation_groups"={"Default", "media_object_create"},
 *             "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                     }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *         },
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 *)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass=AttachmentRepository::class)
 */
class Attachment
{
    use AutoUpdateOrCreateDateTime;

    /**
     * @ApiProperty()
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ApiProperty()
     * @Assert\Length(
     *     min = 2,
     *     max = 50
     * )
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $name;

    /**
     * @ApiProperty()
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
