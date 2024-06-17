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

















    
        use App\Models\Site;

        
        use App\Models\Controlleursacce;

        
        use App\Models\Deploiementspointeusesmoyenstransport;

        
        use App\Models\Postespointeuse;

        
        use App\Models\Sitespointeuse;

    



class Pointeuse extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\PointeuseObservers') &&
method_exists('\App\Observers\PointeuseObservers', 'creating')
){

try {
\App\Observers\PointeuseObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\PointeuseObservers') &&
method_exists('\App\Observers\PointeuseObservers', 'created')
){

try {
\App\Observers\PointeuseObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\PointeuseObservers') &&
method_exists('\App\Observers\PointeuseObservers', 'updating')
){

try {
\App\Observers\PointeuseObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\PointeuseObservers') &&
method_exists('\App\Observers\PointeuseObservers', 'updated')
){

try {
\App\Observers\PointeuseObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\PointeuseObservers') &&
method_exists('\App\Observers\PointeuseObservers', 'deleting')
){

try {
\App\Observers\PointeuseObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\PointeuseObservers') &&
method_exists('\App\Observers\PointeuseObservers', 'deleted')
){

try {
\App\Observers\PointeuseObservers::deleted($model);

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
$this->table = 'pointeuses';
}
protected $fillable = [
    'id' ,
    'code' ,
    'libelle' ,
    'created_at' ,
    'updated_at' ,
    'nom_local' ,
    'supervirzclient_id' ,
    'code_teleric' ,
    'postes' ,
    'Taches' ,
    'lun' ,
    'mar' ,
    'mer' ,
    'jeu' ,
    'ven' ,
    'sam' ,
    'dim' ,
    'site_id' ,
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














    

                    'site',
        



    
    ];







            public function site()
        {
        return $this->belongsTo(Site::class,'site_id','id');
        }
    








            public function controlleursacces()
        {
        return $this->hasMany(Controlleursacce::class,'pointeuse_id','id');
        }
    






            public function deploiementspointeusesmoyenstransports()
        {
        return $this->hasMany(Deploiementspointeusesmoyenstransport::class,'pointeuse_id','id');
        }
    






            public function postespointeuses()
        {
        return $this->hasMany(Postespointeuse::class,'pointeuse_id','id');
        }
    






            public function sites()
        {
        return $this->hasMany(Site::class,'pointeuse_id','id');
        }
    






            public function sitespointeuses()
        {
        return $this->hasMany(Sitespointeuse::class,'pointeuse_id','id');
        }
    













    


    

            public function getCodeAttribute($value)
            {
            return $value;
            }
            public function setCodeAttribute($value)
            {
            $this->attributes['code'] = $value ?? "";
            }








    


    

            public function getLibelleAttribute($value)
            {
            return $value;
            }
            public function setLibelleAttribute($value)
            {
            $this->attributes['libelle'] = $value ?? "";
            }








    


    


    


    

            public function getNomLocalAttribute($value)
            {
            return $value;
            }
            public function setNomLocalAttribute($value)
            {
            $this->attributes['nom_local'] = $value ?? "";
            }








    


    

            public function getSupervirzclientIdAttribute($value)
            {
            return $value;
            }
            public function setSupervirzclientIdAttribute($value)
            {
            $this->attributes['supervirzclient_id'] = $value ?? "";
            }








    


    

            public function getCodeTelericAttribute($value)
            {
            return $value;
            }
            public function setCodeTelericAttribute($value)
            {
            $this->attributes['code_teleric'] = $value ?? "";
            }








    


    

            public function getPostesAttribute($value)
            {
            return $value;
            }
            public function setPostesAttribute($value)
            {
            $this->attributes['postes'] = $value ?? "";
            }








    


    

            public function getTachesAttribute($value)
            {
            return $value;
            }
            public function setTachesAttribute($value)
            {
            $this->attributes['Taches'] = $value ?? "";
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








    


    

            public function getSiteIdAttribute($value)
            {
            return $value;
            }
            public function setSiteIdAttribute($value)
            {
            $this->attributes['site_id'] = $value ?? "";
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

