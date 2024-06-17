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

















    
        use App\Models\User;

        
        use App\Models\Zone;

        
        use App\Models\Homezone;

        
        use App\Models\Validation;

    



class Modelslisting extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\ModelslistingObservers') &&
method_exists('\App\Observers\ModelslistingObservers', 'creating')
){

try {
\App\Observers\ModelslistingObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\ModelslistingObservers') &&
method_exists('\App\Observers\ModelslistingObservers', 'created')
){

try {
\App\Observers\ModelslistingObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\ModelslistingObservers') &&
method_exists('\App\Observers\ModelslistingObservers', 'updating')
){

try {
\App\Observers\ModelslistingObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\ModelslistingObservers') &&
method_exists('\App\Observers\ModelslistingObservers', 'updated')
){

try {
\App\Observers\ModelslistingObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\ModelslistingObservers') &&
method_exists('\App\Observers\ModelslistingObservers', 'deleting')
){

try {
\App\Observers\ModelslistingObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\ModelslistingObservers') &&
method_exists('\App\Observers\ModelslistingObservers', 'deleted')
){

try {
\App\Observers\ModelslistingObservers::deleted($model);

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
$this->table = 'modelslistings';
}
protected $fillable = [
    'id' ,
    'Libelle' ,
    'extra_attributes' ,
    'deleted_at' ,
    'created_at' ,
    'updated_at' ,
    'postes' ,
    'zone_id' ,
    'faction' ,
    'user_id' ,
    'date_debut' ,
    'min_partage' ,
    'Generate' ,
    'etats' ,
    'user_id_2' ,
    'user_id_3' ,
    'user_id_4' ,
    'typelistings' ,
    'horaires' ,
    'directions' ,
    'identifiants_sadge' ,
    'creat_by' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'user',
        



    

                    'zone',
        



    
    ];







            public function user()
        {
        return $this->belongsTo(User::class,'user_id','id');
        }
    






            public function zone()
        {
        return $this->belongsTo(Zone::class,'zone_id','id');
        }
    








            public function homezones()
        {
        return $this->hasMany(Homezone::class,'modelslisting_id','id');
        }
    






            public function validations()
        {
        return $this->hasMany(Validation::class,'modelslisting_id','id');
        }
    













    


    

            public function getLibelleAttribute($value)
            {
            return $value;
            }
            public function setLibelleAttribute($value)
            {
            $this->attributes['Libelle'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getPostesAttribute($value)
            {
            return $value;
            }
            public function setPostesAttribute($value)
            {
            $this->attributes['postes'] = $value ?? "";
            }








    


    

            public function getZoneIdAttribute($value)
            {
            return $value;
            }
            public function setZoneIdAttribute($value)
            {
            $this->attributes['zone_id'] = $value ?? "";
            }








    


    

            public function getFactionAttribute($value)
            {
            return $value;
            }
            public function setFactionAttribute($value)
            {
            $this->attributes['faction'] = $value ?? "";
            }








    


    


    

            public function getDateDebutAttribute($value)
            {
            return $value;
            }
            public function setDateDebutAttribute($value)
            {
            $this->attributes['date_debut'] = $value ?? "";
            }








    


    

            public function getMinPartageAttribute($value)
            {
            return $value;
            }
            public function setMinPartageAttribute($value)
            {
            $this->attributes['min_partage'] = $value ?? "";
            }








    


    

            public function getGenerateAttribute($value)
            {
            return $value;
            }
            public function setGenerateAttribute($value)
            {
            $this->attributes['Generate'] = $value ?? "";
            }








    


    

            public function getEtatsAttribute($value)
            {
            return $value;
            }
            public function setEtatsAttribute($value)
            {
            $this->attributes['etats'] = $value ?? "";
            }








    


    

            public function getUserId2Attribute($value)
            {
            return $value;
            }
            public function setUserId2Attribute($value)
            {
            $this->attributes['user_id_2'] = $value ?? "";
            }








    


    

            public function getUserId3Attribute($value)
            {
            return $value;
            }
            public function setUserId3Attribute($value)
            {
            $this->attributes['user_id_3'] = $value ?? "";
            }








    


    

            public function getUserId4Attribute($value)
            {
            return $value;
            }
            public function setUserId4Attribute($value)
            {
            $this->attributes['user_id_4'] = $value ?? "";
            }








    


    

            public function getTypelistingsAttribute($value)
            {
            return $value;
            }
            public function setTypelistingsAttribute($value)
            {
            $this->attributes['typelistings'] = $value ?? "";
            }








    


    

            public function getHorairesAttribute($value)
            {
            return $value;
            }
            public function setHorairesAttribute($value)
            {
            $this->attributes['horaires'] = $value ?? "";
            }








    


    

            public function getDirectionsAttribute($value)
            {
            return $value;
            }
            public function setDirectionsAttribute($value)
            {
            $this->attributes['directions'] = $value ?? "";
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

