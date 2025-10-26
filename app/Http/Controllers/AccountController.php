<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Alert;
use App\Helpers\SiteHelper;

class AccountController extends Controller
{
    public function PaidStatusChange(Request $request){
        $user = Auth::user();
        if($user->who == 1){
            if($request->status == 'Paid'){
                $paidTime = now();
            }else{
                $paidTime = null;
            }
            $update = DB::table('cashout')->where('id',$request->id)->update(['status' => $request->status,'paid_at' => $paidTime]);
            if($update){
                return true;
            }else{
                return false;
            }
        }
    }

    public function TokenRecharge(Request $request){
        $user = Auth::user();
        $data = DB::table('payments')->where(['token' => $request->token, 'recharge_by' => null])->first();
        if($data){
            $update = DB::table('payments')->where('id',$data->id)->update(['recharge_by' => $user->id]);
            $statementCredentials = [
                'user_id' => $user->id,
                'transaction_amount' => $data->amount,
                'transaction_type' => 'cash-in',
                'balance_before' => $user->balance,
                'balance_now' => $user->balance + $data->amount,
                'status' => 'in'
            ];
            if($update && $data->recharge_by == null){
                User::where('id',$user->id)->increment('balance',$data->amount);
                DB::table('statement')->insert($statementCredentials);
                Alert::success('Recharge Success!');
                return back();
            }
        }
        Alert::error('Invalid Token');
        return back();
    }

    /* public function PaymentApprove(Request $request){
        $user = Auth::user();
        $payment = DB::table('payments')->where('id',$request->id);
        $paymentArr = $payment->first();
        if($paymentArr->status == 'Approved'){
            return false;
        }
        if($user->who == 1 && $request->user_id == $paymentArr->user_id && $paymentArr->status == 'Pending'){
            $user_id = $paymentArr->user_id;
            $CashInUser = User::where('id',$user_id);
            $statementCredentials = [
                'user_id' => $user_id,
                'transaction_amount' => $paymentArr->amount,
                'transaction_type' => 'cash-in',
                'balance_before' => $CashInUser->first()->balance,
                'balance_now' => $CashInUser->first()->balance + $paymentArr->amount,
                'status' => 'in'
            ];
            $update = $payment->update(['status' => 'Approved']);
            if($update){
                $CashInUser->increment('balance',$paymentArr->amount);
                DB::table('statement')->insert($statementCredentials);
                return true;
            }else{
                return false;
            }
        }
    } */

    public function SendMoneyForm(){
        return view('balance.send-money');
    }

    public function SendMoney(Request $request){
        $user = Auth::user();
        $receiver = User::where('phone',$request->to_phone)->first();
        //validation
        if($user->phone == $request->to_phone){
            Alert::error("You Can't Send Own-number!");
            return back();
        }

        if(!$receiver){
            Alert::error("No user belongs to this number!");
            return back();
        }

        if($request->amount < 10){
            Alert::error("Minimun Amount 10 TK!");
            return back();
        }

        if($user->balance < $request->amount){
            Alert::error("Insufficient Balance!");
            return back();
        }

        $userCredentials = [
            'user_id' => $user->id,
            'transaction_amount' => $request->amount,
            'transaction_type' => 'send money',
            'balance_before' => $user->balance,
            'balance_now' => $user->balance - $request->amount,
            'status' => 'out'
        ];

        $receiverCredentials = [
            'user_id' => $receiver->id,
            'transaction_amount' => $request->amount,
            'transaction_type' => 'receive money',
            'balance_before' => $receiver->balance,
            'balance_now' => $receiver->balance + $request->amount,
            'status' => 'in'
        ];

        if(password_verify($request->password , $user->transaction_password)){
            $decrement = User::where('id',$user->id)->decrement('balance',$request->amount);
            $increment = User::where('phone',$request->to_phone)->increment('balance',$request->amount);
            if($decrement && $increment){
                DB::table('statement')->insert($userCredentials);
                DB::table('statement')->insert($receiverCredentials);

                Alert::success('Sent!');
                return back();
            }
        }

        Alert::success("Can't sent!");
        return back();
    }

    public function PaySalaryForm(){
        $classes = SiteHelper::classArray(2);
        return view('account.pay-salary',compact('classes'));
    }

    public function PaySalaryReview(Request $request){
        if($request->student_id || $request->type == 1){
            if($request->type == 1){
                $student = DB::table('admissions')->where(['class_id'=>$request->class_id, 'grp_id'=>$request->grp_id, 'session'=>$request->session, 'roll'=>$request->roll])->join('students','students.id','=','admissions.student_id')->first();
            }else{
                $student = DB::table('admissions')->where('idn',$request->student_id)->join('students','students.id','=','admissions.student_id')->first();
            }
            if($student){
                $class_name = SiteHelper::ClassNameById($student->class_id);
                $group_name = SiteHelper::GroupNameById($student->grp_id);
                return view('account.pay-salary-review',compact('student','class_name','group_name','request'));
            }else{
                Alert::error('Student not found!');
                return back();
            }
        }else{
            $students = DB::table('admissions')->where(['class_id'=>$request->class_id, 'grp_id'=>$request->grp_id, 'session'=>$request->session])->join('students','students.id','=','admissions.student_id')->get();
            if($students->isNotEmpty()){
                $class_name = SiteHelper::ClassNameById($request->class_id);
                $group_name = SiteHelper::GroupNameById($request->grp_id);
                return view('account.pay-salary-review',compact('students','request'));
            }else{
                Alert::error('Student not found!');
                return back();
            }
        }
    }

