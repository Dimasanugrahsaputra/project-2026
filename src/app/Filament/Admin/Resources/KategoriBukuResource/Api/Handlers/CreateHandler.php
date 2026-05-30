<?php
namespace App\Filament\Admin\Resources\KategoriBukuResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\KategoriBukuResource;
use App\Filament\Admin\Resources\KategoriBukuResource\Api\Requests\CreateKategoriBukuRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = KategoriBukuResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create KategoriBuku
     *
     * @param CreateKategoriBukuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateKategoriBukuRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}