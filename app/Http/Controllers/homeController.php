<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\character;
use App\Models\floatingModel;
use App\Models\useful;

class homeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        session( [ 'character' => new character() ] );
        return view('home', array(
            'races'     => useful::unserializeCollection((new floatingModel('races'))->get()),
            'traits'    => (new floatingModel('traits'))->get(),
        ));
    }
}
