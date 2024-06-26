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

















    
        use App\Models\Position;

        
        use App\Models\Tracking;

        
        use App\Models\User;

    



class Balise extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\BaliseObservers') &&
method_exists('\App\Observers\BaliseObservers', 'creating')
){

try {
\App\Observers\BaliseObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\BaliseObservers') &&
method_exists('\App\Observers\BaliseObservers', 'created')
){

try {
\App\Observers\BaliseObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\BaliseObservers') &&
method_exists('\App\Observers\BaliseObservers', 'updating')
){

try {
\App\Observers\BaliseObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\BaliseObservers') &&
method_exists('\App\Observers\BaliseObservers', 'updated')
){

try {
\App\Observers\BaliseObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\BaliseObservers') &&
method_exists('\App\Observers\BaliseObservers', 'deleting')
){

try {
\App\Observers\BaliseObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\BaliseObservers') &&
method_exists('\App\Observers\BaliseObservers', 'deleted')
){

try {
\App\Observers\BaliseObservers::deleted($model);

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
$this->table = 'balises';
}
protected $fillable = [
    'id' ,
    'imei' ,
    'created_at' ,
    'updated_at' ,
    'libelle' ,
    'ref' ,
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














    
    ];









            public function positions()
        {
        return $this->hasMany(Position::class,'balise_id','id');
        }
    






            public function trackings()
        {
        return $this->hasMany(Tracking::class,'balise_id','id');
        }
    






            public function users()
        {
        return $this->hasMany(User::class,'balise_id','id');
        }
    













    


    

            public function getImeiAttribute($value)
            {
            return $value;
            }
            public function setImeiAttribute($value)
            {
            $this->attributes['imei'] = $value ?? "";
            }








    


    


    


    

            public function getLibelleAttribute($value)
            {
            return $value;
            }
            public function setLibelleAttribute($value)
            {
            $this->attributes['libelle'] = $value ?? "";
            }








    


    

            public function getRefAttribute($value)
            {
            return $value;
            }
            public function setRefAttribute($value)
            {
            $this->attributes['ref'] = $value ?? "";
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

