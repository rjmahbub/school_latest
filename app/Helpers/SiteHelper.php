<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use App\Models\inst_info;
use DB;
use App\Models\User;

class SiteHelper
{
    public static $SuperAdmin = 1;
    public static $admin = 2;
    public static $inst_admin = 3;
    public static $teacher = 4;
    public static $student = 5;
    public static $guardian = 6;
    public static $prefixMain = 'edubd';
    public static $mainDomain = 'demo.mahbub.limu';

    // এইসব method সব controller থেকে call করা যাবে app/helpers.php file e global function kora ache
    public static function siteName()
    {
        return 'EduBD School Portal';
    }

    public static function UserRole($role){
        $users = array('SuperAdmin'=>1,'Sub_SuperAdmin'=>2,'InstituteAdmin'=>3,'Teacher'=>4,'Student'=>5,'Guardian'=>6,'AffiliateUser'=>7);
        return $users[$role];
    }

    public static function prefix($i){
        $domainName = self::$mainDomain;//$_SERVER['SERVER_NAME'];
        $arr = explode('.',$domainName);
        if($i == 2){
            return $domainName;
        }else{
            return $prefix = $arr[$i];
        }
    }

    public static function checkDomainActive($prefix){
        $inst = inst_info::where('prefix',$prefix)->first();
        if($inst){
            if(strtotime($inst->valid_till) < strtotime(now()) || $inst->status !== 1){
                return redirect(route('InactiveDomain').'?domain=inactive');
            }
        }else{
            return redirect(route('InactiveDomain').'?domain=available');
        }
    }

    public static function incrementBalance($user_id, $ib, $tnxType){
        if($user_id){
            $user = User::where('id',$user_id);
            $beforeData = $user->first();
            if($beforeData){
                $increment = $user->increment('balance',$ib);
                $afterData = $user->first();
                if($increment){
                    DB::table('statement')->insert([
                        'user_id'=>$user_id,
                        'transaction_amount'=>$ib,
                        'transaction_type'=>$tnxType,
                        'balance_before'=>$beforeData->balance,
                        'balance_now'=>$afterData->balance,
                        'status'=>'in'
                    ]);
                    return true;
                }
            }
        }
        return false;
    }

    public static function decrementBalance($user_id, $db, $tnxType){
        if($user_id){
            $user = User::where('id',$user_id);
            $beforeData = $user->first();
            if($beforeData){
                $increment = $user->decrement('balance',$db);
                $afterData = $user->first();
                if($increment){
                    DB::table('statement')->insert([
                        'user_id'=>$user_id,
                        'transaction_amount'=>$db,
                        'transaction_type'=>$tnxType,
                        'balance_before'=>$beforeData->balance,
                        'balance_now'=>$afterData->balance,
                        'status'=>'in'
                    ]);
                    return true;
                }
            }
        }
        return false;
    }

