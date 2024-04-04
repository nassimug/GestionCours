<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;


    protected $table = 'cours';

    public $timestamps = false;

    protected $fillable = ['id','intitule', 'user_id','formation_id','created_at', 'updated_at'];

    public function users(){
        return $this->belongsToMany(User::class, 'cours_users', 'cours_id', 'user_id');
    }
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function plannings(){
        return $this->hasMany(Planning::class);
    }
   public function isUserEnrolled($user_id){
    return $this->users()->where('user_id', $user_id)->exists();
    }
 



}
