<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use DB;
use Alert;
use App\Helpers\SiteHelper;

class StudentController extends Controller
{
    public function NewStudentForm(Request $request){
        $classes = SiteHelper::classArray(2);
        return view('student.new-student',compact('classes','request'));
    }

    public function SaveStudent(Request $request){
        $prefix = SiteHelper::prefix(0);
        $ExistRoll = DB::table('admissions')
        ->where('prefix',$prefix)
        ->where('session',$request->session)
        ->where('class_id',$request->class_id)
        ->where('grp_id',$request->grp_id)
        ->where('roll',$request->roll)
        ->first();
        if($ExistRoll){
            return back()->with('exist');
        }
        if($request->roll < 1){
            return back()->with('invalid_roll');
        }
        $idn = SiteHelper::StudentIdNumberMaker($request->session,$request->class_id,$request->grp_id,$request->roll);

        $credentials = [
            'prefix' => $prefix,
            'full_name' => $request->full_name,
            'father' => $request->father,
            'mother' => $request->mother,
            'gender' => $request->gender,
            'present_addr' => $request->present_addr,
            'permanent_addr' => $request->permanent_addr,
            'phone' => $request->phone,
            'email' => $request->email,
            'dob' => $request->dob,
        ];
        //move file
        $src = "public/uploads/temps/$request->photo";
        $dst = "public/uploads/$prefix/students/";
        if(!is_dir($dst)){
            mkdir($dst, 0777, true);
        }
        if(file_exists($src)){
            rename($src, $dst.$request->photo);
            $credentials['photo'] = $request->photo;
        }
        //end move file
        $SaveStudent = DB::table('students')->insert($credentials);
        if($SaveStudent){
            $student_id = DB::table('students')->where('prefix',$prefix)->max('id');
            $admissionCredentials = [
                'student_id' => $student_id,
                'prefix' => $prefix,
                'idn' => $idn,
                'session' => $request->session,
                'class_id' => $request->class_id,
                'grp_id' => $request->grp_id,
                'roll' => $request->roll,
            ];
            $admission = DB::table('admissions')->insert($admissionCredentials);
            if($admission){
                return redirect(route('students').'?class_id='.$request->class_id.'&grp_id='.$request->grp_id.'&session='.$request->session)->with('success');
            }
        }
        return redirect(route('students').'?class_id='.$request->class_id.'&grp_id='.$request->grp_id.'&session='.$request->session)->with('error');
    }

    public function students(Request $request){
        $exams = SiteHelper::examsArray(2);
        $ClassName = SiteHelper::ClassNameById($request->class_id);
        $GroupName = SiteHelper::GroupNameById($request->grp_id);
        $classes = SiteHelper::classArray(2);
        return view('student.students',compact('classes','exams','GroupName','ClassName','request'));
    }

    public function ClassList(Request $request){
        $classes = SiteHelper::classArray(2);
        $exams = SiteHelper::examsArray(2);
        return view('student.class-list',compact('classes','request'));
    }

    public function UpdateStudent(Request $request){
        $prefix = SiteHelper::prefix(0);
        $id = $request->st_id;
        $student = DB::table('students')->where('id',$id);
        $credentials = [
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'father' => $request->father,
            'mother' => $request->mother,
            'present_addr' => $request->present_addr,
            'permanent_addr' => $request->permanent_addr,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        /* if($request->hasFile('photo')){
            $uniqid = uniqid();
            $file = $request->file('photo');
            $photoExtension = $file->getClientOriginalExtension();
            $destinationPath = "public/uploads/$prefix/students/";
            $filename  = 'tcr'.$uniqid.'.'.$photoExtension;
            $upload_success = $file->move($destinationPath, $filename);
            File::delete($destinationPath.$student->first()->photo);
            $credentials['photo']  = $filename;
        } */
        $update =  $student->update($credentials);
        if($update){
            return '<i class="fa fa-check text-success"> Change Saved!</i>';
        }else{
            return '<i class="fa fa-times-circle text-danger"> Nothing Changed!</i>';
        }
    }
}