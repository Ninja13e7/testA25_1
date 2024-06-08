<?php

namespace App\Http\Controllers;

use App\Models\TransactionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    const PAY_PER_HOUR = 200;

    public function acceptTransaction (Request $request)
    {
        $employee_id = $request->input('employee_id');
        $hours = $request->input('hours');

        $transaction = new TransactionsModel();
        $transaction->employee_id = $employee_id;
        $transaction->hours = $hours;
        $transaction->save();

        return response()->json(['message' => 'Транзакция принята успешно'], 200);
    }

    public function getHours()
    {
        $employeesHours = TransactionsModel::select('employee_id', DB::raw('SUM(hours) as total_hours'))
            ->groupBy('employee_id')
            ->get();
        return $employeesHours;
    }

    public function paymentAllEmployees()
    {
        $countPayouts = TransactionsModel::count();

        if (!$countPayouts) {
            return response()->json('Все задолжности погашены', 200);
        }

        $payouts = $this->getHours();

        $result = [];
        foreach ($payouts as $payout) {
            $result[] = [
                "$payout->employee_id" => $payout->total_hours * self::PAY_PER_HOUR . ' руб',
                'status' => 'Задолжность погашена'
            ];

            TransactionsModel::where('employee_id', $payout->employee_id)->delete();
        }

        return response()->json($result, 200);
    }

    public function getPayouts ()
    {
        $countPayouts = TransactionsModel::count();

        if (!$countPayouts) {
            return response()->json('Все выплаты были сделаны', 200);
        }

        $payouts = $this->getHours();
        $result = [];
        foreach ($payouts as $payout) {
            $result[] = [
                "$payout->employee_id" => $payout->total_hours * self::PAY_PER_HOUR . ' руб'
            ];
        }

        return response()->json($result, 200);
    }
}
