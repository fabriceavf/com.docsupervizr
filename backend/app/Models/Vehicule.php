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





















class Vehicule extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\VehiculeObservers') &&
method_exists('\App\Observers\VehiculeObservers', 'creating')
){

try {
\App\Observers\VehiculeObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\VehiculeObservers') &&
method_exists('\App\Observers\VehiculeObservers', 'created')
){

try {
\App\Observers\VehiculeObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\VehiculeObservers') &&
method_exists('\App\Observers\VehiculeObservers', 'updating')
){

try {
\App\Observers\VehiculeObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\VehiculeObservers') &&
method_exists('\App\Observers\VehiculeObservers', 'updated')
){

try {
\App\Observers\VehiculeObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\VehiculeObservers') &&
method_exists('\App\Observers\VehiculeObservers', 'deleting')
){

try {
\App\Observers\VehiculeObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\VehiculeObservers') &&
method_exists('\App\Observers\VehiculeObservers', 'deleted')
){

try {
\App\Observers\VehiculeObservers::deleted($model);

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
$this->table = 'vehicules';
}
protected $fillable = [
    'id' ,
    'code' ,
    'type' ,
    'marque' ,
    'modele' ,
    'generation' ,
    'serie' ,
    'valeur' ,
    'moteur' ,
    'poids' ,
    'creat_by' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    
    ];
















    


    

            public function getCodeAttribute($value)
            {
            return $value;
            }
            public function setCodeAttribute($value)
            {
            $this->attributes['code'] = $value ?? "";
            }








    


    

            public function getTypeAttribute($value)
            {
            return $value;
            }
            public function setTypeAttribute($value)
            {
            $this->attributes['type'] = $value ?? "";
            }








    


    

            public function getMarqueAttribute($value)
            {
            return $value;
            }
            public function setMarqueAttribute($value)
            {
            $this->attributes['marque'] = $value ?? "";
            }








    


    

            public function getModeleAttribute($value)
            {
            return $value;
            }
            public function setModeleAttribute($value)
            {
            $this->attributes['modele'] = $value ?? "";
            }








    


    

            public function getGenerationAttribute($value)
            {
            return $value;
            }
            public function setGenerationAttribute($value)
            {
            $this->attributes['generation'] = $value ?? "";
            }








    


    

            public function getSerieAttribute($value)
            {
            return $value;
            }
            public function setSerieAttribute($value)
            {
            $this->attributes['serie'] = $value ?? "";
            }








    


    

            public function getValeurAttribute($value)
            {
            return $value;
            }
            public function setValeurAttribute($value)
            {
            $this->attributes['valeur'] = $value ?? "";
            }








    


    

            public function getMoteurAttribute($value)
            {
            return $value;
            }
            public function setMoteurAttribute($value)
            {
            $this->attributes['moteur'] = $value ?? "";
            }








    


    

            public function getPoidsAttribute($value)
            {
            return $value;
            }
            public function setPoidsAttribute($value)
            {
            $this->attributes['poids'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getIdentifiantsSadgeAttribute($value)
            {
            return $value;
            }
            public function setIdentifiantsSadgeAttribute($value)
            {
            $this->attributes['identifiants_sadge'] = $value ?? "";
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

