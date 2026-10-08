<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #12243a;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .pad {
            padding: 0 36px;
        }

        .h {
            background: #083b78;
            color: #ffffff;
            text-align: center;
            padding: 26px 36px;
        }

        .gold {
            background: #d69c1a;
            height: 5px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #083b78;
        }

        .label {
            color: #65758b;
            padding: 5px 0;
            width: 38%;
        }

        .box {
            background: #f5f8fc;
            border-left: 4px solid #d69c1a;
            padding: 10px 14px;
        }

        .items td {
            padding: 8px 10px;
            border-bottom: 1px solid #d5dfec;
        }

        .items th {
            background: #083b78;
            color: #ffffff;
            text-align: left;
            padding: 8px 10px;
        }

        /* .right {
            text-align: right;
        } */

        .total td {
            font-size: 15px;
            font-weight: bold;
            color: #083b78;
            padding: 10px;
        }

        .paid {
            color: #1a9c4f;
            font-weight: bold;
        }

        .small {
            font-size: 10px;
            color: #65758b;
        }
    </style>
</head>

<body>
    @php
        $user = $registration->user;
        $paidAt = ($registration->paid_at ?? now())->timezone('Asia/Kolkata');
    @endphp

    <div class="h">
        <div style="font-size:22px;font-weight:bold;">DiCD2026 Delhi</div>
        <div style="font-size:11px;margin-top:3px;">The flagship conference of IAAD</div>
        <div style="font-size:12px;margin-top:10px;color:#f2c65a;">Theme: THE CLINICAL EDGE - Where Diagnosis Meets
            Practice</div>
        <div style="font-size:11px;margin-top:6px;">Venue: The Leela Ambience, Gurugram &nbsp;|&nbsp; Date: 19 - 21
            December 2026</div>
    </div>
    <div class="gold"></div>

    <div class="pad" style="padding-top:22px;">
        <table>
            <tr>
                <td class="title">Payment Receipt</td>
                <td class="right paid">PAID</td>
            </tr>
        </table>

        <div class="box" style="margin-top:14px;">
            <table>
                <tr>
                    <td class="label">Registration no.</td>
                    <td><strong>{{ $registration->registration_number }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Payment reference</td>
                    <td>{{ $registration->payment_reference }}</td>
                </tr>
                <tr>
                    <td class="label">Order id</td>
                    <td>{{ $registration->gateway_order_id }}</td>
                </tr>
                <tr>
                    <td class="label">Paid on</td>
                    <td>{{ $paidAt->format('d M Y, h:i A') }} IST</td>
                </tr>
            </table>
        </div>

        <p style="margin:20px 0 6px;font-weight:bold;color:#083b78;">Delegate</p>
        <table>
            <tr>
                <td class="label">Name</td>
                <td>{{ $user->title }} {{ $user->name }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td class="label">Phone</td>
                <td>{{ $user->phone }}</td>
            </tr>
            <tr>
                <td class="label">Institution</td>
                <td>{{ $user->institution }}</td>
            </tr>
            <tr>
                <td class="label">Category</td>
                <td>{{ $user->category }}</td>
            </tr>
        </table>

        @if ($registration->accommodation === 'double' && !empty($registration->sharing))
            <p style="margin:18px 0 4px;font-weight:bold;color:#083b78;">Room sharing with</p>
            <p style="margin:0;">{{ $registration->sharing['title'] }} {{ $registration->sharing['name'] }}</p>
        @endif

        @if (!empty($registration->accompanying))
            <p style="margin:18px 0 4px;font-weight:bold;color:#083b78;">Accompanying persons</p>
            @foreach ($registration->accompanying as $p)
                <p style="margin:0 0 2px;">{{ $loop->iteration }}. {{ $p['title'] }} {{ $p['name'] }}</p>
            @endforeach
        @endif

        @if (!empty($registration->workshops))
            <p style="margin:18px 0 4px;font-weight:bold;color:#083b78;">Workshops</p>
            @foreach ($registration->workshops as $w)
                <p style="margin:0 0 2px;">{{ $loop->iteration }}. {{ $w }}</p>
            @endforeach
        @endif

        <table class="items" style="margin-top:22px;">
            <tr>
                <th>Description</th>
                <th class="right">Amount</th>
            </tr>
            @foreach ($registration->lineItems() as [$name, $price])
                <tr>
                    <td>{{ $name }}</td>
                    <td class="right">₹{{ number_format($price) }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="right">Subtotal</td>
                <td class="right">₹{{ number_format($registration->subtotal) }}</td>
            </tr>
            <tr>
                <td class="right">GST ({{ config('registration.gst') }}%)</td>
                <td class="right">₹{{ number_format($registration->gst_amount) }}</td>
            </tr>
            <tr class="total">
                <td class="right">Total paid</td>
                <td class="right">₹{{ number_format($registration->total) }}</td>
            </tr>
        </table>

        <p class="small" style="margin-top:26px;">This is a computer-generated receipt and does not require a
            signature.</p>
    </div>
</body>

</html>
