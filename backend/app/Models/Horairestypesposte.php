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

















    
        use App\Models\Typesposte;

    



class Horairestypesposte extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\HorairestypesposteObservers') &&
method_exists('\App\Observers\HorairestypesposteObservers', 'creating')
){

try {
\App\Observers\HorairestypesposteObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\HorairestypesposteObservers') &&
method_exists('\App\Observers\HorairestypesposteObservers', 'created')
){

try {
\App\Observers\HorairestypesposteObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\HorairestypesposteObservers') &&
method_exists('\App\Observers\HorairestypesposteObservers', 'updating')
){

try {
\App\Observers\HorairestypesposteObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\HorairestypesposteObservers') &&
method_exists('\App\Observers\HorairestypesposteObservers', 'updated')
){

try {
\App\Observers\HorairestypesposteObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\HorairestypesposteObservers') &&
method_exists('\App\Observers\HorairestypesposteObservers', 'deleting')
){

try {
\App\Observers\HorairestypesposteObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\HorairestypesposteObservers') &&
method_exists('\App\Observers\HorairestypesposteObservers', 'deleted')
){

try {
\App\Observers\HorairestypesposteObservers::deleted($model);

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
$this->table = 'horairestypespostes';
}
protected $fillable = [
    'id' ,
    'libelle' ,
    'debut' ,
    'fin' ,
    'typesposte_id' ,
    'creat_by' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'ordre' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'typesposte',
        



    
    ];







            public function typesposte()
        {
        return $this->belongsTo(Typesposte::class,'typesposte_id','id');
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








    


    

            public function getTypesposteIdAttribute($value)
            {
            return $value;
            }
            public function setTypesposteIdAttribute($value)
            {
            $this->attributes['typesposte_id'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getOrdreAttribute($value)
            {
            return $value;
            }
            public function setOrdreAttribute($value)
            {
            $this->attributes['ordre'] = $value ?? "";
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

