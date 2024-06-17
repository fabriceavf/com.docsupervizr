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

















    
        use App\Models\Programmation;

        
        use App\Models\User;

    



class Ventilation extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\VentilationObservers') &&
method_exists('\App\Observers\VentilationObservers', 'creating')
){

try {
\App\Observers\VentilationObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\VentilationObservers') &&
method_exists('\App\Observers\VentilationObservers', 'created')
){

try {
\App\Observers\VentilationObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\VentilationObservers') &&
method_exists('\App\Observers\VentilationObservers', 'updating')
){

try {
\App\Observers\VentilationObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\VentilationObservers') &&
method_exists('\App\Observers\VentilationObservers', 'updated')
){

try {
\App\Observers\VentilationObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\VentilationObservers') &&
method_exists('\App\Observers\VentilationObservers', 'deleting')
){

try {
\App\Observers\VentilationObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\VentilationObservers') &&
method_exists('\App\Observers\VentilationObservers', 'deleted')
){

try {
\App\Observers\VentilationObservers::deleted($model);

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
$this->table = 'ventilations';
}
protected $fillable = [
    'id' ,
    'user_id' ,
    'semaine' ,
    'dimanche_date' ,
    'lundi_date' ,
    'mardi_date' ,
    'mercredi_date' ,
    'jeudi_date' ,
    'vendredi_date' ,
    'samedi_date' ,
    'dimanche_horaire' ,
    'lundi_horaire' ,
    'mardi_horaire' ,
    'mercredi_horaire' ,
    'jeudi_horaire' ,
    'vendredi_horaire' ,
    'samedi_horaire' ,
    'dimanche' ,
    'lundi' ,
    'mardi' ,
    'mercredi' ,
    'jeudi' ,
    'vendredi' ,
    'samedi' ,
    'dimanche_pointage' ,
    'lundi_pointage' ,
    'mardi_pointage' ,
    'mercredi_pointage' ,
    'jeudi_pointage' ,
    'vendredi_pointage' ,
    'samedi_pointage' ,
    'dimanche_collecter' ,
    'lundi_collecter' ,
    'mardi_collecter' ,
    'mercredi_collecter' ,
    'jeudi_collecter' ,
    'vendredi_collecter' ,
    'samedi_collecter' ,
    'dimanche_depassement' ,
    'lundi_depassement' ,
    'mardi_depassement' ,
    'mercredi_depassement' ,
    'jeudi_depassement' ,
    'vendredi_depassement' ,
    'samedi_depassement' ,
    'dimanche_programmer' ,
    'lundi_programmer' ,
    'mardi_programmer' ,
    'mercredi_programmer' ,
    'jeudi_programmer' ,
    'vendredi_programmer' ,
    'samedi_programmer' ,
    'dimanche_retard' ,
    'lundi_retard' ,
    'mardi_retard' ,
    'mercredi_retard' ,
    'jeudi_retard' ,
    'vendredi_retard' ,
    'samedi_retard' ,
    'programmation_id' ,
    'total_programmer' ,
    'total_colecter' ,
    'total_depassement' ,
    'hs15' ,
    'hs26' ,
    'hs55' ,
    'hs30' ,
    'hs60' ,
    'hs115' ,
    'hs130' ,
    'total' ,
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














    

                    'programmation',
        



    

                    'user',
        



    
    ];







            public function programmation()
        {
        return $this->belongsTo(Programmation::class,'programmation_id','id');
        }
    






            public function user()
        {
        return $this->belongsTo(User::class,'user_id','id');
        }
    















    


    


    

            public function getSemaineAttribute($value)
            {
            return $value;
            }
            public function setSemaineAttribute($value)
            {
            $this->attributes['semaine'] = $value ?? "";
            }








    


    

            public function getDimancheDateAttribute($value)
            {
            return $value;
            }
            public function setDimancheDateAttribute($value)
            {
            $this->attributes['dimanche_date'] = $value ?? "";
            }








    


    

            public function getLundiDateAttribute($value)
            {
            return $value;
            }
            public function setLundiDateAttribute($value)
            {
            $this->attributes['lundi_date'] = $value ?? "";
            }








    


    

            public function getMardiDateAttribute($value)
            {
            return $value;
            }
            public function setMardiDateAttribute($value)
            {
            $this->attributes['mardi_date'] = $value ?? "";
            }








    


    

            public function getMercrediDateAttribute($value)
            {
            return $value;
            }
            public function setMercrediDateAttribute($value)
            {
            $this->attributes['mercredi_date'] = $value ?? "";
            }








    


    

            public function getJeudiDateAttribute($value)
            {
            return $value;
            }
            public function setJeudiDateAttribute($value)
            {
            $this->attributes['jeudi_date'] = $value ?? "";
            }








    


    

            public function getVendrediDateAttribute($value)
            {
            return $value;
            }
            public function setVendrediDateAttribute($value)
            {
            $this->attributes['vendredi_date'] = $value ?? "";
            }








    


    

            public function getSamediDateAttribute($value)
            {
            return $value;
            }
            public function setSamediDateAttribute($value)
            {
            $this->attributes['samedi_date'] = $value ?? "";
            }








    


    

            public function getDimancheHoraireAttribute($value)
            {
            return $value;
            }
            public function setDimancheHoraireAttribute($value)
            {
            $this->attributes['dimanche_horaire'] = $value ?? "";
            }








    


    

            public function getLundiHoraireAttribute($value)
            {
            return $value;
            }
            public function setLundiHoraireAttribute($value)
            {
            $this->attributes['lundi_horaire'] = $value ?? "";
            }








    


    

            public function getMardiHoraireAttribute($value)
            {
            return $value;
            }
            public function setMardiHoraireAttribute($value)
            {
            $this->attributes['mardi_horaire'] = $value ?? "";
            }








    


    

            public function getMercrediHoraireAttribute($value)
            {
            return $value;
            }
            public function setMercrediHoraireAttribute($value)
            {
            $this->attributes['mercredi_horaire'] = $value ?? "";
            }








    


    

            public function getJeudiHoraireAttribute($value)
            {
            return $value;
            }
            public function setJeudiHoraireAttribute($value)
            {
            $this->attributes['jeudi_horaire'] = $value ?? "";
            }








    


    

            public function getVendrediHoraireAttribute($value)
            {
            return $value;
            }
            public function setVendrediHoraireAttribute($value)
            {
            $this->attributes['vendredi_horaire'] = $value ?? "";
            }








    


    

            public function getSamediHoraireAttribute($value)
            {
            return $value;
            }
            public function setSamediHoraireAttribute($value)
            {
            $this->attributes['samedi_horaire'] = $value ?? "";
            }








    


    

            public function getDimancheAttribute($value)
            {
            return $value;
            }
            public function setDimancheAttribute($value)
            {
            $this->attributes['dimanche'] = $value ?? "";
            }








    


    

            public function getLundiAttribute($value)
            {
            return $value;
            }
            public function setLundiAttribute($value)
            {
            $this->attributes['lundi'] = $value ?? "";
            }








    


    

            public function getMardiAttribute($value)
            {
            return $value;
            }
            public function setMardiAttribute($value)
            {
            $this->attributes['mardi'] = $value ?? "";
            }








    


    

            public function getMercrediAttribute($value)
            {
            return $value;
            }
            public function setMercrediAttribute($value)
            {
            $this->attributes['mercredi'] = $value ?? "";
            }








    


    

            public function getJeudiAttribute($value)
            {
            return $value;
            }
            public function setJeudiAttribute($value)
            {
            $this->attributes['jeudi'] = $value ?? "";
            }








    


    

            public function getVendrediAttribute($value)
            {
            return $value;
            }
            public function setVendrediAttribute($value)
            {
            $this->attributes['vendredi'] = $value ?? "";
            }








    


    

            public function getSamediAttribute($value)
            {
            return $value;
            }
            public function setSamediAttribute($value)
            {
            $this->attributes['samedi'] = $value ?? "";
            }








    


    

            public function getDimanchePointageAttribute($value)
            {
            return $value;
            }
            public function setDimanchePointageAttribute($value)
            {
            $this->attributes['dimanche_pointage'] = $value ?? "";
            }








    


    

            public function getLundiPointageAttribute($value)
            {
            return $value;
            }
            public function setLundiPointageAttribute($value)
            {
            $this->attributes['lundi_pointage'] = $value ?? "";
            }








    


    

            public function getMardiPointageAttribute($value)
            {
            return $value;
            }
            public function setMardiPointageAttribute($value)
            {
            $this->attributes['mardi_pointage'] = $value ?? "";
            }








    


    

            public function getMercrediPointageAttribute($value)
            {
            return $value;
            }
            public function setMercrediPointageAttribute($value)
            {
            $this->attributes['mercredi_pointage'] = $value ?? "";
            }








    


    

            public function getJeudiPointageAttribute($value)
            {
            return $value;
            }
            public function setJeudiPointageAttribute($value)
            {
            $this->attributes['jeudi_pointage'] = $value ?? "";
            }








    


    

            public function getVendrediPointageAttribute($value)
            {
            return $value;
            }
            public function setVendrediPointageAttribute($value)
            {
            $this->attributes['vendredi_pointage'] = $value ?? "";
            }








    


    

            public function getSamediPointageAttribute($value)
            {
            return $value;
            }
            public function setSamediPointageAttribute($value)
            {
            $this->attributes['samedi_pointage'] = $value ?? "";
            }








    


    

            public function getDimancheCollecterAttribute($value)
            {
            return $value;
            }
            public function setDimancheCollecterAttribute($value)
            {
            $this->attributes['dimanche_collecter'] = $value ?? "";
            }








    


    

            public function getLundiCollecterAttribute($value)
            {
            return $value;
            }
            public function setLundiCollecterAttribute($value)
            {
            $this->attributes['lundi_collecter'] = $value ?? "";
            }








    


    

            public function getMardiCollecterAttribute($value)
            {
            return $value;
            }
            public function setMardiCollecterAttribute($value)
            {
            $this->attributes['mardi_collecter'] = $value ?? "";
            }








    


    

            public function getMercrediCollecterAttribute($value)
            {
            return $value;
            }
            public function setMercrediCollecterAttribute($value)
            {
            $this->attributes['mercredi_collecter'] = $value ?? "";
            }








    


    

            public function getJeudiCollecterAttribute($value)
            {
            return $value;
            }
            public function setJeudiCollecterAttribute($value)
            {
            $this->attributes['jeudi_collecter'] = $value ?? "";
            }








    


    

            public function getVendrediCollecterAttribute($value)
            {
            return $value;
            }
            public function setVendrediCollecterAttribute($value)
            {
            $this->attributes['vendredi_collecter'] = $value ?? "";
            }








    


    

            public function getSamediCollecterAttribute($value)
            {
            return $value;
            }
            public function setSamediCollecterAttribute($value)
            {
            $this->attributes['samedi_collecter'] = $value ?? "";
            }








    


    

            public function getDimancheDepassementAttribute($value)
            {
            return $value;
            }
            public function setDimancheDepassementAttribute($value)
            {
            $this->attributes['dimanche_depassement'] = $value ?? "";
            }








    


    

            public function getLundiDepassementAttribute($value)
            {
            return $value;
            }
            public function setLundiDepassementAttribute($value)
            {
            $this->attributes['lundi_depassement'] = $value ?? "";
            }








    


    

            public function getMardiDepassementAttribute($value)
            {
            return $value;
            }
            public function setMardiDepassementAttribute($value)
            {
            $this->attributes['mardi_depassement'] = $value ?? "";
            }








    


    

            public function getMercrediDepassementAttribute($value)
            {
            return $value;
            }
            public function setMercrediDepassementAttribute($value)
            {
            $this->attributes['mercredi_depassement'] = $value ?? "";
            }








    


    

            public function getJeudiDepassementAttribute($value)
            {
            return $value;
            }
            public function setJeudiDepassementAttribute($value)
            {
            $this->attributes['jeudi_depassement'] = $value ?? "";
            }








    


    

            public function getVendrediDepassementAttribute($value)
            {
            return $value;
            }
            public function setVendrediDepassementAttribute($value)
            {
            $this->attributes['vendredi_depassement'] = $value ?? "";
            }








    


    

            public function getSamediDepassementAttribute($value)
            {
            return $value;
            }
            public function setSamediDepassementAttribute($value)
            {
            $this->attributes['samedi_depassement'] = $value ?? "";
            }








    


    

            public function getDimancheProgrammerAttribute($value)
            {
            return $value;
            }
            public function setDimancheProgrammerAttribute($value)
            {
            $this->attributes['dimanche_programmer'] = $value ?? "";
            }








    


    

            public function getLundiProgrammerAttribute($value)
            {
            return $value;
            }
            public function setLundiProgrammerAttribute($value)
            {
            $this->attributes['lundi_programmer'] = $value ?? "";
            }








    


    

            public function getMardiProgrammerAttribute($value)
            {
            return $value;
            }
            public function setMardiProgrammerAttribute($value)
            {
            $this->attributes['mardi_programmer'] = $value ?? "";
            }








    


    

            public function getMercrediProgrammerAttribute($value)
            {
            return $value;
            }
            public function setMercrediProgrammerAttribute($value)
            {
            $this->attributes['mercredi_programmer'] = $value ?? "";
            }








    


    

            public function getJeudiProgrammerAttribute($value)
            {
            return $value;
            }
            public function setJeudiProgrammerAttribute($value)
            {
            $this->attributes['jeudi_programmer'] = $value ?? "";
            }








    


    

            public function getVendrediProgrammerAttribute($value)
            {
            return $value;
            }
            public function setVendrediProgrammerAttribute($value)
            {
            $this->attributes['vendredi_programmer'] = $value ?? "";
            }








    


    

            public function getSamediProgrammerAttribute($value)
            {
            return $value;
            }
            public function setSamediProgrammerAttribute($value)
            {
            $this->attributes['samedi_programmer'] = $value ?? "";
            }








    


    

            public function getDimancheRetardAttribute($value)
            {
            return $value;
            }
            public function setDimancheRetardAttribute($value)
            {
            $this->attributes['dimanche_retard'] = $value ?? "";
            }








    


    

            public function getLundiRetardAttribute($value)
            {
            return $value;
            }
            public function setLundiRetardAttribute($value)
            {
            $this->attributes['lundi_retard'] = $value ?? "";
            }








    


    

            public function getMardiRetardAttribute($value)
            {
            return $value;
            }
            public function setMardiRetardAttribute($value)
            {
            $this->attributes['mardi_retard'] = $value ?? "";
            }








    


    

            public function getMercrediRetardAttribute($value)
            {
            return $value;
            }
            public function setMercrediRetardAttribute($value)
            {
            $this->attributes['mercredi_retard'] = $value ?? "";
            }








    


    

            public function getJeudiRetardAttribute($value)
            {
            return $value;
            }
            public function setJeudiRetardAttribute($value)
            {
            $this->attributes['jeudi_retard'] = $value ?? "";
            }








    


    

            public function getVendrediRetardAttribute($value)
            {
            return $value;
            }
            public function setVendrediRetardAttribute($value)
            {
            $this->attributes['vendredi_retard'] = $value ?? "";
            }








    


    

            public function getSamediRetardAttribute($value)
            {
            return $value;
            }
            public function setSamediRetardAttribute($value)
            {
            $this->attributes['samedi_retard'] = $value ?? "";
            }








    


    

            public function getProgrammationIdAttribute($value)
            {
            return $value;
            }
            public function setProgrammationIdAttribute($value)
            {
            $this->attributes['programmation_id'] = $value ?? "";
            }








    


    

            public function getTotalProgrammerAttribute($value)
            {
            return $value;
            }
            public function setTotalProgrammerAttribute($value)
            {
            $this->attributes['total_programmer'] = $value ?? "";
            }








    


    

            public function getTotalColecterAttribute($value)
            {
            return $value;
            }
            public function setTotalColecterAttribute($value)
            {
            $this->attributes['total_colecter'] = $value ?? "";
            }








    


    

            public function getTotalDepassementAttribute($value)
            {
            return $value;
            }
            public function setTotalDepassementAttribute($value)
            {
            $this->attributes['total_depassement'] = $value ?? "";
            }








    


    

            public function getHs15Attribute($value)
            {
            return $value;
            }
            public function setHs15Attribute($value)
            {
            $this->attributes['hs15'] = $value ?? "";
            }








    


    

            public function getHs26Attribute($value)
            {
            return $value;
            }
            public function setHs26Attribute($value)
            {
            $this->attributes['hs26'] = $value ?? "";
            }








    


    

            public function getHs55Attribute($value)
            {
            return $value;
            }
            public function setHs55Attribute($value)
            {
            $this->attributes['hs55'] = $value ?? "";
            }








    


    

            public function getHs30Attribute($value)
            {
            return $value;
            }
            public function setHs30Attribute($value)
            {
            $this->attributes['hs30'] = $value ?? "";
            }








    


    

            public function getHs60Attribute($value)
            {
            return $value;
            }
            public function setHs60Attribute($value)
            {
            $this->attributes['hs60'] = $value ?? "";
            }








    


    

            public function getHs115Attribute($value)
            {
            return $value;
            }
            public function setHs115Attribute($value)
            {
            $this->attributes['hs115'] = $value ?? "";
            }








    


    

            public function getHs130Attribute($value)
            {
            return $value;
            }
            public function setHs130Attribute($value)
            {
            $this->attributes['hs130'] = $value ?? "";
            }








    


    

            public function getTotalAttribute($value)
            {
            return $value;
            }
            public function setTotalAttribute($value)
            {
            $this->attributes['total'] = $value ?? "";
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

