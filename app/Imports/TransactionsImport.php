<?php

namespace App\Imports;

use App\Models\Transaction;
use Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class TransactionsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $normalizedRow = array_change_key_case(array_map('trim', $row), CASE_LOWER);
        $date = isset($normalizedRow['date']) ? $this->transformDate($normalizedRow['date']) : null;

        $data = [
            'transaction_details' => $normalizedRow['transaction_details'] ?? null,
            'date' => $date ?? null,
            'deposit' => $normalizedRow['deposit'] ?? 0,
            'withdrawal' => $normalizedRow['withdrawal'] ?? 0,
            'balance' => $normalizedRow['balance'] ?? null,
            'notice' => $normalizedRow['notice'] ?? null,
            'remittance_slip' => $normalizedRow['remittance slip'] ?? null,
        ];

        $validator = Validator::make($data, [
            'transaction_details' => 'nullable|string',
            'date' => 'nullable|date',
            'deposit' => 'nullable|numeric|min:0',
            'withdrawal' => 'nullable|numeric|min:0',
            'balance' => 'nullable|numeric',
            'notice' => 'nullable|string',
            'remittance_slip' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return null; // Skip invalid row
        }

        // Ensure that only one of deposit or withdrawal is more than zero
        if (($data['deposit'] > 0 && $data['withdrawal'] > 0) || ($data['deposit'] <= 0 && $data['withdrawal'] <= 0)) {
            return null; // Skip rows where both or neither are positive
        }

        return new Transaction([
            'user_id' => Auth::id(),
            'transaction_details' => $data['transaction_details'],
            'date' => $data['date'],
            'deposit' => $data['deposit'],
            'withdrawal' => $data['withdrawal'],
            'balance' => $data['balance'],
            'notice' => $data['notice'],
            'remittance_slip' => $data['remittance_slip'],
        ]);
    }

    public function transformDate($value)
    {
        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
        } elseif (strtotime($value)) {
            return date('Y-m-d', strtotime($value));
        } else {
            return null;
        }
    }
}
