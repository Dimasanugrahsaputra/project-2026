<?php

namespace App\Filament\Admin\Resources\DetailPeminjamanResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\DetailPeminjamanResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\DetailPeminjamanResource\Api\Transformers\DetailPeminjamanTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = DetailPeminjamanResource::class;


    /**
     * Show DetailPeminjaman
     *
     * @param Request $request
     * @return DetailPeminjamanTransformer
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

        return new DetailPeminjamanTransformer($query);
    }
}
