<?php

namespace App\Http\Controllers\Api\V1\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Transporter\TrackLocationRequest;
use App\Infrastructure\ApiResponse\DataResponse;
use App\Services\TransporterService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransporterController extends Controller
{
    public function __construct(
        private readonly TransporterService $transporterService
    )
    {
    }

    public function trackLocation(string $transporter) :DataResponse
    {
        $result = $this->transporterService->getLocation((int)$transporter);
        return json_response(data: $result);
    }
}
