<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeesModel extends Model
{
    protected $table = 'employees';

    public $timestamps = false;
    protected $fillable = [
        'employee_id',
        'email',
        'password',
    ];
}
