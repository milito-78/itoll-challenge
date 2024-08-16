<?php

namespace App\Repositories\Queryable;

class AcceptOrderQueryable
{
    public function __construct(
        public int $page = 1,
        public int $per_page = 15,
    )
    {
    }
}
