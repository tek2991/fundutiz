<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'team_id',
        'type',
        'status',
        'sanctioned_at',
        'amount',
        'item',
        'vendor_name',
        'file_number',
        'is_gem',
        'non_gem_remark',
        'gem_non_availability',
        'gem_non_availability_remark',
        'sanctioner_id',
        'user_id',
        'financial_year_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sanctioned_at' => 'date',
        'is_gem' => 'boolean',
        'gem_non_availability' => 'boolean',
        'amount' => 'integer',
    ];

    /**
     * Append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'amount',
    ];

    /**
     * Hide the model's attributes for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'amount_in_cents',
    ];

    /**
     * Get the fund for the transaction.
     *
     */
    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }

    /**
     * Get the team for the transaction.
     *
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the sanctioner for the transaction.
     *
     */
    public function sanctioner()
    {
        return $this->belongsTo(Sanctioner::class);
    }

    /**
     * Get the last user for the transaction.
     *
     */
    public function lastUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the financial year for the transaction.
     *
     */
    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class);
    }


    /**
     * Interact with the amount_in_cents column.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $attributes['amount_in_cents'] / 100,

            set: fn ($value) => [
                'amount_in_cents' => $value * 100,
            ]
        );
    }
}
