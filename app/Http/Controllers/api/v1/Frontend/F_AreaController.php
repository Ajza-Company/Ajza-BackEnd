<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Enums\EncodingMethodsEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Frontend\Area\F_AreaResource;
use App\Repositories\Frontend\Area\Fetch\F_FetchAreaInterface;
use Illuminate\Http\Request;

class F_AreaController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_FetchAreaInterface $fetchArea
     */
    public function __construct(private F_FetchAreaInterface $fetchArea)
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(string $city_id)
    {
        $city_id = decodeString($city_id, EncodingMethodsEnum::HASHID);
        return F_AreaResource::collection($this->fetchArea->fetch(data: ['state_id' => $city_id], paginate: false));
    }
}
