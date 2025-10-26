<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\inst_info;
use DB;
use Alert;
use App\Helpers\SiteHelper;

class DesignController extends Controller
{
    public function SlideshowForm(){
        $prefix = SiteHelper::prefix(0);
        $images = DB::table('slideshow')->where('prefix',$prefix)->orderBy('sequence')->get();
        return view('design.slideshow',compact('images'));
    }

    public function AddSlideItem(Request $request){
        $prefix = SiteHelper::prefix(0);
        $file = $request->file('SlidePhoto');
        $uniqid = uniqid();
        $photoExtension = $file->getClientOriginalExtension();
        $destinationPath = "public/uploads/$prefix/slideshow/";
        $filename  = $uniqid.'.'.$photoExtension;
        $upload_success = $file->move($destinationPath, $filename);
        $credentials = [
            'prefix' => $prefix,
            'img' => $filename,
            'sequence' => $request->sequence,
        ];
        $insert = DB::table('slideshow')->insert($credentials);
        if($insert){
            Alert::success('Success!');
            return redirect()->back();
        }else{
            Alert::error('Failed!');
            return redirect()->back();
        }
    }

    public function UpdateSlideItem(Request $request){
        $prefix = SiteHelper::prefix(0);
        $id = $request->id;
        $sequence = $request->sequence;
        $credentials = [
            'sequence' => $sequence
        ];
        if($request->hasFile('slide_photo')){
            $file = $request->file('slide_photo');
            $prePhoto = DB::table('slideshow')->where('id',$id)->first()->img;
            $uniqid = uniqid();
            $photoExtension = $file->getClientOriginalExtension();
            $destinationPath = "public/uploads/$prefix/slideshow/";
            $filename  = $uniqid.'.'.$photoExtension;
            $upload_success = $file->move($destinationPath, $filename);
            $credentials['img'] = $filename;
            File::delete($destinationPath.$prePhoto);
        }
        $update = DB::table('slideshow')->where('id',$id)->update($credentials);
        if($update){
            Alert::success('Success!');
            return redirect()->back();
        }else{
            Alert::info('Nothing Update!');
            return redirect()->back();
        }
    }

    public function DeleteSlideItem(Request $request){
        $prefix = SiteHelper::prefix(0);
        $id = $request->id;
        $getSlideItem = DB::table('slideshow')->where('id',$id);
        $slideItem = $getSlideItem->first();
        if($slideItem){
            $destinationPath = "public/uploads/$prefix/slideshow/$slideItem->img";
            File::delete($destinationPath);
            $delete = $getSlideItem->delete();

            if($delete){
                Alert::success('Delete Success!');
                return back();
            }else{
                Alert::error('Delete Failed!');
                return back();
            }
        }
        Alert::info('Not Found!');
        return back();
    }

    public function ChangeInfoForm(){
        $prefix = SiteHelper::prefix(0);
        $info = inst_info::where('prefix',$prefix)->first();
        if($info){
            return view('design.change_info',compact('info'));
        }
    }

    public function WebHeader(Request $request){
        $prefix = SiteHelper::prefix(0);
        $credentials = [
            'web_head' => $request->WebHeader
        ];
        $update = inst_info::where('prefix',$prefix)->update($credentials);
        if($update){
            Alert::success('Success!');
            return redirect()->back();
        }else{
            Alert::error('Failed!');
            return redirect()->back();
        }
    }

    public function ChangeInfo(Request $request){
        $prefix = SiteHelper::prefix(0);
        $credentials = [
            'inst_name' => $request->inst_name,
            'inst_addr' => $request->inst_addr,
            'inst_phone' => $request->inst_phone,
            'inst_phone2' => $request->inst_phone2,
            'inst_email' => $request->inst_email,
        ];
        $update = inst_info::where('prefix',$prefix)->update($credentials);
        if($update){
            return '<i class="fa fa-check text-success"> Change Saved!</i>';
        }else{
            return '<i class="fa fa-times-circle text-danger"> Nothing Changed!</i>';
        }
    }

    public function PhotoGalleryView(){
        $prefix = SiteHelper::prefix(0);
        $photos = DB::table('photo_gallery')->where('prefix',$prefix)->get();
        return view('design.photo-gallery',compact('photos'));
    }

    public function PhotoGallery(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->hasFile('photo')) {
            $uniqid = uniqid();
            $file = $request->file('photo');
            $photoExtension = $file->getClientOriginalExtension();
            $destinationPath = "public/uploads/$prefix/photo_gallery/";
            $filename  = $uniqid.'.'.$photoExtension;
            $upload_success = $file->move($destinationPath, $filename);
            $insert = DB::table('photo_gallery')->insert([
                'prefix' => $prefix,
                'img' => $filename,
            ]);

            if($upload_success && $insert){
                Alert::success('Success');
                return back();
            }
            Alert::error('Failed!');
            return back();
        }
    }

    public function DeleteGalleryPhoto(Request $request){
        $isDelete = DB::table('photo_gallery')->whereIn('id',$request->checkbox)->delete();
        if($isDelete){
            Alert::success('Success');
            return back();
        }
        Alert::error('Failed!');
        return back();
    }

    public function VideoGalleryView(){
        $prefix = SiteHelper::prefix(0);
        $videos = DB::table('video_gallery')->where('prefix',$prefix)->get();
        return view('design.video-gallery',compact('videos'));
    }

    public function VideoGallery(Request $request){
        $prefix = SiteHelper::prefix(0);
        if($request->hasFile('photo')) {
            $uniqid = uniqid();
            $file = $request->file('photo');
            $photoExtension = $file->getClientOriginalExtension();
            $destinationPath = "public/uploads/$prefix/video_gallery/";
            $filename  = $uniqid.'.'.$photoExtension;
            $upload_success = $file->move($destinationPath, $filename);
            $insert = DB::table('video_gallery')->insert([
                'prefix' => $prefix,
                'img' => $filename,
                'link' => $request->link,
            ]);

            if($upload_success && $insert){
                Alert::success('Success');
                return back();
            }
        }
    }
}
