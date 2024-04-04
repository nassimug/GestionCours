<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = ['mdp'];

    protected $fillable = ['id', 'nom', 'prenom','login','mdp', 'formation_id','type'];

    protected $attributes = [
        'type' => 'user'
    ];


    public function getAuthPassword(){
        return $this->mdp;
    }

    public function cours(){
        return $this->belongsToMany(Cours::class, 'cours_users', 'user_id', 'cours_id');

    }
     public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function isAdmin(){
        return $this->type =='admin';
    }

    public function isEtudiant(){
        return $this->type =='etudiant' || $this->type =='admin';
    }

    public function isEnseignant() {
        return $this->type =='enseignant' || $this->type =='admin';
    }
 


}
