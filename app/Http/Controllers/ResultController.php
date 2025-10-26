<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\result;
use DB;
use Alert;
use PDF;
use App\Helpers\SiteHelper;

class ResultController extends Controller
{
    public function ResultShowForm(){
        $prefix = SiteHelper::prefix(0);
        $class_ids = SiteHelper::classArray(1);
        $exams = array();
        $array = array();
        $e = SiteHelper::examsArray(2);
        foreach($e as $xm){
            $arr = DB::table($prefix.'_results')->where('exam_id',$xm->exam_id)->pluck('year')->toArray();
            $arr = array_unique($arr);
            $loop = count($arr)-1;
            foreach($xm as $k => $v){
                $m[$k] = $v;
                if($arr){
                    $m['year'] = $arr;
                }
            }
            $exams[] = $m;
        }
        if($class_ids){
            foreach($class_ids as $ck => $cv){
                $array[$ck]['class_name'] = SiteHelper::ClassNameById($cv);
                $array[$ck]['class_id'] = $cv;
                $groups = DB::table('inst_groups')->where('class_id',$cv)->first();
                if($groups){
                    $groups = $groups->grp_ids;
                    $groups = explode(',',$groups);
                    foreach($groups as $gk => $gv){
                        $array[$ck]['groups'][$gv] = SiteHelper::GroupNameById($gv);
                    }
                }
            }
        }
        return view('result.show_form',compact('array','exams'));
    }
    public function ResultShow(Request $request){
        $prefix = SiteHelper::prefix(0);
        $year = $request->year;
        $restype = $request->restype;
        $month = $request->month;

        $exam_name = SiteHelper::ExamNameById($request->exam_id);
        $class_name = SiteHelper::ClassNameById($request->class_id);
        if($request->grp_id){
            $group_name = SiteHelper::GroupNameById($request->grp_id);
        }else{
            $group_name = '';
        }

        if($restype == '1'){
            $getResults = DB::table($prefix.'_results')
            ->where('exam_id',$request->exam_id)
            ->where('month',$request->month)
            ->where('class_id',$request->class_id)
            ->where('grp_id',$request->grp_id)
            ->where('roll',$request->roll)
            ->where('year',$year)
            ->get();
            $results = array();
            foreach($getResults as $result){
                foreach($result as $k => $v){
                    $res['sub_name'] = SiteHelper::SubNameById($result->sub_id);
                    $res[$k] = $v;
                }
                $results[] = $res;
            }

            $student = DB::table('admissions')
                ->where('class_id',$request->class_id)
                ->where('grp_id',$request->grp_id)
                ->where('roll',$request->roll)
                ->join('students', 'students.id', '=', 'admissions.student_id')->first();

            if($results && $student){
                return view('result.result_by_roll',compact('results','student','year','exam_name','month','class_name','group_name'));
            }
        }elseif ($restype == '2') {
            $class_id_array = DB::table($prefix.'_results')
            ->where('exam_id',$request->exam_id)
            ->where('month',$month)
            ->where('class_id',$request->class_id)
            ->where('grp_id',$request->grp_id)
            ->where('year',$year)
            ->pluck('sub_id')->toArray();
            $classIds = array_unique($class_id_array);
            $subArr = DB::table('all_subjects')->whereIn('sub_id',$class_id_array)->get();
            return view('result.result_sheet',compact('request','subArr','exam_name','month','class_name','group_name'));
        }
        echo '<h3 style="text-align:center;color:red;margin-top:20px;">No Result Found!</h3>';
    }

