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





















class Login extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\LoginObservers') &&
method_exists('\App\Observers\LoginObservers', 'creating')
){

try {
\App\Observers\LoginObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\LoginObservers') &&
method_exists('\App\Observers\LoginObservers', 'created')
){

try {
\App\Observers\LoginObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\LoginObservers') &&
method_exists('\App\Observers\LoginObservers', 'updating')
){

try {
\App\Observers\LoginObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\LoginObservers') &&
method_exists('\App\Observers\LoginObservers', 'updated')
){

try {
\App\Observers\LoginObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\LoginObservers') &&
method_exists('\App\Observers\LoginObservers', 'deleting')
){

try {
\App\Observers\LoginObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\LoginObservers') &&
method_exists('\App\Observers\LoginObservers', 'deleted')
){

try {
\App\Observers\LoginObservers::deleted($model);

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
$this->table = 'logins';
}
protected $fillable = [
    'id' ,
    'email' ,
    'password' ,
    'etat' ,
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
















    


    

            public function getEmailAttribute($value)
            {
            return $value;
            }
            public function setEmailAttribute($value)
            {
            $this->attributes['email'] = $value ?? "";
            }








    


    

            public function getPasswordAttribute($value)
            {
            return $value;
            }
            public function setPasswordAttribute($value)
            {
            $this->attributes['password'] = $value ?? "";
            }








    


    

            public function getEtatAttribute($value)
            {
            return $value;
            }
            public function setEtatAttribute($value)
            {
            $this->attributes['etat'] = $value ?? "";
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

