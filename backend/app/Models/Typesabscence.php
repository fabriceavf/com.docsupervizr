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

















    
        use App\Models\Soldable;

        
        use App\Models\Variable;

        
        use App\Models\Abscence;

    



class Typesabscence extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\TypesabscenceObservers') &&
method_exists('\App\Observers\TypesabscenceObservers', 'creating')
){

try {
\App\Observers\TypesabscenceObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\TypesabscenceObservers') &&
method_exists('\App\Observers\TypesabscenceObservers', 'created')
){

try {
\App\Observers\TypesabscenceObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\TypesabscenceObservers') &&
method_exists('\App\Observers\TypesabscenceObservers', 'updating')
){

try {
\App\Observers\TypesabscenceObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\TypesabscenceObservers') &&
method_exists('\App\Observers\TypesabscenceObservers', 'updated')
){

try {
\App\Observers\TypesabscenceObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\TypesabscenceObservers') &&
method_exists('\App\Observers\TypesabscenceObservers', 'deleting')
){

try {
\App\Observers\TypesabscenceObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\TypesabscenceObservers') &&
method_exists('\App\Observers\TypesabscenceObservers', 'deleted')
){

try {
\App\Observers\TypesabscenceObservers::deleted($model);

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
$this->table = 'typesabscences';
}
protected $fillable = [
    'id' ,
    'libelle' ,
    'soldable_id' ,
    'variable_id' ,
    'nombrejours' ,
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














    

                    'soldable',
        



    

                    'variable',
        



    
    ];







            public function soldable()
        {
        return $this->belongsTo(Soldable::class,'soldable_id','id');
        }
    






            public function variable()
        {
        return $this->belongsTo(Variable::class,'variable_id','id');
        }
    








            public function abscences()
        {
        return $this->hasMany(Abscence::class,'typesabscence_id','id');
        }
    













    


    

            public function getLibelleAttribute($value)
            {
            return $value;
            }
            public function setLibelleAttribute($value)
            {
            $this->attributes['libelle'] = $value ?? "";
            }








    


    

            public function getSoldableIdAttribute($value)
            {
            return $value;
            }
            public function setSoldableIdAttribute($value)
            {
            $this->attributes['soldable_id'] = $value ?? "";
            }








    


    

            public function getVariableIdAttribute($value)
            {
            return $value;
            }
            public function setVariableIdAttribute($value)
            {
            $this->attributes['variable_id'] = $value ?? "";
            }








    


    

            public function getNombrejoursAttribute($value)
            {
            return $value;
            }
            public function setNombrejoursAttribute($value)
            {
            $this->attributes['nombrejours'] = $value ?? "";
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

