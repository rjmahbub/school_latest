<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\User;
use App\Helpers\SiteHelper;

class JsonController extends Controller
{
    public function InstitutesJson(Request $request){
        $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        $limit = $request->limit;
        $offset = $request->offset;
        $insts = DB::table('inst_infos')->orderBy('id','desc');
        if($user->who == 7){
            $inst_array = DB::table('refer_inst')->where('user_id',$user->id)->pluck('prefix')->toArray();
            $insts = $insts->whereIn('prefix',$inst_array);
        }
        if($request->search){
            $q = $request->search;
            $insts = $insts->where(function($query)use ($q){
            $query->where('prefix','LIKE','%'.$q.'%')
                ->orWhere('code','LIKE','%'.$q.'%')
                ->orWhere('inst_name','LIKE','%'.$q.'%')
                ->orWhere('inst_addr','LIKE','%'.$q.'%')
                ->orWhere('inst_phone','LIKE','%'.$q.'%')
                ->orWhere('inst_phone2','LIKE','%'.$q.'%')
                ->orWhere('inst_email','LIKE','%'.$q.'%');
            });
        }
        $total = count($insts->get());
        $insts = $insts->offset($offset)->limit($limit)->get();
        $datas = array('total'=>$total, 'rows'=>$insts);
        return json_encode($datas);
    }

    public function TeachersJson(Request $request){
        $prefix = SiteHelper::prefix(0);
        $limit = $request->limit;
        $offset = $request->offset;
        $rows = DB::table('teachers')->where('prefix',$prefix);
        if($request->search){
            $q = $request->search;
            $rows = $rows->where(function($query)use ($q){
            $query->where('full_name','LIKE','%'.$q.'%')
                ->orWhere('idn','LIKE','%'.$q.'%')
                ->orWhere('gender','LIKE','%'.$q.'%')
                ->orWhere('father','LIKE','%'.$q.'%')
                ->orWhere('mother','LIKE','%'.$q.'%')
                ->orWhere('present_addr','LIKE','%'.$q.'%')
                ->orWhere('permanent_addr','LIKE','%'.$q.'%')
                ->orWhere('phone','LIKE','%'.$q.'%')
                ->orWhere('email','LIKE','%'.$q.'%')
                ->orWhere('dob','LIKE','%'.$q.'%');
            });
        }

        $total = count($rows->get());
        $rows = $rows->offset($offset)->limit($limit)->get();
        $datas = array('total'=>$total, 'rows'=>$rows);
        return json_encode($datas);
    }
    public function StudentsJson(Request $request){
        $prefix = SiteHelper::prefix(0);
        $limit = $request->limit;
        $offset = $request->offset;
        if(isset($_GET['class_id']) && isset($_GET['grp_id']) && isset($_GET['session'])){
            $class_id = $_GET['class_id'];
            $grp_id = $_GET['grp_id'];
            $session = $_GET['session'];
            $rows = DB::table('admissions')->join("students", "students.id", "=", "admissions.student_id")->where(['students.prefix'=>$prefix, 'admissions.prefix'=>$prefix, 'class_id'=>$class_id, 'grp_id'=>$grp_id, 'session'=>$session]);
            if($request->search){
                $q = $request->search;
                $rows = $rows->where(function($query)use ($q){
                $query->where('full_name','LIKE','%'.$q.'%')
                    ->orWhere('gender','LIKE','%'.$q.'%')
                    ->orWhere('father','LIKE','%'.$q.'%')
                    ->orWhere('mother','LIKE','%'.$q.'%')
                    ->orWhere('present_addr','LIKE','%'.$q.'%')
                    ->orWhere('permanent_addr','LIKE','%'.$q.'%')
                    ->orWhere('phone','LIKE','%'.$q.'%')
                    ->orWhere('phone2','LIKE','%'.$q.'%')
                    ->orWhere('email','LIKE','%'.$q.'%')
                    ->orWhere('dob','LIKE','%'.$q.'%');
                });
            }
            $total = count($rows->get());
            $rows = $rows->offset($offset)->limit($limit)->get();
            $datas = array('total'=>$total, 'rows'=>$rows);
            return json_encode($datas);
        }
    }
    public function ResultSheetJson(Request $request){
        $prefix = SiteHelper::prefix(0);
        $ResultSheet = array();
        $m = array();
        $ResultSheetArray = DB::table($prefix.'_results')
        ->where('exam_id',$request->exam_id)
        ->where('month',$request->month)
        ->where('class_id',$request->class_id)
        ->where('grp_id',$request->grp_id)
        ->where('year',$request->year)
        ->get();

        foreach($ResultSheetArray as $entry) {
            $roll = $entry->roll;
            $ResultSheet[$roll]['roll'] = $entry->roll;
            $ResultSheet[$roll]['id'] = $entry->id;
            if($ResultSheet[$roll]){
                $sub_name = SiteHelper::SubNameById($entry->sub_id);
                $student_name = SiteHelper::getWhereCol('students','id',$entry->student_id,'full_name');
                $ResultSheet[$roll][$sub_name] = $entry->marks;
                $ResultSheet[$roll]['name'] = $student_name;
            }
        }
        foreach($ResultSheet as $results){
            foreach($results as $k => $v){
                $result[$k] = $v;
            }
            $m[] = $result;
        }
        return json_encode($m);
    }
    public function NoticesJson(Request $request){
        $prefix = SiteHelper::prefix(0);
        $limit = $request->limit;
        $offset = $request->offset;
        $array = DB::table('notices')->where('prefix',$prefix);
        if($request->q){   
            if($request->q == 1){
                $array = $array->where('exam','on');
            }elseif($request->q == 2){
                $array = $array->where('headline','on');
            }
        }

        if($request->search){
            $q = $request->search;
            $array = $array->where(function($query)use ($q){
                $query->orWhere('title','LIKE','%'.$q.'%')->orWhere('created_at','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%');
            });
        }        

        $total = count($array->get());
        $array = $array->offset($offset)->limit($limit)->get();

        $rows = array();
        $notices = array();
        $i = 1;
        foreach($array as $notice){
            foreach($notice as $k => $v){
                $notices['sl'] = $i;
                $notices[$k] = $v;
            }
            $rows[] = $notices;
            $i++;
        }

        $datas = array('total'=>$total, 'rows'=>$rows);
        return json_encode($datas);
    }

