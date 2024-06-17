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

        
        use App\Models\Lignesmoyenstransport;

        
        use App\Models\Moyenstransport;

        
        use App\Models\Controlleursacce;

        
        use App\Models\Sitessdeplacement;

    



class Deplacement extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\DeplacementObservers') &&
method_exists('\App\Observers\DeplacementObservers', 'creating')
){

try {
\App\Observers\DeplacementObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\DeplacementObservers') &&
method_exists('\App\Observers\DeplacementObservers', 'created')
){

try {
\App\Observers\DeplacementObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\DeplacementObservers') &&
method_exists('\App\Observers\DeplacementObservers', 'updating')
){

try {
\App\Observers\DeplacementObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\DeplacementObservers') &&
method_exists('\App\Observers\DeplacementObservers', 'updated')
){

try {
\App\Observers\DeplacementObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\DeplacementObservers') &&
method_exists('\App\Observers\DeplacementObservers', 'deleting')
){

try {
\App\Observers\DeplacementObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\DeplacementObservers') &&
method_exists('\App\Observers\DeplacementObservers', 'deleted')
){

try {
\App\Observers\DeplacementObservers::deleted($model);

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
$this->table = 'deplacements';
}
protected $fillable = [
    'id' ,
    'date' ,
    'debut_prevu' ,
    'fin_prevu' ,
    'lignesmoyenstransport_id' ,
    'creat_by' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'moyenstransport_id' ,
    'ligne_id' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'ligne',
        



    

                    'lignesmoyenstransport',
        



    

                    'moyenstransport',
        



    
    ];







            public function ligne()
        {
        return $this->belongsTo(Ligne::class,'ligne_id','id');
        }
    






            public function lignesmoyenstransport()
        {
        return $this->belongsTo(Lignesmoyenstransport::class,'lignesmoyenstransport_id','id');
        }
    






            public function moyenstransport()
        {
        return $this->belongsTo(Moyenstransport::class,'moyenstransport_id','id');
        }
    








            public function controlleursacces()
        {
        return $this->hasMany(Controlleursacce::class,'deplacement_id','id');
        }
    






            public function sitessdeplacements()
        {
        return $this->hasMany(Sitessdeplacement::class,'deplacement_id','id');
        }
    













    


    

            public function getDateAttribute($value)
            {
            return $value;
            }
            public function setDateAttribute($value)
            {
            $this->attributes['date'] = $value ?? "";
            }








    


    

            public function getDebutPrevuAttribute($value)
            {
            return $value;
            }
            public function setDebutPrevuAttribute($value)
            {
            $this->attributes['debut_prevu'] = $value ?? "";
            }








    


    

            public function getFinPrevuAttribute($value)
            {
            return $value;
            }
            public function setFinPrevuAttribute($value)
            {
            $this->attributes['fin_prevu'] = $value ?? "";
            }








    


    

            public function getLignesmoyenstransportIdAttribute($value)
            {
            return $value;
            }
            public function setLignesmoyenstransportIdAttribute($value)
            {
            $this->attributes['lignesmoyenstransport_id'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
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

