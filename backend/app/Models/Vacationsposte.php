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

















    
        use App\Models\Poste;

    



class Vacationsposte extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\VacationsposteObservers') &&
method_exists('\App\Observers\VacationsposteObservers', 'creating')
){

try {
\App\Observers\VacationsposteObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\VacationsposteObservers') &&
method_exists('\App\Observers\VacationsposteObservers', 'created')
){

try {
\App\Observers\VacationsposteObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\VacationsposteObservers') &&
method_exists('\App\Observers\VacationsposteObservers', 'updating')
){

try {
\App\Observers\VacationsposteObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\VacationsposteObservers') &&
method_exists('\App\Observers\VacationsposteObservers', 'updated')
){

try {
\App\Observers\VacationsposteObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\VacationsposteObservers') &&
method_exists('\App\Observers\VacationsposteObservers', 'deleting')
){

try {
\App\Observers\VacationsposteObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\VacationsposteObservers') &&
method_exists('\App\Observers\VacationsposteObservers', 'deleted')
){

try {
\App\Observers\VacationsposteObservers::deleted($model);

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
$this->table = 'vacationspostes';
}
protected $fillable = [
    'id' ,
    'total' ,
    'date' ,
    'poste_id' ,
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














    

                    'poste',
        



    
    ];







            public function poste()
        {
        return $this->belongsTo(Poste::class,'poste_id','id');
        }
    















    


    

            public function getTotalAttribute($value)
            {
            return $value;
            }
            public function setTotalAttribute($value)
            {
            $this->attributes['total'] = $value ?? "";
            }








    


    

            public function getDateAttribute($value)
            {
            return $value;
            }
            public function setDateAttribute($value)
            {
            $this->attributes['date'] = $value ?? "";
            }








    


    

            public function getPosteIdAttribute($value)
            {
            return $value;
            }
            public function setPosteIdAttribute($value)
            {
            $this->attributes['poste_id'] = $value ?? "";
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

