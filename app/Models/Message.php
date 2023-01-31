<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $appends = [
        'show_button'
    ];

    protected $formatDate = 'Y-m-d H:i';

    public function receiver()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function getTextAttribute($value)
    {
        return $this->trashed() ? 'Mensagem excluída' : $value;
    }

    public function getShowButtonAttribute()
    {
        return !$this->trashed() && auth()->user()->id == $this->attributes['sender_id'];
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

    public function getCreatedatAttribute($attribute)
    {
        return Carbon::parse($attribute)->format($this->formatDate);
    }
}
