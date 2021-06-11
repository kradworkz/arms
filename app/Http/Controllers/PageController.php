<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    ///////////////////////////////////
    /////// ADMINISTRATOR PAGES ///////
    ///////////////////////////////////

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

    public function deviceslist()
    {
        return view('user_admin.devicelist');
    }

    ///////////////////////////////////
    /////////// MEMBER PAGES //////////
    ///////////////////////////////////

    public function inventory()
    {
        return view('user_member.inventory');
    }

    public function locations()
    {
        return view('user_member.location');
    }

    public function requests()
    {
        return view('user_member.request');
    }

    public function viewasset()
    {
        return view('user_member.view');
    }

    public function search()
    {
        return view('user_member.search');
    }


    ///////////////////////////////////
    /////////// ALL PAGES //////////
    ///////////////////////////////////

    public function devices()
    {
        return view('user_admin.device');
    }
}
