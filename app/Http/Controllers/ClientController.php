<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends BaseController
{
    public function __construct(ClientService $clientService)
    {
        parent::__construct($clientService);
    }

    /**
     * @return Application|Factory|View
     */
    public function home(): View
    {
        return view('client.index');
    }
}
