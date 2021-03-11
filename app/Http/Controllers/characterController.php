<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\character;
use App\Models\useful;

class characterController extends Controller
{
    public function update(Request $request){
        $data = useful::decodeStringafy($request->get('data'));
        if (isset($data['id'])){
            session('character')->{$request->get('item')} = $data['id'];
            if (isset($data['extra'])){
                session('character')->{$request->get('item').'_extra'} = $data['extra'];
            }
        } else {
            session('character')->{$request->get('item')} = $data;
        }

        return ['response'=> session('character')->{$request->get('item')} ];
    }
}
