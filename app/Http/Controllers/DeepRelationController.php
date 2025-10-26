<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admitted;
use App\Models\Shop;
use App\Models\Country;
use DB;

class DeepRelationController extends Controller
{
    public function deepRelated(){
        $shops = Shop::with('city.country')->get();
        return view('deep-relation',compact('shops'));
    }
}
