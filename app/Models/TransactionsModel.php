<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';

    public $timestamps = false;
    protected $fillable = [
        'employee_id',
        'hours'
    ];
}
