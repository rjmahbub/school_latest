<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use DB;
use Alert;
use Mail;
use App\Helpers\SiteHelper;

class ProfileController extends Controller
{
    public function Logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }

    public function LoginForm(){
        return view('auth.login');
    }

    public function Login(Request $request){
        $prefix = SiteHelper::prefix(0);
        if(Auth::attempt(['prefix' => $prefix, 'phone' => $request->phone, 'password' => $request->password, 'status' => 1])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'phone' => "Phone number or password did't match",
        ]);
    }

    public function forgetPasswordForm(){
        $session = strtotime(now()) - 7200;
        $date = date('Y-m-d H:i:s',$session);
        $data = DB::table('reset_password')->where('created_at','<=',$date);
        $data->delete();
        return view('auth.passwords.forget');
    }

    public function forgetPassword(Request $request){
        $user = User::where('email',$request->email)->first();
        $token = sha1(md5(now()));
        if($user){
            $isExist = DB::table('reset_password')->where('user_id',$user->id);
            $timestamp = date('Y-m-d H:m:s',strtotime(now()));
            if($isExist->first()){
                DB::table('reset_password')->where('user_id',$user->id)->update(['code' => $token, 'created_at' => $timestamp]);
            }else{
                DB::table('reset_password')->insert(['user_id'=>$user->id, 'code'=>$token]);
            }

            $data["email"] = $request->email;
            $data["title"] = SiteHelper::prefix(2);
            $data["body"] = "";
            $data['name'] = $user->nick_name;
            $data['token'] = $token;
     
            /* $files = [
                public_path('public/uploads/dedubd/users/Mahbub.jpg'),
                public_path('public/uploads/dedubd/users/student_application_from.pdf'),
            ]; */
      
            Mail::send('emails.password_reset', $data, function($message)use($data) {
                $message->to($data["email"])
                        ->subject('Password Reset');
     
                /* foreach ($files as $file){
                    $message->attach($file);
                } */
            });
            return redirect()->back()->with('success','Password reset link has been sent to'.$request->email);
        }else{
            return redirect()->back()->with('error','No user found!');
        }
    }

    public function resetPasswordForm(Request $request){
        $getToken = DB::table('reset_password')->where('code',$request->token)->first();
        if($getToken){
            $session = strtotime(now()) - strtotime($getToken->created_at);
            if($session < 7200){
                return view('auth.passwords.reset',compact('getToken'));
            }else{
                echo '<h4 style="text-align:center;color:red;">Session Timeout!</h4>';
            }
        }else{
            echo '<h4 style="text-align:center;color:red;">Session Timeout!</h4>';
        }
    }

    public function resetPassword(Request $request){
        $token = DB::table('reset_password')->where('code',$request->token);
        if($token->first()){
            $session = strtotime(now()) - strtotime($token->first()->created_at);
            if($session < 7200){
                $password = $request->password;
                $confirm_password = $request->confirm_password;
                $hashPwd = bcrypt($password);
                if($password == $confirm_password){
                    $update = User::where('id',$token->first()->user_id)->update(['password'=>$hashPwd]);
                    if($update){
                        $token->delete();
                        return redirect(route('login'))->with('success','Password successfully changed!');
                    }
                }else{
                    return redirect()->back()->with('error','Password did not match!');
                }
            }else{
                echo '<h4 style="text-align:center;color:red;">Session Timeout!</h4>';
            }
        }else{
            return redirect()->back()->with('error','Something Wrong!');
        }
    }

    public function RegisterForm(Request $request){
        return view('auth.register');
    }
    
    public function reg_step1(){
        return view('auth.reg_step1');
    }

    public function reg_step2(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->usr == 4){
            $getInfo = DB::table('teachers')->where('prefix',$prefix)->where('phone',$request->phone)->first();
            if(!$getInfo){
                return back()->with('error','No teacher found!')->withInput();
            }
            return view('auth.reg_step2',compact('request','getInfo'));
        }elseif($request->usr == 5 || $request->usr == 6 ){
            $admission = DB::table('admissions')->where('prefix',$prefix)->where(['roll' => $request->roll, 'class_id' => 11])->first();
            if($admission){
                $getInfo = DB::table('students')->where(['prefix'=>$prefix, 'id'=>$admission->student_id])->first();
                if($getInfo){
                    if($getInfo->dob == $request->dob){
                        return view('auth.reg_step2',compact('request','getInfo'));
                    }
                }
            }
            return back()->with('error','No student found!')->withInput();
        }
    }

    public function reg_save(Request $request){
        $prefix = SiteHelper::prefix(0);
        /* $rules = [
            'nick_name' => ['required', 'string', 'max:255'],
            'member_id' => ['required', 'integer', 'max:20'],
            'gender' => ['required', 'string', 'max:20'],
            'phone' => ['required','integer','max:11',Rule::unique(User::class),],
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => ['required', 'string', 'max:255'],
        ];
        $validator = Validator::make($request->all(),$rules)->validate(); */
        $isExistUser = User::where('prefix',$prefix)->where(['member_id'=>$request->member_id, 'who'=>$request->who])->first();
        $phoneExist = User::where('prefix',$prefix)->where('phone',$request->phone)->first();
        if($phoneExist){
            Alert::error('Phone Number Already Registered!')->persistent("Close this");
            return redirect(route('register'));
        }
        if($isExistUser){
            Alert::error('The User Already Registered!')->persistent("Close this");
            return redirect(route('register'));
        }else{
            if($request->password_confirmation == $request->password){
                if($request->who == 4 || $request->who == 5 || $request->who == 6){
                    $credentials = [
                        'prefix' => $prefix,
                        'member_id' => $request->member_id,
                        'nick_name' => $request->nick_name,
                        'gender' => $request->gender,
                        'who' => $request->who,
                        'phone' => $request->phone,
                        'password' => Hash::make($request->password),
                    ];
                    
                    $save = User::insert($credentials);
                    if($save){
                        Alert::success('Registration Complete')->persistent("Close this");
                        return redirect(route('login'));
                    }else{
                        Alert::error('Something wrong!')->persistent("Close this");
                        return redirect(route('register'));
                    }
                }
            }else{

            }
        }
    }

    public function ShowProfile(Request $request){
        $user = Auth::user();
        if($request->user_id && $user->who == 1){
            $user = User::where('id',$request->user_id)->first();
        }
        if($user){
            return view('profile.profile',compact('user'));
        }else{
            return view('error.not-found');
        }
    }

    public function UpdateProfile(Request $request){
        $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        $credentials = [
            'nick_name' => $request->nick_name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        $update = DB::table('users')->where('id',$user->id)->update($credentials);

        if($update){
            Alert::Success("Profile Update Success")->persistent("Close this");
            return redirect()->back();
        }else{
            Alert::warning("Nothing update!")->persistent("Close this");
            return redirect()->back();
        }
        
    }

    public function UserPasswordUpdate(Request $request){
        $user = Auth::user();
        $current_pwd = $request->current_password;
        $pwd = $request->password;
        $confirm_pwd = $request->confirm_password;

        $hashPwd = bcrypt($pwd);
        if($pwd == $confirm_pwd && password_verify($current_pwd,$user->password)){
            $savePwd = User::where('phone',$user->phone)->update(['password' => $hashPwd]);
            if($savePwd){
                Alert::success('Password Successfuly Changed!');
                return redirect()->back();
            }
        }else{
            Alert::error('Something Wrong!');
            return redirect()->back();
        }
    }

    public function cashoutForm(){
        return view('balance.cashout-form');
    }

    public function cashout(Request $request){
        $user = Auth::user();
        //validation
        if($request->cashout_amount > $user->balance){
            Alert::error('Insufficient Balance!');
            return redirect()->back()->withInput();
        }
        if($request->cashout_amount < 100){
            Alert::error('You can withdraw min 100');
            return redirect()->back()->withInput();
        }
        
        if(password_verify($request->password,$user->password)){
            $cashoutCredentials = [
                'user_id' => $user->id,
                'amount' => $request->cashout_amount,
                'method' => $request->pay_method,
                'cashout_to' => $request->mobile_banking
            ];
            $stmtCredentials = [
                'user_id' => $user->id,
                'transaction_amount' => $request->cashout_amount,
                'transaction_type' => 'withdraw',
                'balance_before' => $user->balance,
                'balance_now' => $user->balance - $request->cashout_amount,
                'status' => 'out'
            ];
            $decrement = User::where('id',$user->id)->decrement('balance',$request->cashout_amount);
            if($decrement){
                $cashout = DB::table('cashout')->insert($cashoutCredentials);
                $statement = DB::table('statement')->insert($stmtCredentials);
                if($cashout && $statement){
                    Alert::success('Success!');
                    return redirect()->back();
                }
            }
        }else{
            Alert::error('Wrong Password!');
            return redirect()->back()->withInput();
        }
        Alert::error('Something Wrong!');
        return back();
    }

    public function cashInFormSuperAdmin(){
        return view('balance.cashin-superAdmin');
    }

    public function cashInSuperAdmin(Request $request){
        $user = Auth::user();
        //validation
        if($request->cashin_amount < 100 ){
            Alert::error('Minimum amount 100');
            return back();
        }
        if($user->who == 1 && $user->id == 1 && password_verify($request->password,$user->transaction_password)){
            $cashIn = User::where('id',$user->id)->increment('balance',$request->cashin_amount);
            $stmtCredentials = [
                'user_id' => $user->id,
                'transaction_amount' => $request->cashin_amount,
                'transaction_type' => 'cash-in',
                'balance_before' => $user->balance,
                'balance_now' => $user->balance + $request->cashin_amount,
                'status' => 'in'
            ];
            if($cashIn){
                $statement = DB::table('statement')->insert($stmtCredentials);
                Alert::success('Success');
                return back();
            }
        }else{
            Alert::error('Some Error!');
            return back();
        }
    }

    public function statement(Request $request){
        return view('balance.statement',compact('request'));
    }

    public function cashoutHistory(){
        return view('balance.cashout-history');
    }
}