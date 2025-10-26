<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\inst_info;
use DB;
use Alert;
use App\Helpers\SiteHelper;

class PublicController extends Controller
{
    public function AffiliateGeneration(Request $request){
        $user = Auth::user();
        if($user->who == 1){
            $affUser = User::where(['who'=>7]);
            if($request->phone){
                $affUser = $affUser->where('phone',$request->phone);
            }
            $affUser = $affUser->first();
            if($affUser){
                $id = $affUser->id;
            }else{
                $id = 7;
            }
        }elseif($user->who == 7){
            $id = $user->id;
        }else{
            return back();
        }
        $reqLevel = $request->level ? : 5;
        $parent = User::where(['id'=>$id,'who'=>7])->first();
        if(!$parent){
            $tree = false;
        }else{
            function olLiTree($id, $level, $reqLevel){
                $parent = User::where(['id'=>$id,'who'=>7])->first();
                $newArray['name'] = $parent->nick_name;
                $newArray['img'] = $parent->photo;
                $data = DB::table('refer_affiliate')->where(['refer_by'=>$id,'who'=>7])->join('users','users.id','=','refer_affiliate.refer_to')->get();
                if($data){
                    $i = 0;
                    foreach($data as $row){
                        if($level > $reqLevel){
                            return $newArray;
                        }
                        $newArray['child'][] = array('name' => $row->nick_name, 'img' => $row->photo);
                        $childData = DB::table('refer_affiliate')->where('refer_by',$row->refer_to)->get();
                        if($childData){
                            foreach($childData as $child){
                                $newArray['child'][$i] = olLiTree($child->refer_by, $level+1, $reqLevel);
                            }
                        }
                        $i++;
                    }
                }
                return $newArray;
            }
            $tree[] = olLiTree($id, 1, $reqLevel);
        }
        return view('org-chart.affiliate-generation',compact('tree','request'));
    }

    public function getAffiliateReferCode($user_id){
        $data = DB::table('refer_code')->where('user_id',$user_id)->first();
        if($data){
            return $data->code;
        }else{
            return 'Not Found!';
        }
    }

    public function documentation(){
        $prefix = SiteHelper::prefix(0);
        $prefixMain = SiteHelper::$prefixMain;
        if($prefix == $prefixMain){
            return view('public.documentation');
        }
    }

    public function InactiveDomain(Request $request){
        $q = $request->q;
        return view('public.inactive',compact('q'));
    }

    public function domainSearch(){
        $prefix = SiteHelper::prefix(0);
        $prefixMain = SiteHelper::$prefixMain;
        if($prefix == $prefixMain){
            return view('public.domain_search');
        }
    }

    public function package(){
        $prefix = SiteHelper::prefix(0);
        $prefixMain = SiteHelper::$prefixMain;
        $packages = DB::table('packages')->get();
        if($prefix == $prefixMain){
            return view('public.packages',compact('packages'));
        }
    }

    public function DomainRegisterForm(Request $request){
        $user = Auth::user();
        $prefix = SiteHelper::prefix(0);
        $prefixMain = SiteHelper::$prefixMain;
        if($request->q){
            if(!Auth::check()){
                return redirect(route('login'));
            }
        }
        if($prefix == $prefixMain){
            $packages = DB::table('packages')->get();
            return view('public.domain_register',compact('request','packages'));
        }
    }

