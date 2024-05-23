<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\State\MultiOperandCalculatorRequestProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/calculate/multiple",
            openapi: new Model\Operation(
                summary: 'Calculate multiple operands',
                description: 'This operation allows you to calculate multiple operands',
            ),
            //controller: MultiOperandCalculatorRequestAction::class,
            normalizationContext: ['groups' => ['multiple_calculator_request:read']],
            denormalizationContext: ['groups' => ['multiple_calculator_request:write']],
            input: MultiOperandCalculatorRequest::class,
            output: MultiOperandCalculatorRequest::class,
            processor: MultiOperandCalculatorRequestProcessor::class,
        )
    ]
)]
class MultiOperandCalculatorRequest
{
    #[ApiProperty(
        openapiContext: [
            'type' => 'enum',
            'enum' => ['add', 'subtract', 'multiply']
        ]
    )]
    #[Groups([ 'multiple_calculator_request:write'])]
    #[Assert\Choice(choices: ['add', 'subtract', 'multiply'])]
    public string $operation;

    #[ApiProperty(
        openapiContext: [
            'type' => 'array',
            'items' => [
                'type' => 'integer'
            ]
        ]
    )]
    #[Groups([ 'multiple_calculator_request:write'])]
    #[Assert\All([
            new Assert\NotBlank(),
            new Assert\Type(type: 'integer'),
            new Assert\NotNull()
        ]
    )]
    public array $operands;

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups([ 'multiple_calculator_request:read'])]
    public int $result;

    public function process(): void
    {
        if ($this->operation === 'add') {
            $this->result = array_sum($this->operands);
        } elseif ($this->operation === 'subtract') {
            $this->result = $this->operands[0];
            for ($i = 1; $i < count($this->operands); $i++) {
                $this->result -= $this->operands[$i];
            }
        } elseif ($this->operation === 'multiply') {
            $this->result = $this->operands[0];
            for ($i = 1; $i < count($this->operands); $i++) {
                $this->result *= $this->operands[$i];
            }
        }
    }
}