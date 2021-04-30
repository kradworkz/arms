<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function staffs()
    {
        return view('user_admin.staff');
    }
    
    public function agencies()
    {
        return view('user_admin.member');
    }

    public function lgus()
    {
        return view('user_admin.lgu');
    }

    public function settings()
    {
        return view('user_admin.setting');
    }
    
}
