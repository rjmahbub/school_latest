<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inst_info;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\admission;
use App\Models\Country;
use Alert;
use App\Helpers\SiteHelper;

class IndexController extends Controller
{
    public function htmlPages(){
        $pages = DB::table('html_pages')->get();
        return view('mixed.html-pages',compact('pages'));
    }

    public function index(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($prefix == SiteHelper::$prefixMain){
            $packages = DB::table('packages')->get();
            return view('welcome',compact('packages'));
        }else{
            if($request->pgp && $request->pgp > 1){
                $offset = ($request->pgp - 1) * 6;
            }else{
                $offset = 0;
            }
            $images = DB::table('slideshow')->where('prefix',$prefix)->orderBy('sequence')->get();
            $photos = DB::table('photo_gallery')->where('prefix',$prefix);
            $countPhoto = count($photos->get())/6;
            if(is_int($countPhoto)){
                $page = $countPhoto;
            }else{
                $page = intval($countPhoto + 1);
            }
            $photos = $photos->offset($offset)->limit(6)->get();
            $videos = DB::table('video_gallery')->where('prefix',$prefix)->get();
            $notices = DB::table('notices')->where('prefix',$prefix)->orderBy('id','desc')->get();
            $headlines = DB::table('notices')->where('prefix',$prefix)->where('headline','on')->orderBy('id','desc')->get();
            return view('welcome',compact('request','images','photos','page','videos','notices','headlines'));
        }
    }

    public function DashboardView(){
        /* $shops = Country::with('shops')->get();

        foreach($shops as $shop){
            echo $shop->city->name;
            echo '<br>';
        }
        exit; */
        $user = Auth::user();
        $prefix = SiteHelper::prefix(0);
        $recharge = DB::table('payments')->where(['ref_no' => $user->phone, 'recharge_by' => null])->first();
        if($recharge){
            $update = DB::table('payments')->where('id',$recharge->id)->update(['recharge_by' => $user->id]);
            $statementCredentials = [
                'user_id' => $user->id,
                'transaction_amount' => $recharge->amount,
                'transaction_type' => 'recharge',
                'balance_before' => $user->balance,
                'balance_now' => $user->balance + $recharge->amount,
                'status' => 'in'
            ];
            if($update){
                User::where('phone',$user->phone)->increment('balance',$recharge->amount);
                DB::table('statement')->insert($statementCredentials);
            }
        }
        if($user->who == 1 || $user->who == 2 || $user->who == 7){
            if($prefix !== SiteHelper::$prefixMain){
                Auth::logout();
                return redirect(route('login'));
            }
            return view('dashboard');
        }else{
            if($prefix == SiteHelper::$prefixMain){
                Auth::logout();
                return redirect(route('login'));
            }
            $inst = inst_info::where('prefix',$prefix)->first();
            if($inst && strtotime($inst->valid_till) > strtotime(now()) && $inst->status == 1 && $user->status == 1){
                return view('dashboard');
            }else{
                return SiteHelper::payment();
            }
        }
    }

    public function includeDashboard(Request $request){
        $user = Auth::user();
        $prefix = SiteHelper::prefix(0);
        if($user->who == 1 || $user->who == 2 || $user->who == 3){
            $userCount = array();
            $usersCount = array();
            for($i=0;$i<=7;$i++){
                $userCount = User::where('who',$i);
                if($user->who == 3){
                    $userCount = $userCount->where('prefix',$prefix);
                }
                $userCount = count($userCount->get());
                $usersCount[] = $userCount;
            }

            $teachers = DB::table('teachers');
            $students = DB::table('admissions');
            if($user->who == 3){
                $teachers = $teachers->where('prefix',$prefix);
                $students = $students->where('prefix',$prefix);
            }
            $teachersCount = count($teachers->get());
            $studentsCount = count($students->get());
            $packages = DB::table('packages')->get();
            return view('includes.dashboard',compact('usersCount','teachersCount','studentsCount','packages'));
        }
        if($user->who == 7){
            $totalCashout = SiteHelper::SumWhereCol('cashout','user_id',$user->id,'amount');
            $totalRefer = count(DB::table('refer_inst')->where('user_id',$user->id)->get());
            return view('includes.dashboard',compact('totalCashout','totalRefer'));
        }
    }

    public function packageList(){
        $packages = DB::table('packages')->get();
        return view('mixed.packages',compact('packages'));
    }

    public function editPackage(Request $request){
        $package = DB::table('packages')->where('id',$request->id)->first();
        return view('mixed.package_edition',compact('package'));
    }

    public function PackageEditionSave(Request $request){
        $credentials = [
            'name' => $request->name,
            'price' => $request->price,
            'details' => $request->details
        ];
        $success = DB::table('packages')->where('id',$request->id);
        if($request->add == 'on'){
            $success = $success->insert($credentials);
        }else{
            $success = $success->update($credentials);
        }

        if($success){
            Alert::success('Updated!');
            return back();
        }else{
            Alert::error('Failed!');
            return back();
        }
    }

    public function geoip(){
        $array = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        return view('location.ip-location',compact('array'));
    }
}
