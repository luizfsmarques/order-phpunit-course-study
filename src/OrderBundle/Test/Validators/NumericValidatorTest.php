<?php declare(strict_types=1);

namespace OrderBundle\Test\Validators;

use OrderBundle\Validators\NumericValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NumericValidatorTest extends TestCase
{
    #[DataProvider('valueProvider')]
    //However,to declare the type of parameter $value, we could do: mixed $value
    public function testIsValid( string|int|float|bool $value, bool $expectedResult): void
    {
        $NumericValidator = new NumericValidator($value);
        $isValid = $NumericValidator->isValid();
        $this->assertEquals($expectedResult,$isValid);
    }

    public static function valueProvider(): array
    {
        return [
            'shouldBeValidWhenValueIsANumber' => ['value'=>20,'expectedResult'=>true],
            'shouldBeValidWhenValueIsANumberAsString' => ['value'=>'20','expectedResult'=>true],
            'shouldNotBeValiWhenValueIsString' => ['value'=>'bla','expectedResult'=>false],
            'shouldNotBeValidWhenValueIsEmpty' => ['value'=>'','expectedResult'=>false],
            'shouldNotBeValidWhenValueIsBoolean' => ['value'=>true,'expectedResult'=>false],
        ];
    }

}
