<?php

namespace App\Repositories\Interfaces;

use App\Domains\Order;
use App\Repositories\Queryable\AcceptOrderQueryable;
use App\Repositories\Queryable\OrderQueryable;
use App\Services\Dto\ChangeOrderStatusDto;
use App\Services\Dto\CreateOrderDto;
use Illuminate\Contracts\Pagination\Paginator;

interface OrderRepositoryInterface
{

    /**
     * Get order with created status
     *
     * @param AcceptOrderQueryable $queryable
     * @return Paginator<Order>
     */
    public function getAcceptableOrders(AcceptOrderQueryable $queryable) : Paginator;

    /**
     * Get order with filter
     *
     * @param OrderQueryable $queryable
     * @return Paginator<Order>
     */
    public function getPaginate(OrderQueryable $queryable) : Paginator;

    /**
     * Create new order
     *
     * @param CreateOrderDto $order
     * @return Order|null
     */
    public function create(CreateOrderDto $order): ?Order;

    /**
     * Update order status
     *
     * @param ChangeOrderStatusDto $dto
     * @return ?bool
     */
    public function changeStatus(ChangeOrderStatusDto $dto): ?bool;

    /**
     * Get order details by id
     *
     * @param int $id
     * @return Order|null
     */
    public function getById(int $id): ?Order;


    /**
     * Get order details by tracking_code
     *
     * @param string $tracking
     * @return Order|null
     */
    public function getByTrackingCode(string $tracking): ?Order;
}
