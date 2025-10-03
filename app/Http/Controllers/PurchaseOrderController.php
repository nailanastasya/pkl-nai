<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrders;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrders::all();
        return view('purchaseOrders.index', compact('purchaseOrders'));
    }

    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrders::find($id);
        $purchaseOrder->delete();

        session()->flash('danger', 'Data Berhasil Dihapus');
        return redirect()->route('purchaseOrder.index');
    }
}
