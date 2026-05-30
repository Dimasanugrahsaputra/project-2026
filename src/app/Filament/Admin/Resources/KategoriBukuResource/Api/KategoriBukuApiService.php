<?php
namespace App\Filament\Admin\Resources\KategoriBukuResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\KategoriBukuResource;
use Illuminate\Routing\Router;


class KategoriBukuApiService extends ApiService
{
    protected static string | null $resource = KategoriBukuResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
