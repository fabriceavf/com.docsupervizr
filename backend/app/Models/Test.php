<?php

namespace App\Models;

use App\Observers\TestObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Test extends Model
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
        'transactions_heures',
        'transactions_id',
        'matricule',
        'date',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


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
        $this->table = 'tests';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TestObservers') &&
                method_exists('\App\Observers\TestObservers', 'creating')
            ) {

                try {
                    TestObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TestObservers') &&
                method_exists('\App\Observers\TestObservers', 'created')
            ) {

                try {
                    TestObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TestObservers') &&
                method_exists('\App\Observers\TestObservers', 'updating')
            ) {

                try {
                    TestObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TestObservers') &&
                method_exists('\App\Observers\TestObservers', 'updated')
            ) {

                try {
                    TestObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TestObservers') &&
                method_exists('\App\Observers\TestObservers', 'deleting')
            ) {

                try {
                    TestObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TestObservers') &&
                method_exists('\App\Observers\TestObservers', 'deleted')
            ) {

                try {
                    TestObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

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

    public function getMatriculeAttribute($value)
    {
        return $value;
    }

    public function setMatriculeAttribute($value)
    {
        $this->attributes['matricule'] = $value ?? "";
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


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";


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

