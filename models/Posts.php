<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Posts extends Model {
 
 
    protected $table = 'eititan_feed';
    public $timestamps = false;
    protected $fillable = [
        'username',
        'post_message',
        'posted_on',
    ];
}