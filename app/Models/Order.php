<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'Order';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $ignoreChangedAttributes = ['updated_at'];

    public const PENDING = 'pending';

    public const APPROVED = 'approved';

    public const REJECTED = 'rejected';

    public const PROCESSING = 'processing';

    public const SHIPPED = 'shipped';

    public const DELIVERED = 'delivered';

    protected $fillable = [ 'status', 'total' ];

    public function products (): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['price', 'qty', 'total']);
    }

    public function user (): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
