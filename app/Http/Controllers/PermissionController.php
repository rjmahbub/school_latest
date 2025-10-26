<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Alert;
use App\Helpers\SiteHelper;

class PermissionController extends Controller
{
    public function SettingOthers(){
        return view('settings.others');
    }

    public function SettingClass(){
        $prefix = SiteHelper::prefix(0);
        $classIds = array();
        $classes = array();
        $classes = DB::table('all_classes')->get();
        $getIds = DB::table('inst_exams_classes')->where('prefix',$prefix)->first();
        if($getIds && $getIds->class_ids !== null){
            $getIds = $getIds->class_ids;
            $getIds = explode(',',$getIds);
            foreach($getIds as $k => $v){
                $classIds[$v] = $k;
            }
        }
        return view('settings.class',compact('classes','classIds'));
    }

    public function currentSession(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->session){
            $session = DB::table('current_session')->where('prefix',$prefix);
            $getSession = $session->first();
            $credential = ['session'=>$request->session];
            if($getSession){
                $method = 'update';
            }else{
                $method = 'insert';
                $credential['prefix'] = $prefix;
            }
            $success = $session->$method($credential);
            if($success){
                return back();
            }else{
                return back();
            }
        }
        return back();
    }

    public function UploadSignature(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->image){
            $image_array_1 = explode(";", $request->image);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $path = "public/uploads/$prefix/signature/";
            if(!is_dir($path)){
                mkdir($path, 0777, true);
            }
            $image_name = 'signature.png';
            $success = file_put_contents($path.$image_name, $data);
            return $image_name;
        }
    }

    public function UploadStudentPic(Request $request){
        $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        if(isset($_POST['image'])){
            $data = $_POST['image'];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $path = "public/uploads/temps/";
            if(!is_dir($path)){
                mkdir($path, 0777, true);
            }
            $image_name = time() . '.png';
            $success = file_put_contents($path.$image_name, $data);
            if($success){
                return $image_name;
            }else{
                return false;
            }
        }
    }

    public function ChangePhoto(Request $request){
        $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        if($request->image){
            $image_array_1 = explode(";", $request->image);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $path = "public/uploads/$request->table/";
            if(!is_dir($path)){
                mkdir($path, 0777, true);
            }
            $image_name = time() . '.png';
            $success = file_put_contents($path.$image_name, $data);
            if($success){
                if($request->id && $request->col){
                    $arr = DB::table($request->table)->where('id',$request->id);
                    $getData = $arr->first();
                    $arr->update([$request->col=>$image_name]);
                    File::delete($path.$getData->photo);
                }
                return $image_name;
            }else{
                return false;
            }
        }
    }

    public function SettingGroup(Request $request){
        $prefix = SiteHelper::prefix(0);
        $classes = array();
        $groups = array();
        $grpIds = array();
        $a = DB::table('inst_exams_classes')->where('prefix',$prefix)->first();
        if($a){
            $classIds = $a->class_ids;
            $classes = DB::table('all_classes')->whereIn('class_id',explode(',',$classIds))->get();
        }
        $groups = DB::table('all_groups')->get();
        
        $getIds = SiteHelper::groupsArray($request->class_id,1);
        if($getIds){
            foreach($getIds as $k => $v){
                $grpIds[$v] = $k;
            }
        }
        return view('settings.group',compact('request','classes','groups','grpIds'));
    }

    public function SettingSubject(Request $request){
        $prefix = SiteHelper::prefix(0);
        $classes = array();
        $groups = array();
        $subjects = array();
        $subs = array();
        $a = DB::table('inst_exams_classes')->where('prefix',$prefix)->first();
        $subjects = DB::table('all_subjects')->get();
        if($a){
            $classIds = $a->class_ids;
            $classes = DB::table('all_classes')->whereIn('class_id',explode(',',$classIds))->get();
        }
        $getIds = DB::table('inst_groups')->where('prefix',$prefix)->where('class_id',$request->class_id)->first();
        if($getIds){
            $groups = DB::table('all_groups')->whereIn('grp_id',explode(',',$getIds->grp_ids))->get();
        }
        $b = DB::table('inst_subjects')->where('prefix',$prefix)->where('class_id',$request->class_id)->where('grp_id',$request->grp_id)->first();
        if($b){
            $subIds = $b->sub_ids;
            $c = explode(',',$subIds);
            foreach($c as $k => $v){
                $subs[$v] = $k;
            }
        }
        return view('settings.subject',compact('request','classes','groups','subjects','subs'));
    }

    public function SettingExam(){
        $prefix = SiteHelper::prefix(0);
        $exams = array();
        $examIds = array();
        $exams = DB::table('all_exams')->get();
        $getIds = SiteHelper::examsArray(1);
        if($getIds){
            foreach($getIds as $k => $v){
                $examIds[$v] = $k;
            }
        }
        return view('settings.exam',compact('exams','examIds'));
    }

    public function InstAddGroup(Request $request){
        $prefix = SiteHelper::prefix(0);
        $grp_ids = $request->ids;
        $isExist = DB::table('inst_groups')->where('prefix',$prefix)->where('class_id',$request->class_id)->first();
        if($isExist){
            $update = DB::table('inst_groups')->where('prefix',$prefix)->where('class_id',$request->class_id)->update([
                'grp_ids' => $grp_ids
            ]);

            if($update){
                return true;
            }else{
                return false;
            }
        }else{
            $insert = DB::table('inst_groups')->insert([
                'prefix' => $prefix,
                'class_id' => $request->class_id,
                'grp_ids' => $grp_ids
            ]);

            if($insert){
                return true;
            }else{
                return false;
            }
        }
    }

    public function InstAddSubject(Request $request){
        $prefix = SiteHelper::prefix(0);
        $sub_ids = $request->ids;
        $isExist = DB::table('inst_subjects')->where(['prefix'=>$prefix,'class_id'=>$request->class_id,'grp_id'=>$request->grp_id]);
        $check = $isExist->first();
        if($check){
            $update = $isExist->update([
                'sub_ids' => $sub_ids
            ]);
            if($update){
                return true;
            }
        }else{
            $insert = DB::table('inst_subjects')->insert([
                'prefix' => $prefix,
                'class_id' => $request->class_id,
                'grp_id' => $request->grp_id,
                'sub_ids' => $sub_ids
            ]);

            if($insert){
                return true;
            }
        }
        return false;
    }

    public function InstAddClass(Request $request){
        $prefix = SiteHelper::prefix(0);
        $class_ids = $request->ids;
        $isExist = DB::table('inst_exams_classes')->where('prefix',$prefix)->first();
        if($isExist){
            $update = DB::table('inst_exams_classes')->where('prefix',$prefix)->update([
                'class_ids' => $class_ids
            ]);

            if($update){
                return true;
            }else{
                return false;
            }
        }else{
            $insert = DB::table('inst_exams_classes')->insert([
                'prefix' => $prefix,
                'class_ids' => $class_ids
            ]);

            if($insert){
                return true;
            }else{
                return false;
            }
        }
    }

    public function InstAddExam(Request $request){
        $prefix = SiteHelper::prefix(0);
        $exam_ids = $request->ids;
        $isExist = DB::table('inst_exams_classes')->where('prefix',$prefix)->first();
        if($isExist){
            $update = DB::table('inst_exams_classes')->where('prefix',$prefix)->update([
                'exam_ids' => $exam_ids
            ]);

            if($update){
                return true;
            }else{
                return false;
            }
        }else{
            $insert = DB::table('inst_exams_classes')->insert([
                'prefix' => $prefix,
                'exam_ids' => $exam_ids
            ]);

            if($insert){
                return true;
            }else{
                return false;
            }
        }
    }

    public function RequestFormcgse(){
        return view('settings.request');
    }

    public function Requestcgse(Request $request){
        $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        if($request->cgse == 0 || $request->cgse == 1 || $request->cgse == 2 || $request->cgse == 3){
            $insert = DB::table('request_cgse')->insert([
                'prefix' => $prefix,
                'phone' => $user->phone,
                'name' => $request->name,
                'cgse' => $request->cgse,
                'remarks' => $request->remarks,
            ]);
            if($insert){
                return true;
            }
        }
        return false;
    }

    public function users(Request $request){
        return view('users.user-list',compact('request'));
    }

    public function UserPermission(){
        $prefix = SiteHelper::prefix(0);
        $users = DB::table('users')->where(['prefix'=>$prefix,'who'=>4])->get();
        $menus = explode(',',DB::table('settings')->where(['setting_name'=>'menus'])->first()->value);
        return view('users.user-permission',compact('users','menus'));
    }

    public function SaveUserPermission(Request $request){
        $data = explode(',',DB::table('settings')->where('setting_name','menus')->first()->value);
        $count = count($data) - 1;
        for($i=0;$i<=$count;$i++){
            $property = 'cb'.$i;
            $col = 'm'.$i;
            if($request->$property){
                $val = 1;
            }else{
                $val = null;
            }
            User::where('id',$request->user_id)->update([$col => $val]);
        }
        return back();
    }
}
