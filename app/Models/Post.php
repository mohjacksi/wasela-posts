<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'posts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'barcode',
        'sender_id',
        'receiver_name',
        'receiver_phone_number',
        'governorate_id',
        'city_id',
        'delivery_address',
        'sender_total',
        'delivery_price',
        'customer_invoice_total',
        'status_id',
        'notes',
        'invoice_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function sender()
    {
        return $this->belongsTo(CrmCustomer::class, 'sender_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function status()
    {
        return $this->belongsTo(PostStatus::class, 'status_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
