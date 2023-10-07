<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFundRequest;
use App\Http\Requests\UpdateFundRequest;
use App\Http\Resources\FundResource;
use App\Http\Resources\PotentialDuplicateResource;
use App\Models\Fund;
use App\Models\PotentialDuplicate;
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
     * Store a newly created resource in storage.
     */
    public function store(StoreFundRequest $request)
    {
        $fund = new Fund();
        $fund->name = $request->input('name');
        $fund->start_year = $request->input('start_year');
        $fund->manager_id = $request->input('manager_id');
        $fund->save();
        foreach ($request->input('aliases') as $alias) {
            $fund->aliases()->create(['name' => $alias]);
        }
        $fund->companies()->sync($request->input('companies'));
        return new FundResource($fund);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fund $fund)
    {
        return new FundResource($fund);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundRequest $request, Fund $fund)
    {
        if ($request->has('name')) {
            $fund->name = $request->input('name');
        }
        if ($request->has('start_year')) {
            $fund->start_year = $request->input('start_year');
        }
        if ($request->has('manager_id')) {
            $fund->manager_id = $request->input('manager_id');
        }
        $fund->save();
        if ($request->has('aliases')) {
            $fund->aliases()->delete();
            foreach ($request->input('aliases') as $alias) {
                $fund->aliases()->create(['name' => $alias]);
            }
        }
        if ($request->has('companies')) {
            $fund->companies()->detach();
            $fund->companies()->sync($request->input('companies'));
        }

        return new FundResource($fund);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund)
    {
        $fund->delete();
        return response()->noContent();
    }

    /**
     * Display a listing of the potential duplicates.
     */
    public function duplicates()
    {
        $potentialDuplicates = PotentialDuplicate::with('originalFund', 'duplicateFund')->paginate();
        return PotentialDuplicateResource::collection($potentialDuplicates);
    }
}
