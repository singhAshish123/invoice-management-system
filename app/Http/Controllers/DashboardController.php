<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $timeFilter = $request->query('filter', 'today');

        $query = Invoice::query();

        switch ($timeFilter) {
            case 'this_week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'this_year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
            case 'custom':
                if ($request->has(['start_date', 'end_date'])) {
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }
                break;
            default:
                $query->whereDate('created_at', Carbon::today());
        }

        if ($user->hasRole('admin')) {
            $totalUsers = User::count();
            $totalInvoices = $query->count();
            return view('dashboard', compact('totalUsers', 'totalInvoices', 'timeFilter'));
        } else {
            $totalVendors = Vendor::count();
            $totalProducts = Product::count();
            $totalInvoices = $query->where('created_at', $user->id)->count();

            return view('dashboard', compact('totalVendors', 'totalProducts', 'totalInvoices', 'timeFilter'));
        }
    }
}
