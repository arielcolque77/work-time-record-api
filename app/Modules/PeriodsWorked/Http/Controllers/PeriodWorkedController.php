<?php

namespace App\Modules\PeriodsWorked\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\PeriodsWorked\Repositories\PeriodWorkedRepository;
use App\Modules\PeriodsWorked\Requests\PeriodWorkedStoreRequest;
use App\Modules\PeriodsWorked\Requests\PeriodWorkedUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PeriodWorkedController extends Controller
{
    public function index(PeriodWorkedRepository $product, Request $request)
    {
        return response()->json(
            $product->findAll($request)
        );
    }

    public function indexByWorker(PeriodWorkedRepository $product, Request $request, $workerId)
    {
        return response()->json(
            $product->findByWorker($request, $workerId)
        );
    }

    public function monthlyReportByWorker(PeriodWorkedRepository $periodWorked, Request $request, $workerId)
    {
        return response()->json(
            $periodWorked->monthlyReportByWorker($request, $workerId)
        );
    }

    public function monthlyReport(PeriodWorkedRepository $periodWorked, Request $request)
    {
        return response()->json(
            $periodWorked->monthlyReport($request)
        );
    }


    public function store(PeriodWorkedStoreRequest $request, PeriodWorkedRepository $product)
    {
        return response()->json(
            $product->create($request),
            Response::HTTP_OK
        );
    }

    public function show(PeriodWorkedRepository $product, $id)
    {
        return response()->json(
            $product->find($id)
        );
    }

    public function update(PeriodWorkedUpdateRequest $request, PeriodWorkedRepository $product, $id)
    {
        return response()->json(
            $product->update($request, $id),
            Response::HTTP_OK
        );
    }

    public function delete(PeriodWorkedRepository $product, $id)
    {
        $product->delete($id);
    }
}
