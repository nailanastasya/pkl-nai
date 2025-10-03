<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.index', [
            'customers' => Customer::where('status', 'accepted')->latest()->get(),
        ]);
    }

    public function prospects()
    {
        return view('customers.potential', [
            'customers' => Customer::where('status', 'pending')->latest()->get(),
        ]);
    }
    public function create()
    {
        $products = Product::all();

        return view('customers.create', compact('products'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'company_name' => ['required', 'min:3'],
            'photo' => ['image'],
            'company_email' => ['required', 'min:10', 'email'],
            'company_phone' => ['required', 'min:7'],
            'billing_address' => ['required', 'min:10'],
            'operational_address' => ['required', 'min:10'],
            'npwp' => ['required', 'regex:/^\d{2}\.\d{3}\.\d{3}\.\d-\d{3}\.\d{3}$/'],
            'nib' => ['required', 'digits_between:13,20', 'regex:/^\d+$/'],

            // contact person


            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'contact_position' => 'required|string|max:255',

            // quatation
            'quotation_number' => ['required', 'min:3'],
            'date' => ['required', 'date'],
            'file_path' => ['required', 'url', 'active_url'],
        ], [
            'company_name' => 'Nama Perusahaan Harus Diisi',
            'company_email' => 'Email Perusahaan Harus Diisi',
            'company_phone' => 'Nomor Telepon Perusahaan Harus Diisi',
            'billing_address' => 'Alamat Penagihan Harus Diisi',
            'operational_address' => 'Alamat Operasional Harus Diisi',
            'npwp' => 'NPWP Harus Diisi',
            'nib' => 'NIB Harus Diisi',

            // contact person
            'contact_name' => 'Nama Harus Diisi',
            'contact_email' => 'Email Harus Diisi',
            'contact_phone' => 'Nomor Harus Diisi',
            'contact_position' => 'Posisi Harus Diisi',

            // quatation
            'quotation_number' => 'Nomor Surat Penawaran Harus Diisi',
            'date' => 'Tanggal Harus Diisi',
            'file_path' => 'Link Harus Diisi',
        ]);

        $customer = new Customer;
        $photo = null;
        if ($request->hasFile('photo')) {
            if (Storage::exists('$customer->photo')) {
                Storage::delete('$customer->photo');
            }
            $photo = $request->file('photo')->store('photos');
        }

        $customer->company_name = $request->company_name;
        $customer->photo = $photo;
        $customer->company_email = $request->company_email;
        $customer->company_phone = $request->company_phone;
        $customer->billing_address = $request->billing_address;
        $customer->operational_address = $request->operational_address;
        $customer->npwp = $request->npwp;
        $customer->nib = $request->nib;

        $customer->save();

        /** @var User|null $user */
        $user = Auth::user();
        ActivityLog::create([
            'action' => 'created',
            'model_type' => Customer::class,
            'model_id' => $customer->getKey(),
            'description' => 'Add New Prospective Customer: ' . $customer->company_name,
            'user_id' => $user ? $user->id : null,
        ]);

        if ($request->filled('products')) {
            foreach ($request->products as $productId) {
                $product = Product::find($productId);

                $customer->customerProducts()->create([
                    'product_id' => $productId,
                    'period' => $request->period,
                ]);
            }
        }




        $customer->contactPeople()->create([

            'customer_id' => $customer->getKey(),
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_position' => $request->contact_position,
        ]);



        $customer->quotations()->create([
            'quotation_number' => $request->quotation_number,
            'date' => $request->date,
            'file_path' => $request->file_path,
        ]);
        session()->flash('success', 'Data has been created successfully');
        return redirect()->route('customer.index');
    }

    public function edit($id)
    {
        $customer = Customer::with(['customerProducts', 'contactPeople', 'quotations'])->findOrFail($id);
        $products = Product::all();
        $selectedProducts = $customer->customerProducts->pluck('product_id')->toArray();

        return view('customers.edit', compact('customer', 'products', 'selectedProducts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => ['required', 'min:3'],
            'photo' => ['image'],
            'company_email' => ['required', 'min:10', 'email'],
            'company_phone' => ['required', 'min:7'],
            'billing_address' => ['required', 'min:10'],
            'operational_address' => ['required', 'min:10'],
            'npwp' => ['required', 'regex:/^\d{2}\.\d{3}\.\d{3}\.\d-\d{3}\.\d{3}$/'],
            'nib' => ['required', 'digits_between:13,20', 'regex:/^\d+$/'],

            // contact person
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'contact_position' => 'required|string|max:255',
            // quatation
            'quotation_number' => ['required', 'min:3'],
            'date' => ['required', 'date'],
            'file_path' => ['required', 'url', 'active_url'],
        ], [
            'company_name' => 'Nama Perusahaan Harus Diisi',
            'company_email' => 'Email Perusahaan Harus Diisi',
            'company_phone' => 'Nomor Telepon Perusahaan Harus Diisi',
            'billing_address' => 'Alamat Penagihan Harus Diisi',
            'operational_address' => 'Alamat Operasional Harus Diisi',
            'npwp' => 'NPWP Harus Diisi',
            'nib' => 'NIB Harus Diisi',
            // contact person
            'contact_name' => 'Nama Harus Diisi',
            'contact_email' => 'Email Harus Diisi',
            'contact_phone' => 'Nomor Harus Diisi',
            'contact_position' => 'Posisi Harus Diisi',

            // quatation
            'quotation_number' => 'Nomor Surat Penawaran Harus Diisi',
            'date' => 'Tanggal Harus Diisi',
            'file_path' => 'Link Harus Diisi',
        ]);
        $photo = null;
        $customer = Customer::find($id);

        if ($request->hasFile('photo')) {
            if ($customer->photo && Storage::disk('public')->exists($customer->photo)) {
                Storage::disk('public')->delete($customer->photo);
            }

            $customer->photo = $request->file('photo')->store('photos', 'public');
        }
        $customer->company_name = $request->company_name;
        $customer->company_email = $request->company_email;
        $customer->company_phone = $request->company_phone;
        $customer->billing_address = $request->billing_address;
        $customer->operational_address = $request->operational_address;
        $customer->npwp = $request->npwp;
        $customer->nib = $request->nib;
        $customer->save();

        /** @var User|null $user */
        $user = Auth::user();
        ActivityLog::create([
            'action' => 'updated',
            'model_type' => Customer::class,
            'model_id' => $customer->getKey(),
            'description' => 'Updated customer data: ' . $customer->company_name,
            'user_id' => $user ? $user->id : null,
        ]);

        if ($request->has('products')) {
            $customer->customerProducts()->delete();
            foreach ($request->products as $productId) {
                $product = Product::find($productId);
                $customer->customerProducts()->create([
                    'product_id' => $productId,
                ]);
            }
        }


        $customer->contactPeople()->update([

            'customer_id' => $customer->getKey(),
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_position' => $request->contact_position,
        ]);

        $customer->quotations()->update([
            'customer_id' => $customer->getKey(),
            'quotation_number' => $request->quotation_number,
            'date' => $request->date,
            'file_path' => $request->file_path,
        ]);

        session()->flash('success', 'Data has been updated successfully');
        return redirect()->route('customer.index');
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        /** @var User|null $user */
        $user = Auth::user();
        ActivityLog::create([
            'action' => 'deleted',
            'model_type' => Customer::class,
            'model_id' => $customer->id,
            'description' => 'Menghapus customer: ' . $customer->company_name,
            'user_id' => $user ? $user->id : null,
        ]);
        $customer->delete();

        session()->flash('danger', 'Data deleted successfully');
        return redirect()->route('customer.index');
    }
    public function trashed()
    {
        $customers = Customer::onlyTrashed()->get();
        return view('customers.trashed', compact('customers'));
    }

    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();
        /** @var User|null $user */
        $user = Auth::user();
        ActivityLog::create([
            'action' => 'restored',
            'model_type' => Customer::class,
            'model_id' => $customer->id,
            'description' => 'Restrore customer: ' . $customer->company_name,
            'user_id' => $user ? $user->id : null,
        ]);

        return redirect()->back()->with('success', 'Customer restored successfully');
    }
    public function show($id)
    {
        $customer = Customer::with([
            'contactPeople',
            'customerProducts.product',
            'quotations',
            'purchaseOrders',
        ])->findOrFail($id);
        $products = Product::all();
        $quotations = $customer->quotations;

        return view('customers.detail', compact('customer', 'products'));
    }

    public function searchAccepted(Request $request)
    {
        $keyword = $request->keyword;

        $customers = Customer::where('status', 'accepted')
            ->where(function ($query) use ($keyword) {
                $query->where('company_name', 'like', "%$keyword%")
                    ->orWhere('company_email', 'like', "%$keyword%")
                    ->orWhere('company_phone', 'like', "%$keyword%")
                    ->orWhere('npwp', 'like', "%$keyword%")
                    ->orWhere('nib', 'like', "%$keyword%");
            })
            ->get();

        return view('customers.index', compact('customers'))->with('keyword', $keyword);
    }

    public function searchPending(Request $request)
    {
        $keyword = $request->keyword;

        $customers = Customer::where('status', 'pending')
            ->where(function ($query) use ($keyword) {
                $query->where('company_name', 'like', "%$keyword%")
                    ->orWhere('company_email', 'like', "%$keyword%")
                    ->orWhere('company_phone', 'like', "%$keyword%")
                    ->orWhere('npwp', 'like', "%$keyword%")
                    ->orWhere('nib', 'like', "%$keyword%");
            })
            ->get();

        return view('customers.potential', compact('customers'))->with('keyword', $keyword);
    }

    public function accept(Request $request, $id)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'purchase_order_number' => ['required', 'unique:purchase_orders,purchase_order_number'],
            'po_file' => ['required', 'file', 'mimes:pdf,docx,jpg,jpeg,png'],
        ]);

        $customer = Customer::findOrFail($id);


        $path = $request->file('po_file')->store('purchase_orders', 'public');

        PurchaseOrders::create([
            'customer_id' => $customer->id,
            'date' => $request->date,
            'purchase_order_number' => $request->purchase_order_number,
            'file_path' => $path,
        ]);

        $customer->status = 'accepted';
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customer accepted with PO uploaded');
    }
}
