<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'invoices';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'customer_id',
        'amount',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function invoicePosts()
    {
        return $this->hasMany(Post::class, 'invoice_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'customer_id');
    }

    public function status()
    {
        return $this->belongsTo(PostStatus::class, 'status_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
