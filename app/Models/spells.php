<?php

namespace App\Models;

class spells
{

    private $cid;
    private $rid;

    function __construct($cid,$rid)
    {
        $this->cid = $cid;
        $this->rid = $rid;
    }


    private $spellslots;

    /**
     * returns the number of spell slots
     *
     * @param integer $level
     * @return mixed
     */
    private function spellSlots($level=NULL)
    {
        if(!$this->spellslots){
            $this->spellSlots = useful::unserializeCollection( ( new floatingModel('class_to_spellslots') )->where('cid','=',$this->cid)->get() );
        }
        if ($level){
            foreach($this->spellslots as $s){
                if ($s->level == $level){
                    return $s;
                }
            }
        }
        return $this->spellslots;
    }

    /**
     * returns T/F if class can use spells
     *
     * @return boolean
     */
    private function isMagic(){
        return in_array($this->cid,array(2,3,4,7,8,10,11,12));
    }

    /**
     * returns array of spells user can choose from
     *
     * @return void
     */
    public function choice(){
        if ($this->isMagic()){

        }
        return NULL;
    }

    /**
     * returns the number of spells character knows
     *
     * @param integer $level character level
     * @return int
     */
    public function known($level=1){
        return ($this->isMagic()) ? ($this->spellSlots($level))->known : 0;
    }

    /**
     * returns the number of cantrips (lv 0 spells) character has
     *
     * @param integer $level character level
     * @return int
     */
    public function cantrips($level=1){
        return ($this->isMagic()) ? ($this->spellSlots($level))->cantrips : 0;
    }

    /**
     * returns the number of spells castsa at each spell level character has
     *
     * @param integer $level character level
     * @return int
     */
    public function slots($level=1){
        $slots = ($this->spellSlots($level))->slots;
        return ($this->isMagic()) ? ( ( count($slots) == 0 ) ? 0 : $slots ) : 0;
    }
}
