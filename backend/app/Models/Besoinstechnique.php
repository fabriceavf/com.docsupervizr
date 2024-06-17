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





















class Besoinstechnique extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\BesoinstechniqueObservers') &&
method_exists('\App\Observers\BesoinstechniqueObservers', 'creating')
){

try {
\App\Observers\BesoinstechniqueObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\BesoinstechniqueObservers') &&
method_exists('\App\Observers\BesoinstechniqueObservers', 'created')
){

try {
\App\Observers\BesoinstechniqueObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\BesoinstechniqueObservers') &&
method_exists('\App\Observers\BesoinstechniqueObservers', 'updating')
){

try {
\App\Observers\BesoinstechniqueObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\BesoinstechniqueObservers') &&
method_exists('\App\Observers\BesoinstechniqueObservers', 'updated')
){

try {
\App\Observers\BesoinstechniqueObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\BesoinstechniqueObservers') &&
method_exists('\App\Observers\BesoinstechniqueObservers', 'deleting')
){

try {
\App\Observers\BesoinstechniqueObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\BesoinstechniqueObservers') &&
method_exists('\App\Observers\BesoinstechniqueObservers', 'deleted')
){

try {
\App\Observers\BesoinstechniqueObservers::deleted($model);

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
$this->table = 'besoinstechniques';
}
protected $fillable = [
    'id' ,
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














    
    ];
















    


    


    


    


    


    

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

