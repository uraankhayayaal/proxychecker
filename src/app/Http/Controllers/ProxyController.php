<?php

namespace App\Http\Controllers;

use App\Services\ProxyCheckerService;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function __construct(protected ProxyCheckerService $service) {}

    public function index(Request $request)
    {
        return 'asdas';
    }

    public function check(Request $request)
    {
        $request->validate([
            'proxies' => 'required|string',
        ]);

        $listOfProxies = $request->only('proxies');

        $query = $this->service->queueToCheck($listOfProxies['proxies']);

        return view('proxy', [
            'query' => $query
        ]);
    }
}
