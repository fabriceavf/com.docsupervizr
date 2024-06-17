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





















class Terminal extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\TerminalObservers') &&
method_exists('\App\Observers\TerminalObservers', 'creating')
){

try {
\App\Observers\TerminalObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\TerminalObservers') &&
method_exists('\App\Observers\TerminalObservers', 'created')
){

try {
\App\Observers\TerminalObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\TerminalObservers') &&
method_exists('\App\Observers\TerminalObservers', 'updating')
){

try {
\App\Observers\TerminalObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\TerminalObservers') &&
method_exists('\App\Observers\TerminalObservers', 'updated')
){

try {
\App\Observers\TerminalObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\TerminalObservers') &&
method_exists('\App\Observers\TerminalObservers', 'deleting')
){

try {
\App\Observers\TerminalObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\TerminalObservers') &&
method_exists('\App\Observers\TerminalObservers', 'deleted')
){

try {
\App\Observers\TerminalObservers::deleted($model);

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
$this->table = 'terminals';
}
protected $fillable = [
    'id' ,
    'code' ,
    'adresse_mac' ,
    'etat' ,
    'alimentation' ,
    'reseau' ,
    'voiture_id' ,
    'creat_by' ,
    'created_at' ,
    'updated_at' ,
    'extra_attributes' ,
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








    


    

            public function getAdresseMacAttribute($value)
            {
            return $value;
            }
            public function setAdresseMacAttribute($value)
            {
            $this->attributes['adresse_mac'] = $value ?? "";
            }








    


    

            public function getEtatAttribute($value)
            {
            return $value;
            }
            public function setEtatAttribute($value)
            {
            $this->attributes['etat'] = $value ?? "";
            }








    


    

            public function getAlimentationAttribute($value)
            {
            return $value;
            }
            public function setAlimentationAttribute($value)
            {
            $this->attributes['alimentation'] = $value ?? "";
            }








    


    

            public function getReseauAttribute($value)
            {
            return $value;
            }
            public function setReseauAttribute($value)
            {
            $this->attributes['reseau'] = $value ?? "";
            }








    


    

            public function getVoitureIdAttribute($value)
            {
            return $value;
            }
            public function setVoitureIdAttribute($value)
            {
            $this->attributes['voiture_id'] = $value ?? "";
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

    
        

    
                    $select.="".$this->code ." ";
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
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

