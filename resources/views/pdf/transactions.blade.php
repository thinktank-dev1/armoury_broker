<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transactions</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> -->
    <style>
        body,table{
            /*font-family: "Montserrat", sans-serif;*/
            font-family: Verdana, Arial, sans-serif;
            font-weight: 300;
            font-size: 16px;
            color: #0f1f24;
        }
        h1, h2, h3, h4, h5, h6, p, a{
            color: #0f1f24;
            font-family: "Montserrat", sans-serif;
        }
        table {
            width: 100%;
        }
        table,th,td {
            border: none;
            border-collapse: collapse;
        }
        .products{
            border-collapse: collapse;
        }
        .products tr, .products th, .products td {
            border: 1px solid #ccc;
        }
        .products th,.products td{
            padding: 8px;
        }
        table{
            font-size: x-small;
        }
        table th{
            font-size: 16px;
        }
    </style>

</head>
<body>
    <table>
        <tr>
            <td>
                <h2>Transactions</h2>
            </td>
            <td style="text-align: right;">
                <img src="{{ public_path('img/logo.png') }}" style="height: 20px">
            </td>
        </tr>
    </table>
    <div class="margin-top">
        <table class="products" style="width: 100%;">
            <tr>
                <th style="text-align: left;">Date</th>
                <th style="text-align: left;">Description</th>
                <th style="text-align: right;">Amount</th>
                <th style="text-align: left;">Status</th>
            </tr>
 
           @foreach($data as $item)
                 <tr class="items">
                    <th style="font-size: 12px; text-align: left;">
                        {{ date('d M Y', strtotime($item['date'])) }}
                    </th>
                    <th style="font-size: 12px; text-align: left;">
                        {{ ucwords(str_replace('_', ' ',$item['name'])) }}
                    </th>
                    <th style="font-size: 12px; text-align: right;">
                        {{ number_format($item['amount'],2) }}
                    </th>
                    <th style="font-size: 12px; text-align: left;">
                        {{ $item['status'] }}
                    </th>
                 </tr>
           @endforeach
        </table>
    </div>
</body>
</html>