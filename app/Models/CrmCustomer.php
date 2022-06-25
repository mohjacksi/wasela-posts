<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmCustomer extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'crm_customers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'status_id',
        'email',
        'phone',
        'address',
        'description',
        'capital_default_price',
        'other_default_price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function customerCrmNotes()
    {
        return $this->hasMany(CrmNote::class, 'customer_id', 'id');
    }

    public function customerInvoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id', 'id');
    }

    public function senderPosts()
    {
        return $this->hasMany(Post::class, 'sender_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(CrmStatus::class, 'status_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