    public function result_step1(){
        $classes = SiteHelper::classArray(2);
        $exams = SiteHelper::examsArray(2);
        return view('result.publish_step1',compact('exams','classes'));
    }
    public function result_step2(Request $request){
        $prefix = SiteHelper::prefix(0);
        $GetToken = $request->_token;
        $token = csrf_token();
        if(isset($_GET['_token']) && isset($_GET['year']) && isset($_GET['exam_id']) && isset($_GET['month']) && isset($_GET['class_id']) && isset($_GET['grp_id']) && isset($_GET['sub_id'])){
            //$request->_token && $request->year && $request->exam_id && $request->month && $request->class_id && $request->grp_id && $request->sub_id
            if($GetToken == $token){
                $publishedRoll = DB::table($prefix.'_results')
                    ->where('year',$request->year)
                    ->where('exam_id',$request->exam_id)
                    ->where('month',$request->month)
                    ->where('class_id',$request->class_id)
                    ->where('grp_id',$request->grp_id)
                    ->where('sub_id',$request->sub_id)
                    ->pluck('roll')->toArray();
                $exam_name = SiteHelper::ExamNameById($request->exam_id);
                $class_name = SiteHelper::ClassNameById($request->class_id);
                $group_name = SiteHelper::GroupNameById($request->grp_id);
                $sub_name = SiteHelper::SubNameById($request->sub_id);

                $students = DB::table('admissions')
                ->where(['class_id'=>$request->class_id,'grp_id'=>$request->grp_id])->whereNotIn('roll',$publishedRoll)
                ->join('students', 'students.id', '=', 'admissions.student_id')->get();
                $classes = SiteHelper::classArray(2);
                $exams = SiteHelper::examsArray(2);
                return view('result.publish_step2',compact('request','students','exams','classes','exam_name','class_name','group_name','sub_name'));
            }else{
                Alert::error('Session Expired!');
                return redirect()->back();
            }
        }
    }
    public function save_result(Request $request){
        $prefix = SiteHelper::prefix(0);
        $roll = $request->roll;
        $mark = $request->marks;
        $student_id = $request->student_id;

        $loop = count($mark)-1;
        for($i=0; $i <= $loop; $i++){
            if($mark[$i] == null){
                continue;
            }
            $CheckPublish = DB::table($prefix.'_results')
            ->where('year',$request->year)
            ->where('exam_id',$request->exam_id)
            ->where('month',$request->month)
            ->where('class_id',$request->class_id)
            ->where('grp_id',$request->grp_id)
            ->where('sub_id',$request->sub_id)
            ->where('roll',$roll[$i])
            ->first();
            if($CheckPublish){
                continue;
            }
            $save_result = DB::table($prefix.'_results')->insert([
                'student_id' => $student_id[$i],
                'exam_id' => $request->exam_id,
                'month' => $request->month,
                'class_id' => $request->class_id,
                'grp_id' => $request->grp_id,
                'sub_id' => $request->sub_id,
                'roll' => $roll[$i],
                'year' => $request->year,
                'marks' => $mark[$i],
            ]);
            if($i == $loop){
                Alert::success('Successfully result published!')->persistent("Close this");
                return redirect(route('rp'));
            }
        }
        Alert::warning('Success with some error!')->persistent("Close this");
        return redirect(route('rp'));
    }

    public function PublishedResult(Request $request){
        $prefix = SiteHelper::prefix(0);
        $class_ids = SiteHelper::classArray(1);
        $exams = array();
        $array = array();
        $e = SiteHelper::examsArray(2);
        foreach($e as $xm){
            $arr = DB::table($prefix.'_results')->where('exam_id',$xm->exam_id)->pluck('year')->toArray();
            $arr = array_unique($arr);
            $loop = count($arr)-1;
            foreach($xm as $k => $v){
                $m[$k] = $v;
                if($arr){
                    $m['year'] = $arr;
                }
            }
            $exams[] = $m;
        }
        if($class_ids){
            foreach($class_ids as $ck => $cv){
                $array[$ck]['class_name'] = SiteHelper::ClassNameById($cv);
                $array[$ck]['class_id'] = $cv;
                $groups = DB::table('inst_groups')->where('class_id',$cv)->first();
                if($groups){
                    $groups = $groups->grp_ids;
                    $groups = explode(',',$groups);
                    foreach($groups as $gk => $gv){
                        $array[$ck]['groups'][$gv] = SiteHelper::GroupNameById($gv);
                    }
                }
            }
        }
        return view('result.published_results',compact('array','exams'));
    }

    public function ResultUpdate(Request $request){
        $prefix = SiteHelper::prefix(0);
        $isUpdate = DB::table($prefix.'_results')->where('class_id',$request->class_id)->where('grp_id',$request->grp_id)->where('exam_id',$request->exam_id)->where('month',$request->month)->where('year',$request->year)->where('sub_id',$request->sub_id)->where('roll',$request->roll)->update(['marks'=>$request->marks]);
        if($isUpdate){
            return true;
        }else{
            return false;
        }
    }

    public function PublicResultForm(){
        $prefix = SiteHelper::prefix(0);
        $exams = array();
        $array = array();
        $class_ids = SiteHelper::classArray(1);
        $e = SiteHelper::examsArray(2);
        foreach($e as $xm){
            $arr = DB::table($prefix.'_results')->where('exam_id',$xm->exam_id)->pluck('year')->toArray();
            $arr = array_unique($arr);
            $loop = count($arr)-1;
            foreach($xm as $k => $v){
                $m[$k] = $v;
                if($arr){
                    $m['year'] = $arr;
                }
            }
            $exams[] = $m;
        }
        if($class_ids){
            foreach($class_ids as $ck => $cv){
                $array[$ck]['class_name'] = SiteHelper::ClassNameById($cv);
                $array[$ck]['class_id'] = $cv;
                $groups = DB::table('inst_groups')->where('class_id',$cv)->first();
                if($groups){
                    $groups = $groups->grp_ids;
                    $groups = explode(',',$groups);
                    foreach($groups as $gk => $gv){
                        $array[$ck]['groups'][$gv] = SiteHelper::GroupNameById($gv);
                    }
                }
            }
        }
        return view('result.public_result_show',compact('array','exams'));
    }

