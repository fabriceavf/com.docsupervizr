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

















    
        use App\Models\Province;

        
        use App\Models\Ville;

        
        use App\Models\Homezone;

        
        use App\Models\Modelslisting;

        
        use App\Models\Programmation;

        
        use App\Models\Rapport;

        
        use App\Models\Site;

        
        use App\Models\User;

        
        use App\Models\Userszone;

        
        use App\Models\Villeszone;

    



class Zone extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\ZoneObservers') &&
method_exists('\App\Observers\ZoneObservers', 'creating')
){

try {
\App\Observers\ZoneObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\ZoneObservers') &&
method_exists('\App\Observers\ZoneObservers', 'created')
){

try {
\App\Observers\ZoneObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\ZoneObservers') &&
method_exists('\App\Observers\ZoneObservers', 'updating')
){

try {
\App\Observers\ZoneObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\ZoneObservers') &&
method_exists('\App\Observers\ZoneObservers', 'updated')
){

try {
\App\Observers\ZoneObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\ZoneObservers') &&
method_exists('\App\Observers\ZoneObservers', 'deleting')
){

try {
\App\Observers\ZoneObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\ZoneObservers') &&
method_exists('\App\Observers\ZoneObservers', 'deleted')
){

try {
\App\Observers\ZoneObservers::deleted($model);

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
$this->table = 'zones';
}
protected $fillable = [
    'id' ,
    'code' ,
    'libelle' ,
    'province_id' ,
    'created_at' ,
    'updated_at' ,
    'total_titulaires_therorique' ,
    'total_titulaires_reel_jour' ,
    'total_titulaires_reel_nuit' ,
    'total_present_jour' ,
    'total_present_nuit' ,
    'ordre' ,
    'ville_id' ,
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














    

                    'province',
        



    

                    'ville',
        



    
    ];







            public function province()
        {
        return $this->belongsTo(Province::class,'province_id','id');
        }
    






            public function ville()
        {
        return $this->belongsTo(Ville::class,'ville_id','id');
        }
    








            public function homezones()
        {
        return $this->hasMany(Homezone::class,'zone_id','id');
        }
    






            public function modelslistings()
        {
        return $this->hasMany(Modelslisting::class,'zone_id','id');
        }
    






            public function programmations()
        {
        return $this->hasMany(Programmation::class,'zone_id','id');
        }
    






            public function rapports()
        {
        return $this->hasMany(Rapport::class,'zone_id','id');
        }
    






            public function sites()
        {
        return $this->hasMany(Site::class,'zone_id','id');
        }
    






            public function users()
        {
        return $this->hasMany(User::class,'zone_id','id');
        }
    






            public function userszones()
        {
        return $this->hasMany(Userszone::class,'zone_id','id');
        }
    






            public function villeszones()
        {
        return $this->hasMany(Villeszone::class,'zone_id','id');
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








    


    

            public function getProvinceIdAttribute($value)
            {
            return $value;
            }
            public function setProvinceIdAttribute($value)
            {
            $this->attributes['province_id'] = $value ?? "";
            }








    


    


    


    

            public function getTotalTitulairesTheroriqueAttribute($value)
            {
            return $value;
            }
            public function setTotalTitulairesTheroriqueAttribute($value)
            {
            $this->attributes['total_titulaires_therorique'] = $value ?? "";
            }








    


    

            public function getTotalTitulairesReelJourAttribute($value)
            {
            return $value;
            }
            public function setTotalTitulairesReelJourAttribute($value)
            {
            $this->attributes['total_titulaires_reel_jour'] = $value ?? "";
            }








    


    

            public function getTotalTitulairesReelNuitAttribute($value)
            {
            return $value;
            }
            public function setTotalTitulairesReelNuitAttribute($value)
            {
            $this->attributes['total_titulaires_reel_nuit'] = $value ?? "";
            }








    


    

            public function getTotalPresentJourAttribute($value)
            {
            return $value;
            }
            public function setTotalPresentJourAttribute($value)
            {
            $this->attributes['total_present_jour'] = $value ?? "";
            }








    


    

            public function getTotalPresentNuitAttribute($value)
            {
            return $value;
            }
            public function setTotalPresentNuitAttribute($value)
            {
            $this->attributes['total_present_nuit'] = $value ?? "";
            }








    


    

            public function getOrdreAttribute($value)
            {
            return $value;
            }
            public function setOrdreAttribute($value)
            {
            $this->attributes['ordre'] = $value ?? "";
            }








    


    

            public function getVilleIdAttribute($value)
            {
            return $value;
            }
            public function setVilleIdAttribute($value)
            {
            $this->attributes['ville_id'] = $value ?? "";
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

