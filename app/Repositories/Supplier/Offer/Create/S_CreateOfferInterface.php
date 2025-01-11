<?php

namespace App\Repositories\Supplier\Offer\Create;

interface S_CreateOfferInterface
{
    /**
     *
     * @param array $search
     * @param array $data
     * @return mixed
     */
    public function create(array $search, array $data): mixed;
}
