<?php
namespace App\Filament\Admin\Resources\DetailPeminjamanResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\DetailPeminjaman;

/**
 * @property DetailPeminjaman $resource
 */
class DetailPeminjamanTransformer extends JsonResource
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
