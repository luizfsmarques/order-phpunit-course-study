<?php declare(strict_types=1);

namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use FidelityProgramBundle\Repository\PointsRepository;
use FidelityProgramBundle\Test\Service\PointsRepositorySpy;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

//Example 2 -> Implemented on classe of dummies and spies
class FidelityProgramServiceTest extends TestCase
{

    // First scenerio
    public function testShouldSaveWhenReceivePoints(): void
    {
        $PointsRepository = $this->createMock(PointsRepository::class);
        $PointsRepository->expects($this->once())->method('save');

        //Here I create stub with indicated structure of php unit's documentation
        $PointsCalculator = $this->createStub(PointsCalculator::class);
        $PointsCalculator->method('calculatePointsToReceive')->willReturn(100);

        // On this example, it was implemented a spy, using callback function o php unit, here in LoggerInterface
        $LoggerInterface = $this->createMock(LoggerInterface::class);
        $allMessages = [];
        $LoggerInterface->method('log')->willReturnCallback(
            function($message) use (&$allMessages)
            {
                $allMessages[] = $message;
            }
        );

        $FidelityProgramService = new FidelityProgramService($PointsRepository,$PointsCalculator,$LoggerInterface);

        // This is a dummie
        $Customer = $this->createStub(Customer::class);
        $value = 50;

        $FidelityProgramService->addPoints($Customer,$value);

        //Here I put the expected values and do the assert
        $expectedMessages = [
            'Checking points for customer',
            'Customer received points'
        ];
        $this->assertEquals($expectedMessages,$allMessages);
    }

    //Second scenerio
    public function testShouldNotSaveWhenReceiveZeroPoints(): void
    {
        $PointsRepository = $this->createMock(PointsRepository::class);
        $PointsRepository->expects($this->never())->method('save');

        $PointsCalculator = $this->createMock(PointsCalculator::class);
        $PointsCalculator->method('calculatePointsToReceive')->willReturn(0);

        $LoggerInterface = $this->createMock(LoggerInterface::class);

        $FidelityProgramService = new FidelityProgramService($PointsRepository,$PointsCalculator,$LoggerInterface);

        // This is a dummie
        $Customer = $this->createMock(Customer::class);
        $value = 20;

        $FidelityProgramService->addPoints($Customer,$value);
    }

}


/*
// Exemplo 1 -> Implemented on classe of dummies and spies
namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use FidelityProgramBundle\Repository\PointsRepository;
use FidelityProgramBundle\Test\Service\PointsRepositorySpy;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class FidelityProgramServiceTest extends TestCase
{

    // First scenerio
    public function testShouldSaveWhenReceivePoints(): void
    {
        // $PointsRepository = $this->createMock(PointsRepository::class);
        // $PointsRepository->expects($this->once())->method('save');

        $PointsRepository = new PointsRepositorySpy();

        $PointsCalculator = $this->createMock(PointsCalculator::class);
        $PointsCalculator->method('calculatePointsToReceive')->willReturn(100);

        $LoggerInterface = $this->createMock(LoggerInterface::class);

        $FidelityProgramService = new FidelityProgramService($PointsRepository,$PointsCalculator,$LoggerInterface);

        // This is a dummie
        $Customer = $this->createMock(Customer::class);
        $value = 50;

        $FidelityProgramService->addPoints($Customer,$value);

        $this->assertTrue($PointsRepository->called());
    }

    //Second scenerio
    public function testShouldNotSaveWhenReceiveZeroPoints(): void
    {
        $PointsRepository = $this->createMock(PointsRepository::class);
        $PointsRepository->expects($this->never())->method('save');

        $PointsCalculator = $this->createMock(PointsCalculator::class);
        $PointsCalculator->method('calculatePointsToReceive')->willReturn(0);

        $LoggerInterface = $this->createMock(LoggerInterface::class);

        $FidelityProgramService = new FidelityProgramService($PointsRepository,$PointsCalculator,$LoggerInterface);

        // This is a dummie
        $Customer = $this->createMock(Customer::class);
        $value = 20;

        $FidelityProgramService->addPoints($Customer,$value);
    }

}
*/


/*
// Example did on classe of mocks
namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use FidelityProgramBundle\Repository\PointsRepository;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class FidelityProgramServiceTest extends TestCase
{

    // First scenerio
    public function testShouldSaveWhenReceivePoints(): void
    {
        $PointsRepository = $this->createMock(PointsRepository::class);
        $PointsRepository->expects($this->once())->method('save');

        $PointsCalculator = $this->createMock(PointsCalculator::class);
        $PointsCalculator->method('calculatePointsToReceive')->willReturn(100);

        $LoggerInterface = $this->createMock(LoggerInterface::class);

        $FidelityProgramService = new FidelityProgramService($PointsRepository,$PointsCalculator,$LoggerInterface);

        // This is a dummie
        $Customer = $this->createMock(Customer::class);
        $value = 50;

        $FidelityProgramService->addPoints($Customer,$value);
    }

    //Second scenerio
    public function testShouldNotSaveWhenReceiveZeroPoints(): void
    {
        $PointsRepository = $this->createMock(PointsRepository::class);
        $PointsRepository->expects($this->never())->method('save');

        $PointsCalculator = $this->createMock(PointsCalculator::class);
        $PointsCalculator->method('calculatePointsToReceive')->willReturn(0);

        $LoggerInterface = $this->createMock(LoggerInterface::class);

        $FidelityProgramService = new FidelityProgramService($PointsRepository,$PointsCalculator,$LoggerInterface);

        // This is a dummie
        $Customer = $this->createMock(Customer::class);
        $value = 20;

        $FidelityProgramService->addPoints($Customer,$value);
    }

}
*/