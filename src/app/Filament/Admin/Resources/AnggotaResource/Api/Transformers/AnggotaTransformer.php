<?php
namespace App\Filament\Admin\Resources\AnggotaResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Anggota;

/**
 * @property Anggota $resource
 */
class AnggotaTransformer extends JsonResource
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
