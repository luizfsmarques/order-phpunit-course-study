<?php declare(strict_types=1);

namespace PaymentBundle\Test\Service;

use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;
use PaymentBundle\Exception\PaymentErrorException;
use PaymentBundle\Repository\PaymentTransactionRepository;
use PaymentBundle\Service\Gateway;
use PaymentBundle\Service\PaymentService;
use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{
    private $Gateway;
    private $PaymentTransactionRepository;
    private $PaymentService;
    private $Customer;
    private $Item;
    private $CreditCard;

    public function setUp(): void
    {
        $this->Gateway = $this->createMock(Gateway::class);
        $this->PaymentTransactionRepository = $this->createMock(PaymentTransactionRepository::class);
        $this->PaymentService = new PaymentService($this->Gateway,$this->PaymentTransactionRepository);

        $this->Customer = $this->createMock(Customer::class);
        $this->Item = $this->createMock(Item::class);
        $this->CreditCard = $this->createMock(CreditCard::class);
    }

    public function testShouldSaveWhenatewayReturnOkWithRetries(): void 
    {

        $this->Gateway->expects($this->atLeast(3))->method('pay')
            ->willReturn(
                false,false,true
            );

        $this->PaymentTransactionRepository->expects($this->once())->method('save');

        $this->PaymentService->pay($this->Customer,$this->Item,$this->CreditCard);

    }    

    public function testShouldThrowExceptionWhenGatewayFails(): void 
    {

        $this->Gateway->expects($this->atLeast(3))->method('pay')
            ->willReturn(
                false,false,false
            );

        $this->expectException(PaymentErrorException::class);

        $this->PaymentTransactionRepository->expects($this->never())->method('save');

        $this->PaymentService->pay($this->Customer,$this->Item,$this->CreditCard);

    }    

}

/*
//SUBJECT STUDIED: MOCKS WITH RETURN DEPENDING OF THE CALL'S SEQUENCE AND EXCEPTION TESTING
namespace PaymentBundle\Test\Service;

use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;
use PaymentBundle\Exception\PaymentErrorException;
use PaymentBundle\Repository\PaymentTransactionRepository;
use PaymentBundle\Service\Gateway;
use PaymentBundle\Service\PaymentService;
use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{

    public function testShouldSaveWhenatewayReturnOkWithRetries(): void 
    {
        $Gateway = $this->createMock(Gateway::class);
        $PaymentTransactionRepository = $this->createMock(PaymentTransactionRepository::class);
        $PaymentService = new PaymentService($Gateway,$PaymentTransactionRepository);

        $Gateway->expects($this->atLeast(3))->method('pay')
            ->willReturn(
                false,false,true
            );

        $PaymentTransactionRepository->expects($this->once())->method('save');

        $Customer = $this->createMock(Customer::class);
        $Item = $this->createMock(Item::class);
        $CreditCard = $this->createMock(CreditCard::class);

        $PaymentService->pay($Customer,$Item,$CreditCard);

    }    

    public function testShouldThrowExceptionWhenGatewayFails(): void 
    {
        $Gateway = $this->createMock(Gateway::class);
        $PaymentTransactionRepository = $this->createMock(PaymentTransactionRepository::class);
        $PaymentService = new PaymentService($Gateway,$PaymentTransactionRepository);

        $Gateway->expects($this->atLeast(3))->method('pay')
            ->willReturn(
                false,false,false
            );

        $this->expectException(PaymentErrorException::class);

        $PaymentTransactionRepository->expects($this->never())->method('save');

        $Customer = $this->createMock(Customer::class);
        $Item = $this->createMock(Item::class);
        $CreditCard = $this->createMock(CreditCard::class);

        $PaymentService->pay($Customer,$Item,$CreditCard);

    }    

}
*/