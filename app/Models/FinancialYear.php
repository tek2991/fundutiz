<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'is_active',
    ];

    /**
     * Active the financial year.
     *
     * @return void
     */
    public function activate()
    {
        FinancialYear::where('is_active', true)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

    /**
     * Deactive the financial year.
     * 
     * @return void
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }
}
