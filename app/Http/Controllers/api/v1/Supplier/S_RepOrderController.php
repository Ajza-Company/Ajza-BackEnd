<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Models\RepChat;
use App\Repositories\Supplier\RepOrder\Find\S_FindRepOrderInterface;
use App\Services\Supplier\RepOrder\S_AcceptRepOrderService;
use Illuminate\Http\Request;

class S_RepOrderController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param S_AcceptRepOrderService $acceptRepOrder
     */
    public function __construct(private S_AcceptRepOrderService $acceptRepOrder)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function accept(string $rep_order_id)
    {
        return $this->acceptRepOrder->execute($rep_order_id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function orders()
    {
        //
    }
}
