<?php

class Student extends Eloquent {

    protected $table = 'student';
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('User', 'id', 'id');
    }

}