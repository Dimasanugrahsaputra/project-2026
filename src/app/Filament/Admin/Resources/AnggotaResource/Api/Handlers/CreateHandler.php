<?php
namespace App\Filament\Admin\Resources\AnggotaResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\AnggotaResource;
use App\Filament\Admin\Resources\AnggotaResource\Api\Requests\CreateAnggotaRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = AnggotaResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Anggota
     *
     * @param CreateAnggotaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateAnggotaRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}