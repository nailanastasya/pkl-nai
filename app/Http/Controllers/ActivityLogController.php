<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Customer;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(10);

        $deletedCustomers = Customer::onlyTrashed()->orderBy('deleted_at', 'desc')
            ->where('deleted_at', '>=', now()->subDays(1))
            ->get();

        return view('activity-logs.index', compact('logs', 'deletedCustomers'));
    }

    public function destroy(Request $request, $id)
    {
        $log = ActivityLog::findOrFail($id);

        // if (!$request->user()->can('delete', $log)) {
        //     abort(403, 'Unauthorized action.');
        // }

        $log->delete();

        session()->flash('danger', 'Data deleted successfully');
        return redirect()->route('log.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $logs = ActivityLog::where('user_id', 'like', "%$keyword%")
            ->orWhere('action', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->latest()
            ->paginate(10);

        return view('activity-logs.index', compact('logs'))->with('keyword', $keyword);
    }
}
