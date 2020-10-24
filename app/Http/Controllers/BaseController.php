<?php


namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index(){
        return $this->service->all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->service->save($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    /**
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->service->find($id);
    }

    /**
     * Retorno padrão para as respostas API
     * @param $data
     * @param bool $status
     * @param string $message
     * @param int $status_code
     * @return JsonResponse
     */
    public function responseApi($data, bool $status = true, string $message = '', int $status_code = 200): JsonResponse
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }
}
