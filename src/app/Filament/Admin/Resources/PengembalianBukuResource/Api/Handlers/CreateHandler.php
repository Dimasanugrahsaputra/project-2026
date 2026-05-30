<?php
namespace App\Filament\Admin\Resources\PengembalianBukuResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\PengembalianBukuResource;
use App\Filament\Admin\Resources\PengembalianBukuResource\Api\Requests\CreatePengembalianBukuRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = PengembalianBukuResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create PengembalianBuku
     *
     * @param CreatePengembalianBukuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreatePengembalianBukuRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}