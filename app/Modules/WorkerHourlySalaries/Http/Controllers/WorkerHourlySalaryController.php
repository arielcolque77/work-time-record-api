<?php

namespace App\Modules\WorkerHourlySalaries\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WorkerHourlySalaries\Repositories\WorkerHourlySalaryRepository;
use App\Modules\WorkerHourlySalaries\Requests\WorkerHourlySalaryStoreRequest;
use App\Modules\WorkerHourlySalaries\Requests\WorkerHourlySalaryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class WorkerHourlySalaryController extends Controller
{
    public function index(WorkerHourlySalaryRepository $product, Request $request)
    {
        return response()->json(
            $product->findAll($request)
        );
    }

    public function store(WorkerHourlySalaryStoreRequest $request, WorkerHourlySalaryRepository $product)
    {
        return response()->json(
            $product->create($request),
            Response::HTTP_OK
        );
    }

    public function show(WorkerHourlySalaryRepository $product, $id)
    {
        return response()->json(
            $product->find($id)
        );
    }
    public function showCurrentByWorker(WorkerHourlySalaryRepository $product, $workerId)
    {
        return response()->json(
            $product->findCurrentByWorker($workerId)
        );
    }

    public function update(WorkerHourlySalaryUpdateRequest $request, WorkerHourlySalaryRepository $product, $id)
    {
        return response()->json(
            $product->update($request, $id),
            Response::HTTP_OK
        );
    }

    public function delete(WorkerHourlySalaryRepository $product, $id)
    {
        $product->delete($id);
    }

    public function getMonthlyPrice(WorkerHourlySalaryRepository $product, $workerId)
    {
        return response()->json(
            $product->getMonthlyPrice($workerId)
        );
    }
}
