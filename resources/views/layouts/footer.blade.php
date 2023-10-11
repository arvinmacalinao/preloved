<footer class="footer footer-black  footer-white ">
    <div class="container-fluid">
        <div class="row">
            <nav class="footer-nav">
                <ul>
                    <li>
                        <a href="" target="">{{ __('Luxeford') }}</a>
                    </li>
                </ul>
            </nav>
            <div class="credits ml-auto">
                <span class="copyright">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>{{ __(' Cosmic Technology Inc.') }}{{ __(' All Rights Reserved.') }}<a class="@if(Auth::guest()) text-white @endif" href="" target="_blank"></a>
                </span>
            </div>
        </div>
    </div>
</footer>