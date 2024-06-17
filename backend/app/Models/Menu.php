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

















    
        use App\Models\Entreprise;

        



class Menu extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\MenuObservers') &&
method_exists('\App\Observers\MenuObservers', 'creating')
){

try {
\App\Observers\MenuObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\MenuObservers') &&
method_exists('\App\Observers\MenuObservers', 'created')
){

try {
\App\Observers\MenuObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\MenuObservers') &&
method_exists('\App\Observers\MenuObservers', 'updating')
){

try {
\App\Observers\MenuObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\MenuObservers') &&
method_exists('\App\Observers\MenuObservers', 'updated')
){

try {
\App\Observers\MenuObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\MenuObservers') &&
method_exists('\App\Observers\MenuObservers', 'deleting')
){

try {
\App\Observers\MenuObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\MenuObservers') &&
method_exists('\App\Observers\MenuObservers', 'deleted')
){

try {
\App\Observers\MenuObservers::deleted($model);

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
$this->table = 'menus';
}
protected $fillable = [
    'id' ,
    'name' ,
    'icon' ,
    'slug' ,
    'url' ,
    'ordre' ,
    'isSu' ,
    'menu_id' ,
    'entreprise_id' ,
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














    

                    'entreprise',
        



    

                    'menu',
        



    
    ];







            public function entreprise()
        {
        return $this->belongsTo(Entreprise::class,'entreprise_id','id');
        }
    






            public function menu()
        {
        return $this->belongsTo(Menu::class,'menu_id','id');
        }
    








            public function menus()
        {
        return $this->hasMany(Menu::class,'menu_id','id');
        }
    













    


    

            public function getNameAttribute($value)
            {
            return $value;
            }
            public function setNameAttribute($value)
            {
            $this->attributes['name'] = $value ?? "";
            }








    


    

            public function getIconAttribute($value)
            {
            return $value;
            }
            public function setIconAttribute($value)
            {
            $this->attributes['icon'] = $value ?? "";
            }








    


    

            public function getSlugAttribute($value)
            {
            return $value;
            }
            public function setSlugAttribute($value)
            {
            $this->attributes['slug'] = $value ?? "";
            }








    


    

            public function getUrlAttribute($value)
            {
            return $value;
            }
            public function setUrlAttribute($value)
            {
            $this->attributes['url'] = $value ?? "";
            }








    


    

            public function getOrdreAttribute($value)
            {
            return $value;
            }
            public function setOrdreAttribute($value)
            {
            $this->attributes['ordre'] = $value ?? "";
            }








    


    

            public function getIsSuAttribute($value)
            {
            return $value;
            }
            public function setIsSuAttribute($value)
            {
            $this->attributes['isSu'] = $value ?? "";
            }








    


    

            public function getMenuIdAttribute($value)
            {
            return $value;
            }
            public function setMenuIdAttribute($value)
            {
            $this->attributes['menu_id'] = $value ?? "";
            }








    


    

            public function getEntrepriseIdAttribute($value)
            {
            return $value;
            }
            public function setEntrepriseIdAttribute($value)
            {
            $this->attributes['entreprise_id'] = $value ?? "";
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

