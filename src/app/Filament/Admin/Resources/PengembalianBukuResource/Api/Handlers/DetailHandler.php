<?php

namespace App\Filament\Admin\Resources\PengembalianBukuResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Admin\Resources\PengembalianBukuResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Admin\Resources\PengembalianBukuResource\Api\Transformers\PengembalianBukuTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = PengembalianBukuResource::class;


    /**
     * Show PengembalianBuku
     *
     * @param Request $request
     * @return PengembalianBukuTransformer
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

        return new PengembalianBukuTransformer($query);
    }
}
