<?php

namespace App\Http\Resources\v1\General\Product;

use App\Enums\EncodingMethodsEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class G_ProductResource extends JsonResource
{
    protected $storeProductIds;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param array|null $storeProductIds
     * @return void
     */
    public function __construct($resource, $storeProductIds = null)
    {
        parent::__construct($resource);
        $this->storeProductIds = $storeProductIds;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => encodeString($this->id),
            'name' => $this->localized?->name,
            'category_id' => $this->category_id,
            'image' => $this->image,
            'in_store' => $this->isInStore(),
        ];
    }

    /**
     * Check if product is not in store.
     *
     * @return bool
     */
    protected function isInStore()
    {
        return $this->storeProductIds ? !in_array($this->id, $this->storeProductIds) : true;
    }

    /**
     * Create new collection with store product IDs.
     *
     * @param mixed $resource
     * @param array|null $storeProductIds
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource, $storeProductIds = null)
    {
        return tap(parent::collection($resource), function ($collection) use ($storeProductIds) {
            $collection->each(function ($resource) use ($storeProductIds) {
                $resource->storeProductIds = $storeProductIds;
            });
        });
    }
}