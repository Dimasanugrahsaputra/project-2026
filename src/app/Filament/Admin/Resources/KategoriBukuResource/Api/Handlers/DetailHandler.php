<?php

namespace App\Filament\Admin\Resources\KategoriBukuResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\KategoriBukuResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\KategoriBukuResource\Api\Transformers\KategoriBukuTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = KategoriBukuResource::class;


    /**
     * Show KategoriBuku
     *
     * @param Request $request
     * @return KategoriBukuTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new KategoriBukuTransformer($query);
    }
}
