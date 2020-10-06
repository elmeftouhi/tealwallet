<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseCategories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ExpenseController extends Controller{

    private $months = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July ',
                'August',
                'September',
                'October',
                'November',
                'December',
                ];

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        dump($this->getAvgMonth());
        dump($this->getAvgDay());
        return view('expense.index', ['expenses'=> Auth::user()->expenses->sortByDesc('expense_date')]);
    }

    public function create($id_category=0){
        return view('expense.create', ['id_category'=>$id_category, 'expense_categories'=>ExpenseCategories::orderBy('level', 'asc')->get()]);
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'amount'                =>  "required|regex:/^\d+(\.\d{1,2})?/",
            'expense_category_id'   =>  'required',
            'expense_date'          =>  'required'
         ]);

        $request->request->add(['user_id' => Auth::id()]);
        $category = ExpenseCategories::find($request->input('expense_category_id'));

        if( empty($request->input('description') ) ) $request->merge(['description' => $category->expense_category]);

        Expense::create($request->all());
        return redirect(route('expense.index'));
    }

    public function show(Expense $expense){
        //
    }

    public function edit(Expense $expense){
        return view('expense.edit',['expense'=>$expense, 'expense_categories'=> ExpenseCategories::where('status', '=', true)->orderBy('level', 'asc')->get()]);
    }

    public function update(Request $r, Expense $expense){
        $expense->update($r->all());
        Session::flash('message', 'Expense was updated!');
        return redirect(route('expense.index'));
    }

    public function destroy(Expense $expense){
        if($expense->delete())
            Session::flash('message', 'Expense was destroyed!'); 
        else
            Session::flash('message', 'Expense was not destroyed!'); 
        return redirect( route('expense.index') );
    }

    public function sumByYearMonth($year = 0, $month = 0){

        $year = $year === 0? date('Y'): $year;
        if($month === 0){
            $expenses = DB::table('expenses')
                            ->select(DB::raw('MONTHNAME(expense_date) as month'), DB::raw('sum(amount) as total'))
                            ->whereYear('expense_date', '=', $year)
                            ->where('user_id', Auth::id())
                            ->groupBy(DB::raw('MONTHNAME(expense_date)') )
                            ->get()
                            ->toArray();
                            //->toJson();
            $month_total = [];
            foreach($this->months as $month){
                $total = 0;
                foreach($expenses as $e)
                    if($e->month === $month) $total = $e->total;                   
                
                $month_total[$month] = $total;
            }
            return json_encode($month_total);           
        }else{
            $expenses = DB::table('expenses')
                            ->select(DB::raw('Day(expense_date) as day'), DB::raw('sum(amount) as total'))
                            ->whereYear('expense_date', '=', $year)
                            ->whereMonth('expense_date', '=', $month)
                            ->where('user_id', Auth::id())
                            ->groupBy(DB::raw('Day(expense_date)') )
                            ->get()
                            ->toArray();
                            //->toJson();

            $date = Carbon::parse($year . '-' . $month);
            $daysInMonth = $date->daysInMonth;

            $days_total = [];
            for( $i = 1; $i <= $daysInMonth; $i++ ){
                $total = 0;
                foreach($expenses as $e)
                    if($e->day === $i) $total = $e->total;                   
                
                $days_total[$i] = $total;
            }
            return json_encode($days_total); 
        }


    }

    public function getSumToday(){

        $expenses = DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'))
        ->whereDay('expense_date', '=', date('d'))
        ->whereYear('expense_date', '=', date('Y'))
        ->whereMonth('expense_date', '=', date('m'))
        ->where('user_id', Auth::id())
        ->get();
        return $expenses->first()->total;
    }

    public function getSumThisWeek(){

        $expenses = DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'))
        ->whereBetween('expense_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->where('user_id', Auth::id())
        ->get();
        return $expenses->first()->total;
    }

    public function getSumThisMonth(){
        
        $expenses = DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'))
        ->whereYear('expense_date', '=', date('Y'))
        ->whereMonth('expense_date', '=', date('m'))
        ->where('user_id', Auth::id())
        ->get();
        return $expenses->first()->total;
    }

    public function getSumThisYear(){
        
        $expenses = DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'))
        ->whereYear('expense_date', '=', date('Y'))
        ->where('user_id', Auth::id())
        ->get();
        return $expenses->first()->total;
    }

    public function getSums(){
        return [
            'today'     =>  Str::money($this->getSumToday() , 2),
            'week'      =>  Str::money($this->getSumThisWeek(), 2),
            'month'     =>  Str::money($this->getSumThisMonth(), 2),
            'year'      =>  Str::money($this->getSumThisYear(), 2),
        ];
    }

    public function getAvgDay(){
        $expenses = DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'))
        ->whereYear('expense_date', '=', date('Y'))
        ->where('user_id', Auth::id())
        ->groupBy(DB::raw('Day(expense_date)') )
        ->get();
        return $expenses->avg('total');    
    }

    public function getAvgMonth(){
        $expenses = DB::table('expenses')
        ->select(DB::raw('sum(amount) as total'))
        ->whereYear('expense_date', '=', date('Y'))
        ->where('user_id', Auth::id())
        ->groupBy(DB::raw('Month(expense_date)') )
        ->get();
        return $expenses->avg('total');    
    }
}
