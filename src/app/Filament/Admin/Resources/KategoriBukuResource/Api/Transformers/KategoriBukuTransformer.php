<?php
namespace App\Filament\Admin\Resources\KategoriBukuResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\KategoriBuku;

/**
 * @property KategoriBuku $resource
 */
class KategoriBukuTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
