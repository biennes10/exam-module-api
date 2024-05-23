<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\SimpleCalculatorRequestAction;
use ApiPlatform\OpenApi\Model;
use App\State\SimpleCalculatorRequestProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/calculate/simple",
            openapi: new Model\Operation(
                summary: 'Calculate with 2 operands',
                description: 'This operation allows you to calculate with 2 operands',
            ),
            //controller: SimpleCalculatorRequestAction::class,
            normalizationContext: ['groups' => ['simple_calculator_request:read']],
            denormalizationContext: ['groups' => ['simple_calculator_request:write']],
            input: SimpleCalculatorRequest::class,
            output: SimpleCalculatorRequest::class,
            processor: SimpleCalculatorRequestProcessor::class
        )
    ]
)]
class SimpleCalculatorRequest
{
    #[ApiProperty(
        openapiContext: [
            'type' => 'enum',
            'enum' => ['add', 'subtract', 'multiply', 'divide']
        ]
    )]
    #[Groups([ 'simple_calculator_request:write'])]
    #[Assert\Choice(choices: ['add', 'subtract', 'multiply', 'divide'])]
    public string $operation;
    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['simple_calculator_request:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\NotNull]
    public int $firstOperand;

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['simple_calculator_request:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\NotNull]
    public int $secondOperand;

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['simple_calculator_request:read'])]
    public int $result;

    public function process(): void
    {
        if ($this->operation === 'add') {
            $this->result = $this->firstOperand + $this->secondOperand;
        } elseif ($this->operation === 'subtract') {
            $this->result = $this->firstOperand - $this->secondOperand;
        } elseif ($this->operation === 'multiply') {
            $this->result = $this->firstOperand * $this->secondOperand;
        } elseif ($this->operation === 'divide') {
            if($this->secondOperand == 0) {
                throw new \InvalidArgumentException("Division by zero is not allowed");
            }
            else {
                $this->result = $this->firstOperand / $this->secondOperand;
            }
        }
    }
}