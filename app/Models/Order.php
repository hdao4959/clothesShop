<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    const STATUS_ORDER_PENDING = "Chờ xác nhận";
    const STATUS_ORDER_CONFIRMED = 'Đã xác nhận';
    const STATUS_ORDER_PREPARING_GOODS = "Đang chuẩn bị hàng";
    const STATUS_ORDER_SHIPPING = "Đang vận chuyển";
    const STATUS_ORDER_DELIVERED = "Giao hàng thành công";
    const STATUS_ORDER_CANCELED = "Đã huỷ đơn";

    protected $fillable = [
        'order_code',
        'user_id',
        'name',
        'address',
        'phone_number',
        'email'
    ];


    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
