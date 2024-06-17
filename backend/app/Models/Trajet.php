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

















    
        use App\Models\Ligne;

        
        use App\Models\Site;

    



class Trajet extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\TrajetObservers') &&
method_exists('\App\Observers\TrajetObservers', 'creating')
){

try {
\App\Observers\TrajetObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\TrajetObservers') &&
method_exists('\App\Observers\TrajetObservers', 'created')
){

try {
\App\Observers\TrajetObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\TrajetObservers') &&
method_exists('\App\Observers\TrajetObservers', 'updating')
){

try {
\App\Observers\TrajetObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\TrajetObservers') &&
method_exists('\App\Observers\TrajetObservers', 'updated')
){

try {
\App\Observers\TrajetObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\TrajetObservers') &&
method_exists('\App\Observers\TrajetObservers', 'deleting')
){

try {
\App\Observers\TrajetObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\TrajetObservers') &&
method_exists('\App\Observers\TrajetObservers', 'deleted')
){

try {
\App\Observers\TrajetObservers::deleted($model);

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
$this->table = 'trajets';
}
protected $fillable = [
    'id' ,
    'ligne_id' ,
    'distance' ,
    'deleted_at' ,
    'creat_by' ,
    'identifiants_sadge' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'site_id' ,
    'durees' ,
    'ordre' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'ligne',
        



    

                    'site',
        



    
    ];







            public function ligne()
        {
        return $this->belongsTo(Ligne::class,'ligne_id','id');
        }
    






            public function site()
        {
        return $this->belongsTo(Site::class,'site_id','id');
        }
    















    


    

            public function getLigneIdAttribute($value)
            {
            return $value;
            }
            public function setLigneIdAttribute($value)
            {
            $this->attributes['ligne_id'] = $value ?? "";
            }








    


    

            public function getDistanceAttribute($value)
            {
            return $value;
            }
            public function setDistanceAttribute($value)
            {
            $this->attributes['distance'] = $value ?? "";
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








    


    


    


    


    

            public function getSiteIdAttribute($value)
            {
            return $value;
            }
            public function setSiteIdAttribute($value)
            {
            $this->attributes['site_id'] = $value ?? "";
            }








    


    

            public function getDureesAttribute($value)
            {
            return $value;
            }
            public function setDureesAttribute($value)
            {
            $this->attributes['durees'] = $value ?? "";
            }








    


    

            public function getOrdreAttribute($value)
            {
            return $value;
            }
            public function setOrdreAttribute($value)
            {
            $this->attributes['ordre'] = $value ?? "";
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

