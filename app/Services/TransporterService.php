<?php

namespace App\Services;

use App\Domains\Transporter;
use App\Repositories\Interfaces\LocationRepositoryInterface;
use App\Repositories\Interfaces\TransporterRepositoryInterface;

class TransporterService
{
    public function __construct(
        private readonly TransporterRepositoryInterface $repository,
        private readonly LocationRepositoryInterface $locationRepository,
    )
    {
    }

    public function details(int $id): ?Transporter
    {
        return $this->repository->getById($id);
    }

    public function saveLocation(int $transporter, float $lat, float $long): bool
    {
        return $this->locationRepository->updateOrCreate($transporter,$lat,$long);
    }

    /**
     * @param int $transporter
     * @return array{latitude: float, longitude: float}
     */
    public function getLocation(int $transporter) : array
    {
        return $this->locationRepository->get($transporter);
    }
}
