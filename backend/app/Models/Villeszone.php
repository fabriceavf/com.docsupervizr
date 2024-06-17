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

















    
        use App\Models\Ville;

        
        use App\Models\Zone;

    



class Villeszone extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\VilleszoneObservers') &&
method_exists('\App\Observers\VilleszoneObservers', 'creating')
){

try {
\App\Observers\VilleszoneObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\VilleszoneObservers') &&
method_exists('\App\Observers\VilleszoneObservers', 'created')
){

try {
\App\Observers\VilleszoneObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\VilleszoneObservers') &&
method_exists('\App\Observers\VilleszoneObservers', 'updating')
){

try {
\App\Observers\VilleszoneObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\VilleszoneObservers') &&
method_exists('\App\Observers\VilleszoneObservers', 'updated')
){

try {
\App\Observers\VilleszoneObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\VilleszoneObservers') &&
method_exists('\App\Observers\VilleszoneObservers', 'deleting')
){

try {
\App\Observers\VilleszoneObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\VilleszoneObservers') &&
method_exists('\App\Observers\VilleszoneObservers', 'deleted')
){

try {
\App\Observers\VilleszoneObservers::deleted($model);

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
$this->table = 'villeszones';
}
protected $fillable = [
    'id' ,
    'ville_id' ,
    'zone_id' ,
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














    

                    'ville',
        



    

                    'zone',
        



    
    ];







            public function ville()
        {
        return $this->belongsTo(Ville::class,'ville_id','id');
        }
    






            public function zone()
        {
        return $this->belongsTo(Zone::class,'zone_id','id');
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

