<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

















    
        use App\Models\User;

    



class Surveillance extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\SurveillanceObservers') &&
method_exists('\App\Observers\SurveillanceObservers', 'creating')
){

try {
\App\Observers\SurveillanceObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\SurveillanceObservers') &&
method_exists('\App\Observers\SurveillanceObservers', 'created')
){

try {
\App\Observers\SurveillanceObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\SurveillanceObservers') &&
method_exists('\App\Observers\SurveillanceObservers', 'updating')
){

try {
\App\Observers\SurveillanceObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\SurveillanceObservers') &&
method_exists('\App\Observers\SurveillanceObservers', 'updated')
){

try {
\App\Observers\SurveillanceObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\SurveillanceObservers') &&
method_exists('\App\Observers\SurveillanceObservers', 'deleting')
){

try {
\App\Observers\SurveillanceObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\SurveillanceObservers') &&
method_exists('\App\Observers\SurveillanceObservers', 'deleted')
){

try {
\App\Observers\SurveillanceObservers::deleted($model);

} catch (\Throwable $e) {

}
}
});
}

/**
* The primary key associated with the table.
*
* @var string
*/

protected $primaryKey = 'id';

public function __construct(array $attributes = [])
{
parent::__construct($attributes);
$this->table = 'surveillances';
}
protected $fillable = [
    'id' ,
    'action' ,
    'entite' ,
    'entite_cle' ,
    'ancien' ,
    'nouveau' ,
    'user_id' ,
    'ip' ,
    'details' ,
    'navigateur' ,
    'pays' ,
    'ville' ,
    'id_base' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'extra_attributes' ,
    'identifiants_sadge' ,
    'creat_by' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'user',
        



    
    ];







            public function user()
        {
        return $this->belongsTo(User::class,'user_id','id');
        }
    















    


    

            public function getActionAttribute($value)
            {
            return $value;
            }
            public function setActionAttribute($value)
            {
            $this->attributes['action'] = $value ?? "";
            }








    


    

            public function getEntiteAttribute($value)
            {
            return $value;
            }
            public function setEntiteAttribute($value)
            {
            $this->attributes['entite'] = $value ?? "";
            }








    


    

            public function getEntiteCleAttribute($value)
            {
            return $value;
            }
            public function setEntiteCleAttribute($value)
            {
            $this->attributes['entite_cle'] = $value ?? "";
            }








    


    

            public function getAncienAttribute($value)
            {
            return $value;
            }
            public function setAncienAttribute($value)
            {
            $this->attributes['ancien'] = $value ?? "";
            }








    


    

            public function getNouveauAttribute($value)
            {
            return $value;
            }
            public function setNouveauAttribute($value)
            {
            $this->attributes['nouveau'] = $value ?? "";
            }








    


    


    

            public function getIpAttribute($value)
            {
            return $value;
            }
            public function setIpAttribute($value)
            {
            $this->attributes['ip'] = $value ?? "";
            }








    


    

            public function getDetailsAttribute($value)
            {
            return $value;
            }
            public function setDetailsAttribute($value)
            {
            $this->attributes['details'] = $value ?? "";
            }








    


    

            public function getNavigateurAttribute($value)
            {
            return $value;
            }
            public function setNavigateurAttribute($value)
            {
            $this->attributes['navigateur'] = $value ?? "";
            }








    


    

            public function getPaysAttribute($value)
            {
            return $value;
            }
            public function setPaysAttribute($value)
            {
            $this->attributes['pays'] = $value ?? "";
            }








    


    

            public function getVilleAttribute($value)
            {
            return $value;
            }
            public function setVilleAttribute($value)
            {
            $this->attributes['ville'] = $value ?? "";
            }








    


    

            public function getIdBaseAttribute($value)
            {
            return $value;
            }
            public function setIdBaseAttribute($value)
            {
            $this->attributes['id_base'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getIdentifiantsSadgeAttribute($value)
            {
            return $value;
            }
            public function setIdentifiantsSadgeAttribute($value)
            {
            $this->attributes['identifiants_sadge'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
            }








    



public function getSelectvalueAttribute()
{
    $select="";
    try{
    $select =$this->id;
    }catch (\Throwable $e){

    }
    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
    return trim($select);

}
public function getSelectlabelAttribute()
{
    $select="";
    try{
    $select =$this->libelle;
    }catch (\Throwable $e){

    }

    
        

    
                    $select.="".$this->action ." ";
        

    
                    $select.="".$this->entite ." ";
        

    
        

    
        

    
        

    
        

    
                    $select.="".$this->ip ." ";
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
    return trim($select);



}


protected $appends = [
'Selectvalue','Selectlabel'
];

protected $schemalessAttributes = [
'extra_attributes',
'other_extra_attributes',
];

public function scopeWithExtraAttributes(): Builder
{
return $this->extra_attributes->modelScope();
}

public function scopeWithOtherExtraAttributes(): Builder
{
return $this->other_extra_attributes->modelScope();
}



}

