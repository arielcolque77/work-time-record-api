<?php

namespace App\Modules\PeriodsWorked\Repositories;

use App\Modules\PeriodsWorked\Models\PeriodsWorked;
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
        return
            $request->per_page ? $rows->paginate($request->per_page) : $rows->get();
    }

    public function find($id)
    {
        return
            PeriodsWorked::with('worker')->find($id);
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
