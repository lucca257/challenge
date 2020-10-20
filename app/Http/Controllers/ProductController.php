<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use Illuminate\Http\Request;
use \App\Services\ProductService;

class ProductController extends BaseController
{
    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
   public function __construct(ProductService $productService)
   {
       parent::__construct($productService);
   }

    /**
     * view com todas as operações de crud (criar, editar, excluir e visualizar)
     */
    public function home()
    {
        return view('product.index');
    }
}
