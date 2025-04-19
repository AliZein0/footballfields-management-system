<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    function create(){
        return view('teams.create');
    } 
       
}