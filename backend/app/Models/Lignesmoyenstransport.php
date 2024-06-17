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

        
        use App\Models\Moyenstransport;

        
        use App\Models\Deplacement;

    



class Lignesmoyenstransport extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\LignesmoyenstransportObservers') &&
method_exists('\App\Observers\LignesmoyenstransportObservers', 'creating')
){

try {
\App\Observers\LignesmoyenstransportObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\LignesmoyenstransportObservers') &&
method_exists('\App\Observers\LignesmoyenstransportObservers', 'created')
){

try {
\App\Observers\LignesmoyenstransportObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\LignesmoyenstransportObservers') &&
method_exists('\App\Observers\LignesmoyenstransportObservers', 'updating')
){

try {
\App\Observers\LignesmoyenstransportObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\LignesmoyenstransportObservers') &&
method_exists('\App\Observers\LignesmoyenstransportObservers', 'updated')
){

try {
\App\Observers\LignesmoyenstransportObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\LignesmoyenstransportObservers') &&
method_exists('\App\Observers\LignesmoyenstransportObservers', 'deleting')
){

try {
\App\Observers\LignesmoyenstransportObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\LignesmoyenstransportObservers') &&
method_exists('\App\Observers\LignesmoyenstransportObservers', 'deleted')
){

try {
\App\Observers\LignesmoyenstransportObservers::deleted($model);

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
$this->table = 'lignesmoyenstransports';
}
protected $fillable = [
    'id' ,
    'moyenstransport_id' ,
    'ligne_id' ,
    'heure_debut' ,
    'heure_fin' ,
    'lun' ,
    'mar' ,
    'mer' ,
    'jeu' ,
    'ven' ,
    'sam' ,
    'dim' ,
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














    

                    'ligne',
        



    

                    'moyenstransport',
        



    
    ];







            public function ligne()
        {
        return $this->belongsTo(Ligne::class,'ligne_id','id');
        }
    






            public function moyenstransport()
        {
        return $this->belongsTo(Moyenstransport::class,'moyenstransport_id','id');
        }
    








            public function deplacements()
        {
        return $this->hasMany(Deplacement::class,'lignesmoyenstransport_id','id');
        }
    













    


    

            public function getMoyenstransportIdAttribute($value)
            {
            return $value;
            }
            public function setMoyenstransportIdAttribute($value)
            {
            $this->attributes['moyenstransport_id'] = $value ?? "";
            }








    


    

            public function getLigneIdAttribute($value)
            {
            return $value;
            }
            public function setLigneIdAttribute($value)
            {
            $this->attributes['ligne_id'] = $value ?? "";
            }








    


    

            public function getHeureDebutAttribute($value)
            {
            return $value;
            }
            public function setHeureDebutAttribute($value)
            {
            $this->attributes['heure_debut'] = $value ?? "";
            }








    


    

            public function getHeureFinAttribute($value)
            {
            return $value;
            }
            public function setHeureFinAttribute($value)
            {
            $this->attributes['heure_fin'] = $value ?? "";
            }








    


    

            public function getLunAttribute($value)
            {
            return $value;
            }
            public function setLunAttribute($value)
            {
            $this->attributes['lun'] = $value ?? "";
            }








    


    

            public function getMarAttribute($value)
            {
            return $value;
            }
            public function setMarAttribute($value)
            {
            $this->attributes['mar'] = $value ?? "";
            }








    


    

            public function getMerAttribute($value)
            {
            return $value;
            }
            public function setMerAttribute($value)
            {
            $this->attributes['mer'] = $value ?? "";
            }








    


    

            public function getJeuAttribute($value)
            {
            return $value;
            }
            public function setJeuAttribute($value)
            {
            $this->attributes['jeu'] = $value ?? "";
            }








    


    

            public function getVenAttribute($value)
            {
            return $value;
            }
            public function setVenAttribute($value)
            {
            $this->attributes['ven'] = $value ?? "";
            }








    


    

            public function getSamAttribute($value)
            {
            return $value;
            }
            public function setSamAttribute($value)
            {
            $this->attributes['sam'] = $value ?? "";
            }








    


    

            public function getDimAttribute($value)
            {
            return $value;
            }
            public function setDimAttribute($value)
            {
            $this->attributes['dim'] = $value ?? "";
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

