<?php
namespace App\Filament\Admin\Resources\AnggotaResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\AnggotaResource;
use Illuminate\Routing\Router;


class AnggotaApiService extends ApiService
{
    protected static string | null $resource = AnggotaResource::class;

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
