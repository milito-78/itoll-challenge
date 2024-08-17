<?php

namespace App\Repositories\Redis;

use App\Repositories\Interfaces\LocationRepositoryInterface;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;
use JetBrains\PhpStorm\ArrayShape;

class LocationRepository implements LocationRepositoryInterface
{
    private function getQuery(): Connection
    {
        return Redis::connection();
    }

    /**
     * @inheritDoc
     */
    public function updateOrCreate(int $transporter, float $lat, float $long): bool
    {
        $key = $this->keyGen($transporter);
        try {
            $this->getQuery()->client()->lPush($key, json_encode(["latitude" => $lat, "longitude" => $long]));
            $this->getQuery()->client()->lTrim($key, 0,0);
        } catch (\RedisException $e) {
            logger()->error("Error during push redis : " . $e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(["latitude" => "float", "longitude" => "float"])] public function get(int $transporter): array
    {
        try {
            $result = $this->getQuery()->client()->lIndex($this->keyGen($transporter), 0);
            $data = json_decode($result,true);
        } catch (\RedisException $e) {
            logger()->error("Error during push redis : " . $e->getMessage());
            return [];
        }

        return $data??[];
    }


    private function keyGen(int $transporter) : string
    {
        return "transporters:locations:tr-" . $transporter;
    }
}
