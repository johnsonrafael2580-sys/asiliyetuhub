<div style="font-family: Arial, sans-serif; padding: 20px; background-color: #FAF7F2; color: #3D2314;">
    <h2 style="color: #3D2314;">Habari, Mtaalamu / Fundi!</h2>
    <p>Una ombi jipya la bidhaa kutoka kwa mteja kupitia mtandao wa <strong>Asili Yetu Hub</strong>.</p>
    
    <div style="background: #ffffff; padding: 15px; border-radius: 10px; border: 1px solid #e5e7eb; margin-top: 15px;">
        <p><strong>Jina la Bidhaa:</strong> {{ $productRequest->product->title }}</p>
        <p><strong>Bei:</strong> TZS {{ number_format($productRequest->product->price, 2) }}</p>
        <p><strong>Jina la Mteja:</strong> {{ $productRequest->customer->name }}</p>
        <p><strong>Barua Pepe ya Mteja:</strong> {{ $productRequest->customer->email }}</p>
        <p><strong>Ujumbe wa Mteja:</strong> {{ $productRequest->message ?? 'Hakuna ujumbe maalum.' }}</p>
    </div>

    <p style="margin-top: 20px;">Tafadhali ingia kwenye Dashibodi yako ya Asili Yetu Hub kushughulikia ombi hili.</p>
    <p>Asante,<br><strong>Timu ya Asili Yetu Hub</strong></p>
</div>