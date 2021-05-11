<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function inventory()
    {
        return view('user_member.inventory');
    }

    public function list()
    {
        return view('user_member.list');
    }

    public function viewasset()
    {
        return view('user_member.view');
    }
}
