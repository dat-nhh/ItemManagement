<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transfer;
use App\Models\Transfer_detail;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = Transfer::with(['fromRel', 'toRel'])->paginate(10);
        $warehouses = Warehouse::all();

        return view('transfer.index', ['transfers' => $transfers, 'warehouses'=> $warehouses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Transfer $transfer)
    {
        $stocks = DB::table('stocks')->where('warehouse', $transfer->from_warehouse)->get();
        return view('transfer.create', ['stocks' => $stocks, 'transfer' => $transfer->id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'from_warehouse' => 'required',
            'from_warehouse' => 'required',
            'date' => 'required|date',
        ]);

        $transfer = new Transfer();
        $latest = Transfer::orderBy('id', 'desc')->first();
        $latestID = $latest ? $latest->id : 'TRAN99999';
        $number = intval(substr($latestID, 4)) + 1;
        $transfer->id = 'TRAN' . $number;
        $transfer->from_warehouse = $request->from_warehouse;
        $transfer->to_warehouse = $request->to_warehouse;
        $transfer->date = $request->date;
        $transfer->save();

        return redirect()->route('transfer.create', ['transfer' => $transfer]);
    }

    public function stockStore(Request $request)
    {
        $request->validate([
            'transfer' => 'required', // Validate the transfer ID
            'item.*' => 'required', // Validate each item
            'quantity.*' => 'required|integer|min:1', // Validate quantity
        ]);


        $from_warehouse = DB::table('transfers')->where('id', $request->transfer)->first()->from_warehouse;
        $to_warehouse = DB::table('transfers')->where('id', $request->transfer)->first()->to_warehouse;

        foreach ($request->item as $index => $itemId) {
            $transferDetail = new Transfer_detail();
            $transferDetail->transfer = $request->transfer;
            $transferDetail->item = $itemId;
            $transferDetail->quantity = $request->quantity[$index];

            $stock_from = DB::table('stocks')
            ->where('item', $itemId)
                ->where('warehouse', $from_warehouse)
                ->first();

            if ($stock_from) {
                if ($stock_from->quantity > $request->quantity[$index]) {
                    DB::table('stocks')
                    ->where('item', $itemId)
                        ->where('warehouse', $from_warehouse)
                        ->update(['quantity' => DB::raw('quantity - ' . $request->quantity[$index])]);
                } else {
                    DB::table('transfers')
                    ->where('id', $transferDetail->transfer)
                        ->delete();
                    return redirect()->route('transfer.index')->with('error', 'Mặt hàng trong kho không đủ để chuyển.');
                }
            } else {
                DB::table('transfers')
                ->where('id', $transferDetail->transfer)
                    ->delete();
                return redirect()->route('transfer.index')->with('error', 'Không tìm thất mặt hàng');
            }

            $stock_to = DB::table('stocks')
            ->where('item', $itemId)
            ->where('warehouse', $to_warehouse)
                ->first();

            if ($stock_to) {
                DB::table('stocks')
                    ->where('item', $itemId)
                    ->where('warehouse', $to_warehouse)
                    ->update(['quantity' => DB::raw('quantity + ' . $request->quantity[$index])]);
            } else {
                DB::table('stocks')->insert([
                    'item' => $itemId,
                    'warehouse' => $to_warehouse,
                    'quantity' => $request->quantity[$index],
                ]);
            }

            $transferDetail->save();
        }

        return redirect()->route('transfer.index')->with('success', 'Chuyển hàng thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transfer = Transfer::findOrFail($id);
        $transferDetails = DB::table('transfer_details')
        ->where('transfer', $transfer->id)
            ->get();

        return view('transfer.show', ['transfer' => $transfer, 'transferDetails' => $transferDetails]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transfer = Transfer::findOrFail($id);

        $transferDetails = Transfer_detail::where('transfer', $id)->get();

        foreach ($transferDetails as $detail) {
            $stock = DB::table('stocks')
                ->where('item', $detail->item)
                ->where('warehouse', $transfer->from_warehouse)->first();
            if ($stock) {
                DB::table('stocks')
                    ->where('item', $detail->item)
                    ->where('warehouse', $transfer->from_warehouse)
                    ->increment('quantity', $detail->quantity);
            } else {
                DB::table('stocks')->insert([
                    'item'
                    => $detail->item,
                    'warehouse' => $transfer->from_warehouse,
                    'quantity' => $detail->quantity,
                ]);
            }

            DB::table('stocks')
            ->where('item', $detail->item)
            ->where('warehouse', $transfer->warehouse)
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

        $transfer->delete();

        return redirect()->route('transfer.index')->with('success', 'Xóa giao dịch thành công');
    }
}
