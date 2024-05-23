<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\SimpleCalculatorRequestAction;
use ApiPlatform\OpenApi\Model;
use App\State\TaxeOrdureRequestProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/taxe/ordure",
            openapi: new Model\Operation(
                summary: 'Valeur locative',
                description: '9,37% de la moitié de la valeur locative',
            ),
            //controller: SimpleCalculatorRequestAction::class,
            normalizationContext: ['groups' => ['taxe_calculator_request:read']],
            denormalizationContext: ['groups' => ['taxe_calculator_request:write']],
            input: TaxeOrdureRequest::class,
            output: TaxeOrdureRequest::class,
            processor: TaxeOrdureRequestProcessor::class
        )
    ]
)]
class TaxeOrdureRequest
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
    public float $valeurLocative;

    

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['taxe_calculator_request:read'])]
    public float $result;

    public function process(): void
    {
        $taxe = $this->valeurLocative * 0.5 * 0.0937;
        $this->result = $taxe;
    }
}