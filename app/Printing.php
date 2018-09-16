<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printing extends Model
{
    protected $table = "printings";
    protected $fillable = ["folder"];
    public static $discPathName = "prints";


    public function user(){
        return $this->belongsTo("App\User", "user_id", "id");
    }
}
