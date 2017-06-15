<?php

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model{

    protected $table = 'lesson';
    public $timestamps = false;

    public function degree() {
        return $this->belongsTo('Degree', 'did', 'id');
    }

    public function subjects() {
        return $this->hasMany('Subject', 'lId', 'id');
    }

}