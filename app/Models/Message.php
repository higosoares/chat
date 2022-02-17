<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'messages';

    protected $primaryKeyy = 'id';

    protected $fillable = [
        'text',
        'sender_id',
        'receiver_id',
        'is_read',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     * @param  string  $value
     * @return void
     */
    public function setCreatedatAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::now();
    }

    /**
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i');
    }
}
