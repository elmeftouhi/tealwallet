<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseCategories;
use Session;
class ExpenseCategoriesController extends Controller{

    private $icons = [
                        'cars & Fuel'       =>  '<i class="fas fa-car-side"></i>',
                        'school'            =>  '<i class="fas fa-graduation-cap"></i>',
                        'health'            =>  '<i class="fas fa-heartbeat"></i>',
                        'grocerie'          =>  '<i class="fas fa-shopping-basket"></i>',
                        'help & gift'       =>  '<i class="fas fa-hands-helping"></i>',
                        'saving'            =>  '<i class="fas fa-piggy-bank"></i>',
                        'investing'         =>  '<i class="fas fa-chart-line"></i>',
                        'restaurant'        =>  '<i class="fas fa-utensils"></i>',
                        'renting'           =>  '<i class="fas fa-house-damage"></i>',
                        'Eau & Electricity' =>  '<i class="fas fa-charging-station"></i>',
                        'internet'          =>  '<i class="fab fa-internet-explorer"></i>',
                        'Phone'             =>  '<i class="fas fa-phone-square-alt"></i>'
                    ];

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $categories = ExpenseCategories::orderBy('level', 'asc')->get();
        return view('expense_category.category')->with( ['categories' => $categories] );
    }

    public function edit(ExpenseCategories $category){
        $icons = $this->icons;
        return view('expense_category.edit', compact('category', 'icons') );
    }

    public function update(Request $r, ExpenseCategories $category){
        $r->merge(array('status' => $r->has('status') ? true : false));
        $r->merge(array('is_budget' => $r->has('is_budget') ? true : false));
        $r->merge(array('budget_amount' => is_null($r->input('budget_amount')) ? 0 : $r->input('budget_amount')));
        $category->update($r->all());
        Session::flash('message', 'Category was updated!');
        return redirect( route('category') );
    }

    public function create(){
        return view('expense_category.create', ['icons'=>$this->icons]);
    }

    public function store(Request $r){
        $validateData = $r->validate([
           'expense_category'   =>  'required|max:255',
           'icon'               =>  'required|max:255' 
        ]);
        $r->merge(array('status' => $r->has('status') ? true : false));
        $r['level'] =  ExpenseCategories::count() + 1;
        ExpenseCategories::create($r->all());
        Session::flash('message', 'Category was created!'); 
        return redirect( route('category') );
    }

    public function destroy($id){
        
        //ExpenseCategories::destroy($id);
        Session::flash('message', 'Category was not destroyed!'); 
        return redirect( route('category') );
    }

    public function reorder(Request $r){
        foreach($r->categories as $k=>$id){
            ExpenseCategories::find($id)->update([
                'level' =>  $k+1
            ]);
        }
        Session::flash('message', 'Category was created!');
        return 'success';
    }
}
