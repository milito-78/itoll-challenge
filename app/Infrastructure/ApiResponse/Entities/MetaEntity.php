<?php

namespace App\Infrastructure\ApiResponse\Entities;

use Illuminate\Contracts\Support\Arrayable;

class MetaEntity implements Arrayable
{
    public function __construct(
        public bool $simple_paginate = false,
        public int $per_page = 0,
        public int $count = 0,
        public int $current = 0,
        public ?int $next = null,
        public ?int $prev = null,
        public ?int $total = null,
        public ?int $last = null,
    )
    {
    }


    public function toArray():array
    {
        $meta = [
            "simple_paginate"   => $this->simple_paginate,
            "per_page"          => $this->per_page,
            "count"             => $this->count,
            "current_page"      => $this->current,
            "next_page"         => $this->next,
            "prev_page"         => $this->prev,
        ];
        if (!$this->simple_paginate){
            $meta["total"]      = $this->total;
            $meta["last_page"]  = $this->last;
        }
        return $meta;
    }
}
