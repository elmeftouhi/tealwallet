<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\ExpenseCategories;

class ExpenseSearch extends Component{

    public $month = 0;
    public $year = 0;

    public function render(){

        $list = Auth::user()->expenses();
        $year = $this->year === 0? date('Y'): $this->year;
        $month = $this->month === 0? date('m'): $this->month;

        $date = Carbon::parse($year . '-' . $month);
        $nextMonth = $date->addMonthsNoOverflow(1)->month;
        $nextYear = $date->addMonthsNoOverflow(1)->year;
        $prevMonth = date('m', strtotime($year . '-' . $month . ' -1 month'));
        $prevYear = date('Y', strtotime($year . '-' . $month . ' -1 month'));

        $dates = [
            'prev'      =>  [$prevMonth, $prevYear],
            'current'   =>  [$month, $year],
            'next'      =>  [$nextMonth, $nextYear]
        ];

        $expenses = $list->whereYear('expense_date', '=', $year)->whereMonth('expense_date', '=', $month);

        return view('livewire.expense-search', ['expenses'=> $expenses->get(), 'dates'=>$dates, 'expense_categories'=>ExpenseCategories::orderBy('level', 'asc')->get()]);
    }
}
