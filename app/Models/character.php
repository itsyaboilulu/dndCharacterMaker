<?php

namespace App\Models;

use Exception;

class character
{

    private $race;
    private $race_extra;
    private $clas;
    private $background;
    private $background_extra;


    public function race()
    {
        if (is_numeric($this->race)) {
            $this->race = useful::unserializeCollection((new floatingModel('races'))->where('id', $this->race)->get())[0];
        }
        return $this->race;
    }

    public function clas()
    {
        if (is_numeric($this->clas)) {
            $this->clas = useful::unserializeCollection((new floatingModel('classes'))->where('id', $this->clas)->get())[0];
        }
        return $this->clas;
    }

    public function background()
    {
        if (is_numeric($this->background)) {
            $this->background = useful::unserializeCollection((new floatingModel('background'))->where('id', $this->background)->get())[0];
        }
        return $this->background;
    }


    function __set($key, $val)
    {
        if ($key == 'clas'){
            $this->{$key} = $val;
            $this->{$key} = $val;
            $this->{$key} = $val;
            $this->{$key} = $val;
        }
        return $this->{$key} = $val;
    }

    // ---------------------- ABILITYS -----------------------------

    /**
     * stored character ability points
     */
    private $ability;

    /**
     * return the skill points for character
     *
     * @param string $skill
     * @return mixed
     */
    public function ability($ability = NULL)
    {
        return ($ability) ? $this->ability[$ability] : $this->ability;
    }

    /**
     * return the roll modifiers for the character
     *
     * @param string $skill
     * @return mixed
     */
    public function abilityModifer($ability = NULL)
    {
        if ($ability) {
            return floor(($this->ability($ability) - 10) / 2);
        } else {
            $ret = [];
            foreach ($this->ability() as $key => $value) {
                $ret[$key] = $this->abilityModifer($key);
            }
            return $ret;
        }
    }

    public function abilitysRanked()
    {
        return useful::unserializeCollection( (new floatingModel('abilities'))->select('abilities.*', 'abilities_recomended.rank')
            ->join('abilities_recomended', 'abilities_recomended.aid','=', 'abilities.id')
            ->where('abilities_recomended.cid','=', $this->clas()->id)
            ->get() );
    }

//----------------------------- SKILLS --------------------

    private $skills;

    /**
     * returns characters set skills
     *
     * @return void
     */
    public function skills(){
        return $this->skills;
    }

    /**
     * returns the number of skills the character can pick
     *
     * @return integer
     */
    public function skillNumberAvailible(){
        $sn = ($this->race()->id == 7) ? 4 : 2;
        switch ($this->clas()->id){
            case 9:
                $sn = $sn + 2;
                break;
            case 8:
            case 2:
                $sn++;
                break;
        }
        return $sn;
    }

    /**
     * return list of race and background skills
     *
     * @return array
     */
    public function SkillsSet(){
        $ret = [];
        $ret[] = $this->background()->skill1;
        $ret[] = $this->background()->skill2;
        if ($this->race()->id == 2 || $this->race()->id == 8) {
            $ret[] = ((new floatingModel('abilities_skills'))->where('name',str_replace('Skill: ', '', $this->race()->prof['prof'][0]))->first())->id;;
        }
        return $ret;
    }

    //----------------------------- equitment --------------------

    private $equitment;

    private $eqm;
    /**
     * initialize equitment model
     *
     * @return object
     */
    private function equitmentModel(){
        if (!$this->eqm){
            $this->eqm = new equitment($this->clas()->id,$this->background()->id);
        }
        return $this->eqm;
    }

    /**
     * returns the equitemnt that come standered with class and background
     *
     * @return void
     */
    public function equitment(){
        return ($this->equitment + $this->equitmentModel()->set());
    }

    /**
     * returns a list of equitment items that can be selected from
     *
     * @return array
     */
    public function equitmentChoice(){
        return $this->equitmentModel()->choice();
    }

// -------------------------- spells

    private $sm;
    private $spells;

    private function spellsModel(){
        if (!$this->sm){
            $this->sm = new spells();
        }
        return $this->sm;
    }

    public function spells(){

    }

    public function spellsChoice(){
        return $this->spellsModel()->choice();
    }

}
