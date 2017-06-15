<?php

use Illuminate\Database\Eloquent\Model;

class Degree extends Model {

    protected $table = 'degree';
    public $timestamps = false;

    public function lessons() {
        return $this->hasMany('Lesson', 'did', 'id');
    }

}