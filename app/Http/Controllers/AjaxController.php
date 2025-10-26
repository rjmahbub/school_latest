<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\inst_info;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SiteHelper;

class AjaxController extends Controller
{
    public function subdomain(Request $request){
        $prefix = $request->prefix;
        $ExistSubdomain = inst_info::where('prefix',$prefix)->first();
        if($ExistSubdomain || $prefix == SiteHelper::$prefixMain){
            return true;
        }else{
            return false;
        }
    }

    public function ajaxSmsSend(Request $request){
        SiteHelper::SendSms($request->numbers,$request->message);
        return true;
    }

    public function group(Request $request){
        $groups = SiteHelper::groupsArray($request->class_id,2);
        $group_opts = "";
        if($groups){
            foreach($groups as $group){
                $group_opts .= "<option value='$group->grp_id'>$group->grp_name</option>";
            }
        }
        return $group_opts;
    }

    public function subject(Request $request){
        /* $prefix = SiteHelper::prefix(0);
        $grp_id = $request->grp_id;
        $a = 2;
        $subjectNames = array();
        $subIds = array();
        $subject_opts = "";
        $subIds = DB::table('inst_subjects')->where(['prefix'=>$prefix,'class_id'=>$request->class_id])->where(function ($query) use ($grp_id) {
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
        } */


        $subjects = SiteHelper::subjectsArray($request->class_id,$request->grp_id,2);
        $subject_opts = "";
        if($subjects){
            foreach($subjects as $subject){
                $subject_opts .= "<option value='$subject->sub_id'>$subject->sub_name</option>";
            }
        }
        return $subject_opts;
    }

    public function session(Request $request){
        $data = DB::table('admissions')->where(['class_id'=>$request->class_id,'grp_id'=>$request->grp_id])->max('session');
        if($data){
            return $data;
        }
        return false;
    }

    public function DeleteByIds(Request $request){
        $prefix = SiteHelper::prefix(0);
        $user = Auth::user();
        $table_name = $request->table;
        $col = $request->col;
        $ids = explode(',',$request->ids);
        $delete = DB::table($table_name);
        if($user->who !== 1){
            $delete = $delete->where('prefix',$prefix);
        }
        $delete = $delete->whereIn($col,$ids)->delete();
        if($delete){
            return true;
        }else{
            return false;
        }
    }

    public function UpdateById(Request $request){
        $tableName = $request->table;
        $idCol = $request->id_col;
        $id = $request->id;
        $updateCol = $request->update_col;
        $value = $request->value;
        if($tableName && $idCol && $id && $updateCol){
            $update = DB::table($tableName)->where($idCol,$id)->update([$updateCol => $value]);
            if($update){
                return true;
                Alert::sucess('Success!');
                return redirect()->back();
            }else{
                return false;
                Alert::error('Error!');
                return redirect()->back();
            }
        }else{
            return false;
            Alert::error('Error!');
            return redirect()->back();
        }
    }

    public function oneColUpdate(Request $request){
        $user = Auth::user();
        $tableName = $request->table;
        $whereCol = $request->whereCol;
        $whereVal = $request->whereVal;
        $upCol = $request->upCol;
        $upVal = $request->upVal;
        
        if($tableName == 'inst_infos' && $upCol == 'status'){
            if($user->who !== 1){
                return false;
                exit;
            }
        }

        if($tableName && $whereCol && $whereVal && $upCol) {
            $update = DB::table($tableName)->where($whereCol,$whereVal)->update([$upCol => $upVal]);
            if($update){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function searchTos(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->q){
            if($request->type == 2){
                $students = DB::table('admissions')->join('students', 'admissions.student_id', '=', 'students.id')
                    ->where('admissions.prefix',$prefix)
                    ->where(function($query)use ($request){
                        $query->orWhere('roll','LIKE','%'.$request->q.'%')
                              ->orWhere('full_name','LIKE','%'.$request->q.'%')
                              ->orWhere('idn','LIKE','%'.$request->q.'%')
                              ->orWhere('session','LIKE','%'.$request->q.'%')
                              ->orWhere('phone','LIKE','%'.$request->q.'%');
                    })->get();
                $result = null;
                if($students){
                    foreach($students as $student){
                        $group = SiteHelper::GroupNameById($student->grp_id);
                        $class_name = SiteHelper::ClassNameById($student->class_id);
                        $result .= "<option value='$student->student_id'>$student->full_name, $student->session, Class: $class_name, Roll: $student->roll, Group: $group</option>";
                    }
                }
                return $result;
            }else{
                $teachers = DB::table('teachers')
                    ->where('prefix',$prefix)
                    ->where(function($query)use ($request){
                        $query->where('idn','LIKE','%'.$request->q.'%')
                              ->orWhere('full_name','LIKE','%'.$request->q.'%')
                              ->orWhere('phone','LIKE','%'.$request->q.'%');
                    })->get();
                $result = null;
                if($teachers){
                    foreach($teachers as $teacher){
                        $result .= "<option value='$teacher->id'>$teacher->full_name, $teacher->phone</option>";
                    }
                }
                return $result;
            }
        }
    }
}
