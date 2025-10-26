<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\inst_info;
use DB;
use Alert;
use App\Helpers\SiteHelper;

class SuperAdminController extends Controller
{
    public function InstituteList(){
        return view('SuperAdmin.institutes');
    }

    public function InstActiveOrInactive(Request $request){
        return SiteHelper::onOff('inst_infos','id',$request->id,'status',$request->status);
    }

    /* public function InstReferActiveForm(){
        return view('SuperAdmin.inst-refer-activation');
    }

    public function InstReferActive(Request $request){
        $instRefer = DB::table('refer_inst')->where('id',$request->id)->first();
        if($instRefer->user_id == $request->user_id){
            $affiliate = DB::table('settings')->where('id',1)->first();
            if($affiliate){
                if($affiliate->switch == 1){
                    $affValue = explode(',',$affiliate->value);
                    $pp = DB::table('packages')->where('id',$inst->package)->first()->price;
                    $referNumbers = count(DB::table('refer_inst')->where(['user_id'=>$instRefer->user_id, 'completed'=>1])->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->get());
                    $percent = $affiliate->value;
                    if($referNumbers > $affValue[1]){
                        $percent = $percent + $affValue[2];
                    }
                    $affUser = User::where('id',$instRefer->user_id);
                    $instInfo = inst_info::where('prefix',$instRefer->prefix);
                    $commission = $pp / 100 * $percent;
                    $beforeBalance = $affUser->first()->balance;
                    $stmtCredentials = [
                        'user_id' => $instRefer->user_id,
                        'transaction_amount' => $commission,
                        'transaction_type' => 'refer commission',
                        'balance_before' => $beforeBalance,
                        'balance_now' => $beforeBalance + $commission,
                        'status' => 'in'
                    ];
                    $expireDate = $instInfo->first()->valid_till;
                    if(strtotime($expireDate) < strtotime(now())){
                        $expireDate = now();
                    }
                    $valid_till = date('Y-m-d H:i:s',strtotime("+$expireDate months"));
                    $update1 = $instInfo->update(['valid_till'=>$valid_till]);
                    $update2 = DB::table('refer_inst')->where('id',$instRefer->id)->update(['completed' => 1]);
                    if($update1 && $update2){
                        $affUser->increment('balance',$commission);
                        DB::table('statement')->insert($stmtCredentials);
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
        return false;
    } */

    public function InstituteRenewForm(){
        $prefix = SiteHelper::prefix(0);
        $renewPrice = ' ';
        $getRenewPrice = DB::table('renew_price')->where('prefix',$prefix)->first();
        if($getRenewPrice){
            $renewPrice = $getRenewPrice->price;
            return view('SuperAdmin.renew',compact('renewPrice'));
        }else{
            Alert::error('Renew not available');
            return back();
        }
    }

