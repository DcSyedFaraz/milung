<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductGroup;
use App\Models\User;
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
        // dd($request->all());
        if ($request->buyerid) {
            $data['buyers'] = Order::where('buyer', $request->buyerid)->sum('totalvalue');
        }
        if ($request->supplierid) {
            $data['supplier'] = Order::where('supplier', $request->supplierid)->sum('totalvalue');
        }
        return $data;
    }
}
