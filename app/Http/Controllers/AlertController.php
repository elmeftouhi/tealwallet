<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getAlerts(){
        return Auth::user()->alerts->where('unread', 0)->toJson();
    }
}
