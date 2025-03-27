<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header,
        .footer {
            text-align: start;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .company-info {
            width: 100%;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .company-info div,
        .invoice-details div {
            width: 45%;
        }

        table {
            width: 100%;
            border-collapse: separate;
            margin-top: 20px;
        }

        td {
            background: lightgray;
        }

        th {
            background: gray;
            color: white;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .summary-table {
            width: 100%;
            float: right;
            margin-top: 20px;
        }

        .summary-table th,
        .summary-table td {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
        }

        .footer {
            font-size: 0.9em;
            color: gray;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>BidinLine</h1>
    </div>

    <table style="border:none !important;">
        <tr>
            <td style="background: none !important;">
                <div>
                    <strong>{{ __('lang.addr_one') }}</strong><br>
                    {{ __('lang.addr_two') }}<br>
                    {{ __('lang.addr_three') }}<br>
                    {{ __('lang.addr_four') }}
                </div>
            </td>
            <td style="background: none !important;">
                <div style="background: lightgray; padding: 10px;border: 2px solid black;">
                    <strong>{{ $user->name }}</strong><br>
                    {{ $user->address }}<br>
                    {{ $user->city }} - {{ $states->nombre }}<br>
                    {{ $user->postal_code }} - {{ $country->nombre }}<br>
                    {{ $user->tin }}
                </div>
            </td>
        </tr>
    </table>

    <div class="invoice-details">
        <div>
            <table>
                <tr>
                    <th>{{ __('lang.document') }}</th>
                    <th>{{ __('lang.inv_number') }}</th>
                    <th>{{ __('lang.inv_Date') }}</th>
                </tr>
                <tr>
                    <td>{{ __('lang.inv_Factura') }}</td>
                    <td>{{$invoice_id}}</td>
                    <td>{{ $date }}</td>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <th>N.I.F</th>
                    <th>{{ __('lang.inv_pay_method') }}  </th>
                </tr>
                <tr>
                    <td>B70515507</td>
                    <td>{{ __('lang.inv_bank_transfer') }}</td>
                </tr>
            </table>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>{{ __('lang.inv_item') }}</th>
                <th>{{ __('lang.inv_desc') }}</th>
                <th>{{ __('lang.inv_quantity') }}</th>
                <th>{{ __('lang.inv_unit') }}</th>
                <th>{{ __('lang.inv_subtotal') }}</th>
                <th>{{ __('lang.inv_discount') }}</th>
                <th>{{ __('lang.inv_total') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.</td>
                {{-- <td>Pago tarifa de Información</td> --}}
                <td>{{ __('lang.inv_payment_info') }}</td>
                <td>1</td>
                <td>{{ $subtotal }} {{ $country_code }}</td>
                <td>{{ $subtotal }} {{ $country_code }}</td>
                <td></td>
                <td>{{ $subtotal }} {{ $country_code }}</td>
            </tr>
        </tbody>
    </table>
    @if ($country_code == 'EUR')
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Importe</th>
                    <th>Base</th>
                    <th>I.V.A.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $tax_rate }}%</td>
                    <td>{{ $subtotal }} {{ $country_code }}</td>
                    <td>{{ $subtotal }} {{ $country_code }}</td>
                    <td>{{ $tax }} {{ $country_code }}</td>
                </tr>
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <th>{{ __('lang.inv_total') }}:</th>
                <td>{{ $total }} {{ $country_code }}</td>
            </tr>
            <tr>
                <td colspan="2">(Incluye {{ $tax }} {{ $country_code }} de I.V.A.)</td>
            </tr>
        </table>
    @else
        <table class="summary-table">
            <tr>
                <th>{{ __('lang.inv_total') }}:</th>
                <td> {{ $subtotal }} EUR</td>
            </tr>
        </table>
    @endif
    <table>
        <tr>
            <td>
            <!-- <p>64.6 Energy Efficiency SL empresa registrada en Registro Mercantil de Santiago de Compostela Tomo 303 Libro 0 Folio 67 Hoja SC-48855 Inscrip 1.</p> -->

            </td>
        </tr>
    </table>

    <p style="margin-top: 50%">{{ __('lang.footer_addr') }}</p>

</body>

</html>
