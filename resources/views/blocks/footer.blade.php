<div class="footer-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-6 footer-logo">
                        <img src="{{ asset( '/images/logo.svg' ) }}" alt="Лого ТатуГуру" width="120px">
                    </div>
                    <div class="col-lg-6 footer-contact">
                        <p>Контакты</p>
                        {{--<a href=""><img src="/images/icons/phone.svg" />+7 911 929 08 45</a>--}}
                        @if ( config( 'contact.email' ) )
                        <a href="mailto:{{ config( 'contact.email' ) }}">
                            <img alt="email" src="{{ asset( '/images/icons/mail.svg' ) }}">
                            {{ config( 'contact.email' ) }}
                        </a>
                        @endif

                        {{--<a href=""><img src="/images/icons/inst-light.svg" />Инстаграм</a>--}}
                        @if ( config( 'contact.telegram' ) )
                        <a href="https://t.me/{{ config( 'contact.telegram' ) }}" target="_blank">
                            <img alt="telegram" src="{{ asset( '/images/icons/telegram-light.svg' ) }}">
                            Telegram
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <p>Сайт не попадает под законопроект об «агрегаторах товаров (услуг)», не участвует в договорах услуг, не берет комиссию от стоимости услуг ни с заказчика, ни с исполнителя. Выступает как информационная площадка и соединяет заказчика и исполнителя напрямую.</p>
            </div>
        </div>
    </div>
</div>
