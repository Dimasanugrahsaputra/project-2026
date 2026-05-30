<?php
namespace App\Filament\Admin\Resources\DendaResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Denda;

/**
 * @property Denda $resource
 */
class DendaTransformer extends JsonResource
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
