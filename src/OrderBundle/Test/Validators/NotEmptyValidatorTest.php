<?php declare(strict_types=1);

namespace OrderBundle\Test\Validators;

use OrderBundle\Validators\NotEmptyValidator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class NotEmptyValidatorTest extends TestCase
{
    #[DataProvider('valueProvider')]
    public function testIsValid($value,$expected): void
    {
        $NotEmptyValidator= new NotEmptyValidator($value);
        $isValid = $NotEmptyValidator->isValid();
        $this->assertEquals($expected,$value);
    }

    public static function valueProvider(): array
    {
        return [
            'shouldNotBeValidWhenValueIEmpty' => ['',false],
            'shouldBeValidWhenValueIsNotEmpty' => ['full',true],
        ];
    }

}


// namespace OrderBundle\Test\Validators;

// use OrderBundle\Validators\NotEmptyValidator;
// use Generator;
// use PHPUnit\Framework\Attributes\DataProvider;
// use PHPUnit\Framework\TestCase;

// class NotEmptyValidatorTest extends TestCase
// {
//     #[DataProvider('valueProvider')]
//     public function testIsValid($value,$expected): void
//     {
//         $NotEmptyValidator = new NotEmptyValidator($value);
//         $isValid = $NotEmptyValidator->isValid();
//         $this->assertEquals($expected,$isValid);
//     }

//     public static function valueProvider(): generator
//     {
//         yield ['',false];
//         yield ['full',true];
//     }

// }