<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    protected $fillable = [
        "uuid","token","AccountSpendFrom","expensetype",
        "expenseItems","requested_by","overview","expenseTerm",
        "expenseTotal","makeBorrowItems","makeLoanBorrowItems",
        "salaryPaymentType","salaryTerm","totalBorrow",
        "totalBorrowLoan","worker","user_id"
    ];
}
