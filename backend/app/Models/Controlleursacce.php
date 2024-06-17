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

















    
        use App\Models\Deplacement;

        
        use App\Models\Ligne;

        
        use App\Models\Pointeuse;

        
        use App\Models\Site;

        
        use App\Models\Transaction;

    



class Controlleursacce extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\ControlleursacceObservers') &&
method_exists('\App\Observers\ControlleursacceObservers', 'creating')
){

try {
\App\Observers\ControlleursacceObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\ControlleursacceObservers') &&
method_exists('\App\Observers\ControlleursacceObservers', 'created')
){

try {
\App\Observers\ControlleursacceObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\ControlleursacceObservers') &&
method_exists('\App\Observers\ControlleursacceObservers', 'updating')
){

try {
\App\Observers\ControlleursacceObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\ControlleursacceObservers') &&
method_exists('\App\Observers\ControlleursacceObservers', 'updated')
){

try {
\App\Observers\ControlleursacceObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\ControlleursacceObservers') &&
method_exists('\App\Observers\ControlleursacceObservers', 'deleting')
){

try {
\App\Observers\ControlleursacceObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\ControlleursacceObservers') &&
method_exists('\App\Observers\ControlleursacceObservers', 'deleted')
){

try {
\App\Observers\ControlleursacceObservers::deleted($model);

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
$this->table = 'controlleursacces';
}
protected $fillable = [
    'id' ,
    'pointeuse_id' ,
    'ligne_id' ,
    'deplacement_id' ,
    'site_id' ,
    'date_debut' ,
    'date_fin' ,
    'creat_by' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'type' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'deplacement',
        



    

                    'ligne',
        



    

                    'pointeuse',
        



    

                    'site',
        



    
    ];







            public function deplacement()
        {
        return $this->belongsTo(Deplacement::class,'deplacement_id','id');
        }
    






            public function ligne()
        {
        return $this->belongsTo(Ligne::class,'ligne_id','id');
        }
    






            public function pointeuse()
        {
        return $this->belongsTo(Pointeuse::class,'pointeuse_id','id');
        }
    






            public function site()
        {
        return $this->belongsTo(Site::class,'site_id','id');
        }
    








            public function transactions()
        {
        return $this->hasMany(Transaction::class,'controlleursacce_id','id');
        }
    













    


    

            public function getPointeuseIdAttribute($value)
            {
            return $value;
            }
            public function setPointeuseIdAttribute($value)
            {
            $this->attributes['pointeuse_id'] = $value ?? "";
            }








    


    

            public function getLigneIdAttribute($value)
            {
            return $value;
            }
            public function setLigneIdAttribute($value)
            {
            $this->attributes['ligne_id'] = $value ?? "";
            }








    


    

            public function getDeplacementIdAttribute($value)
            {
            return $value;
            }
            public function setDeplacementIdAttribute($value)
            {
            $this->attributes['deplacement_id'] = $value ?? "";
            }








    


    

            public function getSiteIdAttribute($value)
            {
            return $value;
            }
            public function setSiteIdAttribute($value)
            {
            $this->attributes['site_id'] = $value ?? "";
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








    


    


    


    


    


    

            public function getTypeAttribute($value)
            {
            return $value;
            }
            public function setTypeAttribute($value)
            {
            $this->attributes['type'] = $value ?? "";
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

