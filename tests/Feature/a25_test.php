<?php

namespace Tests\Feature;

use App\Models\TransactionsModel;
use Tests\TestCase;

class a25_test extends TestCase
{

    public function testCreateEmployee()
    {
        $response = $this->post('/api/createEmployees', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('employees', ['email' => 'test@example.com']);
    }

    public function testAcceptTransaction()
    {
        $response = $this->post('/api/transaction/accept', [
            'employee_id' => 8,
            'hours' => 45
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', ['employee_id' => 8, 'hours' => 45]);
    }

    public function testGetPayouts()
    {
        TransactionsModel::create(['employee_id' => 8, 'hours' => 40]);
        $response = $this->get('/api/transaction/get-payouts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    8
                ]
            ]);
    }

    public function testPayOutAll()
    {
        $response = $this->get('/api/transaction/repayment-all-debts');

        $response->assertStatus(200);
        $this->assertDatabaseCount('transactions', 0);
    }
}
