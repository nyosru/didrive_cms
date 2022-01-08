<hr>
<hr>
module items tpl
<hr>

@if ( !empty($data_module) )
    <table class="table">
        @foreach ($data_module as $k => $v)

            {{-- <br/> {{ $loop->index }} ++ --}}
            @include('didrive.modules.items-start')

        @endforeach
        </tbody>
    </table>
@endif

<pre style="max-height:300px; overflow: auto;">
    {{ print_r($module ?? 'x') }}
</pre>

<pre style="max-height:300px; overflow: auto;">
{{ print_r($data_module ?? 'y') }}
</pre>
