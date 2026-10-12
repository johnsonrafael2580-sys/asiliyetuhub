<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WhatsAppSetting;
use App\Models\WhatsAppMessage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppIntegrationController extends Controller
{
   
    public function configure()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'artisan') {
            return redirect()->back()
                ->with('error', 'Only artisans can configure communication settings.');
        }

        $settings = WhatsAppSetting::firstOrCreate(
            ['artisan_id' => $user->id],
            [
                'whatsapp_number' => $user->phone ?? '',
                'upload_method' => 'web',
                'whatsapp_enabled' => true,
                'receive_product_alerts' => true,
            ]
        );

        return view('whatsapp.configure', compact('settings'));
    }

   
    public function storeSettings(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'artisan') {
            return redirect()->back()
                ->with('error', 'Only artisans can configure communication settings.');
        }

        $request->validate([
            'whatsapp_number' => [
                'nullable',
                'regex:/^\+?[1-9]\d{7,14}$/',
            ],

            'upload_method' => [
                'required',
                'in:whatsapp,ussd,sms,web,manager',
            ],

            'whatsapp_enabled' => [
                'nullable',
                'boolean',
            ],

            'receive_product_alerts' => [
                'nullable',
                'boolean',
            ],
        ]);

        $method = $request->input('upload_method');

        
        $existingSetting = WhatsAppSetting::where('artisan_id', $user->id)->first();
        $whatsappNumber = $request->input('whatsapp_number') 
            ?? $existingSetting->whatsapp_number 
            ?? $user->phone 
            ?? '';

        WhatsAppSetting::updateOrCreate(
            ['artisan_id' => $user->id],
            [
                'whatsapp_number' => $whatsappNumber,
                'upload_method' => $method,
                'whatsapp_enabled' => $request->boolean('whatsapp_enabled'),
                'receive_product_alerts' => $request->boolean('receive_product_alerts'),
            ]
        );

       
        $formatPhoneNumber = function ($phone) {
            $cleaned = preg_replace('/\D+/', '', $phone);
            if (str_starts_with($cleaned, '0')) {
                $cleaned = '255' . substr($cleaned, 1);
            }
            return $cleaned;
        };

       

        switch ($method) {

           
            case 'web':
                if (\Illuminate\Support\Facades\Route::has('products.create')) {
                    return redirect()->route('products.create')
                        ->with('success', 'Njia ya Web imechaguliwa. Unaweza kuanza kupakia bidhaa yako sasa.');
                }

                return redirect()
                    ->route('artisan.dashboard')
                    ->with(
                        'success',
                        'Web Portal selected successfully. You can now manage your products from the web dashboard.'
                    );

            
            case 'whatsapp':

               
                $adminWhatsapp = config(
                    'services.whatsapp.contact_number',
                    env('WHATSAPP_CONTACT_NUMBER', '255698088657')
                );

                $adminPhoneFormatted = $formatPhoneNumber($adminWhatsapp);

               
                $artisanPhone = $user->phone ?? $whatsappNumber ?? 'Haijawekwa';
                $message = urlencode(
                    "Habari Admin (Asili Yetu Hub), mimi ni mjasiriamali {$user->name} (Namba ya Simu: {$artisanPhone}). Nimechagua kutumia WhatsApp kwa ajili ya kupakia bidhaa na kupokea taarifa za oda."
                );

                $whatsappUrl = "https://wa.me/{$adminPhoneFormatted}?text={$message}";

                return redirect()->away($whatsappUrl);

           
            case 'ussd':

                $ussdCode = config(
                    'services.ussd.code',
                    env('USSD_CODE', '*150*00#')
                );

                $encodedUssd = str_replace('#', '%23', $ussdCode);

                return redirect()->away("tel:{$encodedUssd}");

           
            case 'sms':

                
                $adminSms = config(
                    'services.sms.contact_number',
                    env('SMS_CONTACT_NUMBER', '255626684257')
                );

                $adminSmsFormatted = $formatPhoneNumber($adminSms);

                $artisanPhone = $user->phone ?? $whatsappNumber ?? 'Haijawekwa';
                $smsMessage = urlencode(
                    "Habari Admin, mimi ni mjasiriamali {$user->name} (Simu: {$artisanPhone}). Nimechagua njia ya SMS kwa ajili ya kupakia bidhaa na kupokea taarifa."
                );

                return redirect()->away("sms:+{$adminSmsFormatted}?body={$smsMessage}");

            
            case 'manager':

                return redirect()
                    ->route('artisan.dashboard')
                    ->with(
                        'success',
                        'Njia ya Msimamizi wa Kikundi imechaguliwa. Tafadhali wasiliana na msimamizi wako kwa ajili ya kupakia bidhaa.'
                    );

           
            default:

                return redirect()
                    ->route('artisan.dashboard')
                    ->with(
                        'success',
                        'Communication method saved successfully.'
                    );
        }
    }

   
    public function sendProductAlert(Product $product)
    {
        $artisan = $product->artisan;

        if (!$artisan) {
            return response()->json([
                'error' => 'Product artisan not found.'
            ], 404);
        }

        $settings = $artisan->whatsappSettings;

        if (!$settings || !$settings->whatsapp_enabled) {
            return response()->json([
                'error' => 'WhatsApp is not configured for this artisan.'
            ], 400);
        }

        $message = $this->formatProductMessage($product);

        return response()->json(
            $this->sendWhatsAppMessage(
                $settings->whatsapp_number,
                $message,
                $artisan->id,
                $product->id,
                'product_update'
            )
        );
    }

   
    public function sendOrderNotification($productRequestId)
    {
        $productRequest = \App\Models\ProductRequest::with(
            'product.artisan'
        )->findOrFail($productRequestId);

        if (!$productRequest->product) {
            return response()->json([
                'error' => 'Product not found.'
            ], 404);
        }

        $artisan = $productRequest->product->artisan;

        if (!$artisan) {
            return response()->json([
                'error' => 'Artisan not found.'
            ], 404);
        }

        $settings = $artisan->whatsappSettings;

        if (!$settings || !$settings->whatsapp_enabled) {
            return response()->json([
                'error' => 'WhatsApp is not configured.'
            ], 400);
        }

        $message = $this->formatOrderMessage($productRequest);

        return response()->json(
            $this->sendWhatsAppMessage(
                $settings->whatsapp_number,
                $message,
                $artisan->id,
                $productRequest->product_id,
                'order_notification'
            )
        );
    }

    
    public function handleIncomingMessage(Request $request)
    {
        $payload = $request->all();

        WhatsAppMessage::create([
            'phone_number' => $payload['from'] ?? '',
            'message_content' => $payload['body'] ?? '',
            'message_type' => 'incoming',
            'status' => 'received',
        ]);

        return response()->json([
            'status' => 'received'
        ]);
    }

   
    private function sendWhatsAppMessage(
        $phoneNumber,
        $message,
        $artisanId = null,
        $productId = null,
        $type = 'generic'
    ) {
        $apiKey = config('services.whatsapp.api_key');
        $apiUrl = config('services.whatsapp.api_url');

        if (!$apiKey || !$apiUrl) {

            Log::warning(
                'WhatsApp API is not configured.'
            );

            return [
                'status' => 'skipped',
                'reason' => 'WhatsApp API not configured',
            ];
        }

        try {

            $response = Http::timeout(20)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post(
                    rtrim($apiUrl, '/') . '/send',
                    [
                        'phone' => $phoneNumber,
                        'body' => $message,
                    ]
                );

            if ($response->failed()) {

                throw new \RuntimeException(
                    'WhatsApp API returned HTTP ' .
                    $response->status()
                );
            }

            $messageId = $response->json('id');

            WhatsAppMessage::create([
                'artisan_id' => $artisanId,
                'product_id' => $productId,
                'message_type' => $type,
                'phone_number' => $phoneNumber,
                'message_content' => $message,
                'status' => 'sent',
                'whatsapp_message_id' => $messageId,
                'sent_at' => now(),
            ]);

            return [
                'status' => 'sent',
                'message_id' => $messageId,
            ];

        } catch (\Throwable $e) {

            Log::error(
                'WhatsApp message failed.',
                [
                    'artisan_id' => $artisanId,
                    'product_id' => $productId,
                    'error' => $e->getMessage(),
                ]
            );

            WhatsAppMessage::create([
                'artisan_id' => $artisanId,
                'product_id' => $productId,
                'message_type' => $type,
                'phone_number' => $phoneNumber,
                'message_content' => $message,
                'status' => 'failed',
                'error_details' => $e->getMessage(),
            ]);

            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    
    private function formatProductMessage(Product $product)
    {
        return
            "📦 Asili Yetu Hub - Product Update\n\n" .
            "Title: {$product->title}\n" .
            "Price: TZS " .
            number_format($product->price, 2) . "\n" .
            "Category: {$product->category}\n" .
            "Available: " .
            ($product->is_available ? 'Yes' : 'No') .
            "\n\n" .
            "Log in to Asili Yetu Hub to view details.";
    }

    
    private function formatOrderMessage($productRequest)
    {
        return
            "🎉 Asili Yetu Hub - New Order\n\n" .
            "Product: {$productRequest->product->title}\n" .
            "Customer: {$productRequest->customer_name}\n" .
            "Message: {$productRequest->message}\n\n" .
            "Log in to Asili Yetu Hub to respond to this order.";
    }
}
