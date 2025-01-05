<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::paginate(10);

        return view('vendor.index', ['vendors' => $vendors]);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $vendor = new Vendor();
        $latest = Vendor::orderBy('id', 'desc')->first();
        $latestID = $latest ? $latest->id : 'VEND99999';
        $number = intval(substr($latestID, 4)) + 1;
        $vendor->id = 'VEND' . $number;
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->save();

        return redirect()->route('vendor.index');
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
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return redirect()->route('vendor.index')->with('error', 'Danh mục không tồn tại');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $vendor->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('vendor.index')->with('message', 'Cập nhật nhà cung cấp thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vendor = Vendor::find($id);

        if ($vendor) {
            $vendor->delete();
            Session::flash('message', 'Xóa thành công');
        } else {
            Session::flash('error', 'Không tìm thấy nhà cung cấp.');
        }

        return redirect()->route('vendor.index');
    }
}
