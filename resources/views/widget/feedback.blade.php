<div class="cta-wrapper ptb bg-white">
    <div class="container">
        <h2>Вы владелец Тату-салона и хотите новых клиентов бесплатно?</h2>
        <div class="row">
            <div class="col-lg-6 cta-item-img"><img src="/images/cta.jpg" alt="" /></div>
            <div class="col-lg-6 cta-item-form">
                <div class="alert d-none" id="feedback-result" role="alert">

                </div>
                <h3>Оставьте заявку!</h3>
                <form>
                    <input type="text" class="form-control" name="name" placeholder="Имя">
                    <div class="row">
                        <div class="col-sm-6"><input type="tel" class="form-control" name="phone" placeholder="Номер телефона"></div>
                        <div class="col-sm-6"><input type="email" class="form-control" name="email" placeholder="E-mail"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <textarea class="form-control" placeholder="Ваше сообщение" name="message"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="form_name" value="">
                    <button type="button" id="btn-send-feedback" class="button button-red">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    (() => {
        function createRequest( method, data = {} ) {
            let request = {
                method: method,
                mode: 'cors',
                cache: 'no-cache',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }

            if ( data !== '' && Object.keys( data ).length !== 0 ) {
                request['body'] = JSON.stringify( data );
            }

            return request;
        }

        async function sendRequest( url, method, data = {} ) {
            const response = await fetch( url, createRequest( method, data ) );
            return await response.json();
        }

        let input_name    = document.querySelector( "form input[name=name]" );
        let input_phone   = document.querySelector( "form input[name=phone]" );
        let input_email   = document.querySelector( "form input[name=email]" );
        let input_message = document.querySelector( "form textarea[name=message]" );

        document.getElementById( 'btn-send-feedback' ).addEventListener( 'click', async () => {
            try {
                const json =
                    await sendRequest(
                        "{{ route( 'feedback.store' ) }}",
                        "POST",
                        {
                            _token: "{{ csrf_token() }}",
                            name: input_name?.value ?? '',
                            phone: input_phone?.value ?? '',
                            email: input_email?.value ?? '',
                            message: input_message?.value ?? ''
                        } );

                if ( json.hasOwnProperty( 'status' ) && json['status'] === 'success' ) {
                    customAlert.success( "Заявка успешно отправлена" );
                } else if ( json.errors ) {
                    customAlert.fail( Object.values(json.errors).join('\n') );
                } else {
                    customAlert.fail( "Ошибка отправки заявки!" );
                }
            } catch {
                customAlert.fail( "Ошибка отправки заявки!" );
            }
        }, false );

        const customAlert = (()=>{
            const _wnd = document.querySelector( '#feedback-result' );

            const success = ( message ) => {
                show( 'alert-success', message );
            }

            const fail = ( message ) => {
                show( 'alert-danger', message );
            }

            const show = ( type, message ) => {
                _wnd.innerText = message;
                _wnd.classList.remove( 'alert-success', 'alert-danger', 'd-none' );
                _wnd.classList.add( type );

                setTimeout( hide, 5000 );
            }

            const hide = () => {
                _wnd.classList.add( 'd-none' );
            }

            return {
                success,
                fail
            }
        })();
    })();
</script>
