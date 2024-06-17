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

        
        use App\Models\User;

        
        use App\Models\Credit;

        
        use App\Models\Debit;

        
        use App\Models\Transaction;

    



class Identification extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\IdentificationObservers') &&
method_exists('\App\Observers\IdentificationObservers', 'creating')
){

try {
\App\Observers\IdentificationObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\IdentificationObservers') &&
method_exists('\App\Observers\IdentificationObservers', 'created')
){

try {
\App\Observers\IdentificationObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\IdentificationObservers') &&
method_exists('\App\Observers\IdentificationObservers', 'updating')
){

try {
\App\Observers\IdentificationObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\IdentificationObservers') &&
method_exists('\App\Observers\IdentificationObservers', 'updated')
){

try {
\App\Observers\IdentificationObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\IdentificationObservers') &&
method_exists('\App\Observers\IdentificationObservers', 'deleting')
){

try {
\App\Observers\IdentificationObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\IdentificationObservers') &&
method_exists('\App\Observers\IdentificationObservers', 'deleted')
){

try {
\App\Observers\IdentificationObservers::deleted($model);

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
$this->table = 'identifications';
}
protected $fillable = [
    'id' ,
    'user_id' ,
    'carte_id' ,
    'date_debut' ,
    'date_fin' ,
    'statuts' ,
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














    

                    'carte',
        



    

                    'user',
        



    
    ];







            public function carte()
        {
        return $this->belongsTo(Carte::class,'carte_id','id');
        }
    






            public function user()
        {
        return $this->belongsTo(User::class,'user_id','id');
        }
    








            public function credits()
        {
        return $this->hasMany(Credit::class,'identification_id','id');
        }
    






            public function debits()
        {
        return $this->hasMany(Debit::class,'identification_id','id');
        }
    






            public function transactions()
        {
        return $this->hasMany(Transaction::class,'identification_id','id');
        }
    













    


    


    

            public function getCarteIdAttribute($value)
            {
            return $value;
            }
            public function setCarteIdAttribute($value)
            {
            $this->attributes['carte_id'] = $value ?? "";
            }








    


    

            public function getDateDebutAttribute($value)
            {
            return $value;
            }
            public function setDateDebutAttribute($value)
            {
            $this->attributes['date_debut'] = $value ?? "";
            }








    


    

            public function getDateFinAttribute($value)
            {
            return $value;
            }
            public function setDateFinAttribute($value)
            {
            $this->attributes['date_fin'] = $value ?? "";
            }








    


    

            public function getStatutsAttribute($value)
            {
            return $value;
            }
            public function setStatutsAttribute($value)
            {
            $this->attributes['statuts'] = $value ?? "";
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

