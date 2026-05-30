<?php
namespace App\Filament\Admin\Resources\DendaResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Admin\Resources\DendaResource;
use Illuminate\Routing\Router;


class DendaApiService extends ApiService
{
    protected static string | null $resource = DendaResource::class;

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
