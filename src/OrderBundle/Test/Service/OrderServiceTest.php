<?php declare(strict_types=1);

namespace OrderBundle\Test\Service;

use FidelityProgramBundle\Service\FidelityProgramService;
use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;
use OrderBundle\Entity\Order;
use OrderBundle\Service\BadWordsValidator;
use OrderBundle\Service\OrderService;
use OrderBundle\Exception\BadWordsFoundException;
use OrderBundle\Exception\CustomerNotAllowedException;
use OrderBundle\Exception\ItemNotAvailableException;
use OrderBundle\Repository\OrderRepository;
use PaymentBundle\Service\PaymentService;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{

    private $BadWordsValidator;
    private $PaymentSevice;
    private $OrderRepository;
    private $FidelityProgramService;
    private $Customer;
    private $Item;
    private $CreditCard;

    public function setUp(): void
    {

        $this->BadWordsValidator = $this->createMock(BadWordsValidator::class);
        $this->PaymentService = $this->createMock(PaymentService::class);
        $this->OrderRepository = $this->createMock(OrderRepository::class);
        $this->FidelityProgramService = $this->createMock(FidelityProgramService::class);
        $this->Customer = $this->createMock(Customer::class);
        $this->Item = $this->createMock(Item::class);
        $this->CreditCard = $this->createMock(CreditCard::class);

    }

    public function testShouldNotProcessWhenCustomeNotAllowed(): void
    {
        $OrderService = new OrderService(
            $this->BadWordsValidator,
            $this->PaymentService,
            $this->OrderRepository,
            $this->FidelityProgramService
        );

        $this->Customer->method('isAllowedToOrder')->willReturn(false);

        $this->expectException(CustomerNotAllowedException::class);

        $OrderService->process(
            $this->Customer,
            $this->Item,
            '',
            $this->CreditCard
        );
    }



    public function tearDown(): void
    {

        unset($this->BadWordsValidator);
        unset($this->PaymentService);
        unset($this->OrderRepository);
        unset($this->FidelityProgramService);
        unset($this->Customer);
        unset($this->Item);
        unset($this->CreditCard);

    }

}