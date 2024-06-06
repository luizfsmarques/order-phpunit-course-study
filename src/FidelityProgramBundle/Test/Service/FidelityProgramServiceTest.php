<?php declare(strict_types=1);

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

        $Customer = $this->createMock(Customer::class);
        $value = 20;

        $FidelityProgramService->addPoints($Customer,$value);
    }

}