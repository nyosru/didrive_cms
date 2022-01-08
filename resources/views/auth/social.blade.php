    {{-- Social buttons --}}
    {{-- <div class="text-center margin-bottom-20" id="uLogin"
        data-ulogin="display=panel;theme=flat;fields=first_name,last_name,email,nickname,photo,country;providers=facebook,vkontakte,odnoklassniki,mailru;hidden=other;redirect_uri={{ urlencode('https://' . $_SERVER['HTTP_HOST']) }}/ulogin;mobilebuttons=0;">
    </div> --}}
    {!! '<script src="//ulogin.ru/js/ulogin.js"></script>' !!}
    {{-- <div id="uLogin" data-ulogin="display=panel;theme=classic;fields=nickname,bdate,photo,first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=https%3A%2F%2Fdi.avto-as.php-cat.com%2Fulogin;mobilebuttons=0;"></div> --}}
    <div id="uLogin" data-ulogin="display=panel;theme=classic;fields=nickname,photo,first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=https%3A%2F%2Fdi.avto-as.php-cat.com%2Fulogin;mobilebuttons=0;"></div>

    {{-- @section('js')
        @parent
        <script src="//ulogin.ru/js/ulogin.js"></script>
        222222
    @endsection --}}
