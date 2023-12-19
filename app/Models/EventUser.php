<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventUser extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'event_user';
    protected $fillable = [
        'user_id',
        'event_id'
    ];
    public function event () : BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
