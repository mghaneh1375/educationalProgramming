<?php

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {

    protected $table = 'subject';
    public $timestamps = false;

    public function lesson() {
        return $this->belongsTo('Degree', 'lId', 'id');
    }

}