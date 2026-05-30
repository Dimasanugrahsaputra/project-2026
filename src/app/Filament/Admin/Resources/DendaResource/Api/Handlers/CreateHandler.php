<?php
namespace App\Filament\Admin\Resources\DendaResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\DendaResource;
use App\Filament\Admin\Resources\DendaResource\Api\Requests\CreateDendaRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = DendaResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Denda
     *
     * @param CreateDendaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateDendaRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}