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





















class Pointeusestransaction extends Model
{

  use SchemalessAttributesTrait;
    use SoftDeletes;









public static function boot()
{
parent::boot();

self::creating(function($model){
if(
class_exists('\App\Observers\PointeusestransactionObservers') &&
method_exists('\App\Observers\PointeusestransactionObservers', 'creating')
){

try {
\App\Observers\PointeusestransactionObservers::creating($model);

} catch (\Throwable $e) {

}
}
});

self::created(function($model){
if(
class_exists('\App\Observers\PointeusestransactionObservers') &&
method_exists('\App\Observers\PointeusestransactionObservers', 'created')
){

try {
\App\Observers\PointeusestransactionObservers::created($model);

} catch (\Throwable $e) {

}
}
});

self::updating(function($model){
if(
class_exists('\App\Observers\PointeusestransactionObservers') &&
method_exists('\App\Observers\PointeusestransactionObservers', 'updating')
){

try {
\App\Observers\PointeusestransactionObservers::updating($model);

} catch (\Throwable $e) {

}
}
});

self::updated(function($model){
if(
class_exists('\App\Observers\PointeusestransactionObservers') &&
method_exists('\App\Observers\PointeusestransactionObservers', 'updated')
){

try {
\App\Observers\PointeusestransactionObservers::updated($model);

} catch (\Throwable $e) {

}
}
});

self::deleting(function($model){
if(
class_exists('\App\Observers\PointeusestransactionObservers') &&
method_exists('\App\Observers\PointeusestransactionObservers', 'deleting')
){

try {
\App\Observers\PointeusestransactionObservers::deleting($model);

} catch (\Throwable $e) {

}
}
});

self::deleted(function($model){
if(
class_exists('\App\Observers\PointeusestransactionObservers') &&
method_exists('\App\Observers\PointeusestransactionObservers', 'deleted')
){

try {
\App\Observers\PointeusestransactionObservers::deleted($model);

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

protected $primaryKey = '';

public function __construct(array $attributes = [])
{
parent::__construct($attributes);
$this->table = 'pointeusestransactions';
}
protected $fillable = [
    'transactions_totals' ,
    'transactions_heures' ,
    'transactions_id' ,
    'date' ,
    'pointeuse' ,

];


protected $casts = [
'created_at'  => 'datetime:Y-m-d H:m:s',
'updated_at'  => 'datetime:Y-m-d H:m:s',
'deleted_at'  => 'datetime:Y-m-d H:m:s',
    

    

    

    

    


];





    protected $with = [














    
    ];
















    

            public function getTransactionsTotalsAttribute($value)
            {
            return $value;
            }
            public function setTransactionsTotalsAttribute($value)
            {
            $this->attributes['transactions_totals'] = $value ?? "";
            }








    


    

            public function getTransactionsHeuresAttribute($value)
            {
            return $value;
            }
            public function setTransactionsHeuresAttribute($value)
            {
            $this->attributes['transactions_heures'] = $value ?? "";
            }








    


    

            public function getTransactionsIdAttribute($value)
            {
            return $value;
            }
            public function setTransactionsIdAttribute($value)
            {
            $this->attributes['transactions_id'] = $value ?? "";
            }








    


    

            public function getDateAttribute($value)
            {
            return $value;
            }
            public function setDateAttribute($value)
            {
            $this->attributes['date'] = $value ?? "";
            }








    


    

            public function getPointeuseAttribute($value)
            {
            return $value;
            }
            public function setPointeuseAttribute($value)
            {
            $this->attributes['pointeuse'] = $value ?? "";
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

