<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function statfilter()
    {
        $data['buyers'] = User::role('buyer')->select('id', 'userid')->get();
        $data['supplier'] = User::role('supplier')->select('id', 'userid')->get();
        $data['product'] = ProductGroup::select('id', 'group_name')->get();
        return $data;
    }
    public function statfilterSearch(Request $request)
    {
        // $sale = Order::find(2); // Assuming you have a sale record in your database
        // $quantitySold = $sale->quantity_unit; // This will trigger the accessor method
        // dd($quantitySold);
        // dd($request->date);

        // $data['product'] = Order::select('group')
        //     ->selectRaw('SUM(quantity_unit) as total_quantity')
        //     ->whereBetween('created_at', [$request->date['startDate'], $request->date['endDate']])
        //     ->groupBy('group')
        //     ->orderByDesc('total_quantity')
        //     ->limit(5) // Limit to the top 5 best-selling products
        //     ->get();
        $data['product'] = Order::select('product_groups.group_name as group_name')
            ->selectRaw('SUM(quantity_unit) as total_quantity')
            ->join('product_groups', 'orders.group', '=', 'product_groups.id')
            // ->whereBetween('orders.created_at', [$request->date['startDate'], $request->date['endDate']])
            ->when($request->has('date'), function ($query) use ($request) {
                return $query->whereBetween('orders.created_at', [$request->date['startDate'], $request->date['endDate']]);
            })
            ->when($request->has('buyerid'), function ($query) use ($request) {
                return $query->where('orders.buyer', $request->buyerid);
            })
            ->when($request->has('supplierid'), function ($query) use ($request) {
                return $query->where('orders.supplier', $request->supplierid);
            })
            ->groupBy('product_groups.group_name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        $data['productvalue'] = Order::select('product_groups.group_name as group_name')
            ->selectRaw('SUM(totalvalue) as total_quantity')
            ->join('product_groups', 'orders.group', '=', 'product_groups.id')
            ->when($request->has('date'), function ($query) use ($request) {
                return $query->whereBetween('orders.created_at', [$request->date['startDate'], $request->date['endDate']]);
            })
            ->when($request->has('buyerid'), function ($query) use ($request) {
                return $query->where('orders.buyer', $request->buyerid);
            })
            ->when($request->has('supplierid'), function ($query) use ($request) {
                return $query->where('orders.supplier', $request->supplierid);
            })
            ->whereNotNull('totalvalue')
            ->groupBy('product_groups.group_name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        if ($request->buyerid) {
            $data['buyers'] = Order::where('buyer', $request->buyerid)->sum('totalvalue');
            $data['buyersqty'] = Order::where('buyer', $request->buyerid)->sum('quantity_unit');
        }
        if ($request->supplierid) {
            $data['supplier'] = Order::where('supplier', $request->supplierid)->sum('totalvalue');
            $data['supplierqty'] = Order::where('supplier', $request->supplierid)->sum('quantity_unit');
        }
        return $data;
    }

}
