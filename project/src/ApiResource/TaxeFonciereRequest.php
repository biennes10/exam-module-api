<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\SimpleCalculatorRequestAction;
use ApiPlatform\OpenApi\Model;
use App\State\TaxeFonciereRequestProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/taxe/fonciere",
            openapi: new Model\Operation(
                summary: 'Prix et surface',
                description: '5% de : (prix multiplié par la surface)',
            ),
            //controller: SimpleCalculatorRequestAction::class,
            normalizationContext: ['groups' => ['taxe_calculator_request:read']],
            denormalizationContext: ['groups' => ['taxe_calculator_request:write']],
            input: TaxeFonciereRequest::class,
            output: TaxeFonciereRequest::class,
            processor: TaxeFonciereRequestProcessor::class
        )
    ]
)]
class TaxeFonciereRequest
{

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['taxe_calculator_request:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    #[Assert\NotNull]
    public float $surface;

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['taxe_calculator_request:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    #[Assert\NotNull]
    public float $prix;

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['taxe_calculator_request:read'])]
    public float $result;

    public function process(): void
    {
        $cadastrale =$this->surface * $this->prix;
        $montant = $cadastrale * 0.05;

        $this->result = $montant;
    }
}