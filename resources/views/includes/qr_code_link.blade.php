

@if($type == 'inventory')
{!! QrCode::size(100)->generate(env('APP_URL').'/inventory_profile/'.$dataId); !!}
@endif

@if($type == 'warehouse')
{!! QrCode::size(100)->generate(env('APP_URL').'/warehouse_transfer_order_profile/'.$dataId); !!}
@endif

@if($type == 'vendor_register_form')
{!! QrCode::size(300)->generate(env('APP_URL').'/vendor_register_form'); !!}
@endif

@if($type == 'hse_report_form')
{!! QrCode::size(300)->generate(env('APP_URL').'/hse_report_form'); !!}
@endif

