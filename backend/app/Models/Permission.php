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

















    
        use App\Models\Groupepermission;

        
        use App\Models\ModelHasPermission;

        
        use App\Models\Perm;

        
        use App\Models\RoleHasPermission;

    



class Permission extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;





public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\PermissionObservers') &&
method_exists('\App\Observers\PermissionObservers', 'creating')
){

try {
\App\Observers\PermissionObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\PermissionObservers') &&
method_exists('\App\Observers\PermissionObservers', 'created')
){

try {
\App\Observers\PermissionObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\PermissionObservers') &&
method_exists('\App\Observers\PermissionObservers', 'updating')
){

try {
\App\Observers\PermissionObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\PermissionObservers') &&
method_exists('\App\Observers\PermissionObservers', 'updated')
){

try {
\App\Observers\PermissionObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\PermissionObservers') &&
method_exists('\App\Observers\PermissionObservers', 'deleting')
){

try {
\App\Observers\PermissionObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\PermissionObservers') &&
method_exists('\App\Observers\PermissionObservers', 'deleted')
){

try {
\App\Observers\PermissionObservers::deleted($model);

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
$this->table = 'permissions';
}
protected $fillable = [
    'id' ,
    'name' ,
    'guard_name' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'extra_attributes' ,
    'type' ,
    'nom' ,
    'visible' ,
    'groupepermission_id' ,
    'identifiants_sadge' ,
    'creat_by' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'groupepermission',
        



    
    ];







            public function groupepermission()
        {
        return $this->belongsTo(Groupepermission::class,'groupepermission_id','id');
        }
    








            public function model_has_permissions()
        {
        return $this->hasMany(ModelHasPermission::class,'permission_id','id');
        }
    






            public function perms()
        {
        return $this->hasMany(Perm::class,'permission_id','id');
        }
    






            public function role_has_permissions()
        {
        return $this->hasMany(RoleHasPermission::class,'permission_id','id');
        }
    













    


    

            public function getNameAttribute($value)
            {
            return $value;
            }
            public function setNameAttribute($value)
            {
            $this->attributes['name'] = $value ?? "";
            }








    


    

            public function getGuardNameAttribute($value)
            {
            return $value;
            }
            public function setGuardNameAttribute($value)
            {
            $this->attributes['guard_name'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getTypeAttribute($value)
            {
            return $value;
            }
            public function setTypeAttribute($value)
            {
            $this->attributes['type'] = $value ?? "";
            }








    


    

            public function getNomAttribute($value)
            {
            return $value;
            }
            public function setNomAttribute($value)
            {
            $this->attributes['nom'] = $value ?? "";
            }








    


    

            public function getVisibleAttribute($value)
            {
            return $value;
            }
            public function setVisibleAttribute($value)
            {
            $this->attributes['visible'] = $value ?? "";
            }








    


    

            public function getGroupepermissionIdAttribute($value)
            {
            return $value;
            }
            public function setGroupepermissionIdAttribute($value)
            {
            $this->attributes['groupepermission_id'] = $value ?? "";
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
    
        
            $select=" ".$this->id;
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
    return trim($select);

}
public function getSelectlabelAttribute()
{
    $select="";
    try{
    $select =$this->libelle;
    }catch (\Throwable $e){

    }

    
        

    
                    $select.="".$this->name ." ";
        

    
                    $select.="".$this->guard_name ." ";
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
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

