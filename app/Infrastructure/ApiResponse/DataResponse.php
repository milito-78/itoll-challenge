<?php

namespace App\Infrastructure\ApiResponse;

use App\Infrastructure\ApiResponse\Entities\MetaEntity;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseSymphony;

class DataResponse implements Arrayable, Responsable
{
    protected string $message;

    protected mixed $data;

    protected ?MetaEntity $meta = null;
    protected int $code;

    public function __construct(
        ?string $message = null,
        int $code = ResponseSymphony::HTTP_OK,
        mixed $data = null,
        ?MetaEntity $meta = null
    )
    {
        $this->setMessage($message??"Success");
        $this->setData($data);
        $this->setCode($code);
        if ($meta)
            $this->setMeta($meta);
    }


    public function setMessage(string $message) : self
    {
        $this->message = $message;
        return $this;
    }

    public function setMeta(?MetaEntity $meta): self
    {
        $this->meta = $meta;
        return $this;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }


    public function toResponse($request): JsonResponse|Response
    {
        if ($this->code == ResponseSymphony::HTTP_NO_CONTENT)
            return response()->json(null,$this->code);

        return response()->json($this->toArray(),$this->code);
    }

    public function toArray():array
    {
        $array = [
            "message"   => $this->message,
            "data"      => $this->data,
        ];

        if ($this->meta){
            $array["meta"] = $this->meta->toArray();
        }

        return $array;
    }

    public function setData(mixed $data): self
    {
        if ($data instanceof ResourceCollection){
            $this->data = $data->response()->getData(true)["data"];
            if ($data->resource instanceof LengthAwarePaginator)
                $this->setLengthAwarePaginatorMeta($data->resource);
            elseif ($data->resource instanceof Paginator)
                $this->setPaginatorMeta($data->resource);
        }
        elseif ($data instanceof LengthAwarePaginator)
        {
            $this->data = $data->items();
            $this->setLengthAwarePaginatorMeta($data);
        }
        elseif ($data instanceof Paginator)
        {
            $this->data = $data->items();
            $this->setPaginatorMeta($data);
        }
        else {
            $this->data = $data;
        }
        return $this;
    }

    private function setLengthAwarePaginatorMeta(LengthAwarePaginator $data):void{
        $this->setMeta(new MetaEntity(
            simple_paginate: false,
            per_page: $data->perPage(),
            count: $data->count(),
            current: $data->currentPage(),
            next: $data->nextPageUrl() ? $data->currentPage() + 1: null,
            prev: $data->currentPage() - 1 <= 0 ? null: $data->currentPage() - 1,
            total: $data->total(),
            last: $data->lastPage(),
        ));
    }

    private function setPaginatorMeta(Paginator $data):void{
        $this->setMeta(new MetaEntity(
            simple_paginate: true,
            per_page: $data->perPage(),
            count: $data->count(),
            current: $data->currentPage(),
            next: $data->hasMorePages() ? $data->currentPage() + 1 : null,
            prev: $data->currentPage() - 1 <= 0 ? null: $data->currentPage() - 1,
        ));
    }
}
