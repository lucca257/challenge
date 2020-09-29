<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use Illuminate\Http\Request;
use \App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

   public function __construct(ProductService $productService)
   {
       $this->productService = $productService;
   }

    public function show($id)
    {
        $product = $this->productService->find($id);
        return view('product.show')->with(["product" => $product]);
    }

    public function list()
    {
        return $this->productService->all();
    }

    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(ProductStoreRequest $request)
    {
        return $this->productService->save($request->all());
    }

    public function edit($id)
    {
        $product = $this->productService->find($id);
        return view('product.edit')->with(["product" => $product]);
    }

    public function update(Request $request, $id)
    {
        return $this->productService->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->productService->destroy($id);
    }

    public function find($id)
    {
        return $this->productService->find((int) $id);
    }
}
