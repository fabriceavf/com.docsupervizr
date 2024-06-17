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

















    
        use App\Models\Horairestypessite;

        
        use App\Models\Site;

    



class Typessite extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\TypessiteObservers') &&
method_exists('\App\Observers\TypessiteObservers', 'creating')
){

try {
\App\Observers\TypessiteObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\TypessiteObservers') &&
method_exists('\App\Observers\TypessiteObservers', 'created')
){

try {
\App\Observers\TypessiteObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\TypessiteObservers') &&
method_exists('\App\Observers\TypessiteObservers', 'updating')
){

try {
\App\Observers\TypessiteObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\TypessiteObservers') &&
method_exists('\App\Observers\TypessiteObservers', 'updated')
){

try {
\App\Observers\TypessiteObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\TypessiteObservers') &&
method_exists('\App\Observers\TypessiteObservers', 'deleting')
){

try {
\App\Observers\TypessiteObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\TypessiteObservers') &&
method_exists('\App\Observers\TypessiteObservers', 'deleted')
){

try {
\App\Observers\TypessiteObservers::deleted($model);

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
$this->table = 'typessites';
}
protected $fillable = [
    'id' ,
    'code' ,
    'libelle' ,
    'creat_by' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'canCreate' ,
    'canUpdate' ,
    'canDelete' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    
    ];









            public function horairestypessites()
        {
        return $this->hasMany(Horairestypessite::class,'typessite_id','id');
        }
    






            public function sites()
        {
        return $this->hasMany(Site::class,'typessite_id','id');
        }
    













    


    

            public function getCodeAttribute($value)
            {
            return $value;
            }
            public function setCodeAttribute($value)
            {
            $this->attributes['code'] = $value ?? "";
            }








    


    

            public function getLibelleAttribute($value)
            {
            return $value;
            }
            public function setLibelleAttribute($value)
            {
            $this->attributes['libelle'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getCanCreateAttribute($value)
            {
            return $value;
            }
            public function setCanCreateAttribute($value)
            {
            $this->attributes['canCreate'] = $value ?? "";
            }








    


    

            public function getCanUpdateAttribute($value)
            {
            return $value;
            }
            public function setCanUpdateAttribute($value)
            {
            $this->attributes['canUpdate'] = $value ?? "";
            }








    


    

            public function getCanDeleteAttribute($value)
            {
            return $value;
            }
            public function setCanDeleteAttribute($value)
            {
            $this->attributes['canDelete'] = $value ?? "";
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

