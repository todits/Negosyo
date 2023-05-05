<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryRequest;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventory = Inventory::all();

        return $inventory;
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
        $create = new Inventory;
        $create->name = $request->name;
        $create->datePurchased = $request->datePurchased;
        $create->quantity = $request->quantity;
        $create->price = $request->price;
        $create->total = $request->total;
        $create->condition = $request->condition;
        $create->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        $inventory = Inventory::findOrFail($inventory);
        return $inventory;
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryRequest $request, Inventory $inventory)
    {
        $inventory->update($request->validated());
        // $inventory = Inventory::findOrFail($inventory);
        // $inventory->name = $request->name;
        // $inventory->datePurchased = $request->datePurchased;
        // $inventory->quantity = $request->quantity;
        // $inventory->price = $request->price;
        // $inventory->total = $request->total;
        // $inventory->condition = $request->condition;
        // $inventory->save();
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {

        $inventory->delete();
        //
    }
}