    public function PaySalary(Request $request){
        $user = Auth::user();
        if($request->student_id || $request->type == 1){
            $isExist = DB::table('salary_payments')->where(['student_id' => $request->student_id, 'month' => $request->month])->first();
            if($isExist){
                Alert::info('Already Paid This Month!');
                return back();
            }
            $pay = DB::table('salary_payments')->insert([
                'student_id' => $request->student_id,
                'month' => $request->month,
                'amount' => $request->amount,
                'collect_by' => $user->id,
            ]);
            if($pay){
                Alert::success('Success!');
                return redirect(route('PaySalaryInvoice').'?student_id='.$request->student_id.'&month='.$request->month);
            }else{
                Alert::error('Something Wrong!');
                return back();
            }
        }else{
            $student_ids = $request->studentIds;
            $amounts = $request->amount;
            $i = 0;
            foreach($student_ids as $k => $v){
                $isExist = DB::table('salary_payments')->where(['student_id'=>$student_ids[$i], 'month'=>$request->month])->first();
                if($amounts[$i] && !$isExist){
                    $pay = DB::table('salary_payments')->insert([
                        'student_id' => $student_ids[$i],
                        'month' => $request->month,
                        'amount' => $amounts[$i],
                        'collect_by' => $user->id,
                    ]);
                }
                $i++;
            }
            Alert::success('Success!');
            return back();
        }
    }

    public function PaySalaryInvoice(Request $request){
        $invoice = DB::table('salary_payments')->where(['student_id' => $request->student_id, 'month' => $request->month])->join('students','students.id','=','salary_payments.student_id')->first();
        return view('account.salary-invoice',compact('invoice'));
    }

    public function CheckSalaryForm(){
        $classes = SiteHelper::classArray(2);
        return view('account.salary-check',compact('classes'));
    }

    public function CheckSalary(Request $request){
        if($request->type == 1){
            $student = DB::table('admissions');
            if($request->student_id){
                $student = $student->where(['idn' => $request->student_id]);
            }else{
                $student = $student->where(['class_id' => $request->class_id, 'grp_id' => $request->grp_id, 'session' => $request->session, 'roll' => $request->roll]);
            }
            $student = $student->first();
            if($student){
                $invoice = DB::table('salary_payments')->where(['month' => $request->month, 'student_id' => $student->student_id])->join('students','salary_payments.student_id','=','students.id')->first();
                return view('account.salary-invoice',compact('invoice','request'));
            }else{
                Alert::error('Wrong ID Number!');
                return back();
            }
        }elseif($request->type == 2){
            $credt = ['class_id' => $request->class_id, 'grp_id' => $request->grp_id, 'session' => $request->session];
            $studentIds = DB::table('admissions')->where($credt)->pluck('student_id')->toArray();
            $invoiceArr = array();
            foreach($studentIds as $k => $v){
                $invoice = DB::table('salary_payments')->where(['month' => $request->month, 'student_id' => $v])->join('students','salary_payments.student_id','=','students.id')->first();
                if($invoice){
                    $invoice->pay_status = 'Paid';
                    $invoice->roll = DB::table('admissions')->where($credt)->where('student_id',$v)->first()->roll;
                    $invoiceArr[] = $invoice;
                }else{
                    $student = DB::table('students')->where('id',$v)->first();
                    $student->pay_status = 'Unpaid';
                    $student->roll = DB::table('admissions')->where($credt)->where('student_id',$v)->first()->roll;
                    $invoiceArr[] = $student;
                }
            }
            return view('account.salary-invoice',compact('request','invoiceArr'));
        }
    }

    public function balanceSheet(Request $request){
        if($request->date_from == null || $request->date_to == null){
            $date_from = date('Y-m-01');
            $date_to = date('Y-m-d');
        }else{
            $date_from = $request->date_from;
            $date_to = $request->date_to;
        }
        $bdatas = DB::table('balance_sheet')->where('date','<',$date_from)->get();
        $datas = DB::table('balance_sheet')->where('date','>=',$date_from)->where('date','<=',$date_to)->orderBy('date','ASC')->get();
        $bbalance = SiteHelper::SumColByArray($bdatas,'amount');
        $balance = SiteHelper::SumColByArray($datas,'amount') + $bbalance;
        //summery
        $costData = DB::table('balance_sheet')->where('type',1);
        $incomeData = DB::table('balance_sheet')->where('type',2);
        if($request->date_from && $request->date_to){
            $costData = $costData->where('date','>=',$request->date_from)->where('date','<=',$request->date_to);
            $incomeData = $incomeData->where('date','>=',$request->date_from)->where('date','<=',$request->date_to);
        }
        $costData = $costData->get();
        $incomeData = $incomeData->get();

        $cost = ltrim(SiteHelper::SumColByArray($costData,'amount'),'-');
        $income = SiteHelper::SumColByArray($incomeData,'amount');
        return view('account.balance-sheet',compact('datas','request','bbalance','balance','date_from','cost','income'));
    }

