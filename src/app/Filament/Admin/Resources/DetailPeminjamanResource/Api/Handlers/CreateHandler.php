<?php
namespace App\Filament\Admin\Resources\DetailPeminjamanResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\DetailPeminjamanResource;
use App\Filament\Admin\Resources\DetailPeminjamanResource\Api\Requests\CreateDetailPeminjamanRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = DetailPeminjamanResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create DetailPeminjaman
     *
     * @param CreateDetailPeminjamanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateDetailPeminjamanRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}