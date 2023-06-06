<?php

namespace App\Modules\Workers\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Workers\Repositories\WorkerRepository;
use App\Modules\Workers\Requests\WorkerStoreRequest;
use App\Modules\Workers\Requests\WorkerUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class WorkerController extends Controller
{
    public function index(WorkerRepository $worker, Request $request)
    {
        return response()->json(
            $worker->findAll($request)
        );
    }

    public function store(WorkerStoreRequest $request, WorkerRepository $worker)
    {
        return response()->json(
            $worker->create($request),
            Response::HTTP_OK
        );
    }

    public function show(WorkerRepository $worker, $id)
    {
        return response()->json(
            $worker->find($id)
        );
    }

    public function update(WorkerUpdateRequest $request, WorkerRepository $worker, $id)
    {
        return response()->json(
            $worker->update($request, $id),
            Response::HTTP_OK
        );
    }

    public function delete(WorkerRepository $worker, $id)
    {
        $worker->delete($id);
    }
}
