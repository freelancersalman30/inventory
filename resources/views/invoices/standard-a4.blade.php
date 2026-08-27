<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $sale->invoice_number }} - {{ $business->name ?? 'DPCB INVENTORY' }}</title>
    <style>
        @page { size: A4; margin: 15mm; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            background: #fff;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #e2e8f0;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-b: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .company-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0 0 5px 0;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: 800;
            color: #2563eb;
            text-transform: uppercase;
            text-align: right;
            margin: 0;
        }
        .details-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .details-block { width: 48%; }
        .details-block h4 {
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            margin: 0 0 8px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            padding: 10px 12px;
            border-bottom: 2px solid #cbd5e1;
            text-align: left;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .text-right { text-align: right; }
        .totals-table {
            width: 320px;
            margin-left: auto;
        }
        .totals-table td {
            padding: 6px 12px;
        }
        .grand-total {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
            background: #eff6ff;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 11px;
        }
        @media print {
            .invoice-box { border: none; shadow: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="max-width: 800px; margin: 0 auto 15px auto; text-align: right;">
        <button onclick="window.print()" style="background: #2563eb; color: #fff; border: none; padding: 8px 18px; border-radius: 6px; font-weight: bold; cursor: pointer;">Print Invoice 🖨️</button>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div>
                <h1 class="company-title">{{ $business->name ?? 'DPCB INVENTORY POS' }}</h1>
                <p style="margin: 3px 0; color: #475569;">{{ $business->address ?? 'Dhaka, Bangladesh' }}</p>
                <p style="margin: 3px 0; color: #475569;">Phone: {{ $business->phone ?? 'N/A' }} | Email: {{ $business->email ?? 'sales@dpcb.com' }}</p>
            </div>
            <div>
                <h2 class="invoice-title">INVOICE</h2>
                <p style="margin: 5px 0 0 0; text-align: right; font-weight: bold; font-family: monospace;">#{{ $sale->invoice_number }}</p>
                <p style="margin: 3px 0 0 0; text-align: right; color: #64748b;">Date: {{ $sale->sale_date->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="details-grid">
            <div class="details-block">
                <h4>Billed To (Customer):</h4>
                <p style="font-weight: bold; margin: 0 0 4px 0; font-size: 14px;">{{ $sale->customer->name ?? 'Walk-in Guest Customer' }}</p>
                <p style="margin: 0 0 3px 0; color: #475569;">Phone: {{ $sale->customer->phone ?? 'N/A' }}</p>
                <p style="margin: 0; color: #475569;">Address: {{ $sale->customer->address ?? 'N/A' }}</p>
            </div>

            <div class="details-block">
                <h4>Payment Information:</h4>
                <p style="margin: 0 0 4px 0;">Status: <strong style="color: #059669; text-transform: uppercase;">{{ $sale->status }}</strong></p>
                <p style="margin: 0 0 4px 0;">Payment Method: <strong>{{ strtoupper($sale->payments->first()?->payment_method ?? 'CASH') }}</strong></p>
                <p style="margin: 0;">Issued By: <strong>{{ $sale->cashier->name ?? 'System' }}</strong></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 50%;">Item Description / SKU</th>
                    <th class="text-right" style="width: 15%;">Unit Price</th>
                    <th class="text-right" style="width: 10%;">Qty</th>
                    <th class="text-right" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->variant->product->name ?? 'Item' }}</strong>
                            <span style="display: block; font-size: 11px; color: #64748b; font-family: monospace;">SKU: {{ $item->variant->sku ?? 'N/A' }}</span>
                        </td>
                        <td class="text-right font-mono">৳{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right font-mono">{{ number_format($item->quantity, 0) }}</td>
                        <td class="text-right font-mono" style="font-weight: bold;">৳{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right" style="font-family: monospace;">৳{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            @if ($sale->discount_amount > 0)
                <tr>
                    <td>Discount:</td>
                    <td class="text-right" style="color: #dc2626; font-family: monospace;">-৳{{ number_format($sale->discount_amount, 2) }}</td>
                </tr>
            @endif
            @if ($sale->vat_amount > 0)
                <tr>
                    <td>VAT / Tax:</td>
                    <td class="text-right" style="font-family: monospace;">+৳{{ number_format($sale->vat_amount, 2) }}</td>
                </tr>
            @endif
            <tr class="grand-total">
                <td>Grand Total:</td>
                <td class="text-right" style="font-family: monospace;">৳{{ number_format($sale->grand_total, 2) }}</td>
            </tr>
            <tr>
                <td>Paid Amount:</td>
                <td class="text-right" style="color: #059669; font-family: monospace;">৳{{ number_format($sale->paid_amount, 2) }}</td>
            </tr>
            @if ($sale->due_amount > 0)
                <tr style="color: #dc2626; font-weight: bold;">
                    <td>Balance Due:</td>
                    <td class="text-right" style="font-family: monospace;">৳{{ number_format($sale->due_amount, 2) }}</td>
                </tr>
            @endif
        </table>

        <div class="footer">
            <p style="font-weight: bold;">{{ $business->invoice_footer_note ?? 'Thank you for your business!' }}</p>
            <p style="margin: 0; color: #94a3b8;">This is a computer-generated invoice and requires no physical signature.</p>
        </div>
    </div>
</body>
</html>
