<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchRequest;
use App\Http\Requests\InventoryRequest;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batch = Batch::with('expenses')->get();
        return $batch;
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
    public function store(Request $request)
    {
        $batch = new Batch;
        $batch->batchNo = $request->batchNo;
        $batch->cycle = $request->cycle;
        $batch->dateStarted = $request->dateStarted;
        $batch->endDate = $request->endDate;
        $batch->save();


        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        return $batch->load('expenses');
        //
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BatchRequest $request, Batch $batch)
    {

        $batch->update($request->validated());
        // $batch = Batch::findOrFail($batch);
        // $batch->batchNo = $request->batchNo;
        // $batch->cycle = $request->cycle;
        // $batch->dateStarted = $request->dateStarted;
        // $batch->edndDate = $request->edndDate;
        // $batch->save();

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();
    }

    public function latestBatch($id)
    {
        $batch = Batch::latest($id)->first();
        return $batch;
    }
}
