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


class Transactionspostessynthesesvacation extends Model
{

    use SchemalessAttributesTrait;
    use SoftDeletes;


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = '';
    protected $fillable = [
        'transactions_totals',
        'poste_id',
        'transactions_id',
        'transactions_heures',
        'date',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'poste',


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
        $this->table = 'transactionspostessynthesesvacations';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionspostessynthesesvacationObservers') &&
                method_exists('\App\Observers\TransactionspostessynthesesvacationObservers', 'creating')
            ) {

                try {
                    \App\Observers\TransactionspostessynthesesvacationObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TransactionspostessynthesesvacationObservers') &&
                method_exists('\App\Observers\TransactionspostessynthesesvacationObservers', 'created')
            ) {

                try {
                    \App\Observers\TransactionspostessynthesesvacationObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionspostessynthesesvacationObservers') &&
                method_exists('\App\Observers\TransactionspostessynthesesvacationObservers', 'updating')
            ) {

                try {
                    \App\Observers\TransactionspostessynthesesvacationObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TransactionspostessynthesesvacationObservers') &&
                method_exists('\App\Observers\TransactionspostessynthesesvacationObservers', 'updated')
            ) {

                try {
                    \App\Observers\TransactionspostessynthesesvacationObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TransactionspostessynthesesvacationObservers') &&
                method_exists('\App\Observers\TransactionspostessynthesesvacationObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TransactionspostessynthesesvacationObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TransactionspostessynthesesvacationObservers') &&
                method_exists('\App\Observers\TransactionspostessynthesesvacationObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TransactionspostessynthesesvacationObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', '');
    }

    public function getTransactionsTotalsAttribute($value)
    {
        return $value;
    }

    public function setTransactionsTotalsAttribute($value)
    {
        $this->attributes['transactions_totals'] = $value ?? "";
    }

    public function getPosteIdAttribute($value)
    {
        return $value;
    }

    public function setPosteIdAttribute($value)
    {
        $this->attributes['poste_id'] = $value ?? "";
    }

    public function getTransactionsIdAttribute($value)
    {
        return $value;
    }

    public function setTransactionsIdAttribute($value)
    {
        $this->attributes['transactions_id'] = $value ?? "";
    }

    public function getTransactionsHeuresAttribute($value)
    {
        return $value;
    }

    public function setTransactionsHeuresAttribute($value)
    {
        $this->attributes['transactions_heures'] = $value ?? "";
    }

    public function getDateAttribute($value)
    {
        return $value;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ?? "";
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

