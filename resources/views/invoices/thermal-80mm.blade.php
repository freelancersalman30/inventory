<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POS Receipt #{{ $sale->invoice_number }}</title>
    <style>
        @page { size: 80mm auto; margin: 0; }
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 78mm;
            margin: 0 auto;
            padding: 5mm;
            font-size: 11px;
            color: #000;
            background: #fff;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 2px 0; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h2 class="bold" style="margin: 0;">{{ $business->name ?? 'DPCB INVENTORY POS' }}</h2>
        <p style="margin: 2px 0;">{{ $business->address ?? 'Dhaka, Bangladesh' }}</p>
        <p style="margin: 2px 0;">Phone: {{ $business->phone ?? 'N/A' }}</p>
    </div>

    <div class="divider"></div>

    <div>
        <p style="margin: 2px 0;">Invoice #: <span class="bold">{{ $sale->invoice_number }}</span></p>
        <p style="margin: 2px 0;">Date: {{ $sale->sale_date->format('Y-m-d h:i A') }}</p>
        <p style="margin: 2px 0;">Cashier: {{ $sale->cashier->name ?? 'Staff' }}</p>
        <p style="margin: 2px 0;">Customer: {{ $sale->customer->name ?? 'Walk-in Guest' }}</p>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th class="text-left">Item</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
                <tr>
                    <td>{{ $item->variant->product->name }}</td>
                    <td class="text-center">{{ number_format($item->quantity, 0) }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Subtotal:</td>
            <td class="text-right">৳{{ number_format($sale->subtotal, 2) }}</td>
        </tr>
        @if ($sale->discount_amount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-right">-৳{{ number_format($sale->discount_amount, 2) }}</td>
            </tr>
        @endif
        @if ($sale->vat_amount > 0)
            <tr>
                <td>VAT:</td>
                <td class="text-right">৳{{ number_format($sale->vat_amount, 2) }}</td>
            </tr>
        @endif
        <tr class="bold">
            <td>Grand Total:</td>
            <td class="text-right">৳{{ number_format($sale->grand_total, 2) }}</td>
        </tr>
        <tr>
            <td>Paid Amount:</td>
            <td class="text-right">৳{{ number_format($sale->paid_amount, 2) }}</td>
        </tr>
        @if ($sale->due_amount > 0)
            <tr class="bold">
                <td>Due Amount:</td>
                <td class="text-right">৳{{ number_format($sale->due_amount, 2) }}</td>
            </tr>
        @endif
    </table>

    <div class="divider"></div>

    <div class="text-center">
        <p>{{ $business->invoice_footer_note ?? 'Thank you for shopping with us!' }}</p>
        <p style="font-size: 9px;">Powered by DPCB POS</p>
    </div>
</body>
</html>
