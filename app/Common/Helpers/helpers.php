<?php


use App\Infrastructure\ApiResponse\DataResponse;
use App\Infrastructure\ApiResponse\Entities\MetaEntity;
use App\Infrastructure\ApiResponse\ErrorResponse;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

if (! function_exists("resourceDateTimeFormat")){
    function resourceDateTimeFormat(\Carbon\Carbon $time = null): string
    {
        return (! is_null($time)) ? $time->toDateTimeString() : \Carbon\Carbon::now()->toDateTimeString();
    }
}


if (!function_exists("json_response")){
    function json_response(
        ?string $message = null,
        int $code = SymphonyResponse::HTTP_OK,
        mixed $data = null,
        ?MetaEntity $meta = null
    ) : DataResponse
    {
        return new DataResponse(
            $message,$code,$data,$meta
        );
    }
}

if (!function_exists("error_response")){
    function error_response(
        ?string $message = null,
        ?string $error = null,
        int $code = SymphonyResponse::HTTP_BAD_REQUEST,
        array $errors = [],
        mixed $data = null
    ) : ErrorResponse
    {
        return new ErrorResponse(
            $message,
            $error, $code ,
            $errors,
            $data
        );
    }
}


if(!function_exists("abort_json")){
    function abort_json(int $code, string $message = ""): void
    {
        abort($code, $message, ["accept" => "application/json"]);
    }
}



if (! function_exists("resourceDateFormat")){
    function resourceDateFormat(\Carbon\Carbon $time = null): string
    {
        return (! is_null($time)) ? $time->toDateString() : \Carbon\Carbon::now()->toDateString();
    }
}
