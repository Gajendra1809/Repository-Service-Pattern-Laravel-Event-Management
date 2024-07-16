<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table="events";

    protected $fillable=[
        'user_id',
        'title',
        'description',
        'price',
        'date',
        'image',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($event) {
            if ($event->isForceDeleting()) {
                $event->tickets()->forceDelete();
            } else {
                $event->tickets()->delete();
            }
        });
    }

}
