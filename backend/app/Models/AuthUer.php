<?php

namespace App\Models;

use App\Observers\Auth_uerObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class AuthUer extends Model
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
        'id',
        'username',
        'password',
        'Status',
        'last_login',
        'RoleID',
        'Remark',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',

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
        $this->table = 'auth_user';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\Auth_uerObservers') &&
                method_exists('\App\Observers\Auth_uerObservers', 'creating')
            ) {

                try {
                    Auth_uerObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\Auth_uerObservers') &&
                method_exists('\App\Observers\Auth_uerObservers', 'created')
            ) {

                try {
                    Auth_uerObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\Auth_uerObservers') &&
                method_exists('\App\Observers\Auth_uerObservers', 'updating')
            ) {

                try {
                    Auth_uerObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\Auth_uerObservers') &&
                method_exists('\App\Observers\Auth_uerObservers', 'updated')
            ) {

                try {
                    Auth_uerObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\Auth_uerObservers') &&
                method_exists('\App\Observers\Auth_uerObservers', 'deleting')
            ) {

                try {
                    Auth_uerObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\Auth_uerObservers') &&
                method_exists('\App\Observers\Auth_uerObservers', 'deleted')
            ) {

                try {
                    Auth_uerObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function getUsernameAttribute($value)
    {
        return $value;
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = $value ?? "";
    }

    public function getPasswordAttribute($value)
    {
        return $value;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value ?? "";
    }

    public function getStatusAttribute($value)
    {
        return $value;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['Status'] = $value ?? "";
    }

    public function getLastLoginAttribute($value)
    {
        return $value;
    }

    public function setLastLoginAttribute($value)
    {
        $this->attributes['last_login'] = $value ?? "";
    }

    public function getRoleIDAttribute($value)
    {
        return $value;
    }

    public function setRoleIDAttribute($value)
    {
        $this->attributes['RoleID'] = $value ?? "";
    }

    public function getRemarkAttribute($value)
    {
        return $value;
    }

    public function setRemarkAttribute($value)
    {
        $this->attributes['Remark'] = $value ?? "";
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