    public function InstituteRenew(Request $request){
        $user = Auth::user();
        $prefix = SiteHelper::prefix(0);
        $inst = inst_info::where('prefix',$prefix);
        $expireDate = $inst->first()->valid_till;
        $isRenewable = DB::table('renew_price')->where('prefix',$prefix)->first();
        if($isRenewable){
            $renewPrice = $isRenewable->price;
            if($user->balance < $renewPrice){
                Alert::error('Balance not availble!')->persistent("Close this");
                return back()->withInput();
            }
        }else{
            Alert::error('Renew not availble!')->persistent("Close this");
            return back()->withInput();
        }
        if($request->valid_till < 12){
            Alert::error('Minimum renew duration 1 Year!')->persistent("Close this");
            return back()->withInput();
        }
        if(password_verify($request->password,$user->password)){
            $stmtCredentials = [
                'user_id' => $user->id,
                'transaction_amount' => $renewPrice,
                'transaction_type' => 'website renew',
                'balance_before' => $user->balance,
                'balance_now' => $user->balance - $renewPrice,
                'status' => 'out'
            ];
            if(strtotime($expireDate) < strtotime(now())){
                $expireDate = now();
            }
            $valid_till = strtotime("+$request->valid_till months", strtotime($expireDate));
            $decbal = User::where('id',$user->id)->decrement('balance',$renewPrice);
            if($decbal){
                $inst->update(['valid_till'=>date('Y-m-d H:i:s',$valid_till)]);
                DB::table('statement')->insert($stmtCredentials);
                $instituteRefer = DB::table('refer_inst')->where(['prefix'=>$prefix, 'completed'=>null]);
                $referAvailable = $instituteRefer->first();
                $affiliateCommission = DB::table('settings')->where('setting_name','affiliate')->first();
                if($referAvailable && $affiliateCommission->switch == 1){
                    $affUser = User::where('id',$referAvailable->user_id);
                    $beforeBalance = $affUser->first()->balance;
                    $affUserCredentials = [
                        'user_id' => $referAvailable->user_id,
                        'transaction_amount' => $affiliateCommission->value,
                        'transaction_type' => 'refer commission',
                        'balance_before' => $beforeBalance,
                        'balance_now' => $beforeBalance + $affiliateCommission->value,
                        'status' => 'in'
                    ];
                    $up = $instituteRefer->update(['completed'=>1]);
                    if($up){
                        $affUser->increment('balance',$affiliateCommission->value);
                        DB::table('statement')->insert([$affUserCredentials]);
                        $affiliateGeneration = DB::table('settings')->where('setting_name','affiliate_generation')->first();
                        if($affiliateGeneration->switch == 1){
                            $referTo = $referAvailable->user_id;
                            $initialCommission = $affiliateGeneration->value;
                            for($i=0;$i<=30;$i++){
                                $ru = DB::table('refer_affiliate')->where(['refer_to'=>$referTo])->first();
                                if($ru){
                                    $iu = User::where('id',$ru->refer_by);
                                    $bb = $iu->first()->balance;
                                    $devidedCommission = $initialCommission / 2;
                                    $affChildCredentials = [
                                        'user_id' => $ru->refer_by,
                                        'transaction_amount' => $devidedCommission,
                                        'transaction_type' => 'refer commission',
                                        'balance_before' => $bb,
                                        'balance_now' => $bb + $affiliateGeneration->value,
                                        'status' => 'in'
                                    ];
                                    if($devidedCommission >= 10){
                                        $iu->increment('balance',$devidedCommission);
                                        DB::table('statement')->insert([$affChildCredentials]);
                                    }else{
                                        Alert::success('Success!')->persistent("Close this");
                                        return redirect(route('dashboard'));
                                    }
                                    $referTo = $ru->refer_by;
                                    $initialCommission = $devidedCommission;
                                }else{
                                    Alert::success('Success!')->persistent("Close this");
                                    return redirect(route('dashboard'));
                                }
                            }                            
                        }
                    }
                }
                Alert::success('Success!')->persistent("Close this");
                return redirect(route('dashboard'));
            }
        }else{
            Alert::error('Wrong Password!')->persistent("Close this");
            return back()->withInput();
        }
    }

    public function RenewInstSuperAdminForm(Request $request){
        return view('SuperAdmin.renew-from-sa');
    }

