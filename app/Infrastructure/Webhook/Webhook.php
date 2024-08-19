<?php

namespace App\Infrastructure\Webhook;

use App\Infrastructure\Webhook\Entities\OrderChangeEntity;
use App\Infrastructure\Webhook\Entities\OrderChangeResponseEntity;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Webhook
{
    public function __construct(
        private readonly string $url,
        private readonly string $token,
    )
    {
    }

    public function noticeOrderChange(OrderChangeEntity $entity): OrderChangeResponseEntity
    {
        try {
            $response = Http::withToken($this->token)->post($this->url,$entity->toArray());
            $response->throw();
            return new OrderChangeResponseEntity(
                status: true,
                message: "Successful",
                data: $response->json(),
            );
        }catch (RequestException $e) {
            logger()->error("Failed to send request!" , [
                "error" => $e,
                "data" => $entity
            ]);
            return new OrderChangeResponseEntity(
                status: false,
                message: "Error during send request",
                data: $e->response->json(),
                error: $e
            );
        } catch (\Throwable $exception){
            logger()->error("Failed!" , [
                "error" => $exception,
                "data" => $entity
            ]);
            return new OrderChangeResponseEntity(
                status: false,
                message: "Unknown error : " . $exception->getMessage(),
                error: $exception
            );
        }
    }
}
