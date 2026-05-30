<?php
namespace App\Filament\Admin\Resources\AnggotaResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\AnggotaResource;
use App\Filament\Admin\Resources\AnggotaResource\Api\Requests\UpdateAnggotaRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = AnggotaResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Anggota
     *
     * @param UpdateAnggotaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateAnggotaRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}