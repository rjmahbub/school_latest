<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Alert;
use App\Helpers\SiteHelper;

class AttendanceController extends Controller
{
    public function AttendanceStudentForm(Request $request){
        $prefix = SiteHelper::prefix(0);
        $classIds = SiteHelper::classArray(1);
        $classes = SiteHelper::classArray(2);
        if($request->date && $request->class_id && $request->grp_id && $request->session){
            $date = $request->date;
            $day = ltrim(date('d',strtotime($date)),'0');
            $ids = DB::table('attendance')->where(['prefix'=>$prefix, 'type'=>2, 'class_id'=>$request->class_id, 'grp_id'=>$request->grp_id, 'session'=>$request->session])->where('d'.$day,'!=',null)->pluck('tos_id')->toArray();
            $students = DB::table('admissions')->where(['admissions.prefix'=>$prefix, 'class_id'=>$request->class_id, 'grp_id'=>$request->grp_id, 'session'=>$request->session])->whereNotIn('idn',$ids)->join('students', 'students.id', '=', 'admissions.student_id')->get();
            $class_name = SiteHelper::ClassNameById($request->class_id);
            $group_name = SiteHelper::GroupNameById($request->grp_id);
            return view('attendance.attendance_student',compact('students','request','class_name','group_name'));
        }else{
            return view('attendance.attendance_student',compact('classes','request'));
        }
    }

