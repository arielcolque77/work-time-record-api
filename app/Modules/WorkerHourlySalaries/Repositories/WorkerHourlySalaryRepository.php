<?php

namespace App\Modules\WorkerHourlySalaries\Repositories;

use App\Modules\WorkerHourlySalaries\Models\WorkerHourlySalaries;
use Carbon\Carbon;
use Illuminate\Http\Request;


class WorkerHourlySalaryRepository
{
    public function findAll(Request $request)
    {
        $rows = WorkerHourlySalaries
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

    public function findAllByWorker(Request $request, $workerId)
    {
        $rows = WorkerHourlySalaries::select()
            ->with('worker')
            ->where('worker_id', $workerId);

        return
            $request->per_page ? $rows->paginate($request->per_page) : $rows->get();
    }

    public function findCurrentByWorker($workerId)
    {
        return WorkerHourlySalaries::select()->with('worker')->where('worker_id', $workerId)->first();
    }

    public function getMonthlyPrice($workerId)
    {
        $allPrices = [];
        $prevPrice = 0;
        $price = 0;
        $rows = WorkerHourlySalaries::select()
            ->with('worker')
            ->where('worker_id', $workerId)->orderBy('since')->get();

        $months = range(1, 12);
        foreach ($months as $month) {
            foreach ($rows as $entry) {
                $dateTime = $entry->since;
                $entryMonthNumber = Carbon::parse($dateTime)->format('n');
                if ($entryMonthNumber == $month) {
                    $price = $entry->salary;
                    $prevPrice = $entry->salary;
                } elseif ($entryMonthNumber >= $month) {
                    $price = $prevPrice;
                };
            }
            $allPrices[] = [
                'month' => $month,
                'salary' => $price,
            ];
        }

        return collect($allPrices);
    }

    public function find($id)
    {
        return
            WorkerHourlySalaries::with('worker')->find($id);
    }

    public function create($modelData): WorkerHourlySalaries
    {
        if (auth()->check()) {
            $modelData->merge(
                [
                    'user_create_id' => auth()->user()->id,
                ]
            );
        }

        return WorkerHourlySalaries::create($modelData->all());
    }

    public function update($modelData, $id): WorkerHourlySalaries
    {
        if (auth()->check()) {
            $modelData->merge(
                [
                    'user_update_id' => auth()->user()->id,
                ]
            );
        }

        $row = WorkerHourlySalaries::find($id);
        $row->update($modelData->all());

        return $row;
    }

    public function delete($id)
    {
        $row = WorkerHourlySalaries::find($id);
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
