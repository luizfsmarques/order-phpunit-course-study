<?php declare(strict_types=1);

namespace OrderBundle\Test\Validators;

use OrderBundle\Validators\CreditCardNumberValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CreditCardNumberValidatorTest extends TestCase
{
    #[DataProvider('valueProvider')]
    //However,to declare the type of parameter $value, we could do: mixed $value
    public function testIsValid( string|int|float|bool $value, bool $expectedResult): void
    {
        $CreditCardNumberValidator = new CreditCardNumberValidator($value);
        $isValid = $CreditCardNumberValidator->isValid();
        $this->assertEquals($expectedResult,$isValid);
    }

    public static function valueProvider(): array
    {
        return [
            'shouldBeValidWhenValueIsACreditCard' => ['value'=>1234567812345678,'expectedResult'=>true],
            'shouldBeValidWhenValueIsACreditCardAsString' => ['value'=>'1234567812345678','expectedResult'=>true],
            'shouldNotBeValiWhenValueIsString' => ['value'=>'bla','expectedResult'=>false],
            'shouldNotBeValidWhenValueIsEmpty' => ['value'=>'','expectedResult'=>false],
            'shouldNotBeValidWhenValueIsBoolean' => ['value'=>true,'expectedResult'=>false],
        ];
    }

}
