<?php declare(strict_types=1);

namespace PaymentBundle\Test\Service;

use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    private $array;

    public static function setUpBeforeClass():  void
    {
        
    }

    public function testShouldBeFilled(): void 
    {
        $this->array = ['hello'=>'world'];

        $this->assertNotEmpty($this->array);
    }

    public function testShouldBeEmpty(): void
    {
        $this->assertEmpty($this->array);
    }
}