    public function PublicResultIframe(Request $request){
        $prefix = SiteHelper::prefix(0);
        $class_name = SiteHelper::ClassNameById($request->class_id);
        $group_name = SiteHelper::GroupNameById($request->grp_id);
        $exam_name = SiteHelper::ExamNameById($request->exam_id);
        return view('result.public_result_iframe',compact('class_name','group_name','exam_name'));
    }

    public function DeleteResults(Request $request){
        $prefix = SiteHelper::prefix(0);
        $rolls = explode(',',$request->rolls);
        $isDelete = DB::table($prefix.'_results')
            ->where('class_id',$request->class_id)
            ->where('grp_id',$request->grp_id)
            ->where('exam_id',$request->exam_id)
            ->where('month',$request->month)
            ->where('year',$request->year)
            ->whereIn('roll',$rolls)
            ->delete();
        if($isDelete){
            return true;
        }else{
            return false;
        }
    }

    public function MeritPrepareForm(Request $request){
        $classes = SiteHelper::classArray(2);
        $exams = SiteHelper::examsArray(2);
        return view('result.merit-prepare-form',compact('classes','exams','request'));
    }

    public function MeritPositionReview(Request $request){
        $prefix = SiteHelper::prefix(0);
        $classes = SiteHelper::classArray(2);
        $class_name = SiteHelper::ClassNameById($request->class_id);
        $table = $prefix.'_results';
        $admitted = DB::table('admissions')->where(['class_id'=>$request->class_id, 'grp_id'=>$request->grp_id, 'session'=>$request->session]);
        $rolls = $admitted->pluck('roll')->toArray();
        $absence = array();
        $merits = array();
        if($request->type == 'auto'){
            foreach($rolls as $k => $v){
                $data = DB::table($table)->where(['class_id'=>$request->class_id, 'grp_id'=>$request->grp_id, 'exam_id'=>$request->exam_id, 'year'=>$request->year, 'roll'=>$v])->join("students","$table.student_id","=","students.id")->get();
                if($data->isNotEmpty()){
                    $m['name'] = $data[0]->full_name;
                    $m['student_id'] = $data[0]->student_id;
                    $m['pre_roll'] = $v;
                    $m['subs'] = count($data);
                    $m['marks'] = SiteHelper::SumColByArray($data,'marks');
                    $merits[] = $m;
                }else{
                    $student = $admitted->where('roll',$v)->join("students","admissions.student_id","=","students.id")->first();
                    $ab['name'] = $student->full_name;
                    $ab['student_id'] = $student->student_id;
                    $ab['pre_roll'] = $v;
                    $ab['marks'] = 'Absence';
                    $absence[] = $ab;
                }
            }
            array_multisort(array_column($merits, 'marks'), SORT_DESC, $merits);
        }else{
            $alldata = $admitted->join("students","admissions.student_id","=","students.id")->get();
            $m = array();
            foreach($alldata as $data){
                $m['name'] = $data->full_name;
                $m['student_id'] = $data->student_id;
                $m['pre_roll'] = $data->roll;
                $merits[] = $m;
            }
        }
        /* $arr  = $kfk;
        $sort = array();
        foreach($arr as $k=>$v) {
            $sort['marks'][$k] = $v['marks'];
        }

        array_multisort($sort['marks'], SORT_DESC, $arr);*/
        /* echo '<pre>';
        print_r($merits);
        echo '</pre>'; */
        return view('result.merit-position',compact('merits','absence','classes','class_name','request'));
    }

    public function MeritPosition(Request $request){
        $prefix = SiteHelper::prefix(0);
        $new_roll = $request->new_roll;
        $student_id = $request->student_id;
        $loop = count($student_id)-1;
        for($i=0;$i<=$loop;$i++){
            if($new_roll[$i] == null){
                continue;
            }
            $credentials = [
                'prefix'=>$prefix,
                'student_id'=>$student_id[$i],
                'idn'=>SiteHelper::StudentIdNumberMaker($request->session,$request->class_id,$request->grp_id,$new_roll[$i]),
                'class_id'=>$request->class_id,
                'grp_id'=>$request->grp_id,
                'session'=>$request->session,
                'roll'=>$new_roll[$i]
            ];
            $isExist = DB::table('admissions')->where($credentials)->first();
            if($isExist){
                continue;
            }
            DB::table('admissions')->insert($credentials);
        }
        Alert::success('Success');
        return back();
    }

    public function myRecentResult(){
        $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        $res = DB::table($prefix.'_results')->where('student_id',$user->member_id)->orderBy('id','desc')->first();
        $data = array();
        if($res){
            $data = DB::table($prefix.'_results')->where(['student_id'=>$user->member_id,'class_id'=>$res->class_id,'grp_id'=>$res->grp_id,'exam_id'=>$res->exam_id,'month'=>$res->month,'year'=>$res->year])->get();
        }
        return view('result.my-recent-result',compact('data'));
    }
}