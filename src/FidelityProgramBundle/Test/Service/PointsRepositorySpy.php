<?php declare(strict_types=1);

namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Repository\PointsRepositoryInterface;

class PointsRepositorySpy implements PointsRepositoryInterface
{
    private bool $called;

    public function save($points): void
    {
        $this->called = true;
    }

    public function called(): bool
    {
        return $this->called;
    }
}