<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use App\Helpers\SiteHelper;

class GeneratePaperController extends Controller
{
    public function IdCard(Request $request){
        $img_id = '1';
        $prefix = SiteHelper::prefix(0);
        $ids = explode(',',$request->ids);
        $stIds = DB::table('admissions')->whereIn('student_id',$ids)->pluck('student_id')->toArray();
        $rows = DB::table('students')->where('prefix',$prefix)->whereIn('id',$stIds)->get();
        $students = array();
        foreach($rows as $row){
            $data = SiteHelper::getArrayWhereCol('admissions','student_id',$row->id);
            foreach($row as $k => $v){
                $m[$k] = $v;
                $m['idn'] = $data->idn;
                $m['class_name'] = SiteHelper::ClassNameById($data->class_id);
                $m['group_name'] = SiteHelper::GroupNameById($data->grp_id);
                $m['session'] = $data->session;
                $m['roll'] = $data->roll;
            }
            $students[] = $m;
        }

        /* $pdf = PDF::loadView('GeneratePaper.id_card',compact('students'));
        return $pdf->stream('id-cards.pdf'); */
        $sig = '';
        $signature = DB::table('signature')->where('prefix',$prefix)->first();
        if($signature){
            $sig = $signature->sig;
        }
        return view('GeneratePaper.id_card',compact('students','sig'));
    }
 
    public function AdmitCard(Request $request){
        $prefix = SiteHelper::prefix(0);
        $ids = explode(',',$request->ids);
        $exam = $request->exam;
        $month = $request->month;
        $stIds = DB::table('admissions')->whereIn('student_id',$ids)->pluck('student_id')->toArray();
        $rows = DB::table('students')->where('prefix',$prefix)->whereIn('id',$stIds)->get();
        $students = array();
        foreach($rows as $row){
            $data = SiteHelper::getArrayWhereCol('admissions','student_id',$row->id);
            foreach($row as $k => $v){
                $m[$k] = $v;
                $m['idn'] = $data->idn;
                $m['class_name'] = SiteHelper::ClassNameById($data->class_id);
                $m['group_name'] = SiteHelper::GroupNameById($data->grp_id);
                $m['session'] = $data->session;
                $m['roll'] = $data->roll;
            }
            $students[] = $m;
        }
        $sig = '';
        $signature = DB::table('signature')->where('prefix',$prefix)->first();
        if($signature){
            $sig = $signature->sig;
        }
        $pdf = PDF::loadView('GeneratePaper.admit',compact('students','exam','month','request','sig'));
        return $pdf->stream('admit-cards.pdf');
    }

    public function AddMcqForm(){
        $classes = SiteHelper::classArray(2);
        return view('GeneratePaper.mcq-input',compact('classes'));
/*         $data = DB::table('students')->join('admissions','admissions.student_id','=','students.id')->join('demo_attendance','admissions.idn','=','demo_attendance.idn')->get();
        echo '<pre>';
        print_r($data);
        echo '</pre>'; */

    }

    public function AddMcq(Request $request){
        $insert = DB::table('mcq')->insert([
            'class_id' => $request->class_id,
            'grp_id' => $request->grp_id,
            'sub_id' => $request->sub_id,
            'chapter' => $request->chapter,
            'qname' => $request->qname,
            'opt1' => $request->opt_one,
            'opt2' => $request->opt_two,
            'opt3' => $request->opt_three,
            'opt4' => $request->opt_four,
            'ans' => $request->ans,
            'ref' => $request->ref,
        ]);
        if($insert){
            return '<i class="fa fa-check text-success"> Successfully Added!</i>';
        }else{
            return '<i class="fa fa-times-circle text-danger"> Some Error! try again</i>';
        }
    }

    public function mcqGenForm(){
        $classes = SiteHelper::classArray(2);
        return view('GeneratePaper.mcq-generate',compact('classes'));
    }

    public function mcqGen(Request $request){
        $questions = DB::table('mcq')->where(['class_id'=>$request->class_id,'grp_id'=>$request->grp_id,'sub_id'=>$request->sub_id])->get();
        return view('GeneratePaper.mcq-question',compact('questions','request'));
    }
}
