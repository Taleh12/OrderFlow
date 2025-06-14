<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOrderNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        // Burada bildiriş və ya digər işlər, məsələn WebSocket mesajı göndərmə yazılır.
        // Məsələn:
        // event(new \App\Events\OrderStatusUpdated($order));

        // sadəcə nümunə olaraq log:
        Log::info('Yeni sifariş yaradıldı: #' . $order->id);
    }
}
