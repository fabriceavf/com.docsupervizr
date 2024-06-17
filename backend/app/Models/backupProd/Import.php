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

















    
        use App\Models\Typeseffectif;

        
        use App\Models\Typespointage;

        
        use App\Models\Typesposte;

    



class Import extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\ImportObservers') &&
method_exists('\App\Observers\ImportObservers', 'creating')
){

try {
\App\Observers\ImportObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\ImportObservers') &&
method_exists('\App\Observers\ImportObservers', 'created')
){

try {
\App\Observers\ImportObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\ImportObservers') &&
method_exists('\App\Observers\ImportObservers', 'updating')
){

try {
\App\Observers\ImportObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\ImportObservers') &&
method_exists('\App\Observers\ImportObservers', 'updated')
){

try {
\App\Observers\ImportObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\ImportObservers') &&
method_exists('\App\Observers\ImportObservers', 'deleting')
){

try {
\App\Observers\ImportObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\ImportObservers') &&
method_exists('\App\Observers\ImportObservers', 'deleted')
){

try {
\App\Observers\ImportObservers::deleted($model);

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
$this->table = 'imports';
}
protected $fillable = [
    'id' ,
    'type' ,
    'liaisons' ,
    'identifiant' ,
    'etats' ,
    'creat_by' ,
    'created_at' ,
    'updated_at' ,
    'extra_attributes' ,
    'deleted_at' ,
    'file' ,
    'create' ,
    'update' ,
    'delete' ,
    'valider' ,
    'description' ,
    'typesposte_id' ,
    'typeseffectif_id' ,
    'typespointage_id' ,
    'typespointages' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'typeseffectif',
        



    

                    'typespointage',
        



    

                    'typesposte',
        



    
    ];







            public function typeseffectif()
        {
        return $this->belongsTo(Typeseffectif::class,'typeseffectif_id','id');
        }
    






            public function typespointage()
        {
        return $this->belongsTo(Typespointage::class,'typespointage_id','id');
        }
    






            public function typesposte()
        {
        return $this->belongsTo(Typesposte::class,'typesposte_id','id');
        }
    















    


    

            public function getTypeAttribute($value)
            {
            return $value;
            }
            public function setTypeAttribute($value)
            {
            $this->attributes['type'] = $value ?? "";
            }








    


    

            public function getLiaisonsAttribute($value)
            {
            return $value;
            }
            public function setLiaisonsAttribute($value)
            {
            $this->attributes['liaisons'] = $value ?? "";
            }








    


    

            public function getIdentifiantAttribute($value)
            {
            return $value;
            }
            public function setIdentifiantAttribute($value)
            {
            $this->attributes['identifiant'] = $value ?? "";
            }








    


    

            public function getEtatsAttribute($value)
            {
            return $value;
            }
            public function setEtatsAttribute($value)
            {
            $this->attributes['etats'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getFileAttribute($value)
            {
            return $value;
            }
            public function setFileAttribute($value)
            {
            $this->attributes['file'] = $value ?? "";
            }








    


    

            public function getCreateAttribute($value)
            {
            return $value;
            }
            public function setCreateAttribute($value)
            {
            $this->attributes['create'] = $value ?? "";
            }








    


    

            public function getUpdateAttribute($value)
            {
            return $value;
            }
            public function setUpdateAttribute($value)
            {
            $this->attributes['update'] = $value ?? "";
            }








    


    

            public function getDeleteAttribute($value)
            {
            return $value;
            }
            public function setDeleteAttribute($value)
            {
            $this->attributes['delete'] = $value ?? "";
            }








    


    

            public function getValiderAttribute($value)
            {
            return $value;
            }
            public function setValiderAttribute($value)
            {
            $this->attributes['valider'] = $value ?? "";
            }








    


    

            public function getDescriptionAttribute($value)
            {
            return $value;
            }
            public function setDescriptionAttribute($value)
            {
            $this->attributes['description'] = $value ?? "";
            }








    


    

            public function getTypesposteIdAttribute($value)
            {
            return $value;
            }
            public function setTypesposteIdAttribute($value)
            {
            $this->attributes['typesposte_id'] = $value ?? "";
            }








    


    

            public function getTypeseffectifIdAttribute($value)
            {
            return $value;
            }
            public function setTypeseffectifIdAttribute($value)
            {
            $this->attributes['typeseffectif_id'] = $value ?? "";
            }








    


    

            public function getTypespointageIdAttribute($value)
            {
            return $value;
            }
            public function setTypespointageIdAttribute($value)
            {
            $this->attributes['typespointage_id'] = $value ?? "";
            }








    


    

            public function getTypespointagesAttribute($value)
            {
            return $value;
            }
            public function setTypespointagesAttribute($value)
            {
            $this->attributes['typespointages'] = $value ?? "";
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

