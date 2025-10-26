<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use DB;
use Alert;
use App\Helpers\SiteHelper;

class NoticeController extends Controller
{
    public function AddNoticeForm(Request $request){
        $prefix = SiteHelper::prefix(0);
        $notice = array();
        if($request->id){
            $notice = DB::table('notices')->where(['prefix' => $prefix, 'id' => $request->id])->first();
        }
        return view('notice.publish_notice',compact('notice'));
    }

    public function AddNotice(Request $request){
        $prefix = SiteHelper::prefix(0);
        $title = $request->notice_title;
        $description = $request->notice_description;
        $examNotice = $request->notice_exam;
        $headline = $request->notice_headline;

        $credentials = [
            'title' => $title,
            'description' => $description,
            'exam' => $examNotice,
            'headline' => $headline,
        ];
        if(!$request->notice_id){
            $credentials['prefix']  = $prefix;
        }
        for($i=0;$i<=4;$i++){
            if($request->hasFile('file'.$i)){
                $uniqid = uniqid();
                $file = $request->file('file'.$i);
                $extension = $file->getClientOriginalExtension();
                $destinationPath = "public/uploads/$prefix/notices/";
                $filename  = $uniqid.'.'.$extension;
                $upload_success = $file->move($destinationPath, $filename);
                $credentials['file'.$i]  = $filename;
            }else{
                continue;
            }
        }
        $success = DB::table('notices');
        if($request->notice_id){
            $success = $success->update($credentials);
        }else{
            $success = DB::table('notices')->insert($credentials);
        }
        if($success){
            Alert::success('Success!');
            return redirect()->back();
        }else{
            Alert::warning('Some Error!');
            return redirect()->back();
        }
    }

    public function AllNoticeView(){
        $prefix = SiteHelper::prefix(0);
        $notices = DB::table('notices')->where('prefix',$prefix)->get();
        return view('notice.all_notice',compact('notices'));
    }

    public function ViewNotice(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->ni){
            $notice = DB::table('notices')->where('prefix',$prefix)->where('id',$request->ni)->first();
            $notices = DB::table('notices')->where('prefix',$prefix)->get();
            return view('notice.view_notice',compact('notices','notice'));
        }
    }

    public function DeleteNoticeFile(Request $request){
        $prefix = SiteHelper::prefix(0);
        $update = DB::table('notices')->where(['prefix' => $prefix, 'id' => $request->id])->update([$request->file => null]);
        if($update){
            File::delete("public/uploads/$prefix/notices/$request->fn");
            return back();
        }
    }
}
