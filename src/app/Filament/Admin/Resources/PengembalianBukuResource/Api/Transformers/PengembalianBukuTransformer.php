<?php
namespace App\Filament\Admin\Resources\PengembalianBukuResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PengembalianBuku;

/**
 * @property PengembalianBuku $resource
 */
class PengembalianBukuTransformer extends JsonResource
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
