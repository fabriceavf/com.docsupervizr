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

















    
        use App\Models\Carte;

        
        use App\Models\Controlleursacce;

        
        use App\Models\Identification;

        
        use App\Models\Ligne;

        
        use App\Models\Poste;

        
        use App\Models\Ville;

        
        use App\Models\Preuve;

        
        use App\Models\Traitement;

    



class Transaction extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\TransactionObservers') &&
method_exists('\App\Observers\TransactionObservers', 'creating')
){

try {
\App\Observers\TransactionObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\TransactionObservers') &&
method_exists('\App\Observers\TransactionObservers', 'created')
){

try {
\App\Observers\TransactionObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\TransactionObservers') &&
method_exists('\App\Observers\TransactionObservers', 'updating')
){

try {
\App\Observers\TransactionObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\TransactionObservers') &&
method_exists('\App\Observers\TransactionObservers', 'updated')
){

try {
\App\Observers\TransactionObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\TransactionObservers') &&
method_exists('\App\Observers\TransactionObservers', 'deleting')
){

try {
\App\Observers\TransactionObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\TransactionObservers') &&
method_exists('\App\Observers\TransactionObservers', 'deleted')
){

try {
\App\Observers\TransactionObservers::deleted($model);

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
$this->table = 'transactions';
}
protected $fillable = [
    'id' ,
    'bio_id' ,
    'area_alias' ,
    'card_no' ,
    'terminal_alias' ,
    'emp_code' ,
    'punch_date' ,
    'punch_time' ,
    'poste_id' ,
    'ville_id' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'etats' ,
    'annuler' ,
    'type' ,
    'traiter' ,
    'verification' ,
    'rechercheetape' ,
    'heure' ,
    'identification_id' ,
    'controlleursacce_id' ,
    'carte_id' ,
    'cout' ,
    'ligne_id' ,
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














    

                    'carte',
        



    

                    'controlleursacce',
        



    

                    'identification',
        



    

                    'ligne',
        



    

                    'poste',
        



    

                    'ville',
        



    
    ];







            public function carte()
        {
        return $this->belongsTo(Carte::class,'carte_id','id');
        }
    






            public function controlleursacce()
        {
        return $this->belongsTo(Controlleursacce::class,'controlleursacce_id','id');
        }
    






            public function identification()
        {
        return $this->belongsTo(Identification::class,'identification_id','id');
        }
    






            public function ligne()
        {
        return $this->belongsTo(Ligne::class,'ligne_id','id');
        }
    






            public function poste()
        {
        return $this->belongsTo(Poste::class,'poste_id','id');
        }
    






            public function ville()
        {
        return $this->belongsTo(Ville::class,'ville_id','id');
        }
    








            public function preuves()
        {
        return $this->hasMany(Preuve::class,'transaction_id','id');
        }
    






            public function traitements()
        {
        return $this->hasMany(Traitement::class,'transaction_id','id');
        }
    













    


    

            public function getBioIdAttribute($value)
            {
            return $value;
            }
            public function setBioIdAttribute($value)
            {
            $this->attributes['bio_id'] = $value ?? "";
            }








    


    

            public function getAreaAliasAttribute($value)
            {
            return $value;
            }
            public function setAreaAliasAttribute($value)
            {
            $this->attributes['area_alias'] = $value ?? "";
            }








    


    

            public function getCardNoAttribute($value)
            {
            return $value;
            }
            public function setCardNoAttribute($value)
            {
            $this->attributes['card_no'] = $value ?? "";
            }








    


    

            public function getTerminalAliasAttribute($value)
            {
            return $value;
            }
            public function setTerminalAliasAttribute($value)
            {
            $this->attributes['terminal_alias'] = $value ?? "";
            }








    


    

            public function getEmpCodeAttribute($value)
            {
            return $value;
            }
            public function setEmpCodeAttribute($value)
            {
            $this->attributes['emp_code'] = $value ?? "";
            }








    


    

            public function getPunchDateAttribute($value)
            {
            return $value;
            }
            public function setPunchDateAttribute($value)
            {
            $this->attributes['punch_date'] = $value ?? "";
            }








    


    

            public function getPunchTimeAttribute($value)
            {
            return $value;
            }
            public function setPunchTimeAttribute($value)
            {
            $this->attributes['punch_time'] = $value ?? "";
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








    


    


    


    


    

            public function getEtatsAttribute($value)
            {
            return $value;
            }
            public function setEtatsAttribute($value)
            {
            $this->attributes['etats'] = $value ?? "";
            }








    


    

            public function getAnnulerAttribute($value)
            {
            return $value;
            }
            public function setAnnulerAttribute($value)
            {
            $this->attributes['annuler'] = $value ?? "";
            }








    


    

            public function getTypeAttribute($value)
            {
            return $value;
            }
            public function setTypeAttribute($value)
            {
            $this->attributes['type'] = $value ?? "";
            }








    


    

            public function getTraiterAttribute($value)
            {
            return $value;
            }
            public function setTraiterAttribute($value)
            {
            $this->attributes['traiter'] = $value ?? "";
            }








    


    

            public function getVerificationAttribute($value)
            {
            return $value;
            }
            public function setVerificationAttribute($value)
            {
            $this->attributes['verification'] = $value ?? "";
            }








    


    

            public function getRechercheetapeAttribute($value)
            {
            return $value;
            }
            public function setRechercheetapeAttribute($value)
            {
            $this->attributes['rechercheetape'] = $value ?? "";
            }








    


    

            public function getHeureAttribute($value)
            {
            return $value;
            }
            public function setHeureAttribute($value)
            {
            $this->attributes['heure'] = $value ?? "";
            }








    


    

            public function getIdentificationIdAttribute($value)
            {
            return $value;
            }
            public function setIdentificationIdAttribute($value)
            {
            $this->attributes['identification_id'] = $value ?? "";
            }








    


    

            public function getControlleursacceIdAttribute($value)
            {
            return $value;
            }
            public function setControlleursacceIdAttribute($value)
            {
            $this->attributes['controlleursacce_id'] = $value ?? "";
            }








    


    

            public function getCarteIdAttribute($value)
            {
            return $value;
            }
            public function setCarteIdAttribute($value)
            {
            $this->attributes['carte_id'] = $value ?? "";
            }








    


    

            public function getCoutAttribute($value)
            {
            return $value;
            }
            public function setCoutAttribute($value)
            {
            $this->attributes['cout'] = $value ?? "";
            }








    


    

            public function getLigneIdAttribute($value)
            {
            return $value;
            }
            public function setLigneIdAttribute($value)
            {
            $this->attributes['ligne_id'] = $value ?? "";
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

