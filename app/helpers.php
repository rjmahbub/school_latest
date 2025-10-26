<?php

if (!function_exists('site_name')) {
    function site_name() {
        return \App\Helpers\SiteHelper::siteName();
    }
}
