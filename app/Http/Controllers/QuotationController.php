<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function destroy($id)
    {
        $quotations = Quotation::find($id);
        $quotations->delete();
        return redirect()->route('customer.show', $quotations->customer_id)->with('success', 'Quotation deleted successfully.');
    }
}
