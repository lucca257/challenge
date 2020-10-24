<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class BaseController
{
    protected $service;
    public function __construct(object $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->service->all();
    }

    public function store(Request $request)
    {
        return $this->service->save($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public function find(int $id)
    {
        return $this->service->find($id);
    }
}
