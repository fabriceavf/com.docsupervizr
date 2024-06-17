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





















class Job extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\JobObservers') &&
method_exists('\App\Observers\JobObservers', 'creating')
){

try {
\App\Observers\JobObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\JobObservers') &&
method_exists('\App\Observers\JobObservers', 'created')
){

try {
\App\Observers\JobObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\JobObservers') &&
method_exists('\App\Observers\JobObservers', 'updating')
){

try {
\App\Observers\JobObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\JobObservers') &&
method_exists('\App\Observers\JobObservers', 'updated')
){

try {
\App\Observers\JobObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\JobObservers') &&
method_exists('\App\Observers\JobObservers', 'deleting')
){

try {
\App\Observers\JobObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\JobObservers') &&
method_exists('\App\Observers\JobObservers', 'deleted')
){

try {
\App\Observers\JobObservers::deleted($model);

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
$this->table = 'jobs';
}
protected $fillable = [
    'id' ,
    'queue' ,
    'payload' ,
    'attempts' ,
    'reserved_at' ,
    'available_at' ,
    'created_at' ,
    'extra_attributes' ,
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
















    


    

            public function getQueueAttribute($value)
            {
            return $value;
            }
            public function setQueueAttribute($value)
            {
            $this->attributes['queue'] = $value ?? "";
            }








    


    

            public function getPayloadAttribute($value)
            {
            return $value;
            }
            public function setPayloadAttribute($value)
            {
            $this->attributes['payload'] = $value ?? "";
            }








    


    

            public function getAttemptsAttribute($value)
            {
            return $value;
            }
            public function setAttemptsAttribute($value)
            {
            $this->attributes['attempts'] = $value ?? "";
            }








    


    

            public function getReservedAtAttribute($value)
            {
            return $value;
            }
            public function setReservedAtAttribute($value)
            {
            $this->attributes['reserved_at'] = $value ?? "";
            }








    


    

            public function getAvailableAtAttribute($value)
            {
            return $value;
            }
            public function setAvailableAtAttribute($value)
            {
            $this->attributes['available_at'] = $value ?? "";
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

