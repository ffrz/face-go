<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Employee extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nik',
        'password',
        'name',
        'phone',
        'address',
        'active',
        'notes',
        'last_login_datetime',
        'last_activity_description',
        'last_activity_datetime'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function setLastLogin()
    {
        $this->last_login_datetime = now();
        $this->save();
    }

    public function setLastActivity($description)
    {
        $this->last_activity_description = $description;
        $this->last_activity_datetime = now();
        $this->save();
    }

    public static function activeCustomerCount()
    {
        return DB::select(
            'select count(0) as count from employees where active=1'
        )[0]->count;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'created_datetime')) {
                $model->created_datetime = current_datetime();
                $model->created_by_uid = Auth::id();
            }
            return true;
        });

        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_datetime')) {
                $model->updated_datetime = current_datetime();
                $model->updated_by_uid = Auth::id();
            }
            return true;
        });
    }

    public static function totalActiveBalance()
    {
        return DB::select(
            'select sum(balance) as sum from employees where active=1'
        )[0]->sum;
    }

    public static function totalActiveDebt()
    {
        return DB::select(
            'select sum(balance) as sum from employees where active=1 and balance < 0'
        )[0]->sum;
    }

    public static function totalActiveCredit()
    {
        return DB::select(
            'select sum(balance) as sum from employees where active=1 and balance > 0'
        )[0]->sum;
    }
}
