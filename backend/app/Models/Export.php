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

















    
        use App\Models\Exportsdetail;

    



class Export extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\ExportObservers') &&
method_exists('\App\Observers\ExportObservers', 'creating')
){

try {
\App\Observers\ExportObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\ExportObservers') &&
method_exists('\App\Observers\ExportObservers', 'created')
){

try {
\App\Observers\ExportObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\ExportObservers') &&
method_exists('\App\Observers\ExportObservers', 'updating')
){

try {
\App\Observers\ExportObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\ExportObservers') &&
method_exists('\App\Observers\ExportObservers', 'updated')
){

try {
\App\Observers\ExportObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\ExportObservers') &&
method_exists('\App\Observers\ExportObservers', 'deleting')
){

try {
\App\Observers\ExportObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\ExportObservers') &&
method_exists('\App\Observers\ExportObservers', 'deleted')
){

try {
\App\Observers\ExportObservers::deleted($model);

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
$this->table = 'exports';
}
protected $fillable = [
    'id' ,
    'code' ,
    'libelle' ,
    'lien' ,
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









            public function exportsdetails()
        {
        return $this->hasMany(Exportsdetail::class,'export_id','id');
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








    


    

            public function getLienAttribute($value)
            {
            return $value;
            }
            public function setLienAttribute($value)
            {
            $this->attributes['lien'] = $value ?? "";
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

