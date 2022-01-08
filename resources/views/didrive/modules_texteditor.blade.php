@extends('didrive.app.app')


@section('menu_modules')
    @foreach ($module as $name => $dops)

        {{-- <pre> --}}
        {{-- {{ print_r($name)}} --}}
        {{-- {{ print_r($dops)}} --}}
        {{-- </pre> --}}

        <a href="{{ route('modules.index', ['module_name' => $name]) }}">{{ $dops['name'] }}</a>
        <br />

    @endforeach
@endsection

@section('content')

    <section class="content">


        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        {{-- showEditForm222 {{ showEditForm }} --}}
        {{-- <div v-if="showEditForm" >  показ html редактирование страницы 222 </div> --}}
        {{-- $superCode {{ $superCode ?? 'xx' }} // --}}

        {{-- <br />
        <br />
        module_now {{ $module_now ?? 'x' }}
        <br />
        <br />
        module_name {{ $module_name ?? 'xx' }} --}}

        <form action="/set-api/save-page" method="post">
            <textarea name="editor" id="editor1" rows="10" style="max-width: 100%">{!! $html !!}</textarea>
            <br />
            <br />
            <input type="submit" name="save" value="Сохранить" class="btn btn-success" />
            <input type="hidden" name="now_mod" value="{{ $module_name }}" />
            {{ csrf_field() }}
        </form>

        <router-view name="di_content"></router-view>

    </section>

@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <script src="/js.lib/cfgEditCongig.js?2"></script>
@endsection
