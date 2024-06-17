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

















    
        use App\Models\Pointeuse;

        
        use App\Models\Poste;

    



class Postespointeuse extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\PostespointeuseObservers') &&
method_exists('\App\Observers\PostespointeuseObservers', 'creating')
){

try {
\App\Observers\PostespointeuseObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\PostespointeuseObservers') &&
method_exists('\App\Observers\PostespointeuseObservers', 'created')
){

try {
\App\Observers\PostespointeuseObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\PostespointeuseObservers') &&
method_exists('\App\Observers\PostespointeuseObservers', 'updating')
){

try {
\App\Observers\PostespointeuseObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\PostespointeuseObservers') &&
method_exists('\App\Observers\PostespointeuseObservers', 'updated')
){

try {
\App\Observers\PostespointeuseObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\PostespointeuseObservers') &&
method_exists('\App\Observers\PostespointeuseObservers', 'deleting')
){

try {
\App\Observers\PostespointeuseObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\PostespointeuseObservers') &&
method_exists('\App\Observers\PostespointeuseObservers', 'deleted')
){

try {
\App\Observers\PostespointeuseObservers::deleted($model);

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
$this->table = 'postespointeuses';
}
protected $fillable = [
    'id' ,
    'poste_id' ,
    'pointeuse_id' ,
    'created_at' ,
    'updated_at' ,
    'extra_attributes' ,
    'deleted_at' ,
    'identifiants_sadge' ,
    'creat_by' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'pointeuse',
        



    

                    'poste',
        



    
    ];







            public function pointeuse()
        {
        return $this->belongsTo(Pointeuse::class,'pointeuse_id','id');
        }
    






            public function poste()
        {
        return $this->belongsTo(Poste::class,'poste_id','id');
        }
    















    


    

            public function getPosteIdAttribute($value)
            {
            return $value;
            }
            public function setPosteIdAttribute($value)
            {
            $this->attributes['poste_id'] = $value ?? "";
            }








    


    

            public function getPointeuseIdAttribute($value)
            {
            return $value;
            }
            public function setPointeuseIdAttribute($value)
            {
            $this->attributes['pointeuse_id'] = $value ?? "";
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

