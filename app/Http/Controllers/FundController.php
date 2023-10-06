<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFundRequest;
use App\Http\Requests\UpdateFundRequest;
use App\Http\Resources\FundResource;
use App\Models\Fund;
use Illuminate\Contracts\Database\Eloquent\Builder;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $funds = Fund::query();
        if (request()->has('start_year')) {
            $funds->where('start_year', request()->input('start_year'));
        }
        if (request()->has('name')) {
            $funds->where('name', 'like', '%' . request()->input('name') . '%');
        }
        if (request()->has('manager_id')) {
            $funds->where('manager_id', request()->input('manager_id'));
        }
        if (request()->has('manager')) {
            $funds->whereHas('manager', function (Builder $query) {
                $query->where('name', 'like', '%' . request()->input('manager') . '%');
            });
        }
        $funds = $funds->paginate();
        return FundResource::collection($funds);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundRequest $request)
    {
        dump($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Fund $fund)
    {
        return new FundResource($fund);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundRequest $request, Fund $fund)
    {
        dump($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund)
    {
        //
    }
}
