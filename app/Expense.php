<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    protected $fillable = [
        "uuid","token","expensetype",
        "expenseItems","expenseInfo","expenseTerm",
        "expenseTotal","makeBorrowItems","makeLoanBorrowItems",
        "salaryPaymentType","salaryTerm","totalBorrow",
        "totalBorrowLoan","worker","user_id"
    ];
}
