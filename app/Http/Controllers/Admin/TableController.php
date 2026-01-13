<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = \App\Models\Table::all();
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|integer|unique:tables,number',
        ]);

        // Generate QR URL (Placeholder for now, will link to order page)
        // Assuming route 'order.table' or similar exists in future
        $url = url('/order/' . $validated['number']);
        
        \App\Models\Table::create([
            'number' => $validated['number'],
            'qr_url' => $url,
            'is_active' => true,
        ]);

        return redirect()->route('admin.tables.index')->with('success', 'Table created successfully.');
    }

    public function edit(\App\Models\Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, \App\Models\Table $table)
    {
        $validated = $request->validate([
            'number' => 'required|integer|unique:tables,number,' . $table->id,
            'is_active' => 'boolean',
        ]);

        // If number changed, update URL
        if ($table->number != $validated['number']) {
            $table->qr_url = url('/order/' . $validated['number']);
        }

        // Handle boolean unchecked
        $table->is_active = $request->has('is_active');
        $table->number = $validated['number'];
        $table->save();

        return redirect()->route('admin.tables.index')->with('success', 'Table updated successfully.');
    }

    public function destroy(\App\Models\Table $table)
    {
        $table->delete();
        return redirect()->route('admin.tables.index')->with('success', 'Table deleted successfully.');
    }
}
