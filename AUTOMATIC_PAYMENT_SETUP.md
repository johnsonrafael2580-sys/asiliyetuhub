# Asili Yetu Hub — Automatic Payments Setup

The active checkout no longer uses payment agents, screenshots, transaction-ID submission, or admin payment verification.

## 1. Africa's Talking credentials

Add these values to the production `.env`:

```env
AT_USERNAME=your_africas_talking_username
AT_API_KEY=your_africas_talking_api_key
AT_ENVIRONMENT=live
AT_PAYMENTS_URL=https://payments.africastalking.com
AT_PAYMENT_PRODUCT_NAME="Asili Yetu Hub"
AT_PAYMENT_CURRENCY=TZS
AT_PAYMENT_PROVIDER_CHANNEL=
AT_PAYMENT_CALLBACK_URL=https://your-domain.example/payments/africastalking/callback/YOUR_RANDOM_SECRET
AT_PAYMENT_CALLBACK_SECRET=YOUR_RANDOM_SECRET
```

For sandbox testing use:

```env
AT_ENVIRONMENT=sandbox
AT_SANDBOX_PAYMENTS_URL=https://payments.sandbox.africastalking.com
```

The provider callback URL must be publicly reachable over HTTPS. Configure the same callback URL in the Africa's Talking payment product/channel settings.

## 2. Email notifications

Configure Laravel SMTP in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@your-domain.example
MAIL_FROM_NAME="Asili Yetu Hub"
```

## 3. WhatsApp notifications

The project keeps the existing WhatsApp gateway adapter. Set:

```env
WHATSAPP_API_KEY=...
WHATSAPP_API_URL=https://your-whatsapp-provider.example/api
```

The adapter posts to `{WHATSAPP_API_URL}/send` with `phone` and `body`, matching the gateway contract already used by the project.

## 4. Database

Run:

```bash
php artisan migrate --force
```

The new migration adds:

- automatic payment provider request/transaction fields
- customer order description and delivery location
- per-item product description
- payment states for automatic processing/failure
- automatic approval of existing artisan accounts

## 5. Payment lifecycle

1. Customer selects a product or checks out the cart.
2. Customer enters delivery location and product requirements/description.
3. The order is created and the payment prompt is sent automatically to the customer's phone.
4. Africa's Talking posts the final provider status to the callback URL.
5. A successful callback marks the payment paid, creates/activates the artisan request, and notifies the customer and artisan.
6. Artisan updates packaging/shipping/tracking status.
7. When the shipment becomes `delivered`, paid escrow is settled automatically; no customer or admin payment confirmation is required.
8. Customer sees the status timeline in the dashboard and receives email/WhatsApp updates when configured.

## Important

Do not put API keys in source code or commit `.env`. The repository only contains configuration placeholders in `.env.example`.
