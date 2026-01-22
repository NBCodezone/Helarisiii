<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Generate WhatsApp link for admin notification
     *
     * @param string $message
     * @return string
     */
    public static function generateAdminLink($message)
    {
        $adminNumber = '94764823372'; // Without + sign for wa.me
        return self::generateWhatsAppLink($adminNumber, $message);
    }

    /**
     * Generate WhatsApp link with pre-filled message
     *
     * @param string $phoneNumber
     * @param string $message
     * @return string
     */
    public static function generateWhatsAppLink($phoneNumber, $message)
    {
        // Clean phone number (remove spaces, dashes, plus sign)
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // URL encode the message
        $encodedMessage = urlencode($message);

        // Generate wa.me link
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text={$encodedMessage}";

        // Log for debugging
        Log::info('WhatsApp Link Generated', [
            'to' => $phoneNumber,
            'url' => $whatsappUrl,
            'timestamp' => now()
        ]);

        return $whatsappUrl;
    }

    /**
     * Format order details for WhatsApp message
     *
     * @param \App\Models\Order $order
     * @return string
     */
    public static function formatOrderMessage($order)
    {
        $message = "🛒 *NEW ORDER #" . $order->id . "*\n\n";

        $message .= "👤 *Customer:*\n";
        $message .= "{$order->first_name} {$order->last_name}\n";
        $message .= "📧 {$order->email}\n";

        if ($order->mobile_number) {
            $message .= "📱 {$order->mobile_number}\n";
        }

        if ($order->whatsapp_number) {
            $message .= "💬 {$order->whatsapp_number}\n";
        }

        $message .= "\n📍 *Address:*\n";
        $message .= "{$order->apartment}\n";
        $message .= "{$order->city}, {$order->ken_name} {$order->postal_code}\n";

        $message .= "\n💰 *Total: ¥" . number_format($order->total_amount, 0) . "*\n";
        $message .= "(Subtotal: ¥" . number_format($order->subtotal, 0);
        $message .= " + Tax: ¥" . number_format($order->tax_amount, 0);
        $message .= " + Delivery: ¥" . number_format($order->delivery_charge, 0);

        if ($order->frozen_charge > 0) {
            $message .= " + Frozen: ¥" . number_format($order->frozen_charge, 0);
        }
        $message .= ")\n";

        $message .= "\n🛍️ *Items:*\n";
        if ($order->items && count($order->items) > 0) {
            foreach ($order->items as $item) {
                $productName = $item->product ? $item->product->product_name : 'Unknown Product';
                $message .= "• {$productName} x{$item->quantity}\n";
            }
        } else {
            $message .= "• Items loading...\n";
        }

        $message .= "\n💳 " . ucwords(str_replace('_', ' ', $order->payment_method));
        $message .= "\n⏰ " . $order->created_at->format('M d, Y H:i');

        return $message;
    }
}
