<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\inst_info;
use DB;
use App\Http\Controllers\Controller;
use App\Helpers\SiteHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        $prefix = SiteHelper::prefix(0);
        $prefixMain = SiteHelper::$prefixMain;
        $domainName = SiteHelper::prefix(2);
        $mainDomain = SiteHelper::$mainDomain;
        $CurrentSession = ' ';
        if($prefix !== $prefixMain){
            $CurrentSession = DB::table('current_session')->where('prefix',$prefix)->first();
            if($CurrentSession){
                $CurrentSession = $CurrentSession->session;
            }
        }
        $inst = inst_info::where('prefix',$prefix)->first();
        view::share(['inst'=>$inst, 'domainName'=>$domainName, 'mainDomain'=>$mainDomain, 'prefix'=>$prefix, 'prefixMain'=>$prefixMain, 'CurrentSession'=>$CurrentSession]);
    }
}