    public function balanceSheetEntry(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->type == 1){
            $amount = '-'.$request->amount;
        }else{
            $amount = ltrim($request->amount,'-');
        }
        $insert = DB::table('balance_sheet')->insert([
            'prefix' => $prefix,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'type' => $request->type,
            'amount' => $amount,
        ]);
        if($insert){
            return back()->with('success','Added Successfully!');
        }else{
            return back()->with('error','Error!');
        }
    }

    public function balanceSheetEdit(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->type == 1){
            $amount = '-'.$request->amount;
        }else{
            $amount = ltrim($request->amount,'-');
        }
        $update = DB::table('balance_sheet')->where(['prefix'=>$prefix, 'id'=>$request->id])->update([
            'date' => $request->date,
            'remarks' => $request->remarks,
            'type' => $request->type,
            'amount' => $amount,
        ]);
        if($update){
            return back()->with('success','Updated Successfully!');
        }else{
            return back()->with('error','Error!');
        }
    }

    public function makeBillForm(){
        $classes = SiteHelper::classArray(2);
        return view('account.make-bill',compact('classes'));
    }

    public function makeBill(Request $request){
        $prefix = SiteHelper::prefix(0);
        $insert = DB::table('bill')->insert([
            'prefix' => $prefix,
            'class_id' => $request->class_id,
            'grp_id' => $request->grp_id,
            'session' => $request->session,
            'pay_for' => $request->details,
            'amount' => $request->amount
        ]);
        if($insert){
            return back()->with('success','success');
        }else{
            return back()->with('fail','failed');
        }
    }

    public function bill(Request $request){
        /* $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        $where1 = ['prefix'=>$prefix,'student_id'=>$user->member_id];
        $paid_ids = DB::table('bill_paid')->where($where1)->pluck('bill_id')->toArray();
        $admissions = DB::table('admissions')->where($where1)->orderBy('admissions.id','desc')->get();
        $pending = array();
        $countArr = array();
        if($admissions->isNotempty()){
            foreach($admissions as $admission){
                $m[] = count(DB::table('bill')->where(['prefix'=>$prefix,'class_id'=>$admission->class_id,'grp_id'=>$admission->grp_id,'session'=>$admission->session])->whereNotIn('id',$paid_ids)->get());
            }
            $countArr = $m;
            $pending = DB::table('bill')->where(['prefix'=>$prefix,'class_id'=>$admissions[0]->class_id,'grp_id'=>$admissions[0]->grp_id,'session'=>$admissions[0]->session])->whereNotIn('id',$paid_ids)->get();
        }
        return view('account.bill',compact('admissions','countArr')); */

        $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        $where1 = ['prefix'=>$prefix,'student_id'=>$user->member_id];
        $paid_ids = DB::table('bill_paid')->where($where1)->pluck('bill_id')->toArray();
        $admission = DB::table('admissions')->where($where1)->orderBy('admissions.id','desc')->first();
        if($admission){
            $count = null;
            if($request->pending){
                $method = 'whereNotIn';
            }else{
                $method = 'whereIn';
                $count = count(DB::table('bill')->where(['prefix'=>$prefix,'class_id'=>$admission->class_id,'grp_id'=>$admission->grp_id,'session'=>$admission->session])->whereNotIn('id',$paid_ids)->get());
            }
            $datas = DB::table('bill')->where(['prefix'=>$prefix,'class_id'=>$admission->class_id,'grp_id'=>$admission->grp_id,'session'=>$admission->session])->$method('id',$paid_ids)->get();
            return view('account.bill',compact('count','datas','request'));
        }else{
            return back();
        }
    }

    public function billReport(Request $request){
        $prefix = SiteHelper::prefix(0);
        $classes = SiteHelper::ClassArray(2);
        $where1 = ['prefix'=>$prefix,'class_id'=>$request->class_id,'grp_id'=>$request->grp_id,'session'=>$request->session];
        if($request->bill_id){
            $paidStudents = DB::table('bill_paid')->where(['prefix'=>$prefix,'bill_id'=>$request->bill_id])->pluck('student_id')->toArray();
            $uppaidStudentsIds = DB::table('admissions')->where($where1)->whereNotIn('student_id',$paidStudents)->pluck('student_id')->toArray();
            $uppaidStudents = DB::table('students')->whereIn('id',$uppaidStudentsIds)->paginate(10);
            return view('account.bill-report',compact('classes','request','uppaidStudents'));
        }else{
            $countStudent = count(DB::table('admissions')->where($where1)->get());
            $datas = DB::table('bill')->where($where1)->paginate(10);
            foreach($datas as $k => $v){
                $countBill = count(DB::table('bill_paid')->where(['bill_id'=>$v->id])->get());
                $datas[$k]->countBill = $countBill;
            }
            return view('account.bill-report',compact('classes','datas','countStudent','request'));
        }
    }
}
