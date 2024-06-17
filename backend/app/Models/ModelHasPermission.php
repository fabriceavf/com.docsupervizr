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

















    
        use App\Models\Permission;

    



class ModelHasPermission extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\Model_has_permissionObservers') &&
method_exists('\App\Observers\Model_has_permissionObservers', 'creating')
){

try {
\App\Observers\Model_has_permissionObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\Model_has_permissionObservers') &&
method_exists('\App\Observers\Model_has_permissionObservers', 'created')
){

try {
\App\Observers\Model_has_permissionObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\Model_has_permissionObservers') &&
method_exists('\App\Observers\Model_has_permissionObservers', 'updating')
){

try {
\App\Observers\Model_has_permissionObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\Model_has_permissionObservers') &&
method_exists('\App\Observers\Model_has_permissionObservers', 'updated')
){

try {
\App\Observers\Model_has_permissionObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\Model_has_permissionObservers') &&
method_exists('\App\Observers\Model_has_permissionObservers', 'deleting')
){

try {
\App\Observers\Model_has_permissionObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\Model_has_permissionObservers') &&
method_exists('\App\Observers\Model_has_permissionObservers', 'deleted')
){

try {
\App\Observers\Model_has_permissionObservers::deleted($model);

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

protected $primaryKey = 'model_id';

public function __construct(array $attributes = [])
{
parent::__construct($attributes);
$this->table = 'model_has_permissions';
}
protected $fillable = [
    'permission_id' ,
    'model_type' ,
    'model_id' ,
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














    

                    'permission',
        



    
    ];







            public function permission()
        {
        return $this->belongsTo(Permission::class,'permission_id','model_id');
        }
    















    

            public function getPermissionIdAttribute($value)
            {
            return $value;
            }
            public function setPermissionIdAttribute($value)
            {
            $this->attributes['permission_id'] = $value ?? "";
            }








    


    

            public function getModelTypeAttribute($value)
            {
            return $value;
            }
            public function setModelTypeAttribute($value)
            {
            $this->attributes['model_type'] = $value ?? "";
            }








    


    

            public function getModelIdAttribute($value)
            {
            return $value;
            }
            public function setModelIdAttribute($value)
            {
            $this->attributes['model_id'] = $value ?? "";
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