    public static function SendSms($numbers,$message){
        $url = "http://66.45.237.70/api.php";
        $data= array(
            'username' => "01789050186",
            'password' => "M050186m",
            'number' => "$numbers",
            'message' => "$message"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        return $sendstatus = $p[0];
    }

    public static function getWhereCol($table,$col,$value,$property){
        $row = DB::table($table)->where($col,$value)->first();
        $getValue = null;
        if($row){
            $getValue = $row->$property;
        }
        return $getValue;
    }

    public static function SumWhereCol($table,$col,$value,$property){
        $datas = DB::table($table)->where($col,$value)->get();
        if($datas){
            $sum = 0;
            foreach($datas as $data){
                $sum += $data->$property;
            }
            return $sum;
        }else{
            return null;
        }
    }

    public static function SumColByArray($array,$col){
        $sum = 0;
        if(count($array) > 0){
            foreach($array as $data){
                $sum += $data->$col;
            }
        }
        return $sum;
    }

    public static function ExamNameById($exam_id){
        $prefix = self::prefix(0);
        $exam = DB::table('all_exams')->where('exam_id',$exam_id)->first();
        $exam_name = null;
        if($exam){
            $exam_name = $exam->exam_name;
        }
        return $exam_name;
    }

    public static function CountData($table,$whereArr){
        $data = DB::table($table)->where($whereArr)->get();
        return count($data);
    }

    public static function ClassNameById($class_id){
        $class = DB::table('all_classes')->where('class_id',$class_id)->first();
        $class_name = null;
        if($class){
            $class_name = $class->class_name;
        }
        return $class_name;
    }

    public static function GroupNameById($group_id){
        $grp_name = null;
        $group = DB::table('all_groups')->where('grp_id',$group_id)->first();
        if($group){
            $grp_name = $group->grp_name;
        }
        return $grp_name;
    }

    public static function SubNameById($sub_id){
        $subject = DB::table('all_subjects')->where('sub_id',$sub_id)->first();
        $sub_name = null;
        if($subject){
            $sub_name = $subject->sub_name;
        }
        return $sub_name;
    }

    public static function StudentArrayById($id){
        $prefix = self::prefix(0);
        return DB::table('admissions')->where(['admissions.prefix'=>$prefix, 'student_id'=>$id])->join('students', 'students.id', '=', 'admissions.student_id')->first();
    }

    public static function TeacherArrayById($id){
        $prefix = self::prefix(0);
        return DB::table('teachers')->where('prefix',$prefix)->where('id',$id)->first();
    }

    public static function StudentIdNumberMaker($s,$c,$g,$r){
        $prefix = self::prefix(0);
        $inst = inst_info::where('prefix',$prefix)->first();
        $idn = null;
        if($inst){
            $instCode = $inst->code;
            $session = substr($s,2,2);
            $roll = str_pad($r, 4, 0, STR_PAD_LEFT);
            $idn = $instCode.$session.$c.$g.$roll;
        }
        return $idn;
    }

    public static function TeacherIdNumberMaker($idn){
        $prefix = self::prefix(0);
        $inst = inst_info::where('prefix',$prefix)->first();
        if($inst){
            $instCode = $inst->code;
            $tcr = str_pad($idn, 3, 0, STR_PAD_LEFT);
            $idn = $instCode.$tcr;
        }
        return $idn;
    }

    public static function getArrayWhereCol($table,$whereCol,$whereVal){
        return $data = DB::table($table)->where($whereCol,$whereVal)->first();
    }

    public static function classArray($a){
        $prefix = self::prefix(0);
        $class_ids = DB::table('inst_exams_classes')->where('prefix',$prefix)->first();
        $classNames = array();
        $classIdArr = array();
        if($class_ids){
            $class_ids = $class_ids->class_ids;
            $classIdArr = explode(',',$class_ids);
            $classNames = DB::table('all_classes')->whereIn('class_id',$classIdArr)->get();
        }
        if($a == 1){
            return $classIdArr;
        }else{
            return $classNames;
        }
    }

    public static function examsArray($a){
        $prefix = self::prefix(0);
        $examIds = DB::table('inst_exams_classes')->where('prefix',$prefix)->first();
        $examNames = array();
        $examIdArr = array();
        if($examIds){
            $examIds = $examIds->exam_ids;
            $examIdArr = explode(',',$examIds);
            $examNames = DB::table('all_exams')->whereIn('exam_id',$examIdArr)->get();
        }
        if($a == 1){
            return $examIdArr;
        }else{
            return $examNames;
        }
    }

    public static function groupsArray($class_id,$a){
        $prefix = self::prefix(0);
        $grp_ids = DB::table('inst_groups')->where('prefix',$prefix)->where('class_id',$class_id)->first();
        $groupNames = array();
        $grpIdArr = array();
        if($grp_ids && $grp_ids->grp_ids !== null){
            $grp_ids = $grp_ids->grp_ids;
            $grpIdArr = explode(',',$grp_ids);
            $groupNames = DB::table('all_groups')->whereIn('grp_id',$grpIdArr)->get();
        }
        if($a == 1){
            return $grpIdArr;
        }else{
            return $groupNames;
        }
    }

    public static function subjectsArray($class_id,$grp_id,$a){
        $prefix = static::prefix(0);
        $subjectNames = array();
        $subIds = array();
        $subject_opts = "";
        $subIds = DB::table('inst_subjects')->where(['prefix'=>$prefix,'class_id'=>$class_id])->where(function ($query) use ($grp_id) {
            $query->where('grp_id',$grp_id)->orWhere('grp_id',null);
        })->get();
        
        $ids = '';
        foreach($subIds as $m){
            $ids .= $m->sub_ids.',';
        }
        $subIds = explode(',',rtrim($ids,','));

        if($subIds){
            $subjectNames = DB::table('all_subjects')->whereIn('sub_id',$subIds)->get();
        }
        if($a == 1){
            return $subIds;
        }else{
            return $subjectNames;
        }
    }

    public static function payment(){
        $payment = DB::table('html_pages')->where('code','payment')->first();
        return view('payment',compact('payment'));
    }
}
