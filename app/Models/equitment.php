<?php

namespace App\Models;

/**
 * model to handle equitment data
 *
 * @param int $cid
 * @param int $bid
 */
class equitment
{

    private $class;
    private $bk;

    private $feilds = array('equitment', 'weapons', 'special', 'armour');

    /**
     * model to handle equitment data
     *
     * @param int $cid
     * @param int $bid
     */
    function __construct($cid, $bid)
    {
        $this->bk       = $bid;
        $this->class    = $cid;
    }

    /**
     * get starting equitment for given class
     *
     * @return object
     */
    protected function class()
    {
        if (is_numeric($this->class)) {
            $this->class = useful::unserializeCollection((new floatingModel('equitment_starting'))
                ->leftJoin('class_to_equitment', 'class_to_equitment.eid', '=', 'equitment_starting.id')
                ->where('class_to_equitment.cid', $this->class)
                ->get())[0];
        }
        return $this->class;
    }

    /**
     * get starting equitment for given background
     *
     * @return object
     */
    private function bk()
    {
        if (is_int($this->bk)) {
            $this->bk = useful::unserializeCollection((new floatingModel('equitment_starting'))
                ->leftJoin('background_to_equitment', 'background_to_equitment.eid', '=', 'equitment_starting.id')
                ->where('background_to_equitment.bid', $this->bk)
                ->get())[0];
        }
        return $this->bk;
    }

    /**
     * returns a list of equitment items that can be selected from
     *
     * @return array array( [
     *      'choose'    => int
     *      'from'      => [ 'name' => amount ]
     *  ] )
     */
    public function choice()
    {
        $ret = [];
        foreach($this->class()->optional as $c){
            if (count($c['from'])>0){
                $ret[] = $c;
            }
        }
        return $ret;
    }

    /**
     * returns the set eqiutment for given class and background
     *
     * @return array
     */
    public function set()
    {
        return array_merge($this->setClass(), $this->setBK());
    }

    /**
     * returns the eqiutment for given class
     *
     * @return array
     */
    private function setClass()
    {
        return $this->getSetList($this->class());
    }

    /**
     * returns the eqiutment for given background
     *
     * @return array
     */
    private function setBK()
    {
        return $this->getSetList($this->bk());
    }

    /**
     * converts given data into list of given equitement
     *
     * @param mixed $data
     * @return array
     */
    private function getSetList($data)
    {
        $list = [];
        foreach ($this->feilds as $f) {
            if ($data->{$f} != NULL && is_array($data->{$f})) {
                foreach ($data->{$f} as $foo => $bar) {
                    if (isset($list[$foo])) {
                        $list[$foo] = $list[$foo] + $bar;
                    } else {
                        $list[$foo] = $bar;
                    }
                }
            }
        }
        return $list;
    }

}
