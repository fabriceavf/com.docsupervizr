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

        
        use App\Models\Site;

    



class Sitespointeuse extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\SitespointeuseObservers') &&
method_exists('\App\Observers\SitespointeuseObservers', 'creating')
){

try {
\App\Observers\SitespointeuseObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\SitespointeuseObservers') &&
method_exists('\App\Observers\SitespointeuseObservers', 'created')
){

try {
\App\Observers\SitespointeuseObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\SitespointeuseObservers') &&
method_exists('\App\Observers\SitespointeuseObservers', 'updating')
){

try {
\App\Observers\SitespointeuseObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\SitespointeuseObservers') &&
method_exists('\App\Observers\SitespointeuseObservers', 'updated')
){

try {
\App\Observers\SitespointeuseObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\SitespointeuseObservers') &&
method_exists('\App\Observers\SitespointeuseObservers', 'deleting')
){

try {
\App\Observers\SitespointeuseObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\SitespointeuseObservers') &&
method_exists('\App\Observers\SitespointeuseObservers', 'deleted')
){

try {
\App\Observers\SitespointeuseObservers::deleted($model);

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
$this->table = 'sitespointeuses';
}
protected $fillable = [
    'id' ,
    'site_id' ,
    'pointeuse_id' ,
    'retirer' ,
    'creat_by' ,
    'extra_attributes' ,
    'created_at' ,
    'updated_at' ,
    'deleted_at' ,
    'debut' ,
    'fin' ,
    'identifiants_sadge' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    

    

    

    

    

    

    

    


];





    protected $with = [














    

                    'pointeuse',
        



    

                    'site',
        



    
    ];







            public function pointeuse()
        {
        return $this->belongsTo(Pointeuse::class,'pointeuse_id','id');
        }
    






            public function site()
        {
        return $this->belongsTo(Site::class,'site_id','id');
        }
    















    


    

            public function getSiteIdAttribute($value)
            {
            return $value;
            }
            public function setSiteIdAttribute($value)
            {
            $this->attributes['site_id'] = $value ?? "";
            }








    


    

            public function getPointeuseIdAttribute($value)
            {
            return $value;
            }
            public function setPointeuseIdAttribute($value)
            {
            $this->attributes['pointeuse_id'] = $value ?? "";
            }








    


    

            public function getRetirerAttribute($value)
            {
            return $value;
            }
            public function setRetirerAttribute($value)
            {
            $this->attributes['retirer'] = $value ?? "";
            }








    


    

            public function getCreatByAttribute($value)
            {
            return $value;
            }
            public function setCreatByAttribute($value)
            {
            $this->attributes['creat_by'] = $value ?? "";
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

