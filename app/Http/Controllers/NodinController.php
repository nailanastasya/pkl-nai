<?php

namespace App\Http\Controllers;

use App\Models\Nodin;
use App\Models\PurchaseOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NodinController extends Controller
{
    public function index()
    {
        $nodins = Nodin::with('purchaseOrder')->get();
        return view('nodins.index', compact('nodins'));
    }
    public function create()
    {
        $statusOptions = Nodin::pluck('status')->unique()->toArray();
        $purchaseOrders = PurchaseOrders::all();
        return view('nodins.create', compact('purchaseOrders', 'statusOptions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required',
            'nodin' => 'required',
            'subject' => 'required',
            'date' => 'required',
            'status' => 'required',
            'file_path' => 'required'
        ], [
            'purchase_order_id.required' => 'Purchase Order is required',
            'nodin.required' => 'nodin is required',
            'subject.required' => 'Subject is required',
            'date.required' => 'Date is required',
            'status.required' => 'Status is required',
            'file_path.required' => 'File Path is required',
        ]);

        $photoPath = null;
        if ($request->hasFile('file_path')) {
            $photoPath = $request->file('file_path')->store('file_paths', 'public');
        }

        $nodins = new Nodin();
        $nodins->purchase_order_id = $request->purchase_order_id;
        $nodins->nodin = $request->nodin;
        $nodins->subject = $request->subject;
        $nodins->date = $request->date;
        $nodins->status = $request->status;
        $nodins->file_path = $photoPath;
        $nodins->save();
        return redirect()->route('nodin.index')->with('success', 'Nodin created successfully.');
    }

    public function edit($id)
    {
        $nodin = Nodin::find($id);
        $statusOptions = Nodin::pluck('status')->unique()->toArray();
        $purchaseOrders = PurchaseOrders::all();
        return view('nodins.edit', compact('nodin', 'purchaseOrders', 'statusOptions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'purchase_order_id' => 'required',
            'nodin' => 'required',
            'subject' => 'required',
            'date' => 'required',
            'status' => 'required',
        ], [
            'purchase_order_id.required' => 'Purchase Order is required',
            'nodin.required' => 'nodin is required',
            'subject.required' => 'Subject is required',
            'date.required' => 'Date is required',
            'status.required' => 'Status is required',
        ]);

        $nodin = Nodin::findOrFail($id);
        $nodin->purchase_order_id = $request->purchase_order_id;
        $nodin->nodin = $request->nodin;
        $nodin->subject = $request->subject;
        $nodin->date = $request->date;
        $nodin->status = $request->status;
        if ($request->hasFile('file_path')) {
            if ($nodin->file_path && Storage::disk('public')->exists($nodin->file_path)) {
                Storage::disk('public')->delete($nodin->file_path);
            }
            $nodin->file_path = $request->file('file_path')->store('file_paths', 'public');
        }
        $nodin->save();
        return redirect()->route('nodin.index')->with('success', 'Nodin updated successfully.');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $nodins = Nodin::where('nodin', 'like', '%' . $keyword . '%')->get();
        return view('nodins.index', compact('nodins'));
    }
}
