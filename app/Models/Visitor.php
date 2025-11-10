<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'company', 'purpose', 'badge_no', 'checked_in_at', 'checked_out_at', 'created_by'
    ];

    protected $dates = [
        'checked_in_at',
        'checked_out_at',
        'created_at',
        'updated_at',
    ];

    // convenience accessors
    public function getStatusAttribute()
    {
        if ($this->checked_out_at) {
            return 'checked_out';
        }
        if ($this->checked_in_at) {
            return 'checked_in';
        }
        return 'not_checked_in';
    }

    public function getCheckedInAtFormattedAttribute()
    {
        return $this->checked_in_at ? $this->checked_in_at->toDateTimeString() : null;
    }

    public function getCheckedOutAtFormattedAttribute()
    {
        return $this->checked_out_at ? $this->checked_out_at->toDateTimeString() : null;
    }
}