    public function RenewInstSuperAdmin(Request $request){
        $user = Auth::user();
        if(password_verify($request->password,$user->password)){
            if($user->who == 1 && $request->prefix && $request->valid_till){
                $prefix = $request->prefix;
                $inst = inst_info::where('prefix',$prefix);
                $instArr = $inst->first();
                $instAdmin = User::where(['prefix'=>$prefix, 'who'=>3]);
                $instAdminArr = $instAdmin->first();
                if(!$instAdminArr || !$instArr){
                    Alert::error('No Institute Found!')->persistent("Close this");
                    return back()->withInput();
                }
                $isRenewable = DB::table('renew_price')->where('prefix',$prefix)->first();
                if($isRenewable){
                    $renewPrice = $isRenewable->price;
                    if($instAdminArr->balance < $renewPrice){
                        Alert::error('Institute Balance Not Available!')->persistent("Close this");
                        return back()->withInput();
                    }
                }else{
                    Alert::error('Renew not availble!')->persistent("Close this");
                    return back()->withInput();
                }
                $expireDate = $instArr->valid_till;
                if(strtotime($expireDate) < strtotime(now())){
                    $expireDate = now();
                }
                $stmtCredentials = [
                    'user_id' => $instAdminArr->id,
                    'transaction_amount' => $renewPrice,
                    'transaction_type' => 'website renew',
                    'balance_before' => $instAdminArr->balance,
                    'balance_now' => $instAdminArr->balance - $renewPrice,
                    'status' => 'out'
                ];
                $valid_till = strtotime("+$request->valid_till months", strtotime($expireDate));
                $decbal = $instAdmin->decrement('balance',$renewPrice);
                if($decbal){
                    $inst->update(['valid_till'=>date('Y-m-d H:i:s',$valid_till)]);
                    DB::table('statement')->insert($stmtCredentials);
                    $instituteRefer = DB::table('refer_inst')->where(['prefix'=>$prefix, 'completed'=>null]);
                    $referAvailable = $instituteRefer->first();
                    $affiliateCommission = DB::table('settings')->where('setting_name','affiliate')->first();
                    if($referAvailable && $affiliateCommission->switch == 1){
                        $affUser = User::where('id',$referAvailable->user_id);
                        $beforeBalance = $affUser->first()->balance;
                        $affUserCredentials = [
                            'user_id' => $referAvailable->user_id,
                            'transaction_amount' => $affiliateCommission->value,
                            'transaction_type' => 'refer commission',
                            'balance_before' => $beforeBalance,
                            'balance_now' => $beforeBalance + $affiliateCommission->value,
                            'status' => 'in'
                        ];
                        $up = $instituteRefer->update(['completed'=>1]);
                        if($up){
                            $affUser->increment('balance',$affiliateCommission->value);
                            DB::table('statement')->insert([$affUserCredentials]);
                            $affiliateGeneration = DB::table('settings')->where('setting_name','affiliate_generation')->first();
                            if($affiliateGeneration->switch == 1){
                                $referTo = $referAvailable->user_id;
                                $initialCommission = $affiliateGeneration->value;
                                for($i=0;$i<=30;$i++){
                                    $ru = DB::table('refer_affiliate')->where(['refer_to'=>$referTo])->first();
                                    if($ru){
                                        $iu = User::where('id',$ru->refer_by);
                                        $bb = $iu->first()->balance;
                                        $devidedCommission = $initialCommission / 2;
                                        $affChildCredentials = [
                                            'user_id' => $ru->refer_by,
                                            'transaction_amount' => $devidedCommission,
                                            'transaction_type' => 'refer commission',
                                            'balance_before' => $bb,
                                            'balance_now' => $bb + $affiliateGeneration->value,
                                            'status' => 'in'
                                        ];
                                        if($devidedCommission >= 10){
                                            $iu->increment('balance',$devidedCommission);
                                            DB::table('statement')->insert([$affChildCredentials]);
                                        }else{
                                            Alert::success('Success!')->persistent("Close this");
                                            return back();
                                        }
                                        $referTo = $ru->refer_by;
                                        $initialCommission = $devidedCommission;
                                    }else{
                                        Alert::success('Success!')->persistent("Close this");
                                        return back();
                                    }
                                }                            
                            }
                        }
                    }
                    Alert::success('Success!')->persistent("Close this");
                    return back();
                }
                Alert::error('Something Wrong!')->persistent("Close this");
                return back();
            }
        }else{
            Alert::error('Wrong Password!')->persistent("Close this");
            return back()->withInput();
        }
    }

    /* public function UpgradePackage(Request $request){
        $user = Auth::user();
        $inst = inst_info::where('prefix',$user->prefix);
        $getInst = $inst->first();

        $changeDateStr = strtotime("+15 days", strtotime($getInst->package_change_at));
        $changeDate = date('d M Y h:ia',$changeDateStr);
        if( strtotime(now()) < $changeDateStr ){
            Alert::error("You can change after <br> $changeDate")->persistent("Close this");
            return back();
        }

        $cp = DB::table('packages')->where('id',$getInst->package)->first();
        $up = DB::table('packages')->where('id',$request->package)->first();
        
        $currSeconds = strtotime($getInst->valid_till) - strtotime(now());
        if($currSeconds > 0){
            $currDays = intval($currSeconds/86400);
            $currValues = intval($cp->price / 365 * $currDays);
    
            $upValueInDay = $up->price / 365;
            $upDays = intval($currValues / $upValueInDay);
            $valid_till = strtotime("+$upDays days", strtotime(now()));
        }else{
            $valid_till = strtotime(now());
        }

        $update = $inst->update([
            'valid_till' => date('Y-m-d H:i:s',$valid_till),
            'package' => $request->package,
            'package_change_at' => date('Y-m-d H:i:s',strtotime(now())),
        ]);
        if($update){
            Alert::success('Success!')->persistent("Close this");
            return back();
        }
    } */

    public function DeleteInstitutePrepareForm(){
        //
    }

    public function cgseList(){
        return view('SuperAdmin.cgse-request');
    }

    public function approveCGSE(Request $request){
        $ids = explode(',',$request->ids);
        $datas = DB::table('request_cgse')->whereIn('id',$ids)->get();
        $tables = array('all_classes','all_groups','all_subjects','all_exams');
        $cols = array('class_name','grp_name','sub_name','exam_name');
        $i = 0;
        foreach($datas as $data){
            $insert = DB::table($tables[$data->cgse])->insert([
                $cols[$data->cgse] => $data->name,
            ]);
            if($insert){
                DB::table('request_cgse')->where('id',$data->id)->delete();
            }
            $i++;
        }
        if(count($ids) == $i){
            return true;
        }
        return false;
    }
}
