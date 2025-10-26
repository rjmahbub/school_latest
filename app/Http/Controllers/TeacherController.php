<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Models\User;
use DB;
use Alert;
use PDF;
use App\Helpers\SiteHelper;

class TeacherController extends Controller
{
    public function AddTeacherForm(){
        return view('teacher.add_teacher');
    }

    public function SaveTeacher(Request $request){
        $prefix = SiteHelper::prefix(0);
        $max_idn = DB::table('teachers')->where('prefix',$prefix)->max('idn');
        if(!$max_idn){
            $idn = SiteHelper::TeacherIdNumberMaker($max_idn+1);
        }else{
            $idn = $max_idn + 1;
        }
        $credentials = [
            'prefix' => $prefix,
            'idn' => $idn,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'father' => $request->father,
            'mother' => $request->mother,
            'present_addr' => $request->present_addr,
            'permanent_addr' => $request->permanent_addr,
            'phone' => $request->phone,
            'email' => $request->email
        ];
        //move file
        $src = "public/uploads/temps/$request->photo";
        $dst = "public/uploads/$prefix/teachers/";
        if(!is_dir($dst)){
            mkdir($dst, 0777, true);
        }
        if(file_exists($src)){
            rename($src, $dst.$request->photo);
            $credentials['photo'] = $request->photo;
        }
        //end move file
        $SaveTeacher =  DB::table('teachers')->insert($credentials);
        if($SaveTeacher){
            return redirect(route('teachers'));
        }else{
            return back();
        }
    }

    public function teachers(){
        return view('teacher.teachers');
    }

    public function UpdateTeacher(Request $request){
        $prefix = SiteHelper::prefix(0);
        $id = $request->id;
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
        $update =  DB::table('teachers')->where('prefix',$prefix)->where('id',$id)->update($credentials);

        if($update){
            return '<i class="fa fa-check text-success"> Change Saved!</i>';
        }else{
            return '<i class="fa fa-times-circle text-danger"> Nothing Changed!</i>';
        }
    }
}
