<?php

namespace App\Observers;

use App\Expense;
use App\Alert;
use Illuminate\Support\Facades\Auth;

class ExpenseObserver
{
    /**
     * Handle the expense "created" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function created(Expense $expense)
    {
        //
        if($expense->expense_category->is_budget){
            $budget_amount = $expense->expense_category->budget_amount;
            $sum = $expense->expense_category->month_expenses->sum('amount');
            if($sum >= $budget_amount){
                Auth::user()->alerts()->create([
                    'alert_message' => $expense->expense_category->expense_category . ' has exceeded the Budget'
                ]);
            }
        }


    }

    /**
     * Handle the expense "updated" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function updated(Expense $expense)
    {
        if($expense->expense_category->is_budget){
            $budget_amount = $expense->expense_category->budget_amount;
            $sum = $expense->expense_category->month_expenses->sum('amount');
            if($sum >= $budget_amount){
                Auth::user()->alerts()->create([
                    'alert_message' => $expense->expense_category->expense_category . ' has exceeded the Budget'
                ]);
            }
        }
    }

    /**
     * Handle the expense "deleted" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function deleted(Expense $expense)
    {
        //
    }

    /**
     * Handle the expense "restored" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function restored(Expense $expense)
    {
        //
    }

    /**
     * Handle the expense "force deleted" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function forceDeleted(Expense $expense)
    {
        //
    }
}
