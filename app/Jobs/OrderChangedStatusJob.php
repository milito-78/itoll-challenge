<?php

namespace App\Jobs;

use App\Infrastructure\Webhook\Entities\OrderChangeEntity;
use App\Infrastructure\Webhook\Webhook;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Services\Dto\ChangeOrderStatusDto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderChangedStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $company,
        private readonly ChangeOrderStatusDto $dto
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(CompanyRepositoryInterface $companyRepository): void
    {
        $company = $companyRepository->getById($this->company);
        if (!$company){
            logger()->error("Company not found!" , [
                "company" => $this->company,
                "data" => $this->dto
            ]);
        }

        $url = $company->url;
        $token = $company->api_key;
        $webhook = new Webhook($url,$token);
        $result = $webhook->noticeOrderChange(new OrderChangeEntity(
            $this->dto->tracking_code,
            $this->dto->status,
            $this->dto->by,
            $this->dto->type,
            $this->dto->reason,
        ));

        if ($result->isFailed()){
            logger()->error("Failed to send request to : " . $company->name,[
                "result" => $result,
                "company" => $company->id,
            ]);
        }else{
            logger()->info("Success to send request : " . $company->name,[
                "result" => $result,
                "company" => $company->id,
            ]);
        }
    }
}
