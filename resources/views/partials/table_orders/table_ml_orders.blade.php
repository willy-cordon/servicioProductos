<table class="dataTable table table-bordered table-striped table-hover datatable datatable-User">
    <thead>
    <tr>
        <th width="10" class="not-export-col">

        </th>
        <th>
            {{ trans('cruds.order.fields.id') }}
        </th>
        <th>
            {{ trans('cruds.order.fields.order_id') }}
        </th>
        <th>
            {{ trans('cruds.order.fields.seller_name') }}
        </th>
        <th>
            {{ trans('cruds.order.fields.total_paid_amount') }}
        </th>
        <th>
            {{ trans('cruds.order.fields.product_name') }}
        </th>
        <th>
            {{ trans('cruds.order.fields.method_paid') }}
        </th>
        <th>
            {{ trans('cruds.order.fields.status_order') }}
        </th>
        <th>
            {{ trans('cruds.order.fields.payer_nickname') }}
        </th>


        <th class="actions-3 not-export-col">
            &nbsp;
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($accountServiceOrders as $accountServiceOrder)
        @foreach($accountServiceOrder->external_data as $data)
            <tr data-entry-id="{{ $accountServiceOrder->id }}">
                <td>

                </td>
                <td>
                    {{ $accountServiceOrder->id ?? '' }}
                </td>
                <td>
                    {{ $accountServiceOrder->external_order_id ?? '' }}
                </td>
                <td>
                    {{ $data->seller->nickname ?? '' }}
                </td>
                <td>
                    ${{ $data->payments[0]->total_paid_amount ?? '' }}
                </td>
                <td>
                    {{ $data->payments[0]->reason ?? '' }}
                </td>
                <td>
                    {{ $data->payments[0]->payment_type ?? '' }}
                </td>
                <td>
                    {{ $data->payments[0]->status ?? '' }}
                </td>
                <td>
                    {{ $data->buyer->nickname ?? '' }}
                </td>


                <td>
                    <a class="btn btn-info" href="https://www.mercadolibre.com.ar/ventas/{{$accountServiceOrder->external_order_id}}/detalle" target="_blank"><i class="i-Eye"></i></a>

                </td>

            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
