@component('mail::message')
Здравствуйте!

Вы получили это письмо, потому что мы получили запрос на изменение Вашего e-mail адреса.

Подтвердите, пожалуйста, изменение Вашего e-mail перейдя по ссылке ниже:
@component('mail::button', ['url' => route('email.reset', $token), 'color' => 'blue'])
    Подтвердить
@endcomponent
С уважением,<br>{{ config('app.name') }}
@component('mail::subcopy')
    Если у вас возникли проблемы с нажатием кнопки "Подтвердить" скопируйте и вставьте
    приведенный ниже URL-адрес в веб-браузер: [{{ route('email.reset', $token) }}]({!! route('email.reset', $token) !!})
@endcomponent
@endcomponent
