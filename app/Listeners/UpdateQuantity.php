<?php

namespace App\Listeners;

use App\Events\OrderCreate;
use App\Events\OrderCreated;
use App\Models\ProductVariant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreate $event): void
    {
        DB::beginTransaction();
        try {
            foreach ($event->data as $item) {
                $variant = ProductVariant::where([
                    ['product_id', $item['product_id']],
                    ['product_size_id', $item['size_id']]
                ])->first();

                if ($variant) {
                    $variant->quantity -= $item['quantity'];
                    $variant->save();

                    Log::info('Cập nhật số lượng hàng hoá:', [
                        'product_name' => $item['product_name'],
                        'size_name' => $item['size_name'],
                        'new_quantity' => $variant->quantity
                    ]);
                } else {
                    Log::warning('Không tìm thấy biến thể sản phẩm:', [
                        'product_id' => $item['product_id'],
                        'size_id' => $item['size_id']
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi cập nhật số lượng hàng hoá:', ['error' => $e->getMessage()]);
        }
    }
}
