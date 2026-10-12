# Asili Yetu Hub – Customer Order & Delivery Update

## Main changes

1. Added explicit `customer` role.
2. Added `users.is_approved` so the existing artisan approval flow has a real database column.
3. Added `orders.customer_id` so every new cart checkout belongs to the logged-in customer.
4. Added `product_requests.order_id` so each request sent to an artisan can be traced back to the parent cart order.
5. Customers must authenticate before adding a product to cart or sending a direct product request.
6. Customer registration is available from the normal registration page and logs the new customer into the customer dashboard.
7. Customer login routes customers to `/customer/dashboard`.
8. Added customer dashboard with:
   - new and historical orders,
   - item-level order status,
   - shipment progress,
   - courier/tracking information,
   - delivery timeline,
   - in-app notifications.
9. Artisan status changes now notify the affected customer.
10. Fulfillment status changes also notify the affected customer and synchronize the product request/order status.
11. Fixed the broken `resources/views/cart/index.blade.php` file; it contained controller PHP instead of Blade markup.
12. Updated artisan dashboard status choices to match the actual shipment workflow.
13. Fixed notification "mark as read" so it marks notifications read instead of deleting them.
14. Fixed cart badge/count and stock-remaining calculations.
15. Updated the navigation so customer accounts do not attempt to load artisan-only routes.

## Important database note

The supplied SQL dump and the application migrations were out of sync. The supplied SQL was missing `orders.customer_id`, used `tourist` as the user role, and was missing `users.is_approved` and `product_requests.order_id`.

Use the supplied modified SQL dump for a direct database import, or run the new migration on an existing Laravel database:

`database/migrations/2026_09_28_000001_customer_order_tracking_alignment.php`

## Verification

PHP syntax checks passed for all modified PHP files.

`php artisan route:list` successfully registered the customer, cart, and notification routes.

Full `php artisan view:cache` could not be completed in the provided runtime because the PHP environment is missing the `DOM` extension (`Class "DOMDocument" not found`). This is an environment dependency issue, not a Blade syntax error reported by the application.

## 2026-10-01 — Automatic checkout and operations restructure

- Removed manual mobile-money agent selection, screenshot/proof upload, transaction-ID submission, and admin payment verification from the active checkout flow.
- Added Africa's Talking mobile-money checkout adapter with provider callback handling and idempotent automatic payment confirmation.
- Added automatic payment status polling on the customer payment page.
- Added product-request checkout fields for quantity, delivery location, and detailed customer requirements.
- Paid orders automatically create/activate artisan product requests and send email/WhatsApp notifications when configured.
- Delivery status can automatically settle paid escrow to the artisan; customer confirmation is no longer required for settlement.
- Artisan registration is automatically active; the old admin artisan-approval workflow is no longer part of the active navigation/routes.
- Admin payments screen is now a read-only operations/audit dashboard.
- Added `.env.example` with Africa's Talking and notification configuration.