    public function AttendanceStudent(Request $request){
        $prefix = SiteHelper::prefix(0);
        $date = $request->date;
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));
        $day = ltrim(date('d',strtotime($date)),'0');
        $class_id = $request->class_id;
        $grp_id = $request->grp_id;
        $session = $request->session;

        $st_ids = DB::table('admissions')->where(['prefix'=>$prefix, 'class_id'=>$request->class_id, 'grp_id'=>$request->grp_id, 'session'=>$request->session])->pluck('student_id')->toArray();
        foreach($st_ids as $k => $v){
            $st = 'st'.$v;
            $monthRow = DB::table('attendance')->where(['prefix'=>$prefix, 'tos_id'=>$v, 'type'=>2, 'class_id'=>$class_id, 'grp_id'=>$grp_id, 'session'=>$session, 'month'=>$month, 'year'=>$year]);
            $isExist = $monthRow->first();
            if($request->$st){
                $poa = 'P';
            }else{
                $poa = null;
            }
            if($isExist){
                $monthRow->update(['d'.$day => $poa]);
            }else{
                $monthRow->insert([
                    'prefix' => $prefix,
                    'tos_id' => $v,
                    'type' => 2,
                    'class_id' => $class_id,
                    'grp_id' => $grp_id,
                    'session' => $session,
                    'month' => $month,
                    'year' => $year,
                    'd'.$day => $poa
                ]);
            }
        }
        Alert::success('Success');
        return redirect()->back();
    }

    public function AttendanceTeacherForm(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->date){
            $date = $request->date;
            $day = ltrim(date('d',strtotime($request->date)),'0');
            $ids = DB::table('attendance')->where(['prefix'=>$prefix, 'type'=>1, ])->where('d'.$day,'!=',null)->pluck('tos_id')->toArray();
            $teachers = DB::table('teachers')->where('prefix',$prefix)->whereNotIn('id',$ids)->get();
            return view('attendance.attendance_teacher',compact('teachers'));
        }else{
            return view('attendance.attendance_teacher');
        }
    }

    public function AttendanceTeacher(Request $request){
        $prefix = SiteHelper::prefix(0);
        $date = $request->date;
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));
        $day = ltrim(date('d',strtotime($date)),'0');

        $tcr_ids = DB::table('teachers')->where('prefix',$prefix)->pluck('id')->toArray();
        foreach($tcr_ids as $k => $v){
            $tcr = 'tcr'.$v;
            $monthRow = DB::table('attendance')->where('prefix',$prefix)->where('tos_id',$v)->where('type',1)->where('month',$month)->where('year',$year);
            $isExist = $monthRow->first();
            if($request->$tcr){
                $poa = 'P';
            }else{
                $poa = null;
            }
            if($isExist){
                $monthRow->update(['d'.$day => $poa]);
            }else{
                $monthRow->insert([
                    'prefix' => $prefix,
                    'tos_id' => $v,
                    'type' => 1,
                    'month' => $month,
                    'year' => $year,
                    'd'.$day => $poa
                ]);
            }
        }
        Alert::success('Success');
        return redirect()->back();
    }

    public function MakeAttendanceHoliday(Request $request){
        $prefix = SiteHelper::prefix(0);
        $students = DB::table('admissions')->where(['admissions.prefix'=>$prefix])->join('students', 'students.id', '=', 'admissions.student_id')->get();
        $date = $request->date;
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));
        $day = ltrim(date('d',strtotime($date)),'0');
        foreach($students as $student){
            $attendance = DB::table('attendance')->where('prefix',$prefix)->where('tos_id',$student->student_id)->where('type',2)->where('class_id',$student->class_id)->where('grp_id',$student->grp_id)->where('session',$student->session)->where('month',$month)->where('year',$year);
            $isExist = $attendance->first();
            if($isExist){
                $attendance->update(['d'.$day => 'H']);
            }else{
                $attendance->insert([
                    'prefix' => $prefix,
                    'tos_id' => $student->student_id,
                    'type' => 2,
                    'class_id' => $student->class_id,
                    'grp_id' => $student->grp_id,
                    'session' => $student->session,
                    'month' => $month,
                    'year' => $year,
                    'd'.$day => 'H',
                ]);
            }
        }
        Alert::success('Success');
        return redirect()->back();
    }

    public function MakeTeacherHoliday(Request $request){
        $prefix = SiteHelper::prefix(0);
        $teachers = DB::table('teachers')->where('prefix',$prefix)->get();
        $date = $request->date;
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));
        $day = ltrim(date('d',strtotime($date)),'0');
        foreach($teachers as $teacher){
            $attendance = DB::table('attendance')->where(['prefix'=>$prefix, 'tos_id'=>$teacher->id, 'type'=>1, 'month'=>$month, 'year'=>$year]);
            $isExist = $attendance->first();
            if($isExist){
                $attendance->update(['d'.$day => 'H']);
            }else{
                $attendance->insert([
                    'prefix' => $prefix,
                    'tos_id' => $teacher->id,
                    'type' => 1,
                    'month' => $month,
                    'year' => $year,
                    'd'.$day => 'H',
                ]);
            }
        }
        Alert::success('Success');
        return redirect()->back();
    }

    public function UpdateAttendanceForm(Request $request){
        $prefix = SiteHelper::prefix(0);
        $classIds = SiteHelper::classArray(1);
        $classes = SiteHelper::classArray(2);
        if($request->date && $request->class_id && $request->grp_id && $request->session){
            $date = $request->date;
            $class_name = SiteHelper::ClassNameById($request->class_id);
            $group_name = SiteHelper::GroupNameById($request->grp_id);
            $year = date('Y',strtotime($date));
            $month = date('m',strtotime($date));
            $day = ltrim(date('d',strtotime($date)),'0');
            $d = 'd'.$day;
            $whereCondition = ['class_id'=>$request->class_id, 'grp_id'=>$request->grp_id, 'session'=>$request->session];
            $attends = DB::table('attendance')->where(['prefix'=>$prefix,'type'=>2,'month'=>$month, 'year'=>$year])->where($whereCondition);
            $ids = $attends->pluck('tos_id')->toArray();
            $presents = $attends->select($d,'tos_id')->get();
            $m = array();
            foreach($presents as $present){
                foreach($present as $k => $v){
                    $m[$present->tos_id] = $present->$d;
                }
            }
            $prsnt = $m;
            $students = DB::table('admissions')->where('admissions.prefix',$prefix)->where($whereCondition)->whereIn('student_id',$ids)->join('students', 'admissions.student_id', '=', 'students.id')->get();
            return view('attendance.attendance_update',compact('classes','students','prsnt','d','request','class_name','group_name'));
        }elseif($request->date){
            $date = $request->date;
            $year = date('Y',strtotime($date));
            $month = date('m',strtotime($date));
            $day = ltrim(date('d',strtotime($date)),'0');
            $d = 'd'.$day;
            $attends = DB::table('attendance')->where(['prefix'=>$prefix, 'type'=>1, 'month'=>$month, 'year'=>$year]);
            $ids = $attends->pluck('tos_id')->toArray();
            $presents = $attends->select($d,'tos_id')->get();
            $m = array();
            foreach($presents as $present){
                foreach($present as $k => $v){
                    $m[$present->tos_id] = $present->$d;
                }
            }
            $prsnt = $m;
            $teachers = DB::table('teachers')->where('prefix',$prefix)->whereIn('id',$ids)->get();
            return view('attendance.attendance_update',compact('request','prsnt','d','teachers'));
        }else{
            return view('attendance.attendance_update',compact('classes','request'));
        }
    }

    public function MonthlyAttendance(Request $request){
        $prefix = SiteHelper::prefix(0);
        $classIds = SiteHelper::classArray(1);
        $classes = SiteHelper::classArray(2);
        $class_name = null;
        $group_name = null;
        if($request->type == 2){
            $class_name = SiteHelper::ClassNameById($request->class_id);
            $group_name = SiteHelper::GroupNameById($request->grp_id);
        }
        return view('attendance.monthly_attendance',compact('classes','request','class_name','group_name'));
    }

    public function CalendarViewAttendance(Request $request){
        $name = null;
        if($request->type == 1 && $request->id){
            $name = SiteHelper::TeacherArrayById($request->id);
        }elseif($request->type == 2 && $request->id){
            $name = SiteHelper::StudentArrayById($request->id);
        }
        if($name){
            $name = $name->full_name;
        }else{
            $name = null;
        }
        return view('attendance.attendance_calendar',compact('name','request'));
    }

    public function getAttendance(Request $request){
        $prefix = SiteHelper::prefix(0);
        $day = 'd'.$request->day;
        $id = $request->id;
        $attend = DB::table('attendance')->where('prefix',$prefix)->where('tos_id',$id)->where('type',$request->type)->where('month',$request->month+1)->where('year',$request->year)->first();
        if($attend){
            return $attend->$day;
        }else{
            return null;
        }
    }

    public function AttendanceInputForm(){
        return view('attendance.input');
    }

    public function AttendanceInput(Request $request){
        $prefix = SiteHelper::prefix(0);
        $day = ltrim(date('d',strtotime($request->date)),'0');
        $month = date('m',strtotime($request->date));
        $year = date('Y',strtotime($request->date));
        $isValid = DB::table('admissions')->where('student_id',$request->id)->orderBy('id','desc')->first();
        if($isValid){
            $array = [
                'prefix'=>$prefix,
                'type'=>$request->type,
                'tos_id'=>$request->id,
                'month'=>$month,
                'year'=>$year,
                'session'=>$isValid->session,
                'class_id'=>$isValid->class_id,
                'grp_id'=>$isValid->grp_id
            ];
            $attendance = DB::table('attendance');
            $isExist = $attendance->where($array)->first();
            $present_day = 'd'.$day;
            if($isExist){
                if($isExist->$present_day == null){
                    $success = $attendance->where($array)->update([$present_day=>'P']);
                }else{
                    $success = false;
                }
            }else{
                $array['d'.$day] = 'P';
                $success = $attendance->insert($array);
            }
            if($success){
                return 'Success!';
            }else{
                return 'Already Presented';
            }
        }else{
            return 'Invalid ID Card!';
        }
        /* $array = ['tos'=>$request->tos,'date'=>$request->date,'idn'=>$request->idn,'attend'=>'P'];
        $data = DB::table('demo_attendance')->where($array);
        $isExist = $data->first();
        if(!$isExist){
            $insert = $data->insert($array);
            if($insert){
                return 'success';
            }else{
                return false;
            }
        }else{
            return 2;
        } */
    }
}
