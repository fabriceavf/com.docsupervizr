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

















    
        use App\Models\Client;

        
        use App\Models\Fonction;

        
        use App\Models\Poste;

        
        use App\Models\Site;

        
        use App\Models\Type;

        
        use App\Models\Ville;

        
        use App\Models\Zone;

    



class Rapport extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\RapportObservers') &&
method_exists('\App\Observers\RapportObservers', 'creating')
){

try {
\App\Observers\RapportObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\RapportObservers') &&
method_exists('\App\Observers\RapportObservers', 'created')
){

try {
\App\Observers\RapportObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\RapportObservers') &&
method_exists('\App\Observers\RapportObservers', 'updating')
){

try {
\App\Observers\RapportObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\RapportObservers') &&
method_exists('\App\Observers\RapportObservers', 'updated')
){

try {
\App\Observers\RapportObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\RapportObservers') &&
method_exists('\App\Observers\RapportObservers', 'deleting')
){

try {
\App\Observers\RapportObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\RapportObservers') &&
method_exists('\App\Observers\RapportObservers', 'deleted')
){

try {
\App\Observers\RapportObservers::deleted($model);

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
$this->table = 'rapports';
}
protected $fillable = [
    'id' ,
    'mois' ,
    'poste_id' ,
    'ville_id' ,
    'zone_id' ,
    'fonction_id' ,
    'type_id' ,
    'faction_id' ,
    'site_id' ,
    'client_id' ,
    'day_01' ,
    'day_02' ,
    'day_03' ,
    'day_04' ,
    'day_05' ,
    'day_06' ,
    'day_07' ,
    'day_08' ,
    'day_09' ,
    'day_10' ,
    'day_11' ,
    'day_12' ,
    'day_13' ,
    'day_14' ,
    'day_15' ,
    'day_16' ,
    'day_17' ,
    'day_18' ,
    'day_19' ,
    'day_20' ,
    'day_21' ,
    'day_22' ,
    'day_23' ,
    'day_24' ,
    'day_25' ,
    'day_26' ,
    'day_27' ,
    'day_28' ,
    'day_29' ,
    'day_30' ,
    'day_31' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
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














    

                    'client',
        



    

                    'fonction',
        



    

                    'poste',
        



    

                    'site',
        



    

                    'type',
        



    

                    'ville',
        



    

                    'zone',
        



    
    ];







            public function client()
        {
        return $this->belongsTo(Client::class,'client_id','id');
        }
    






            public function fonction()
        {
        return $this->belongsTo(Fonction::class,'fonction_id','id');
        }
    






            public function poste()
        {
        return $this->belongsTo(Poste::class,'poste_id','id');
        }
    






            public function site()
        {
        return $this->belongsTo(Site::class,'site_id','id');
        }
    






            public function type()
        {
        return $this->belongsTo(Type::class,'type_id','id');
        }
    






            public function ville()
        {
        return $this->belongsTo(Ville::class,'ville_id','id');
        }
    






            public function zone()
        {
        return $this->belongsTo(Zone::class,'zone_id','id');
        }
    















    


    

            public function getMoisAttribute($value)
            {
            return $value;
            }
            public function setMoisAttribute($value)
            {
            $this->attributes['mois'] = $value ?? "";
            }








    


    

            public function getPosteIdAttribute($value)
            {
            return $value;
            }
            public function setPosteIdAttribute($value)
            {
            $this->attributes['poste_id'] = $value ?? "";
            }








    


    

            public function getVilleIdAttribute($value)
            {
            return $value;
            }
            public function setVilleIdAttribute($value)
            {
            $this->attributes['ville_id'] = $value ?? "";
            }








    


    

            public function getZoneIdAttribute($value)
            {
            return $value;
            }
            public function setZoneIdAttribute($value)
            {
            $this->attributes['zone_id'] = $value ?? "";
            }








    


    

            public function getFonctionIdAttribute($value)
            {
            return $value;
            }
            public function setFonctionIdAttribute($value)
            {
            $this->attributes['fonction_id'] = $value ?? "";
            }








    


    

            public function getTypeIdAttribute($value)
            {
            return $value;
            }
            public function setTypeIdAttribute($value)
            {
            $this->attributes['type_id'] = $value ?? "";
            }








    


    

            public function getFactionIdAttribute($value)
            {
            return $value;
            }
            public function setFactionIdAttribute($value)
            {
            $this->attributes['faction_id'] = $value ?? "";
            }








    


    

            public function getSiteIdAttribute($value)
            {
            return $value;
            }
            public function setSiteIdAttribute($value)
            {
            $this->attributes['site_id'] = $value ?? "";
            }








    


    

            public function getClientIdAttribute($value)
            {
            return $value;
            }
            public function setClientIdAttribute($value)
            {
            $this->attributes['client_id'] = $value ?? "";
            }








    


    

            public function getDay01Attribute($value)
            {
            return $value;
            }
            public function setDay01Attribute($value)
            {
            $this->attributes['day_01'] = $value ?? "";
            }








    


    

            public function getDay02Attribute($value)
            {
            return $value;
            }
            public function setDay02Attribute($value)
            {
            $this->attributes['day_02'] = $value ?? "";
            }








    


    

            public function getDay03Attribute($value)
            {
            return $value;
            }
            public function setDay03Attribute($value)
            {
            $this->attributes['day_03'] = $value ?? "";
            }








    


    

            public function getDay04Attribute($value)
            {
            return $value;
            }
            public function setDay04Attribute($value)
            {
            $this->attributes['day_04'] = $value ?? "";
            }








    


    

            public function getDay05Attribute($value)
            {
            return $value;
            }
            public function setDay05Attribute($value)
            {
            $this->attributes['day_05'] = $value ?? "";
            }








    


    

            public function getDay06Attribute($value)
            {
            return $value;
            }
            public function setDay06Attribute($value)
            {
            $this->attributes['day_06'] = $value ?? "";
            }








    


    

            public function getDay07Attribute($value)
            {
            return $value;
            }
            public function setDay07Attribute($value)
            {
            $this->attributes['day_07'] = $value ?? "";
            }








    


    

            public function getDay08Attribute($value)
            {
            return $value;
            }
            public function setDay08Attribute($value)
            {
            $this->attributes['day_08'] = $value ?? "";
            }








    


    

            public function getDay09Attribute($value)
            {
            return $value;
            }
            public function setDay09Attribute($value)
            {
            $this->attributes['day_09'] = $value ?? "";
            }








    


    

            public function getDay10Attribute($value)
            {
            return $value;
            }
            public function setDay10Attribute($value)
            {
            $this->attributes['day_10'] = $value ?? "";
            }








    


    

            public function getDay11Attribute($value)
            {
            return $value;
            }
            public function setDay11Attribute($value)
            {
            $this->attributes['day_11'] = $value ?? "";
            }








    


    

            public function getDay12Attribute($value)
            {
            return $value;
            }
            public function setDay12Attribute($value)
            {
            $this->attributes['day_12'] = $value ?? "";
            }








    


    

            public function getDay13Attribute($value)
            {
            return $value;
            }
            public function setDay13Attribute($value)
            {
            $this->attributes['day_13'] = $value ?? "";
            }








    


    

            public function getDay14Attribute($value)
            {
            return $value;
            }
            public function setDay14Attribute($value)
            {
            $this->attributes['day_14'] = $value ?? "";
            }








    


    

            public function getDay15Attribute($value)
            {
            return $value;
            }
            public function setDay15Attribute($value)
            {
            $this->attributes['day_15'] = $value ?? "";
            }








    


    

            public function getDay16Attribute($value)
            {
            return $value;
            }
            public function setDay16Attribute($value)
            {
            $this->attributes['day_16'] = $value ?? "";
            }








    


    

            public function getDay17Attribute($value)
            {
            return $value;
            }
            public function setDay17Attribute($value)
            {
            $this->attributes['day_17'] = $value ?? "";
            }








    


    

            public function getDay18Attribute($value)
            {
            return $value;
            }
            public function setDay18Attribute($value)
            {
            $this->attributes['day_18'] = $value ?? "";
            }








    


    

            public function getDay19Attribute($value)
            {
            return $value;
            }
            public function setDay19Attribute($value)
            {
            $this->attributes['day_19'] = $value ?? "";
            }








    


    

            public function getDay20Attribute($value)
            {
            return $value;
            }
            public function setDay20Attribute($value)
            {
            $this->attributes['day_20'] = $value ?? "";
            }








    


    

            public function getDay21Attribute($value)
            {
            return $value;
            }
            public function setDay21Attribute($value)
            {
            $this->attributes['day_21'] = $value ?? "";
            }








    


    

            public function getDay22Attribute($value)
            {
            return $value;
            }
            public function setDay22Attribute($value)
            {
            $this->attributes['day_22'] = $value ?? "";
            }








    


    

            public function getDay23Attribute($value)
            {
            return $value;
            }
            public function setDay23Attribute($value)
            {
            $this->attributes['day_23'] = $value ?? "";
            }








    


    

            public function getDay24Attribute($value)
            {
            return $value;
            }
            public function setDay24Attribute($value)
            {
            $this->attributes['day_24'] = $value ?? "";
            }








    


    

            public function getDay25Attribute($value)
            {
            return $value;
            }
            public function setDay25Attribute($value)
            {
            $this->attributes['day_25'] = $value ?? "";
            }








    


    

            public function getDay26Attribute($value)
            {
            return $value;
            }
            public function setDay26Attribute($value)
            {
            $this->attributes['day_26'] = $value ?? "";
            }








    


    

            public function getDay27Attribute($value)
            {
            return $value;
            }
            public function setDay27Attribute($value)
            {
            $this->attributes['day_27'] = $value ?? "";
            }








    


    

            public function getDay28Attribute($value)
            {
            return $value;
            }
            public function setDay28Attribute($value)
            {
            $this->attributes['day_28'] = $value ?? "";
            }








    


    

            public function getDay29Attribute($value)
            {
            return $value;
            }
            public function setDay29Attribute($value)
            {
            $this->attributes['day_29'] = $value ?? "";
            }








    


    

            public function getDay30Attribute($value)
            {
            return $value;
            }
            public function setDay30Attribute($value)
            {
            $this->attributes['day_30'] = $value ?? "";
            }








    


    

            public function getDay31Attribute($value)
            {
            return $value;
            }
            public function setDay31Attribute($value)
            {
            $this->attributes['day_31'] = $value ?? "";
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

