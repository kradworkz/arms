<?php

namespace App\Http\Controllers\Users\Member;

use App\Models\AssetList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function total(){
        $counts[] = [  
            $data[] = [
                'name' => 'Total Assets',
                'count' => AssetList::count(),
                'color' => 'primary',
                'icon' => 'bx-list-ul'
            ],
            $data[]  = [
                'name' => 'Available',
                'count' => AssetList::where('is_available',1)->count(),
                'color' => 'success',
                'icon' => 'bxs-check-circle'
            ],
            $data[] = [
                'name' => 'Not Available',
                'count' => AssetList::where('is_available',0)->count(),
                'color' => 'danger',
                'icon' => 'bxs-x-circle'
            ],
        ];

        return $counts;
    }
}
