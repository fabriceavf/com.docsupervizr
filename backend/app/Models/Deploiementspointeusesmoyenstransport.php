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

















    
        use App\Models\Moyenstransport;

        
        use App\Models\Pointeuse;

    



class Deploiementspointeusesmoyenstransport extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers') &&
method_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers', 'creating')
){

try {
\App\Observers\DeploiementspointeusesmoyenstransportObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers') &&
method_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers', 'created')
){

try {
\App\Observers\DeploiementspointeusesmoyenstransportObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers') &&
method_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers', 'updating')
){

try {
\App\Observers\DeploiementspointeusesmoyenstransportObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers') &&
method_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers', 'updated')
){

try {
\App\Observers\DeploiementspointeusesmoyenstransportObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers') &&
method_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers', 'deleting')
){

try {
\App\Observers\DeploiementspointeusesmoyenstransportObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers') &&
method_exists('\App\Observers\DeploiementspointeusesmoyenstransportObservers', 'deleted')
){

try {
\App\Observers\DeploiementspointeusesmoyenstransportObservers::deleted($model);

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
$this->table = 'deploiementspointeusesmoyenstransports';
}
protected $fillable = [
    'id' ,
    'date' ,
    'pointeuse_id' ,
    'moyenstransport_id' ,
    'debut' ,
    'fin' ,
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














    

                    'moyenstransport',
        



    

                    'pointeuse',
        



    
    ];







            public function moyenstransport()
        {
        return $this->belongsTo(Moyenstransport::class,'moyenstransport_id','id');
        }
    






            public function pointeuse()
        {
        return $this->belongsTo(Pointeuse::class,'pointeuse_id','id');
        }
    















    


    

            public function getDateAttribute($value)
            {
            return $value;
            }
            public function setDateAttribute($value)
            {
            $this->attributes['date'] = $value ?? "";
            }








    


    

            public function getPointeuseIdAttribute($value)
            {
            return $value;
            }
            public function setPointeuseIdAttribute($value)
            {
            $this->attributes['pointeuse_id'] = $value ?? "";
            }








    


    

            public function getMoyenstransportIdAttribute($value)
            {
            return $value;
            }
            public function setMoyenstransportIdAttribute($value)
            {
            $this->attributes['moyenstransport_id'] = $value ?? "";
            }








    


    

            public function getDebutAttribute($value)
            {
            return $value;
            }
            public function setDebutAttribute($value)
            {
            $this->attributes['debut'] = $value ?? "";
            }








    


    

            public function getFinAttribute($value)
            {
            return $value;
            }
            public function setFinAttribute($value)
            {
            $this->attributes['fin'] = $value ?? "";
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

