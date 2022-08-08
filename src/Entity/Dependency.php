<?php
namespace App\Entity;

use Ramsey\Uuid\Uuid;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    itemOperations: [
        'get', 
        'put' =>[
            'denormalization_context' => [
                'groups' => ['put:Dependency']
            ]
            ],
            'delete'
    ],
    collectionOperations: ['get','post'],
    paginationEnabled: false
)]
class Dependency
{
    #[ApiProperty(
        identifier: true
    )]
    private string $uuid;

    #[ApiProperty(
        description: 'Nom de la dépendance'
    ),
        Length(min:2),
        NotBlank()
    ]
    private string $name;

    #[ApiProperty(
        description: 'Version de la dépendance',
        openapiContext: [
            'example' => "^3.2"
        ]
    ),
        Length(min:2),
        NotBlank(),
        Groups(['put:Dependency'])
    ]
    private string $version;

    public function __construct(string $name, string $version)
    {
        $this->uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * Get the value of uuid
     *
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }


    /**
     * Set the value of version
     *
     * @param string $version
     *
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }
}