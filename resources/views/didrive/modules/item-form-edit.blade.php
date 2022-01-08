@extends('didrive.modules')

@section('content')

{{ $now_module }}

    <item-block></item-block>

@endsection


@section('content2')

    @if (session('status'))
        <div class="alert alert-warning">
            {{ session('status') }}
        </div>
    @endif

    <h2>edit item</h2>

    <br />
    <br />

    <form method="post" action="" enctype="multipart/form-data">

        @csrf
        <input type="hidden" name="id" value="{{ $data_item->id }}">

        {{-- <br />
        <br />
        id -
        <br /> --}}

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        @foreach ($data_item as $k => $v)
            @foreach ($module[$now_module]['cfg'] as $key => $val)

                {{-- <br/>{{ $key }} --}}
                {{-- <br/>{{ $data_item->{$key} }} --}}

                @if ($k == $key)

                    {{-- @if (!empty($val['name'])) --}}

                    <div class="form_edit_row">

                        @if (isset($val['type']) && ($val['type'] == 'string' || $val['type'] == 'sort' || $val['type'] == 'img'))

                            @include('didrive.modules.form-edit.items-'.$val['type'], [
                            'name' => $val['name'] ?? $key ,
                            'key' => $key ,
                            'value' => ( $val['url_start'] ?? '' ).$data_item->{$key}.( $val['url_end'] ?? '' )
                            // 'value' => 111
                            ] )

                        @endif

                    </div>

                    {{-- <pre>{{ print_r([$key, $val]) }}</pre> --}}

                    {{-- @endif --}}
                @endif

            @endforeach

        @endforeach


        <br />
        <br />

        Видимость:
        <label><input type="radio" name="status" value="show" @if ($data_item->status == 'show') checked @endif> Видно </label>
        <label><input type="radio" name="status" value="hide" @if ($data_item->status == 'hide') checked @endif> Не Видно </label>

        <br />
        <br />
        <br />

        <input type="submit" class="btn btn-success" value="Сохранить">

    </form>



    11

    <pre style="max-height:300px; overflow: auto;">{{ print_r($_POST) }}</pre>
    11

    <pre style="max-height:300px; overflow: auto;">{{ print_r($module[$now_module]) }}</pre>

    222

    <pre style="max-height:300px; overflow: auto;">{{ print_r($data_item) }}</pre>



@endsection


@section('css')
    @parent
    <style>
        .form_edit_row {
            display: grid;
            grid-template-columns: 110px auto;
            /* grid-template-rows: auto; */
            /* grid-row-gap: 10px; */
            grid-template-areas: "key value";
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: 10px;
            padding-bottom: 10px;
        }

        .form_edit_row .k {
            grid-area: key;
        }

        .form_edit_row .v {
            grid-area: value;
        }

    </style>
@endsection
