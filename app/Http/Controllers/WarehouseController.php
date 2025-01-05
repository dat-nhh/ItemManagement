<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouse::paginate(10);
        return view('warehouse.index', ['warehouses' => $warehouses]);
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
        $warehouse = new Warehouse();
        $latest = Warehouse::orderBy('id', 'desc')->first();
        $latestID = $latest ? $latest->id : 'WARE99999';
        $number = intval(substr($latestID, 4)) + 1;
        $warehouse->id = 'WARE' . $number;
        $warehouse->name = $request->name;
        $warehouse->address = $request->address;
        $warehouse->save();

        return redirect()->route('warehouse.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $stocks = DB::table('stocks')
        ->where('warehouse', $warehouse->id)
            ->get();

        return view('warehouse.show', ['warehouse' => $warehouse, 'stocks' => $stocks]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return redirect()->route('warehouse.index')->with('error', 'Kho không tồn tại');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $warehouse->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ]);

        return redirect()->route('warehouse.index')->with('message', 'Cập nhật kho thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warehouse = Warehouse::find($id);
    
        if ($warehouse) {
            $warehouse->delete();
            Session::flash('message', 'Xóa thành công');
        } else {
            Session::flash('error', 'Không tìm thấy kho.');
        }

        return redirect()->route('warehouse.index');
    }
}
