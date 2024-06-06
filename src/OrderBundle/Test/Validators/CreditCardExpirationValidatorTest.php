<?php declare(strict_types=1);

namespace OrderBundle\Test\Validators;

use OrderBundle\Validators\CreditCardExpirationValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CreditCardExpirationValidatorTest extends TestCase
{

    #[DataProvider('valueProvider')]
    public function testIsValid( string $value, bool $expectedResult): void 
    {
        $creditCardExpirationDate = new \DateTime($value);
        $CreditCardExpirationValidator = new CreditCardExpirationValidator($creditCardExpirationDate);
        $isValid = $CreditCardExpirationValidator->isValid();
        $this->assertEquals($expectedResult,$isValid);
    }

    public static function valueProvider(): array
    {
        return [
            'shouldBeValidWhenDateNotExpired' => ['value'=>'2100-12-31','expectedResult'=>true],
            'shouldNotBeValidWhenDateExpired' => ['value'=>'1990-01-01','expectedResult'=>false],
        ];
    }

}
