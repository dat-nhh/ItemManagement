<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\Import_detail;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ImportController extends Controller
{
    public function index()
    {
        $imports = Import::with(['vendorRel', 'warehouseRel'])->paginate(10);
        $vendors = Vendor::all();
        $warehouses = Warehouse::all();

        return view('import.index', [
            'imports' => $imports,
            'vendors' => $vendors,
            'warehouses' => $warehouses
        ]);
    }

    public function create($import)
    {
        $items = Item::all();
        return view('import.create', ['items' => $items, 'import' => $import]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor' => 'required',
            'date' => 'required|date',
            'warehouse' => 'required',
        ]);

        $import = new Import();
        $latest = Import::orderBy('id', 'desc')->first();
        $latestID = $latest ? $latest->id : 'IMPO99999';
        $number = intval(substr($latestID, 4)) + 1;
        $import->id = 'IMPO' . $number;
        $import->vendor = $request->vendor;
        $import->date = $request->date;
        $import->warehouse = $request->warehouse;
        $import->save();

        return redirect()->route('import.create', ['import' => $import->id]);
    }

    public function stockStore(Request $request)
    {
        $request->validate([
            'import' => 'required', // Validate the import ID
            'item.*' => 'required', // Validate each item
            'quantity.*' => 'required|integer|min:1', // Validate quantity
        ]);


        $warehouse = DB::table('imports')->where('id', $request->import)->first()->warehouse;

        foreach ($request->item as $index => $itemId) {
            $importDetail = new Import_detail();
            $importDetail->import = $request->import;
            $importDetail->item = $itemId;
            $importDetail->quantity = $request->quantity[$index];

            $stock = DB::table('stocks')
            ->where('item', $itemId)
                ->where('warehouse', $warehouse)
                ->first();

            if ($stock) {
                DB::table('stocks')
                ->where('item', $itemId)
                    ->where('warehouse', $warehouse)
                    ->update(['quantity' => DB::raw('quantity + ' . $request->quantity[$index])]);
            } else {
                DB::table('stocks')->insert([
                    'item' => $itemId,
                    'warehouse' => $warehouse,
                    'quantity' => $request->quantity[$index],
                ]);
            }

            $importDetail->save();
        }

        return redirect()->route('import.index')->with('success', 'Thêm hàng vào kho thành công.');
    }

    public function show($id)
    {
        $import = Import::findOrFail($id);
        $importDetails = DB::table('import_details')
        ->where('import', $import->id)
            ->get();

        return view('import.show', ['import' => $import, 'importDetails' => $importDetails]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $import = Import::findOrFail($id);

        $importDetails = Import_detail::where('import', $id)->get();

        foreach ($importDetails as $detail) {
            DB::table('stocks')
            ->where('item', $detail->item)
            ->where('warehouse',$import->warehouse)
                ->decrement('quantity', $detail->quantity); 

            $currentQuantity = DB::table('stocks')
            ->where('item', $detail->item)
            ->value('quantity');

            if ($currentQuantity <= 0) {
                DB::table('stocks')
                    ->where('item', $detail->item)
                    ->delete();
            }
        }

        $import->delete();

        return redirect()->route('import.index')->with('success', 'Xóa giao dịch thành công');
    }
}
