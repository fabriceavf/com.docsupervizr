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


use App\Models\Transaction;


class Transactionsdetail extends Model
{

    use SchemalessAttributesTrait;
    use SoftDeletes;


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'parent',
        'parentId',
        'transaction_id',
        'created_at',
        'updated_at',
        'creat_by',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'transaction',


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'transactionsdetails';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsdetailObservers') &&
                method_exists('\App\Observers\TransactionsdetailObservers', 'creating')
            ) {

                try {
                    \App\Observers\TransactionsdetailObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsdetailObservers') &&
                method_exists('\App\Observers\TransactionsdetailObservers', 'created')
            ) {

                try {
                    \App\Observers\TransactionsdetailObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsdetailObservers') &&
                method_exists('\App\Observers\TransactionsdetailObservers', 'updating')
            ) {

                try {
                    \App\Observers\TransactionsdetailObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsdetailObservers') &&
                method_exists('\App\Observers\TransactionsdetailObservers', 'updated')
            ) {

                try {
                    \App\Observers\TransactionsdetailObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsdetailObservers') &&
                method_exists('\App\Observers\TransactionsdetailObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TransactionsdetailObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsdetailObservers') &&
                method_exists('\App\Observers\TransactionsdetailObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TransactionsdetailObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function getParentAttribute($value)
    {
        return $value;
    }

    public function setParentAttribute($value)
    {
        $this->attributes['parent'] = $value ?? "";
    }

    public function getParentIdAttribute($value)
    {
        return $value;
    }

    public function setParentIdAttribute($value)
    {
        $this->attributes['parentId'] = $value ?? "";
    }

    public function getTransactionIdAttribute($value)
    {
        return $value;
    }

    public function setTransactionIdAttribute($value)
    {
        $this->attributes['transaction_id'] = $value ?? "";
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
        $select = "";
        try {
            $select = $this->id;
        } catch (\Throwable $e) {

        }


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";
        try {
            $select = $this->libelle;
        } catch (\Throwable $e) {

        }


        return trim($select);


    }

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public function scopeWithOtherExtraAttributes(): Builder
    {
        return $this->other_extra_attributes->modelScope();
    }


}

