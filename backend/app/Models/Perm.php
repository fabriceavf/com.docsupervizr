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

        
        use App\Models\User;

    



class Perm extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\PermObservers') &&
method_exists('\App\Observers\PermObservers', 'creating')
){

try {
\App\Observers\PermObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\PermObservers') &&
method_exists('\App\Observers\PermObservers', 'created')
){

try {
\App\Observers\PermObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\PermObservers') &&
method_exists('\App\Observers\PermObservers', 'updating')
){

try {
\App\Observers\PermObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\PermObservers') &&
method_exists('\App\Observers\PermObservers', 'updated')
){

try {
\App\Observers\PermObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\PermObservers') &&
method_exists('\App\Observers\PermObservers', 'deleting')
){

try {
\App\Observers\PermObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\PermObservers') &&
method_exists('\App\Observers\PermObservers', 'deleted')
){

try {
\App\Observers\PermObservers::deleted($model);

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

protected $primaryKey = '';

public function __construct(array $attributes = [])
{
parent::__construct($attributes);
$this->table = 'perms';
}
protected $fillable = [
    'id' ,
    'permission_label' ,
    'permission_nom' ,
    'permission_id' ,
    'updated_at' ,
    'user_id' ,
    'nom' ,
    'prenom' ,
    'type' ,
    'deleted_at' ,
    'created_at' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'permission',
        



    

                    'user',
        



    
    ];







            public function permission()
        {
        return $this->belongsTo(Permission::class,'permission_id','');
        }
    






            public function user()
        {
        return $this->belongsTo(User::class,'user_id','');
        }
    















    


    

            public function getPermissionLabelAttribute($value)
            {
            return $value;
            }
            public function setPermissionLabelAttribute($value)
            {
            $this->attributes['permission_label'] = $value ?? "";
            }








    


    

            public function getPermissionNomAttribute($value)
            {
            return $value;
            }
            public function setPermissionNomAttribute($value)
            {
            $this->attributes['permission_nom'] = $value ?? "";
            }








    


    

            public function getPermissionIdAttribute($value)
            {
            return $value;
            }
            public function setPermissionIdAttribute($value)
            {
            $this->attributes['permission_id'] = $value ?? "";
            }








    


    


    


    

            public function getNomAttribute($value)
            {
            return $value;
            }
            public function setNomAttribute($value)
            {
            $this->attributes['nom'] = $value ?? "";
            }








    


    

            public function getPrenomAttribute($value)
            {
            return $value;
            }
            public function setPrenomAttribute($value)
            {
            $this->attributes['prenom'] = $value ?? "";
            }








    


    

            public function getTypeAttribute($value)
            {
            return $value;
            }
            public function setTypeAttribute($value)
            {
            $this->attributes['type'] = $value ?? "";
            }








    


    


    



public function getSelectvalueAttribute()
{
    $select="";
    try{
    $select =$this->id;
    }catch (\Throwable $e){

    }
    
        

    
        

    
        

    
        
            $select=" ".$this->permission_id;
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
    return trim($select);

}
public function getSelectlabelAttribute()
{
    $select="";
    try{
    $select =$this->libelle;
    }catch (\Throwable $e){

    }

    
        

    
                    $select.="".$this->permission_label ." ";
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
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

