@if ($loop->index == 0)
    <thead>
        <tr>
            <th> </th>
            @foreach ($module['cfg'] as $val)
                @if (isset($val['show_start']) && $val['show_start'])
                    <th>{{ $val['mod'] }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
@endif

<tr>

    <td>

        <a href="{{ route('modules.item_show_form', ['module_name' => $name, 'item_id' => $v->id, 'mod_action' => 'edit']) }}"
            class="btn btn-sm btn-info"><i class="far fa-edit"></i> редактировать</a>

        {{ $v->id }}

        <item-on-off item-id="{{ $v->id }}" item-status="{{ $v->status }}" ></item-on-off>

        <pre>{{ print_r($v) }}</pre>


    </td>

    @foreach ($module['cfg'] as $val)
        @if (isset($val['show_start']) && $val['show_start'])

            @if (isset($val['type']) && ($val['type'] == 'string' || $val['type'] == 'img'))
                <td>
                    @include('didrive.modules.items-start-'.$val['type'], [
                    'key' => $val['mod'] ,
                    'value' => ( $val['url_start'] ?? '' ).$v->{ $val['mod'] }.( $val['url_end'] ?? '' )
                    ] )
                </td>
            @endif

        @endif
    @endforeach
</tr>
