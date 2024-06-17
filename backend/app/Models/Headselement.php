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

















    
        use App\Models\Entreprise;

    



class Headselement extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\HeadselementObservers') &&
method_exists('\App\Observers\HeadselementObservers', 'creating')
){

try {
\App\Observers\HeadselementObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\HeadselementObservers') &&
method_exists('\App\Observers\HeadselementObservers', 'created')
){

try {
\App\Observers\HeadselementObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\HeadselementObservers') &&
method_exists('\App\Observers\HeadselementObservers', 'updating')
){

try {
\App\Observers\HeadselementObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\HeadselementObservers') &&
method_exists('\App\Observers\HeadselementObservers', 'updated')
){

try {
\App\Observers\HeadselementObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\HeadselementObservers') &&
method_exists('\App\Observers\HeadselementObservers', 'deleting')
){

try {
\App\Observers\HeadselementObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\HeadselementObservers') &&
method_exists('\App\Observers\HeadselementObservers', 'deleted')
){

try {
\App\Observers\HeadselementObservers::deleted($model);

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
$this->table = 'headselements';
}
protected $fillable = [
    'id' ,
    'cle' ,
    'valeur' ,
    'entreprise_id' ,
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














    

                    'entreprise',
        



    
    ];







            public function entreprise()
        {
        return $this->belongsTo(Entreprise::class,'entreprise_id','id');
        }
    















    


    

            public function getCleAttribute($value)
            {
            return $value;
            }
            public function setCleAttribute($value)
            {
            $this->attributes['cle'] = $value ?? "";
            }








    


    

            public function getValeurAttribute($value)
            {
            return $value;
            }
            public function setValeurAttribute($value)
            {
            $this->attributes['valeur'] = $value ?? "";
            }








    


    

            public function getEntrepriseIdAttribute($value)
            {
            return $value;
            }
            public function setEntrepriseIdAttribute($value)
            {
            $this->attributes['entreprise_id'] = $value ?? "";
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

