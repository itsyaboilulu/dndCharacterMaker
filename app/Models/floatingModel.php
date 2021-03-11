<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * used a a tabless model to reduce need for a model for every database table and reduce size of project
 *
 * @param string $table table want to be accessed
 */
class floatingModel extends Model
{
    public $timestamps = false;
    protected $table;

    /**
     * used a a tabless model to reduce need for a model for every database table and reduce size of project
     *
     * @param string $table table want to be accessed
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->setTable($table);
        parent::__construct();
    }
}
