<?php

namespace App\Http\Controllers;

use App\Models\CustomerProduct;
use App\Models\Invoice;
use App\Models\Nodin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use GuzzleHttp\Client as GuzzleClient;

class InvoiceController extends Controller
{
    public function index()
    {
        // Ambil data invoice aktif (belum diarsipkan)
        $invoices = Invoice::where('is_archived', false)->get();
        $nodins = Nodin::all();
        $customerProducts = CustomerProduct::with('customer', 'product')->get();
        $statusOptions = ['unpaid', 'paid', 'overdue', 'partial'];

        // ======= Google Drive =======
        $driveFiles = [];
        try {
            $client = new GoogleClient();
            $client->setAuthConfig(storage_path('app/credentials.json'));
            $client->setScopes([GoogleDrive::DRIVE_READONLY]);
            $client->setHttpClient(new GuzzleClient([
                'verify' => storage_path('app/cacert.pem') // path ke cacert.pem
            ]));

            $driveService = new GoogleDrive($client);

            // folder ID dari Google Drive (HARUS diganti sesuai foldermu)
            $folderId = env('GOOGLE_DRIVE_FOLDER_ID', null);

            if ($folderId) {
                $response = $driveService->files->listFiles([
                    'q' => "'{$folderId}' in parents and trashed = false",
                    'fields' => 'files(id, name, mimeType, webViewLink)',
                    'supportsAllDrives' => true,
                    'includeItemsFromAllDrives' => true,
                ]);
            } else {
                $response = $driveService->files->listFiles([
                    'q' => "trashed = false",
                    'fields' => 'files(id, name, mimeType, webViewLink)',
                    'supportsAllDrives' => true,
                    'includeItemsFromAllDrives' => true,
                ]);
            }

            $driveFiles = $response->getFiles();
        } catch (\Exception $e) {
            Log::error("Google Drive error: " . $e->getMessage());
            $driveFiles = [];
        }

        return view('invoices.index', compact(
            'invoices',
            'nodins',
            'customerProducts',
            'statusOptions',
            'driveFiles'
        ));
    }

    public function archiveIndex()
    {
        // Ambil invoice yang sudah diarsipkan
        $invoices = Invoice::where('is_archived', true)->get();
        return view('invoices.archive', compact('invoices'));
    }

    public function create()
    {
        $usedNodinIds = Invoice::pluck('nodin_id')->toArray();
        $nodins = Nodin::whereNotIn('id', $usedNodinIds)->get();
        $customerProducts = CustomerProduct::with('customer', 'product')->get();
        $statusOptions = ['unpaid', 'paid', 'overdue', 'partial'];

        return view('invoices.create', compact('nodins', 'customerProducts', 'statusOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nodin_id' => [
                'required',
                'exists:nodins,id',
                function ($attribute, $value, $fail) {
                    if (Invoice::where('nodin_id', $value)->exists()) {
                        $fail('Nodin sudah dipakai di invoice lain.');
                    }
                },
            ],
            'customer_product_id' => 'required',
            'invoice_subject' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'file_path' => 'required',
            'date' => 'required',
            'due_date' => 'required',
            'status' => 'required',
        ]);

        $invoices = new Invoice();
        $invoices->nodin_id = $request->nodin_id;
        $invoices->customer_product_id = $request->customer_product_id;
        $invoices->invoice_subject = $request->invoice_subject;
        $invoices->description = $request->description;
        $invoices->amount = $request->amount;
        $invoices->file_path = $request->file_path; // Google Drive File ID
        $invoices->date = $request->date;
        $invoices->due_date = $request->due_date;
        $invoices->status = $request->status;
        $invoices->is_archived = false;

        $invoices->save();

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nodin_id' => 'required',
            'customer_product_id' => 'required',
            'invoice_subject' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'file_path' => 'required', // konsisten dengan store()
            'date' => 'required',
            'due_date' => 'required',
            'status' => 'required',
        ]);

        $invoices = Invoice::findOrFail($id);
        $invoices->nodin_id = $request->nodin_id;
        $invoices->customer_product_id = $request->customer_product_id;
        $invoices->invoice_subject = $request->invoice_subject;
        $invoices->description = $request->description;
        $invoices->amount = $request->amount;
        $invoices->file_path = $request->file_path; // Google Drive File ID
        $invoices->date = $request->date;
        $invoices->due_date = $request->due_date;
        $invoices->status = $request->status;

        $invoices->save();

        return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::with('receipts')->findOrFail($id);
        return view('invoices.detail', compact('invoice'));
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        return redirect()->route('invoice.index')->with('danger', 'Invoice deleted successfully.');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $invoices = Invoice::where('invoice_subject', 'like', '%' . $keyword . '%')
            ->where('is_archived', false)
            ->get();
        return view('invoices.index', compact('invoices'));
    }

    public function archive($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->is_archived = true;
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice berhasil diarsipkan.');
    }

    public function unarchive($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->is_archived = false;
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice berhasil dikembalikan dari arsip.');
    }
}
