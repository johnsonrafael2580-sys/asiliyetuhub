<div style="font-family: Arial, sans-serif; color: #222;">
    <h3>{{ $data['title'] ?? 'Notification' }}</h3>
    <p>{{ $data['message'] ?? '' }}</p>
    @if(isset($data['product_id']))
        <p>Product ID: {{ $data['product_id'] }}</p>
    @endif
    <p style="font-size:12px;color:#666">This email was sent from AsiliYetuHub.</p>
</div>
