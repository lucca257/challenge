<?php


namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController
{
    /**
     * @var object
     */
    protected $service;

    /**
     * BaseController constructor.
     * @param object $service
     */
    public function __construct(object $service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->service->all();
            return $this->responseApi($data, 'Dados retornados com sucesso');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->responseApi([], 'Falha interna ao listar dados', false, 500);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->service->save($request->all());
            return $this->responseApi([], 'Dados criados com sucesso');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->responseApi([], 'Falha interna ao criar dados', false, 500);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            //verificando se item existe
            $item = $this->find($id);
            if (!$item->original['success']){
                return $item;
            }
            $this->service->update($id, $request->all());
            return $this->responseApi([], 'Dados alterados com sucesso');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->responseApi([], 'Falha interna ao alterar dados', false, 500);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id): JsonResponse
    {
        try {
            //verificando se item existe
            $item = $this->find($id);
            if (!$item->original['success']){
                return $item;
            }

            $this->service->destroy($id);
            return $this->responseApi([], 'Dados excluidos com sucesso');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->responseApi([], 'Falha interna ao excluir dados', false, 500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): JsonResponse
    {
        try {
            $data = $this->service->find($id);
            if (!$data){
                return $this->responseApi([], 'Este registro não existe', false, 200);
            }
            return $this->responseApi($data, 'Dados retornados com sucesso');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->responseApi([], 'Falha interna ao retornar dados', false, 500);
        }
    }

    /**
     * Retorno padrão para as respostas API
     * @param $data
     * @param bool $status
     * @param string $message
     * @param int $status_code
     * @return JsonResponse
     */
    public function responseApi($data, string $message = '', bool $status = true, int $status_code = 200): JsonResponse
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }
}
