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

















    
        use App\Models\User;

    



class Log extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\LogObservers') &&
method_exists('\App\Observers\LogObservers', 'creating')
){

try {
\App\Observers\LogObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\LogObservers') &&
method_exists('\App\Observers\LogObservers', 'created')
){

try {
\App\Observers\LogObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\LogObservers') &&
method_exists('\App\Observers\LogObservers', 'updating')
){

try {
\App\Observers\LogObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\LogObservers') &&
method_exists('\App\Observers\LogObservers', 'updated')
){

try {
\App\Observers\LogObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\LogObservers') &&
method_exists('\App\Observers\LogObservers', 'deleting')
){

try {
\App\Observers\LogObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\LogObservers') &&
method_exists('\App\Observers\LogObservers', 'deleted')
){

try {
\App\Observers\LogObservers::deleted($model);

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
$this->table = 'logs';
}
protected $fillable = [
    'id' ,
    'action' ,
    'ip' ,
    'details' ,
    'navigateur' ,
    'pays' ,
    'ville' ,
    'user_id' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'extra_attributes' ,
    'identifiants_sadge' ,
    'creat_by' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'user',
        



    
    ];







            public function user()
        {
        return $this->belongsTo(User::class,'user_id','id');
        }
    















    


    

            public function getActionAttribute($value)
            {
            return $value;
            }
            public function setActionAttribute($value)
            {
            $this->attributes['action'] = $value ?? "";
            }








    


    

            public function getIpAttribute($value)
            {
            return $value;
            }
            public function setIpAttribute($value)
            {
            $this->attributes['ip'] = $value ?? "";
            }








    


    

            public function getDetailsAttribute($value)
            {
            return $value;
            }
            public function setDetailsAttribute($value)
            {
            $this->attributes['details'] = $value ?? "";
            }








    


    

            public function getNavigateurAttribute($value)
            {
            return $value;
            }
            public function setNavigateurAttribute($value)
            {
            $this->attributes['navigateur'] = $value ?? "";
            }








    


    

            public function getPaysAttribute($value)
            {
            return $value;
            }
            public function setPaysAttribute($value)
            {
            $this->attributes['pays'] = $value ?? "";
            }








    


    

            public function getVilleAttribute($value)
            {
            return $value;
            }
            public function setVilleAttribute($value)
            {
            $this->attributes['ville'] = $value ?? "";
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

    
        

    
                    $select.="".$this->action ." ";
        

    
                    $select.="".$this->ip ." ";
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
        

    
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

