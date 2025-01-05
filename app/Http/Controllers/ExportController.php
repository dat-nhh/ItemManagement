<?php

namespace App\Http\Controllers;

use App\Models\Export;
use App\Models\Export_detail;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExportController extends Controller
{
    public function index()
    {
        $exports = Export::with('customerRel', 'warehouseRel')->paginate(10);
        $customers = Customer::all();
        $warehouses = Warehouse::all();

        return view('export.index', [
            'exports' => $exports,
            'customers' => $customers,
            'warehouses' => $warehouses
        ]);
    }

    public function create(Export $export)
    {
        $stocks = DB::table('stocks')->where('warehouse', $export->warehouse)->get();
        return view('export.create', ['stocks' => $stocks, 'export' => $export->id]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'required',
            'date' => 'required|date',
            'warehouse' => 'required',
        ]);

        $export = new Export();
        $latest = Export::orderBy('id', 'desc')->first();
        $latestID = $latest ? $latest->id : 'EXPO99999';
        $number = intval(substr($latestID, 4)) + 1;
        $export->id = 'EXPO' . $number;
        $export->customer = $request->customer;
        $export->date = $request->date;
        $export->warehouse = $request->warehouse;
        $export->save();

        return redirect()->route('export.create', ['export' => $export]);
    }

    public function stockStore(Request $request)
    {
        $request->validate([
            'export' => 'required', // Validate the export ID
            'item.*' => 'required', // Validate each item
            'quantity.*' => 'required|integer|min:1', // Validate quantity
        ]);


        $warehouse = DB::table('exports')->where('id', $request->export)->first()->warehouse;

        foreach ($request->item as $index => $itemId) {
            $exportDetail = new Export_detail();
            $exportDetail->export = $request->export;
            $exportDetail->item = $itemId;
            $exportDetail->quantity = $request->quantity[$index];

            $stock = DB::table('stocks')
                ->where('item', $itemId)
                ->where('warehouse', $warehouse)
                ->first();

            if ($stock) {
                if($stock->quantity> $request->quantity[$index])
                {
                    DB::table('stocks')
                    ->where('item', $itemId)
                    ->where('warehouse', $warehouse)
                    ->update(['quantity' => DB::raw('quantity - ' . $request->quantity[$index])]);
                $exportDetail->save();
                } else{
                    DB::table('exports')
                    ->where('id', $exportDetail->export)
                    ->delete();
                    return redirect()->route('export.index')->with('error', 'Mặt hàng trong kho không đủ để xuất.');
                }      
            } else {
                DB::table('exports')
                    ->where('id', $exportDetail->export)
                    ->delete();
                return redirect()->route('export.index')->with('error', 'Không tìm thất mặt hàng');
            }
        }

        return redirect()->route('export.index')->with('success', 'Xuất hàng khỏi kho thành công.');
    }

    public function show($id)
    {
        $export = Export::findOrFail($id);
        $exportDetails = DB::table('export_details')
            ->where('export', $export->id)
            ->get();

        return view('export.show', ['export' => $export, 'exportDetails' => $exportDetails]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $export = Export::findOrFail($id);

        $exportDetails = Export_detail::where('export', $id)->get();

        foreach ($exportDetails as $detail) {
            $stock = DB::table('stocks')
                ->where('item', $detail->item)
                ->where('warehouse', $export->warehouse)->first();
            if($stock){
                DB::table('stocks')
                    ->where('item', $detail->item)
                    ->where('warehouse', $export->warehouse)
                ->increment('quantity', $detail->quantity);
            } else{
                DB::table('stocks')->insert([
                    'item'
                    => $detail->item,
                    'warehouse' => $export->warehouse,
                    'quantity' => $detail->quantity,
                ]);
            }
        }

        $export->delete();

        return redirect()->route('export.index')->with('success', 'Xóa giao dịch thành công');
    }
}