    public function DomainRegister(Request $request){
        if($request->refer_user && !Auth::check()){
            Alert::error('You must login to refer!')->persistent("Close this");;
            return back()->withInput();
        }
        $user = Auth::user();
        $prefix = $request->prefix;
        //validation
        $Institute = inst_info::where('prefix',$prefix);
        if($Institute->first()){
            Alert::error('Subdomain Not Available!')->persistent("Close this");;
            return back()->withInput();
        }
        $InstAdmin = User::where('phone',$request->phone);
        if($InstAdmin->first()){
            Alert::error('Admin Phone Number Already Exist!')->persistent("Close this");;
            return back()->withInput();
        }
        $code = inst_info::max('code');
        $instCredentials = [
            'prefix' => $prefix,
            'code' => $code + 1,
            'inst_name' => $request->inst_name,
            'inst_addr' => $request->inst_addr,
            'inst_phone' => $request->inst_phone,
            'inst_phone2' => $request->inst_phone2,
            'inst_email' => $request->inst_email,
            'package' => $request->package,
            'status' => 1,
        ];
        $AdminCredentials = [
            'prefix' => $prefix,
            'nick_name' => $request->nick_name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'who' => '3',
            'status' => '1',
        ];
        if($request->refer_user){
            $referCredentials = [
                'user_id' => $user->id,
                'prefix' => $prefix,
                'package' => $request->package
            ];
        }
        $save_inst = inst_info::insert($instCredentials);
        $create_admin = User::insert($AdminCredentials);
        if($save_inst && $create_admin){
            if($request->refer_user){
                $insertRefer = DB::table('refer_inst')->insert($referCredentials);
            }
            $y = date('y')+1;
            $session = date('Y').'-'.$y;
            DB::table('current_session')->insert(['prefix'=>$prefix,'session'=>$session]);
            $upArr = array('slideshow','photo_gallery','signeture');
            foreach($upArr as $k => $v){
                $src = "public/uploads/common/$v/";
                $dst = "public/uploads/$prefix/$v/";
                if(!file_exists("$dst")){
                    mkdir("$dst", 0777, true);
                }
                $files = glob("$src*.*");
                $i = 1;
                foreach($files as $file){
                    $file_to_go = str_replace($src,$dst,$file);
                    copy($file, $file_to_go);
                    if($k == 0 || $k == 1){
                        $upCredentials = [
                            'prefix' => $prefix,
                            'img' => "$i.jpg",
                        ];
                        DB::table($v)->insert($upCredentials);
                        $i++;
                    }
                }
            }
            Schema::create($prefix.'_results', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('student_id');
                $table->integer('class_id');
                $table->integer('grp_id')->nullable();
                $table->integer('exam_id');
                $table->string('month')->nullable();
                $table->string('year');
                $table->integer('sub_id');
                $table->integer('roll');
                $table->integer('marks')->nullable();
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            });
            Alert::success('Registration Complete!')->persistent("Close this");
            return redirect()->back();
        }
        Alert::error('Something wrong!')->persistent("Close this");;
        return redirect()->back()->withInput();
    }

    public function AffiliateRegisterForm(){
        $prefix = SiteHelper::prefix(0);
        $prefixMain = SiteHelper::$prefixMain;
        if($prefix == $prefixMain){
            return view('auth.affiliate-register');
        }
    }

    public function AffiliateRegister(Request $request){
        $prefix = SiteHelper::$prefixMain;
        $isExist = User::where('phone',$request->phone)->first();
        if($isExist){
            Alert::error('Phone Number Alredy Use! Try Another')->persistent("Close this");
            return redirect()->back()->withInput();
        }
        $affWelcomeBonus = DB::table('settings')->where('setting_name','affiliate_welcome')->first();
        $balance = '0.00';
        if($affWelcomeBonus->switch == 1){
            $balance = $affWelcomeBonus->value;
        }
        $credentials = [
            'prefix' => $prefix,
            'nick_name' => $request->nick_name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'who' => 7,
            'balance' => $balance,
            'status' => 1,
        ];
        if($request->refer_code){
            $referBy = DB::table('refer_code')->where('code',$request->refer_code)->first();
            if(!$referBy){
                Alert::error('Invalid Refer Code')->persistent("Close this");
                return back();
            }
        }
        $save = User::insert($credentials);
        if($save){
            $newUser = User::where($credentials)->first();
            $affiliateCode = substr(str_shuffle(str_repeat('123456789abcdefghijkmnpqrstuvwxyz', 10)), 0, 6);
            DB::table('refer_code')->insert(['user_id'=>$newUser->id,'code'=>$affiliateCode]);
            if($request->refer_code && $referBy){
                $referCredentials = [
                    'refer_by' => $referBy->user_id,
                    'refer_to' => $newUser->id,
                ];
                DB::table('refer_affiliate')->insert($referCredentials);
            }
            Alert::success('Success! You can login now.')->persistent("Close this");
            return redirect(route('login'));
        }
    }

    public function paymentPage(){
        return SiteHelper::payment();
    }

    public function sendPayment(Request $request){
        $user = Auth::user();
        $k = str_shuffle('0123456789012345678901234567890123456789');
        $token = substr($k,0,16);
        $insert = DB::table('payments')->insert([
            'method' => $request->pay_method,
            'sender' => $request->sender,
            'ref_no' => $request->reference,
            'tnx_id' => $request->tnx_id,
            'amount' => $request->amount,
            'token' => $token,
            'recharge_by' => null,
            'entry_by' => $user->id
        ]);

        if($insert){
            if($request->reference){
                $number = $request->reference;
            }else{
                $number = $request->sender;
            }
            $message = "Your recharge token number $token";
            SiteHelper::SendSms($number,$message);
            Alert::success('Success!')->persistent("Close this");
            return back();
        }
    }

    public function AddPaymentInfoForm(){
        return view('payment.add-info');
    }

    public function PaymentList(){
        return view('payment.list');
    }

    public function opinion(Request $request){
        $insert = DB::table('opinions')->insert([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message
        ]);
        if($insert){
            return '<i class="fa fa-check text-success"> Message Sent!</i>';
        }else{
            return '<i class="fa fa-times-circle text-danger"> Sending Failed!</i>';
        }
    }

    public function onlineAdmissionForm(){
        $classes = SiteHelper::classArray(2);
        return view('public.online-admission',compact('classes'));
    }

    public function onlineAdmission(Request $request){
        $prefix = SiteHelper::prefix(0);
        $credentials = [
            'prefix' => $prefix,
            'class_id' => $request->class_id,
            'grp_id' => $request->grp_id,
            'full_name' => $request->full_name,
            'father' => $request->father,
            'mother' => $request->mother,
            'gender' => $request->gender,
            'present_addr' => $request->present_addr,
            'permanent_addr' => $request->permanent_addr,
            'phone' => $request->phone,
            'phone2' => $request->phone2,
            'email' => $request->email,
            'dob' => $request->dob,
            'photo' => $request->photo,
        ];
        if($request->photo){
            //move file
            $src = "public/uploads/temps/$request->photo";
            $dst = "public/uploads/$prefix/students/$request->photo";
            rename($src, $dst);
            //end move file
        }
        $saveStudent = DB::table('online_admitted')->insert($credentials);
        if($saveStudent){
            Alert::success('Success!!!');
            return back();
        }else{
            Alert::error('Error!!!');
            return back();
        }
    }

    public function onlineAdmittedList(){
        return view('student.online-admitted-list');
    }

    public function AdmissionApprove(Request $request){
        $prefix = SiteHelper::prefix(0);
        $ids = explode(',',$request->ids);
        $data = DB::table('online_admitted')->where('prefix',$prefix)->whereIn('id',$ids)->get();
        foreach($data as $row){
            $studentCredentials = [
                'prefix' => $prefix,
                'full_name' => $row->full_name,
                'dob' => $row->dob,
                'father' => $row->father,
                'mother' => $row->mother,
                'gender' => $row->gender,
                'phone' => $row->phone,
                'phone2' => $row->phone2,
                'email' => $row->email,
                'present_addr' => $row->present_addr,
                'permanent_addr' => $row->permanent_addr,
                'photo' => $row->photo
            ];
            $admissionCredentials = [
                'prefix' => $prefix,
                'class_id' => $row->class_id,
                'grp_id' => $row->grp_id,
                'session' => $request->session,
            ];
            $roll = DB::table('admissions')->where($admissionCredentials)->max('roll') + 1;
            $admissionCredentials['idn'] = SiteHelper::StudentIdNumberMaker($request->session,$row->class_id,$row->grp_id,$roll);
            $admissionCredentials['roll'] = $roll;

            $student = DB::table('students')->insert($studentCredentials);
            if($student){
                $info = DB::table('students')->where($studentCredentials)->first();
                $admissionCredentials['student_id'] = $info->id;
                $admission = DB::table('admissions')->insert($admissionCredentials);
                if($admission){
                    DB::table('online_admitted')->where(['prefix'=>$prefix,'id'=>$row->id])->delete();
                }
            }
        }
        Alert::success('success');
        return back();
    }
}
