<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategories extends Model
{
    protected $fillable = [
        'expense_category', 'status', 'icon', 'level', 'is_budget', 'budget_amount'
    ];

    public function expenses(){
        return $this->hasMany('App\Expense', 'expense_category_id');
    }

    public function month_expenses(){
        return $this->expenses()->whereMonth('expense_date','=', date('m'));
    }
}
