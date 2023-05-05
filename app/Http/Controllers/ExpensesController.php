<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpensesRequest;
use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Expenses::with('batch')->get();
        //
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
    public function store(ExpensesRequest $request)
    {
        $expenses = new Expenses;
        $expenses->item = $request->item;
        $expenses->price = $request->price;
        $expenses->quantity = $request->quantity;
        $expenses->total = $request->total;
        $expenses->datepurchase = $request->datepurchase;
        $expenses->batch_id = $request->batch_id;
        $expenses->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensesRequest $request, Expenses $expense)
    {
        $expense->update($request->validated());
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expense)
    {

        $expense->delete();
        return response()->noContent();

        //
    }
}
