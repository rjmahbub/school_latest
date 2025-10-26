<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function AcademyCalendar(){
        return view('academy.academy_calendar');
    }
}
