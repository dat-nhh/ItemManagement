<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('categoryRel')->paginate(10);
        $categories = Category::all();
        $results = null;


        return view('item.index', ['items' => $items, 'categories' => $categories, 'results' => $results]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $results = Item::with('categoryRel')
        ->where('name', 'like', "%$search%")
        ->paginate(10);
        $categories = Category::all();

        return view('item.index', ['results' => $results, 'categories' => $categories]);
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
        $item = new Item();
        $latest = Item::orderBy('id', 'desc')->first();
        $latestID = $latest ? $latest->id : 'ITEM99999';
        $number = intval(substr($latestID, 4)) + 1;
        $item->id = 'ITEM' . $number;
        $item->name = $request->name;
        $item->category = $request->category;
        $item->unit = $request->unit;
        $item->save();

        return redirect()->route('item.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $item = Item::find($id);

        if (!$item) {
            return redirect()->route('item.index')->with('error', 'Sản phẩm không tồn tại');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $item->update([
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'unit' => $request->input('unit'),
        ]);

        return redirect()->route('item.index')->with('message', 'Cập nhật sản phẩm thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);

        if ($item) {
            $item->delete();
            Session::flash('message', 'Xóa thành công');
        } else {
            Session::flash('error', 'Không tìm thấy sản phẩm.');
        }

        return redirect()->route('item.index');
    }
}
