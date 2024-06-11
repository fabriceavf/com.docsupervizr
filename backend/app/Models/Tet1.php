<?php

namespace App\Models;

use App\Observers\Tet1Observers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Tet1 extends Model
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
        'pointage',
        'debut_prevu',
        'fin_revu',
        'programme_id',
        'user_id',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'programme',


        'user',


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
        $this->table = 'test1';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\Tet1Observers') &&
                method_exists('\App\Observers\Tet1Observers', 'creating')
            ) {

                try {
                    Tet1Observers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\Tet1Observers') &&
                method_exists('\App\Observers\Tet1Observers', 'created')
            ) {

                try {
                    Tet1Observers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\Tet1Observers') &&
                method_exists('\App\Observers\Tet1Observers', 'updating')
            ) {

                try {
                    Tet1Observers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\Tet1Observers') &&
                method_exists('\App\Observers\Tet1Observers', 'updated')
            ) {

                try {
                    Tet1Observers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\Tet1Observers') &&
                method_exists('\App\Observers\Tet1Observers', 'deleting')
            ) {

                try {
                    Tet1Observers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\Tet1Observers') &&
                method_exists('\App\Observers\Tet1Observers', 'deleted')
            ) {

                try {
                    Tet1Observers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id', '');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '');
    }

    public function getPointageAttribute($value)
    {
        return $value;
    }

    public function setPointageAttribute($value)
    {
        $this->attributes['pointage'] = $value ?? "";
    }

    public function getDebutPrevuAttribute($value)
    {
        return $value;
    }

    public function setDebutPrevuAttribute($value)
    {
        $this->attributes['debut_prevu'] = $value ?? "";
    }

    public function getFinRevuAttribute($value)
    {
        return $value;
    }

    public function setFinRevuAttribute($value)
    {
        $this->attributes['fin_revu'] = $value ?? "";
    }

    public function getProgrammeIdAttribute($value)
    {
        return $value;
    }

    public function setProgrammeIdAttribute($value)
    {
        $this->attributes['programme_id'] = $value ?? "";
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

