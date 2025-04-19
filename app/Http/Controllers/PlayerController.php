<?php

namespace App\Http\Controllers;

use App\Models\SportField;
use Illuminate\Http\Request;
use App\Models\User;
class PlayerController extends Controller
{
    /**
     * Display the homepage with a list of players.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('players.index' , [
            'fields' => SportField::all(),
        ]);
    }


    public function show()
    {
 
        return view('players.profile');
    }
}
