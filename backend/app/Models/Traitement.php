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

















    
        use App\Models\Transaction;

    



class Traitement extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\TraitementObservers') &&
method_exists('\App\Observers\TraitementObservers', 'creating')
){

try {
\App\Observers\TraitementObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\TraitementObservers') &&
method_exists('\App\Observers\TraitementObservers', 'created')
){

try {
\App\Observers\TraitementObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\TraitementObservers') &&
method_exists('\App\Observers\TraitementObservers', 'updating')
){

try {
\App\Observers\TraitementObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\TraitementObservers') &&
method_exists('\App\Observers\TraitementObservers', 'updated')
){

try {
\App\Observers\TraitementObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\TraitementObservers') &&
method_exists('\App\Observers\TraitementObservers', 'deleting')
){

try {
\App\Observers\TraitementObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\TraitementObservers') &&
method_exists('\App\Observers\TraitementObservers', 'deleted')
){

try {
\App\Observers\TraitementObservers::deleted($model);

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
$this->table = 'traitements';
}
protected $fillable = [
    'id' ,
    'libelle' ,
    'date' ,
    'etat_depart' ,
    'etat_arrive' ,
    'transaction_id' ,
    'creat_by' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'transaction',
        



    
    ];







            public function transaction()
        {
        return $this->belongsTo(Transaction::class,'transaction_id','id');
        }
    















    


    

            public function getLibelleAttribute($value)
            {
            return $value;
            }
            public function setLibelleAttribute($value)
            {
            $this->attributes['libelle'] = $value ?? "";
            }








    


    

            public function getDateAttribute($value)
            {
            return $value;
            }
            public function setDateAttribute($value)
            {
            $this->attributes['date'] = $value ?? "";
            }








    


    

            public function getEtatDepartAttribute($value)
            {
            return $value;
            }
            public function setEtatDepartAttribute($value)
            {
            $this->attributes['etat_depart'] = $value ?? "";
            }








    


    

            public function getEtatArriveAttribute($value)
            {
            return $value;
            }
            public function setEtatArriveAttribute($value)
            {
            $this->attributes['etat_arrive'] = $value ?? "";
            }








    


    

            public function getTransactionIdAttribute($value)
            {
            return $value;
            }
            public function setTransactionIdAttribute($value)
            {
            $this->attributes['transaction_id'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
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

