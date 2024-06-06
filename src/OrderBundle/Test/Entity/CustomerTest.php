<?php declare(strict_types=1);

namespace OrderBundle\Test\Entity;

use OrderBundle\Entity\Customer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    #[DataProvider('customerAllowedDataProvider')]
    // #[Test] //Não pegou por qual motivo?
    public function testIsAllowedToOrder( bool $isActive, bool $isBlocked, bool $expectedResult): void
    {
        $Customer = new Customer(
            $isActive,
            $isBlocked,
            'Fernando',
            '+5522912345678'
        );
        $isAllowed = $Customer->isAllowedToOrder();
        $this->assertEquals($expectedResult,$isAllowed);

    }

    public static function customerAllowedDataProvider(): array
    {
        return [
            'shouldBeAllowedWhenIsActiveAndNotBlocked' => [
                'isActive'=>true,
                'isBlocked'=>false,
                'expectedResult'=>true
            ],
            'shouldNotBeAllowedWhenIsActiveButBlocked' => [
                'isActive'=>true,
                'isBlocked'=>true,
                'expectedResult'=>false
            ],
            'shouldNotBeAllowedWhenIsNotActiveAndNotBlocked' => [
                'isActive'=>false,
                'isBlocked'=>false,
                'expectedResult'=>false
            ],
            'shouldNotBeAllowedWhenIsNotActiveAndBlocked' => [
                'isActive'=>false,
                'isBlocked'=>false,
                'expectedResult'=>false
            ],
        ];
    }

}