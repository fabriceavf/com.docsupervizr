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

















    
        use App\Models\Typessite;

    



class Horairestypessite extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\HorairestypessiteObservers') &&
method_exists('\App\Observers\HorairestypessiteObservers', 'creating')
){

try {
\App\Observers\HorairestypessiteObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\HorairestypessiteObservers') &&
method_exists('\App\Observers\HorairestypessiteObservers', 'created')
){

try {
\App\Observers\HorairestypessiteObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\HorairestypessiteObservers') &&
method_exists('\App\Observers\HorairestypessiteObservers', 'updating')
){

try {
\App\Observers\HorairestypessiteObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\HorairestypessiteObservers') &&
method_exists('\App\Observers\HorairestypessiteObservers', 'updated')
){

try {
\App\Observers\HorairestypessiteObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\HorairestypessiteObservers') &&
method_exists('\App\Observers\HorairestypessiteObservers', 'deleting')
){

try {
\App\Observers\HorairestypessiteObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\HorairestypessiteObservers') &&
method_exists('\App\Observers\HorairestypessiteObservers', 'deleted')
){

try {
\App\Observers\HorairestypessiteObservers::deleted($model);

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
$this->table = 'horairestypessites';
}
protected $fillable = [
    'id' ,
    'libelle' ,
    'debut' ,
    'fin' ,
    'typessite_id' ,
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














    

                    'typessite',
        



    
    ];







            public function typessite()
        {
        return $this->belongsTo(Typessite::class,'typessite_id','id');
        }
    















    


    

            public function getLibelleAttribute($value)
            {
            return $value;
            }
            public function setLibelleAttribute($value)
            {
            $this->attributes['libelle'] = $value ?? "";
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








    


    

            public function getTypessiteIdAttribute($value)
            {
            return $value;
            }
            public function setTypessiteIdAttribute($value)
            {
            $this->attributes['typessite_id'] = $value ?? "";
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

