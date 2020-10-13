<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Expense extends Model
{
    protected $fillable = [
        'expense_date', 'expense_category_id', 'description', 'amount', 'description', 'user_id'
    ];

    public function expense_category(){
        return $this->belongsTo('App\ExpenseCategories', 'expense_category_id');
    }
}
