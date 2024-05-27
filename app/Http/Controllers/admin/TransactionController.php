<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\TransactionsImport;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index()
    {
        $stat = Transaction::orderBy('created_at', 'desc')->get();
        // return json
        return response()->json($stat, 200);
    }
    public function getTransactions(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = Transaction::whereBetween('date', [$startDate, $endDate])->get();

        return response()->json($transactions, 200);
    }
    public function transactions(Request $request, $id)
    {
        // dd($request->all(), $id);
        $request->validate([
            'file' => 'required|file'
        ]);

        $transaction = Transaction::findOrFail($id);
        if ($request->file('file')) {
            $file = $request->file('file');

            $fileName = time() . $file->getClientOriginalName();
            $path = $file->storeAs('orders/remittance_slips', $fileName, 'public');
            $transaction->remittance_slip = $path;
            $transaction->save();
        }

        return response()->json(['message' => 'File uploaded successfully', 'file' => $path]);
    }
    public function statement(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'statement' => 'required|file|mimes:csv,xlsx',
        ]);

        Excel::import(new TransactionsImport, $request->file('statement'));

        return response()->json(['message' => 'Transactions uploaded successfully.'], 200);
    }
    public function destroy($id)
    {
        // dd($id);
        try {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->remittance_slip) {
                $filePath = $transaction->remittance_slip;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            $transaction->delete();

            return response()->json(['message' => 'Transaction successfully'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
