<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSupplier;
use App\Models\PriceInquiry;
use App\Models\ProductGroup;
use App\Models\Products;
use App\Models\User;
use Auth;
use Cache;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function product($id)
    {
        $product = Products::where('id', $id)->with('printAreas', 'images', 'product_group')->first();
        // dd($product);
        return response()->json($product, 200);
    }
    public function dashboard()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Ensure the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Retrieve the user's roles
        $roles = $user->getRoleNames(); // Collection of roles

        // Initialize the data array with the user's roles
        $data = [
            'roles' => $roles,
            'permissions' => $user->getAllPermissions()->pluck('name'), // Collection of permission names
        ];

        // Determine if the user is Admin or Internal
        $isAdmin = $roles->contains('Admin');
        $isInternal = $roles->contains('Internal');

        if ($isAdmin || $isInternal) {
            // Common data for Admin and Internal
            $data['Buyers'] = User::role('Buyer')->count();
            $data['Suppliers'] = User::role('Supplier')->count();
            $data['Products'] = Products::count();
            $data['Orders'] = Order::select('id', 'productname', 'sendoutdate', 'status')
                ->latest()
                ->take(3)
                ->get();

            if ($user->hasPermissionTo('purchaseRevenue')) {
                $purchaseRevenueTotal = Cache::remember('purchase_revenue_total', 300, function () {
                    return Order::sum(DB::raw('buyingprice * quantity_unit'));
                });

                $purchaseRevenueWeekly = Cache::remember('purchase_revenue_weekly', 300, function () {
                    return Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->sum(DB::raw('buyingprice * quantity_unit'));
                });

                $purchaseRevenueMonthly = Cache::remember('purchase_revenue_monthly', 300, function () {
                    return Order::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                        ->sum(DB::raw('buyingprice * quantity_unit'));
                });

                $purchaseRevenueYearly = Cache::remember('purchase_revenue_yearly', 300, function () {
                    return Order::whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
                        ->sum(DB::raw('buyingprice * quantity_unit'));
                });

                $data['purchaseRevenue'] = [
                    'total' => $purchaseRevenueTotal,
                    'weekly' => $purchaseRevenueWeekly,
                    'monthly' => $purchaseRevenueMonthly,
                    'yearly' => $purchaseRevenueYearly,
                ];
            }
            $data['OrderPriceInquiry'] = Order::where('buyer', $user->buyer_id)->where('status', 'Printview Reject')
                ->count();
            // Additional data based on permissions for Internal
            if ($isInternal) {
                // Determine if user has Operation or Merchandiser permissions
                $isOperation = $user->hasPermissionTo('createPriceInquiry') || $user->hasPermissionTo('orderGeneralSinglePage');
                $isMerchandiser = $user->hasPermissionTo('printviewConfirmRejectButton') || $user->hasPermissionTo('massCargoPhotoApproval');

                if ($isOperation) {
                    // Additional Operation-specific data
                }

                if ($isMerchandiser) {
                }

            }
            $data['PrintviewRejected'] = Order::where('status', 'Printview Reject')->count();
            if ($user->hasPermissionTo('bestSales') || $user->hasPermissionTo('bestPurchase') || $user->hasPermissionTo('salesRevenue') || $user->hasPermissionTo('purchaseRevenue')) {
                $topCategories = ProductGroup::select('product_groups.group_name', DB::raw('SUM(orders.quantity_unit) as units_sold'))
                    // ->join('products', 'product_groups.id', '=', 'products.group')
                    ->join('orders', 'product_groups.id', '=', 'orders.group')
                    ->groupBy('product_groups.id', 'product_groups.group_name')
                    ->orderByDesc('units_sold')
                    ->take(20)
                    ->get();

                $data['TopCategories'] = $topCategories;
            }

        }

        // Data for Buyer
        if ($roles->contains('Buyer')) {
            $data['FixedOrders'] = Order::where('buyer', $user->buyer_id)
                ->count();
            $data['PrintviewRejected'] = Order::where('buyer', $user->buyer_id)->where('status', 'Printview Reject')
                ->count();
            $data['Orders'] = Order::select('id', 'productname', 'sendoutdate', 'status')
                ->where('buyer', $user->buyer_id)
                ->latest()
                ->take(3)
                ->get();
            $data['OrderPriceInquiry'] = Order::where('buyer', $user->buyer_id)->where('status', 'Price')
                ->count();
        }

        // Data for Supplier
        if ($roles->contains('Supplier')) {
            $data['PrintviewRejected'] = Order::where('supplier', $user->supplier_id)->where('status', 'Printview Reject')
                ->count();
            $data['Inquiry'] = PriceInquiry::whereJsonContains('supplier_ids', (string) $user->supplier_id)
                ->count();
            $data['OrderPriceInquiry'] = OrderSupplier::where('user_id', $user->supplier_id)->whereNull('purchase')
                ->count();
            $data['Orders'] = Order::select('id', 'productname', 'sendoutdate', 'status')
                ->where('supplier', $user->supplier_id)
                ->latest()
                ->take(3)
                ->get();
        }

        // Data for Marketing (if applicable)
        // Adjust based on your actual roles and permissions

        return response()->json($data, 200);
    }
    public function Buyerdashboard()
    {
        // dd($id);
        $id = auth()->user()->buyer_id;
        $data['Inquiry'] = PriceInquiry::where('buyer', $id)->count();
        $data['Products'] = Products::count();
        $data['Orders'] = Order::where('buyer', $id)->count();
        $data['Order'] = Order::select('id', 'productname', 'sendoutdate', 'status')->where('buyer', $id)->latest()->take(3)->get();
        return response()->json($data, 200);
    }
}
