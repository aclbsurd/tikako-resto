<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; 
use App\Models\User; 
use App\Models\Feedback;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminOrderController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $ordersAwaiting = Order::where('status', 'Diterima')->count();
        $totalRevenue = Order::where('status', 'Selesai')->sum('total_price');
        $latestOrders = Order::with(['details.menu', 'user']) 
                             ->where('status', '!=', 'Selesai') 
                             ->orderBy('created_at', 'desc')
                             ->take(5) 
                             ->get();        
        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'ordersAwaiting' => $ordersAwaiting,
            'totalRevenue' => $totalRevenue,
            'latestOrders' => $latestOrders,
        ]);
    }
    
    public function index()
    {
        $data_pesanan = Order::with(['details.menu', 'user']) 
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);
        return view('admin.orders.index', [
            'data_pesanan' => $data_pesanan,
        ]);
    }

    public function customersIndex(Request $request)
    {
        $search = $request->query('search');
        $query = User::where('role', 'user');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $customers = $query->orderBy('created_at', 'desc')->paginate(10);
        $customers->appends(['search' => $search]);
        return view('admin.customers', [
            'customers' => $customers
        ]);
    }
    public function reportsIndex(Request $request)
    {
        $period = $request->query('period', '7_days');
        $search = $request->query('search');
        $endDate = \Carbon\Carbon::now();       
        if ($period == '30_days') {
            $startDate = \Carbon\Carbon::now()->subDays(29);
            $titleChart = 'Tren 30 Hari Terakhir';
        } elseif ($period == 'this_month') {
            $startDate = \Carbon\Carbon::now()->startOfMonth();
            $titleChart = 'Tren Bulan Ini';
        } else {
            $startDate = \Carbon\Carbon::now()->subDays(6);
            $titleChart = 'Tren 7 Hari Terakhir';
        }
        $query = Order::with(['details.menu', 'user'])
                      ->where('status', 'Selesai')
                      ->whereBetween('created_at', [
                          $startDate->format('Y-m-d') . ' 00:00:00', 
                          $endDate->format('Y-m-d') . ' 23:59:59'
                      ]);
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%$search%")          // Cari ID
                  ->orWhere('nomor_meja', 'like', "%$search%") // Cari No Meja
                  ->orWhereHas('user', function($u) use ($search) { 
                      $u->where('name', 'like', "%$search%"); // Cari Nama User
                  });
            });
        }

        $completedOrders = $query->orderBy('created_at', 'desc')->get();       
        $revenueQuery = Order::where('status', 'Selesai')
                             ->whereBetween('created_at', [
                                 $startDate->format('Y-m-d') . ' 00:00:00', 
                                 $endDate->format('Y-m-d') . ' 23:59:59'
                             ]);
        $totalRevenue = $revenueQuery->sum('total_price');
        $rawChartData = $revenueQuery->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
                                     ->groupBy('date')
                                     ->get();
        $chartLabels = [];
        $chartValues = [];
        $daysDifference = $startDate->diffInDays($endDate);
        for ($i = 0; $i <= $daysDifference; $i++) {
            $dateCheck = $startDate->copy()->addDays($i)->format('Y-m-d');            
            if ($period == '30_days' || $period == 'this_month') {
                $dateLabel = $startDate->copy()->addDays($i)->format('d M'); 
            } else {
                $dateLabel = $startDate->copy()->addDays($i)->format('D, d M');
            }
            $salesOnThisDay = $rawChartData->firstWhere('date', $dateCheck);
            $chartLabels[] = $dateLabel;
            $chartValues[] = $salesOnThisDay ? $salesOnThisDay->total : 0;
        }
        return view('admin.reports', [
            'completedOrders' => $completedOrders,
            'totalRevenue' => $totalRevenue,
            'chartLabels' => $chartLabels, 
            'chartValues' => $chartValues,
            'currentPeriod' => $period,
            'titleChart' => $titleChart
        ]);
    }

    public function printReport(Request $request)
    {
        $period = $request->query('period', '7_days');
        $endDate = \Carbon\Carbon::now();       
        $titlePeriod = ''; 
        if ($period == '30_days') {
            $startDate = \Carbon\Carbon::now()->subDays(29);
            $titlePeriod = '30 Hari Terakhir';
        } elseif ($period == 'this_month') {
            $startDate = \Carbon\Carbon::now()->startOfMonth();
            $titlePeriod = 'Bulan Ini (' . $startDate->format('F Y') . ')';
        } elseif ($period == 'all') {
            $startDate = \Carbon\Carbon::create(2000, 1, 1); 
            $titlePeriod = 'Semua Riwayat Transaksi';
        } else {
            $startDate = \Carbon\Carbon::now()->subDays(6);
            $titlePeriod = '7 Hari Terakhir';
        }
        $completedOrders = Order::with(['details.menu', 'user'])
                                ->where('status', 'Selesai')
                                ->whereBetween('created_at', [
                                    $startDate->format('Y-m-d') . ' 00:00:00', 
                                    $endDate->format('Y-m-d') . ' 23:59:59'
                                ])
                                ->orderBy('created_at', 'desc')
                                ->get();
        $totalRevenue = $completedOrders->sum('total_price');
        return view('admin.reports-print', [
            'completedOrders' => $completedOrders,
            'totalRevenue' => $totalRevenue,
            'titlePeriod' => $titlePeriod 
        ]);
    }

    public function destroyCustomer(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Akun pelanggan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:Diterima,Sedang Dimasak,Selesai,Dibatalkan' 
        ]);
        $order->status = $request->status;
        $order->save();
        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil di-update!');
    }

    public function printStruk(Request $request, Order $order, $type)
    {
        $period = $request->query('period', '7_days');
        $endDate = \Carbon\Carbon::now();        
        $titlePeriod = ''; 
        if ($period == '30_days') {
            $startDate = \Carbon\Carbon::now()->subDays(29);
            $titlePeriod = '30 Hari Terakhir';
        } elseif ($period == 'this_month') {
            $startDate = \Carbon\Carbon::now()->startOfMonth();
            $titlePeriod = 'Bulan Ini (' . $startDate->format('F Y') . ')';
        } elseif ($period == 'all') {
            $startDate = \Carbon\Carbon::create(2000, 1, 1); 
            $titlePeriod = 'Semua Riwayat Transaksi';
        } else {
            $startDate = \Carbon\Carbon::now()->subDays(6);
            $titlePeriod = '7 Hari Terakhir';
        }
        $completedOrders = Order::with(['details.menu', 'user'])
                                ->where('status', 'Selesai')
                                ->whereBetween('created_at', [
                                    $startDate->format('Y-m-d') . ' 00:00:00', 
                                    $endDate->format('Y-m-d') . ' 23:59:59'
                                ])
                                ->orderBy('created_at', 'desc')
                                ->get();
        $totalRevenue = $completedOrders->sum('total_price');
        return view('admin.reports-print', [
            'completedOrders' => $completedOrders,
            'totalRevenue' => $totalRevenue,
            'titlePeriod' => $titlePeriod 
        ]);
    }

    public function feedbackIndex()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.feedback.index', [
            'feedbacks' => $feedbacks
        ]);
    }

    public function feedbackDestroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->back()->with('success', 'Feedback berhasil dihapus.');
    }

    public function showChangePasswordForm()
    {
        return view('admin.password'); 
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed', 
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Password lama salah!');
        }

        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function qrCodeIndex()
    {
        return view('admin.qrcode.index');
    }

    public function qrCodePrint(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|integer|min:1'
        ]);

        $urlTujuan = route('menu.indexPage', ['meja' => $request->nomor_meja]);

        $qrcode = QrCode::size(300)->margin(2)->generate($urlTujuan);

        return view('admin.qrcode.print', [
            'qrcode' => $qrcode,
            'nomor_meja' => $request->nomor_meja,
            'url' => $urlTujuan
        ]);
    }
}