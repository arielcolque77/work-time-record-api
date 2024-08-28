<?php

namespace App\Modules\PeriodsWorked\Repositories;

use App\Modules\PeriodsWorked\Models\PeriodsWorked;
use App\Modules\WorkerHourlySalaries\Repositories\WorkerHourlySalaryRepository;
use App\Modules\Workers\Models\Workers;
use App\Modules\Workers\Repositories\WorkerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PeriodWorkedRepository
{
    public function findAll(Request $request)
    {
        $rows = PeriodsWorked
            ::select()
            ->with('worker');

        if ($request->search) {
            $rows = $rows->where(function ($subQuery) use ($request) {
                $subQuery->where('worker_id', 'like', "%{$request->search}%");
            });
        }
        return
            $request->per_page ? $rows->paginate($request->per_page) : $rows->get();
    }

    public function findByWorker(Request $request, int $workerId)
    {
        $rows = PeriodsWorked
            ::select()
            ->with('worker')
            ->where('worker_id', $workerId);

        if ($request->search) {
            $rows = $rows->where(function ($subQuery) use ($request) {
                $subQuery->where('worker_id', 'like', "%{$request->search}%");
            });
        }

        if ($request->month) {
            $rows = $rows->whereMonth('start_time', $request->month);
        }

        return
            $request->per_page ? $rows->paginate($request->per_page) : $rows->get();
    }

    public function find($id)
    {
        return
            PeriodsWorked::with('worker')->find($id);
    }

    public function monthlyReportByWorker(Request $request, $workerId)
    {

        $rows = $this->findByWorker($request, $workerId);

        $report = [];
        $totalDuration = 0;
        foreach ($rows as $row) {
            $startTime = Carbon::parse($row->start_time);
            $endTime = Carbon::parse($row->end_time);

            $duration = $endTime->diffInMinutes($startTime);
            $totalDuration += $duration;

            $report[] = [
                'id' => $row->id,
                'worker_id' => $row->worker_id,
                'month' => $request->month,
                'start_time' => $row->start_time,
                'end_time' => $row->end_time,
                'duration' => $duration,
            ];
        }

        $customRequest = new Request();
        $customRequest->merge(['month' => $request->month]);

        $priceThisMonth = (new WorkerHourlySalaryRepository())->getOneMonthPrice($customRequest, $workerId);

        $finalReport = collect([
            'worker_report' => $report,
            'total_duration' => $totalDuration,
            'price_this_month' => $priceThisMonth,
        ]);

        return
            $finalReport;
    }

    public function monthlyReport(Request $request)
    {
        $workers = Workers::all();
        $completeReport = [];
        $totalAllWorkers = 0;
        foreach ($workers as $worker) {
            $individualReport = $this->monthlyReportByWorker($request, $worker->id);

            $totalAllWorkers += $individualReport['total_duration'];

            $completeReport[] = [
                'id' => $worker->id,
                'worker_report' => $individualReport,
            ];
        }

        $structuredReport = collect([
            'report' => $completeReport,
            'total_all_workers' => $totalAllWorkers,
        ]);

        return $structuredReport;
    }

    public function create($modelData): PeriodsWorked
    {
        if (auth()->check()) {
            $modelData->merge(
                [
                    'user_create_id' => auth()->user()->id,
                ]
            );
        }

        return PeriodsWorked::create($modelData->all());
    }

    public function update($modelData, $id): PeriodsWorked
    {
        if (auth()->check()) {
            $modelData->merge(
                [
                    'user_update_id' => auth()->user()->id,
                ]
            );
        }

        $row = PeriodsWorked::find($id);
        $row->update($modelData->all());

        return $row;
    }

    public function delete($id)
    {
        $row = PeriodsWorked::find($id);
        if ($row) {
            if (auth()->check()) {
                $row->update(
                    [
                        'user_update_id' => auth()->user()->id,
                    ]
                );
            }
            $row->delete();
        }
        return $row;
    }
}
