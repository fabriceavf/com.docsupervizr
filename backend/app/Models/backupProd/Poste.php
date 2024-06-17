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

















    
        use App\Models\Contratsclient;

        
        use App\Models\Postesarticle;

        
        use App\Models\Site;

        
        use App\Models\Typesposte;

        
        use App\Models\Horaire;

        
        use App\Models\Postespointeuse;

        
        use App\Models\Programmation;

        
        use App\Models\Programme;

        
        use App\Models\Rapportposte;

        
        use App\Models\Rapport;

        
        use App\Models\Transaction;

        
        use App\Models\User;

        
        use App\Models\Vacationsposte;

    



class Poste extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\PosteObservers') &&
method_exists('\App\Observers\PosteObservers', 'creating')
){

try {
\App\Observers\PosteObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\PosteObservers') &&
method_exists('\App\Observers\PosteObservers', 'created')
){

try {
\App\Observers\PosteObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\PosteObservers') &&
method_exists('\App\Observers\PosteObservers', 'updating')
){

try {
\App\Observers\PosteObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\PosteObservers') &&
method_exists('\App\Observers\PosteObservers', 'updated')
){

try {
\App\Observers\PosteObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\PosteObservers') &&
method_exists('\App\Observers\PosteObservers', 'deleting')
){

try {
\App\Observers\PosteObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\PosteObservers') &&
method_exists('\App\Observers\PosteObservers', 'deleted')
){

try {
\App\Observers\PosteObservers::deleted($model);

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
$this->table = 'postes';
}
protected $fillable = [
    'id' ,
    'code' ,
    'libelle' ,
    'nature' ,
    'coordonnees' ,
    'site_id' ,
    'created_at' ,
    'updated_at' ,
    'jours' ,
    'contratsclient_id' ,
    'maxjours' ,
    'maxnuits' ,
    'NbrsJours' ,
    'NbrsNuits' ,
    'IsCouvert' ,
    'pointeuses' ,
    'Agentjour' ,
    'Agentnuit' ,
    'couvertAgentjour' ,
    'couvertAgentnuit' ,
    'type' ,
    'typeagents' ,
    'typesposte_id' ,
    'postesarticle_id' ,
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














    

                    'contratsclient',
        



    

                    'postesarticle',
        



    

                    'site',
        



    

                    'typesposte',
        



    
    ];







            public function contratsclient()
        {
        return $this->belongsTo(Contratsclient::class,'contratsclient_id','id');
        }
    






            public function postesarticle()
        {
        return $this->belongsTo(Postesarticle::class,'postesarticle_id','id');
        }
    






            public function site()
        {
        return $this->belongsTo(Site::class,'site_id','id');
        }
    






            public function typesposte()
        {
        return $this->belongsTo(Typesposte::class,'typesposte_id','id');
        }
    








            public function horaires()
        {
        return $this->hasMany(Horaire::class,'poste_id','id');
        }
    






            public function postespointeuses()
        {
        return $this->hasMany(Postespointeuse::class,'poste_id','id');
        }
    






            public function programmations()
        {
        return $this->hasMany(Programmation::class,'poste_id','id');
        }
    






            public function programmes()
        {
        return $this->hasMany(Programme::class,'poste_id','id');
        }
    






            public function rapportpostes()
        {
        return $this->hasMany(Rapportposte::class,'poste_id','id');
        }
    






            public function rapports()
        {
        return $this->hasMany(Rapport::class,'poste_id','id');
        }
    






            public function transactions()
        {
        return $this->hasMany(Transaction::class,'poste_id','id');
        }
    






            public function users()
        {
        return $this->hasMany(User::class,'poste_id','id');
        }
    






            public function vacationspostes()
        {
        return $this->hasMany(Vacationsposte::class,'poste_id','id');
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








    


    

            public function getNatureAttribute($value)
            {
            return $value;
            }
            public function setNatureAttribute($value)
            {
            $this->attributes['nature'] = $value ?? "";
            }








    


    

            public function getCoordonneesAttribute($value)
            {
            return $value;
            }
            public function setCoordonneesAttribute($value)
            {
            $this->attributes['coordonnees'] = $value ?? "";
            }








    


    

            public function getSiteIdAttribute($value)
            {
            return $value;
            }
            public function setSiteIdAttribute($value)
            {
            $this->attributes['site_id'] = $value ?? "";
            }








    


    


    


    

            public function getJoursAttribute($value)
            {
            return $value;
            }
            public function setJoursAttribute($value)
            {
            $this->attributes['jours'] = $value ?? "";
            }








    


    

            public function getContratsclientIdAttribute($value)
            {
            return $value;
            }
            public function setContratsclientIdAttribute($value)
            {
            $this->attributes['contratsclient_id'] = $value ?? "";
            }








    


    

            public function getMaxjoursAttribute($value)
            {
            return $value;
            }
            public function setMaxjoursAttribute($value)
            {
            $this->attributes['maxjours'] = $value ?? "";
            }








    


    

            public function getMaxnuitsAttribute($value)
            {
            return $value;
            }
            public function setMaxnuitsAttribute($value)
            {
            $this->attributes['maxnuits'] = $value ?? "";
            }








    


    

            public function getNbrsJoursAttribute($value)
            {
            return $value;
            }
            public function setNbrsJoursAttribute($value)
            {
            $this->attributes['NbrsJours'] = $value ?? "";
            }








    


    

            public function getNbrsNuitsAttribute($value)
            {
            return $value;
            }
            public function setNbrsNuitsAttribute($value)
            {
            $this->attributes['NbrsNuits'] = $value ?? "";
            }








    


    

            public function getIsCouvertAttribute($value)
            {
            return $value;
            }
            public function setIsCouvertAttribute($value)
            {
            $this->attributes['IsCouvert'] = $value ?? "";
            }








    


    

            public function getPointeusesAttribute($value)
            {
            return $value;
            }
            public function setPointeusesAttribute($value)
            {
            $this->attributes['pointeuses'] = $value ?? "";
            }








    


    

            public function getAgentjourAttribute($value)
            {
            return $value;
            }
            public function setAgentjourAttribute($value)
            {
            $this->attributes['Agentjour'] = $value ?? "";
            }








    


    

            public function getAgentnuitAttribute($value)
            {
            return $value;
            }
            public function setAgentnuitAttribute($value)
            {
            $this->attributes['Agentnuit'] = $value ?? "";
            }








    


    

            public function getCouvertAgentjourAttribute($value)
            {
            return $value;
            }
            public function setCouvertAgentjourAttribute($value)
            {
            $this->attributes['couvertAgentjour'] = $value ?? "";
            }








    


    

            public function getCouvertAgentnuitAttribute($value)
            {
            return $value;
            }
            public function setCouvertAgentnuitAttribute($value)
            {
            $this->attributes['couvertAgentnuit'] = $value ?? "";
            }








    


    

            public function getTypeAttribute($value)
            {
            return $value;
            }
            public function setTypeAttribute($value)
            {
            $this->attributes['type'] = $value ?? "";
            }








    


    

            public function getTypeagentsAttribute($value)
            {
            return $value;
            }
            public function setTypeagentsAttribute($value)
            {
            $this->attributes['typeagents'] = $value ?? "";
            }








    


    

            public function getTypesposteIdAttribute($value)
            {
            return $value;
            }
            public function setTypesposteIdAttribute($value)
            {
            $this->attributes['typesposte_id'] = $value ?? "";
            }








    


    

            public function getPostesarticleIdAttribute($value)
            {
            return $value;
            }
            public function setPostesarticleIdAttribute($value)
            {
            $this->attributes['postesarticle_id'] = $value ?? "";
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