    public function MonthlyAttendanceJson(Request $request){
        /* $prefix = SiteHelper::prefix(0);
        $limit = $request->limit;
        $offset = $request->offset;
        if($request->ym){
            $ym = $request->ym;
            $year = date('Y',strtotime($ym));
            $month = date('m',strtotime($ym));
        }else{
            $year = date('Y');
            $month = date('m');
        }
        $days = date('t', mktime(0, 0, 0, $month, 1, $year));

        $array = DB::table($prefix.'_attendance')->where(['tos'=>2])->whereYear('date',$year)->whereMonth('date',$month)->join('admissions','admissions.idn','=',$prefix.'_attendance.idn')->join('students','students.id','=','admissions.student_id');
        $total = count($array->get());
        $array = $array->offset($offset)->limit($limit)->get();
        $holidays = DB::table($prefix.'_attendance')->where(['attend'=>'H'])->whereYear('date',$year)->whereMonth('date',$month)->get();
        foreach($holidays as $dm){
            $dd = ltrim(date('d',strtotime($dm->date)),'0');
            $f[$dd] = $dm;
        }
        foreach($array as $entry) {
            $idn = $entry->idn;
            $day = ltrim(date('d',strtotime($entry->date)),'0');
            $attendance[$idn]['idn'] = $idn;
            $attendance[$idn]['id'] = $entry->id;
            if($attendance[$idn]){
                if(isset($f[$day])){
                    $attendance[$idn]['d'.$day] = 'H';
                }else{
                    $attendance[$idn]['d'.$day] = $entry->attend;
                }
            }
        }
        $m = array();
        foreach($attendance as $results){
            foreach($results as $k => $v){
                $mm = $results;
            }
            $m[] = $mm;
        }
        return json_encode($m); */

        $prefix = SiteHelper::prefix(0);
        $date = $request->ym;
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));
        $attends = DB::table('attendance')->where(['attendance.prefix'=>$prefix, 'type'=>$request->type]);
        if($request->type == 2){
            $table = 'students';
        }else{
            $table = 'teachers';
        }
        $attends = $attends->where(['year'=>$year, 'month'=>$month]);
        $attends = $attends->join("$table", "attendance.tos_id", "=", "$table.id")->get();
        return json_encode($attends);
    }

    public function StatementJson(Request $request){
        $user = Auth::user();
        $limit = $request->limit;
        $offset = $request->offset;
        $statement = DB::table('statement');
        if($request->user_id !== 'all'){
            if($user->who == 1 && $request->user_id){
                $user_id = $request->user_id;
            }else{
                $user_id = $user->id;
            }
            $statement = $statement->where('user_id',$user_id);
        }
        
        if($request->search){
            $q = $request->search;
            $statement = $statement->where(function($query)use ($q){
                $query->where('transaction_amount','LIKE','%'.$q.'%')
                ->orWhere('transaction_type','LIKE','%'.$q.'%')
                ->orWhere('status','LIKE','%'.$q.'%');
            });
        }
        $statement = $statement->orderBy('id','desc');
        $total = count($statement->get());
        $statement = $statement->offset($offset)->limit($limit)->get();
        $datas = array('total'=>$total, 'rows'=>$statement);
        return json_encode($datas);
    }

    public function CashoutHistoryJson(Request $request){
        $user = Auth::user();
        $limit = $request->limit;
        $offset = $request->offset;
        if($user->who == 1){
            $cashoutHistory = DB::table('cashout');
        }else{
            $cashoutHistory = DB::table('cashout')->where('user_id',$user->id);
        }
        if($request->search){
            $q = $request->search;
            $cashoutHistory = $cashoutHistory->where(function($query)use ($q){
                $query->where('amount','LIKE','%'.$q.'%')
                ->orWhere('method','LIKE','%'.$q.'%')
                ->orWhere('cashout_to','LIKE','%'.$q.'%')
                ->orWhere('status','LIKE','%'.$q.'%');
            });
        }
        $cashoutHistory = $cashoutHistory->orderBy('id','desc');
        $total = count($cashoutHistory->get());
        $cashoutHistory = $cashoutHistory->offset($offset)->limit($limit)->get();
        $datas = array('total'=>$total, 'rows'=>$cashoutHistory);
        return json_encode($datas);
    }

    /* public function RefersInstJson(Request $request){
        $user = Auth::user();
        $limit = $request->limit;
        $offset = $request->offset;

        $rows = DB::table('refer_inst')->where('completed',null);

        if($request->search){
            $q = $request->search;
            $rows = $rows->where(function($query)use ($q){
                $query->where('user_id','LIKE','%'.$q.'%')
                ->orWhere('prefix','LIKE','%'.$q.'%')
                ->orWhere('package','LIKE','%'.$q.'%');
            });
        }

        $total = count($rows->get());
        $rows = $rows->offset($offset)->limit($limit)->get();
        $getRows = array();
        foreach($rows as $row){
            $affUser = User::where('id',$row->user_id)->first();
            foreach($row as $k => $v){
                $m[$k] = $v;
                $m['name'] = $affUser->nick_name;
                $m['balance'] = $affUser->balance;
            }
            $getRows[] = $m;
        }
        $datas = array('total'=>$total, 'rows'=>$getRows);
        return json_encode($datas);
    } */

    /* public function PaymentHistoryJson(Request $request){
        $user = Auth::user();
        $prefix = SiteHelper::prefix(0);
        $limit = $request->limit;
        $offset = $request->offset;

        $payments = DB::table('payments');
        if($user->who !== 1){
            $payments = $payments->where('user_id',$user->id);
        }

        if($request->search){
            $q = $request->search;
            $payments = $payments->where(function($query)use ($q){
                $query->where('user_id','LIKE','%'.$q.'%')
                ->orWhere('prefix','LIKE','%'.$q.'%')
                ->orWhere('payer_number','LIKE','%'.$q.'%')
                ->orWhere('amount','LIKE','%'.$q.'%')
                ->orWhere('tnx','LIKE','%'.$q.'%')
                ->orWhere('status','LIKE','%'.$q.'%')
                ->orWhere('method','LIKE','%'.$q.'%')
                ->orWhere('created_at','LIKE','%'.$q.'%');
            });
        }

        $total = count($payments->get());
        $payments = $payments->offset($offset)->limit($limit)->orderBy('id','desc')->get();
        foreach($payments as $pay){
            $user_info = User::where('id',$pay->user_id)->first();
            $balance = null;
            if($user_info){
                $balance = $user_info->balance;
            }
            foreach($pay as $k => $v){
                $m[$k] = $v;
                $m['balance'] = $balance;
            }
            $getRows[] = $m;
        }
        $datas = array('total'=>$total, 'rows'=>$getRows);
        return json_encode($datas);
    }*/

    public function cgseJson(Request $request){
        $limit = $request->limit;
        $offset = $request->offset;
        $reqData = DB::table('request_cgse');
        if($request->search){
            $q = $request->search;
            $reqData = $reqData->where(function($query)use ($q){
                $query->where('prefix','LIKE','%'.$q.'%')
                ->orWhere('phone','LIKE','%'.$q.'%')
                ->orWhere('name','LIKE','%'.$q.'%')
                ->orWhere('remarks','LIKE','%'.$q.'%');
            });
        }
        $reqData = $reqData->orderBy('id','desc');
        $total = count($reqData->get());
        $reqData = $reqData->offset($offset)->limit($limit)->get();
        $datas = array('total'=>$total, 'rows'=>$reqData);
        return json_encode($datas);
    }

    public function paymentJson(Request $request){
        $limit = $request->limit;
        $offset = $request->offset;
        $payData = DB::table('payments');
        if($request->search){
            $q = $request->search;
            $payData = $payData->where(function($query)use ($q){
                $query->where('sender','LIKE','%'.$q.'%')
                ->orWhere('ref_no','LIKE','%'.$q.'%')
                ->orWhere('tmx_id','LIKE','%'.$q.'%')
                ->orWhere('amount','LIKE','%'.$q.'%')
                ->orWhere('token','LIKE','%'.$q.'%');
            });
        }
        $payData = $payData->orderBy('id','desc');
        $total = count($payData->get());
        $payData = $payData->offset($offset)->limit($limit)->get();
        $datas = array('total'=>$total, 'rows'=>$payData);
        return json_encode($datas);
    }

    public function onlineAdmissionJson(Request $request){
        $prefix = SiteHelper::prefix(0);
        $limit = $request->limit;
        $offset = $request->offset;
        $data = DB::table('online_admitted')->where('prefix',$prefix);
        if($request->search){
            $q = $request->search;
            $data = $data->where(function($query)use ($q){
                $query->where('full_name','LIKE','%'.$q.'%')
                ->orWhere('father','LIKE','%'.$q.'%')
                ->orWhere('mother','LIKE','%'.$q.'%')
                ->orWhere('dob','LIKE','%'.$q.'%');
            });
        }
        $total = count($data->get());
        $data = $data->offset($offset)->limit($limit)->get();
        foreach($data as $row){
            $row->class = 'Nine';
            $rows[] = $row;
        }
        $datas = array('total'=>$total, 'rows'=>$rows);
        return json_encode($datas);
    }

    public function UsersJson(Request $request){
        $prefix = SiteHelper::prefix(0);
        $limit = $request->limit;
        $offset = $request->offset;
        $rows = User::where(['prefix'=>$prefix])->where('who','!=',3);
        if($request->user){
            $rows = $rows->where('who',$request->user);
        }
        if($request->search){
            $q = $request->search;
            $rows = $rows->where(function($query)use ($q){
            $query->where('nick_name','LIKE','%'.$q.'%')
                ->orWhere('phone','LIKE','%'.$q.'%')
                ->orWhere('email','LIKE','%'.$q.'%')
                ->orWhere('gender','LIKE','%'.$q.'%');
            });
        }
        $total = count($rows->get());
        $rows = $rows->offset($offset)->limit($limit)->get();
        $datas = array('total'=>$total, 'rows'=>$rows);
        return json_encode($datas);
    }
}
