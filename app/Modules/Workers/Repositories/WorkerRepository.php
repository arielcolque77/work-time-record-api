<?php

namespace App\Modules\Workers\Repositories;

use App\Modules\Workers\Models\Workers;
use Illuminate\Http\Request;


class WorkerRepository
{
    public function findAll(Request $request)
    {
        $rows = Workers
            ::select();

        if ($request->search) {
            $rows = $rows->where(function ($subQuery) use ($request) {
                $subQuery->where('name', 'like', "%{$request->search}%");
            });
        }
        return
            $request->per_page ? $rows->paginate($request->per_page) : $rows->get();
    }

    public function find($id)
    {
        return
            Workers::find($id);
    }

    public function create($modelData): Workers
    {
        if (auth()->check()) {
            $modelData->merge(
                [
                    'user_create_id' => auth()->user()->id,
                ]
            );
        }

        return Workers::create($modelData->all());
    }

    public function update($modelData, $id): Workers
    {
        if (auth()->check()) {
            $modelData->merge(
                [
                    'user_update_id' => auth()->user()->id,
                ]
            );
        }

        $row = Workers::find($id);
        $row->update($modelData->all());

        return $row;
    }

    public function delete($id)
    {
        $row = Workers::find($id);
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
