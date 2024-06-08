<?php

namespace App\Http\Controllers;

use App\Models\EmployeesModel;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{

    public function createEmployees (Request $request)
    {
        $email = $request->input('email');
        $password = bcrypt($request->input('password'));

        $employees = new EmployeesModel();
        $employees->email = $email;
        $employees->password = $password;
        $employees->save();

        return response()->json(['message' => 'Сотрудник успешно добавлен'], 200);
    }
}
