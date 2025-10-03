<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function store(Request $request, $invoiceId)
    {
        $request->validate([
            'file_path' => 'required|file|mimes:pdf,jpg,png,jpeg|max:2048',
            'date' => 'required|date',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('receipts', $fileName, 'public');
        }

        Receipt::create([
            'invoice_id' => $invoice->id,
            'file_path' => $filePath,
            'date' => $request->date,
        ]);

        // opsional: update status invoice ke "paid"
        $invoice->update(['status' => 'paid']);

        return redirect()->route('invoice.show', $invoiceId)
            ->with('success', 'Receipt uploaded successfully.');
    }
}
