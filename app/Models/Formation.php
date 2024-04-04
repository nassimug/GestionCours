<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $table = 'formations';

    public $timestamps = false;

    protected $fillable = ['id','intitule', 'created_at', 'updated_at'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function cours(){
        return $this->hasMany(Cours::class);
    }
}
