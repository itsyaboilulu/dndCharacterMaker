<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\floatingModel;
use App\Models\useful;

class internalController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function class(Request $request)
    {
        if ($request->has('class')) {
        } else {
            $ret = [];
            foreach (useful::unserializeCollection((new floatingModel('classes'))->get()) as $c) {
                $c->classFeatures = useful::unserializeCollection((new floatingModel('class_feature'))->where('cid', $c->id)->where('level', 1)->whereNotNull('small_desc')->get());
                $ret[] = $c;
            }
            return $ret;
        }
    }

    public function background(Request $request)
    {
        $ret = [];
        foreach (useful::unserializeCollection((new floatingModel('background'))->get()) as $b) {
            $b->skill1      = ((new floatingModel('abilities_skills'))->find($b->skill1))->name;
            $b->skill2      = ((new floatingModel('abilities_skills'))->find($b->skill2))->name;
            $b->feature     = (new floatingModel('background_feature'))->find($b->feature);
            $ret[] = $b;
        }
        return $ret;
    }

    public function language(Request $request)
    {
        return (new floatingModel('languages'))->get();
    }

    public function abilities(Request $request)
    {
        $ret= [];
        foreach( session('character')->abilitysRanked() as $a){
            $pd = [];
            foreach((new floatingModel('abilities_point_desc'))->select('points', 'desc')->where('aid',$a->id)->get() as $apd ){
                $pd[] = $apd;
            }
            $a->apd = $pd;
            $a->bonus = 0;
            foreach( (session('character'))->race()->ability['bonus'] as $shorname=>$num ){
                if ($shorname == strtolower($a->shortname)){
                    $a->bonus = $num;
                    if ($a->rank < 3 && (session('character'))->clas()->id == 7) {
                        $a->bonus++;
                    }
                }
            }
            $a->bonus_option = FALSE;
            if (isset((session('character'))->race()->ability['options']['bonus'])){
                if (in_array(strtolower($a->shortname), (session('character'))->race()->ability['options']['bonus'])){
                    $a->bonus_option = TRUE;
                }
            }
            $ret[] = $a;
        }
        return $ret;
    }


    public function skills(Request $request)
    {
        $ret = [ 'pick'  => session('character')->skillNumberAvailible(), 'skills'=> [ 'STR'=>[], 'DEX'=>[], 'INT'=>[], 'WIS'=>[], 'CHA'=>[] ] ];
        foreach (( new floatingModel('abilities_skills'))->select('abilities_skills.id', 'abilities_skills.name', 'abilities_skills.desc', 'abilities.shortname')
                    ->join('abilities', 'abilities.id','=', 'abilities_skills.ability')
                    ->get()
        as $a) {
            $a->set = 0;
            foreach (session('character')->SkillsSet() as $s){ if ($s == $a->id) { $a->set = 1; } }
            $ret['skills'][$a->shortname][] = $a;
        }
        return $ret;
    }

    public function equitment(Request $request)
    {
        return session('character')->equitmentChoice();
    }

    public function spells(Request $request)
    {
        return session('character')->spellsChoice();
    }
}
