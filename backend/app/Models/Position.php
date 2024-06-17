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

















    
        use App\Models\Balise;

    



class Position extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\PositionObservers') &&
method_exists('\App\Observers\PositionObservers', 'creating')
){

try {
\App\Observers\PositionObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\PositionObservers') &&
method_exists('\App\Observers\PositionObservers', 'created')
){

try {
\App\Observers\PositionObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\PositionObservers') &&
method_exists('\App\Observers\PositionObservers', 'updating')
){

try {
\App\Observers\PositionObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\PositionObservers') &&
method_exists('\App\Observers\PositionObservers', 'updated')
){

try {
\App\Observers\PositionObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\PositionObservers') &&
method_exists('\App\Observers\PositionObservers', 'deleting')
){

try {
\App\Observers\PositionObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\PositionObservers') &&
method_exists('\App\Observers\PositionObservers', 'deleted')
){

try {
\App\Observers\PositionObservers::deleted($model);

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
$this->table = 'positions';
}
protected $fillable = [
    'id' ,
    'lat' ,
    'lon' ,
    'name' ,
    'title' ,
    'speed' ,
    'icon_color' ,
    'moyenstransportid' ,
    'creat_by' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'date' ,
    'tracername' ,
    'traceruniqueid' ,
    'sim' ,
    'balise_id' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'balise',
        



    
    ];







            public function balise()
        {
        return $this->belongsTo(Balise::class,'balise_id','id');
        }
    















    


    

            public function getLatAttribute($value)
            {
            return $value;
            }
            public function setLatAttribute($value)
            {
            $this->attributes['lat'] = $value ?? "";
            }








    


    

            public function getLonAttribute($value)
            {
            return $value;
            }
            public function setLonAttribute($value)
            {
            $this->attributes['lon'] = $value ?? "";
            }








    


    

            public function getNameAttribute($value)
            {
            return $value;
            }
            public function setNameAttribute($value)
            {
            $this->attributes['name'] = $value ?? "";
            }








    


    

            public function getTitleAttribute($value)
            {
            return $value;
            }
            public function setTitleAttribute($value)
            {
            $this->attributes['title'] = $value ?? "";
            }








    


    

            public function getSpeedAttribute($value)
            {
            return $value;
            }
            public function setSpeedAttribute($value)
            {
            $this->attributes['speed'] = $value ?? "";
            }








    


    

            public function getIconColorAttribute($value)
            {
            return $value;
            }
            public function setIconColorAttribute($value)
            {
            $this->attributes['icon_color'] = $value ?? "";
            }








    


    

            public function getMoyenstransportidAttribute($value)
            {
            return $value;
            }
            public function setMoyenstransportidAttribute($value)
            {
            $this->attributes['moyenstransportid'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
            }








    


    


    


    


    


    

            public function getDateAttribute($value)
            {
            return $value;
            }
            public function setDateAttribute($value)
            {
            $this->attributes['date'] = $value ?? "";
            }








    


    

            public function getTracernameAttribute($value)
            {
            return $value;
            }
            public function setTracernameAttribute($value)
            {
            $this->attributes['tracername'] = $value ?? "";
            }








    


    

            public function getTraceruniqueidAttribute($value)
            {
            return $value;
            }
            public function setTraceruniqueidAttribute($value)
            {
            $this->attributes['traceruniqueid'] = $value ?? "";
            }








    


    

            public function getSimAttribute($value)
            {
            return $value;
            }
            public function setSimAttribute($value)
            {
            $this->attributes['sim'] = $value ?? "";
            }








    


    

            public function getBaliseIdAttribute($value)
            {
            return $value;
            }
            public function setBaliseIdAttribute($value)
            {
            $this->attributes['balise_id'] = $value ?? "";
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

