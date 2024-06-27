<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQueryRequest;
use App\Models\Query;
use App\Rules\IsIpAddress;
use App\Services\ProxyCheckerService;
use App\Services\QueryService;

class QueryController extends Controller
{
    public function __construct(
        protected QueryService $service,
        protected ProxyCheckerService $checkerService,
    ) {}

    public function index()
    {
        return view('queries', [
            'queries' => $this->service->getAll()
        ]);
    }

    public function store(StoreQueryRequest $request)
    {
        $data = $request->only('addresses');

        $query = $this->service->create($data);

        $this->checkerService->queueToCheck($query);

        return redirect('/query/' . $query->id)->with('success', 'Ваш запрос принят в обработку.');
    }

    public function view(Query $query)
    {
        return view('query', [
            'query' => $query
        ]);
    }
}
