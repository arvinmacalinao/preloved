<footer class="footer footer-black  footer-white ">
    <div class="container-fluid">
        <div class="row">
            <nav class="footer-nav">
                <ul>
                    <li>
                        <a href="https://cherry.com.ph" target="_blank">{{ __('Cherry') }}</a>
                    </li>
                </ul>
            </nav>
            <div class="credits ml-auto">
                <span class="copyright">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>{{ __(', made with ') }}<i class="fa fa-heart heart"></i>{{ __(' by ') }}<a class="@if(Auth::guest()) text-white @endif" href="" target="_blank">{{ __('Vinmeister') }}</a>{{ __(' follow social -> ') }}<a class="@if(Auth::guest()) text-white @endif" target="_blank" href="https://www.facebook.com/vinnnmeister">{{ __('Facebook') }}</a>
                </span>
            </div>
        </div>
    </div>
</footer>