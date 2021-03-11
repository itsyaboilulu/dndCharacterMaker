<?php

namespace App\Models;

use DateTime;

/**
 * store of useful static functions i dont have a place for
 */
class useful
{
    /**
     * returns unserialize $data, check if $data can be unserialized, if not return $str
     *
     * @param string $str
     * @return mixed
     */
    public static function unserialize($str)
    {
        return (@unserialize($str)) ? unserialize($str) : $str;
    }


    /**
     * remaps collection data to unserialize any serialized data
     *
     * @param object $model
     * @return object
     */
    public static function unserializeCollection($model)
    {
        return $model->map(function ($i) {
            foreach ($i->getAttributes() as $key => $value) {
                $i->$key = useful::unserialize( $value );
            }
            return $i;
        });
    }

    /**
     * decode stringified object into array
     *
     * @param string $str
     * @return array
     */
    public static function decodeStringafy($str){
        return json_decode(urldecode($str),true);
    }

}
