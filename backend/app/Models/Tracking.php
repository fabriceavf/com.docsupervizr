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

        
        use App\Models\Moyenstransport;

    



class Tracking extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\TrackingObservers') &&
method_exists('\App\Observers\TrackingObservers', 'creating')
){

try {
\App\Observers\TrackingObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\TrackingObservers') &&
method_exists('\App\Observers\TrackingObservers', 'created')
){

try {
\App\Observers\TrackingObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\TrackingObservers') &&
method_exists('\App\Observers\TrackingObservers', 'updating')
){

try {
\App\Observers\TrackingObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\TrackingObservers') &&
method_exists('\App\Observers\TrackingObservers', 'updated')
){

try {
\App\Observers\TrackingObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\TrackingObservers') &&
method_exists('\App\Observers\TrackingObservers', 'deleting')
){

try {
\App\Observers\TrackingObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\TrackingObservers') &&
method_exists('\App\Observers\TrackingObservers', 'deleted')
){

try {
\App\Observers\TrackingObservers::deleted($model);

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
$this->table = 'trackings';
}
protected $fillable = [
    'id' ,
    'balise_id' ,
    'moyenstransport_id' ,
    'date_debut' ,
    'date_fin' ,
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














    

                    'balise',
        



    

                    'moyenstransport',
        



    
    ];







            public function balise()
        {
        return $this->belongsTo(Balise::class,'balise_id','id');
        }
    






            public function moyenstransport()
        {
        return $this->belongsTo(Moyenstransport::class,'moyenstransport_id','id');
        }
    















    


    

            public function getBaliseIdAttribute($value)
            {
            return $value;
            }
            public function setBaliseIdAttribute($value)
            {
            $this->attributes['balise_id'] = $value ?? "";
            }








    


    

            public function getMoyenstransportIdAttribute($value)
            {
            return $value;
            }
            public function setMoyenstransportIdAttribute($value)
            {
            $this->attributes['moyenstransport_id'] = $value ?? "";
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

