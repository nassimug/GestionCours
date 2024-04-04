<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    protected $table = 'plannings';

    public $timestamps = false;

    protected $fillable = ['id','cours_id', 'date_debut', 'date_fin'];

    public function cours(){
        return $this->belongsTo(Cours::class);
    }
    




}
