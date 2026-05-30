<?php
namespace App\Filament\Admin\Resources\KategoriBukuResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\KategoriBukuResource;
use App\Filament\Admin\Resources\KategoriBukuResource\Api\Requests\UpdateKategoriBukuRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = KategoriBukuResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update KategoriBuku
     *
     * @param UpdateKategoriBukuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateKategoriBukuRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}