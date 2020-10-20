<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends BaseController
{
    public function __construct(ClientService $clientService)
    {
        parent::__construct($clientService);
    }

    public function index()
    {
        return view('client.index');
    }

    public function create()
    {
        return view('client.create');
    }

    public function show($id)
    {
        return view('client.show');
    }

    public function edit($id)
    {
        return view('client.edit');
    }
}
