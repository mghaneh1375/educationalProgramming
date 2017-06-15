<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface{

    protected $table = 'user';
    public $timestamps = false;

    use UserTrait, RemindableTrait;

    public function student() {
        return $this->belongsTo('Student', 'id', 'id');
    }

    public function adviser() {
        return $this->belongsTo('Adviser', 'id', 'id');
    }

    protected $hidden = array('password', 'remember_token');

}