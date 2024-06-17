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





















class Joursferie extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\JoursferieObservers') &&
method_exists('\App\Observers\JoursferieObservers', 'creating')
){

try {
\App\Observers\JoursferieObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\JoursferieObservers') &&
method_exists('\App\Observers\JoursferieObservers', 'created')
){

try {
\App\Observers\JoursferieObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\JoursferieObservers') &&
method_exists('\App\Observers\JoursferieObservers', 'updating')
){

try {
\App\Observers\JoursferieObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\JoursferieObservers') &&
method_exists('\App\Observers\JoursferieObservers', 'updated')
){

try {
\App\Observers\JoursferieObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\JoursferieObservers') &&
method_exists('\App\Observers\JoursferieObservers', 'deleting')
){

try {
\App\Observers\JoursferieObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\JoursferieObservers') &&
method_exists('\App\Observers\JoursferieObservers', 'deleted')
){

try {
\App\Observers\JoursferieObservers::deleted($model);

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
$this->table = 'joursferies';
}
protected $fillable = [
    'id' ,
    'raison' ,
    'debut' ,
    'fin' ,
    'etats' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'identifiants_sadge' ,
    'creat_by' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    
    ];
















    


    

            public function getRaisonAttribute($value)
            {
            return $value;
            }
            public function setRaisonAttribute($value)
            {
            $this->attributes['raison'] = $value ?? "";
            }








    


    

            public function getDebutAttribute($value)
            {
            return $value;
            }
            public function setDebutAttribute($value)
            {
            $this->attributes['debut'] = $value ?? "";
            }








    


    

            public function getFinAttribute($value)
            {
            return $value;
            }
            public function setFinAttribute($value)
            {
            $this->attributes['fin'] = $value ?? "";
            }








    


    

            public function getEtatsAttribute($value)
            {
            return $value;
            }
            public function setEtatsAttribute($value)
            {
            $this->attributes['etats'] = $value ?? "";
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

