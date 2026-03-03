
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>فاتورة رقم #{{ $order->id }}</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: 'Cairo', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
            table-layout: fixed;
        }
        table thead th {
            height: 28px;
            text-align: right;
            font-size: 16px;
            font-family: 'Cairo', sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        th, td {
            text-align: center;
            vertical-align: middle;
        }   

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: 'Cairo', sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: 'Cairo', sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        ..text-start {
            text-align: right;
        }

        .text-end {
            text-align: left;
        }

        .heading {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>

    <table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <h2 class="text-start">متجر زراعي</h2>
                </th>
                <th width="50%" colspan="2" class="text-center company-data">
                    <span>رقم الفاتورة: #{{ $order->id }}</span> <br>
                    <span>التاريخ: {{ $order->created_at }}</span> <br>
                    <span>العنوان: {{ $order->address }}</span> <br>
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">تفاصيل الطلب</th>
                <th width="50%" colspan="2">بيانات العميل</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="30%">رقم الطلب:</td>
                <td width="70%">{{ $order->id }}</td>

                <td width="30%">الاسم بالكامل:</td>
                <td width="70%">{{ $order->name ?? $order->user->name }}</td>
            </tr>
            <tr>
                <td width="30%">حالة الطلب:</td>
                <td width="70%">{{ match($order->status) {
                    'pending' => 'قيد الإنتظار',
                    'processing' => 'قيد التجهيز',
                    'shipped' => 'تم الشحن',
                    'delivered' => 'تم التسليم',
                    'cancelled' => 'تم الالغاء',
                    default => ucfirst($order->status),
                } }}</td>

                <td width="30%">الهاتف:</td>
                <td width="70%">{{ $order->phone ?? $order->user->phone }}</td>
            </tr>
            <tr>
                <td width="30%">تاريخ الطلب:</td>
                <td width="70%">{{ $order->created_at }}</td>

                <td width="30%">العنوان:</td>
                <td width="70%">{{ $order->address ?? 'غير محدد' }}</td>
            </tr>
            <tr>
                <td width="30%">طريقة الدفع:</td>
                <td width="70%">{{ $order->paymentMethod->name  ?? 'غير محدد'}}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    منتجات الطلب
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="10%">م</th>
                <th width="40%">المنتج</th>
                <th width="15%">السعر</th>
                <th width="15%">الكمية</th>
                <th width="20%">الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td width="10%">{{ $loop->iteration }}</td>
                <td width="20%">
                    {{ $item->product->name }}
                </td>
                <td width="10%">{{ $item->price }}</td>
                <td width="10%">{{ $item->quantity }}</td>
                <td width="15%" class="fw-bold">{{ $item->quantity * $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center total-heading">الخصم:</td>
                <td colspan="3" class="text-center total-heading">{{ $order->discount_amount ?? 0 }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center total-heading">الإجمالي:</td>
                <td colspan="3" class="text-center total-heading">{{ $order->final_amount }}</td>
            </tr>
        </tfoot>
    </table>

    <br>
    <p class="text-center">
        شكراً لتسوقكم من متجر زراعي - Zeraty Store
    </p>

</body>
</html>