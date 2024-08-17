<?php

namespace App\Http\Controllers\Api\V1\Transporter;

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

    public function storeTrackLocation(TrackLocationRequest $request) :DataResponse
    {
        $transporter = auth("transporter-api")->id();
        $this->transporterService->saveLocation($transporter,$request->input("latitude") , $request->input("longitude"));
        return json_response(code: Response::HTTP_NO_CONTENT);
    }
}
