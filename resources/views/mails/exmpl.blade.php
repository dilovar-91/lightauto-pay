@component('mail::message')
Клиент по имени **{{$fio}}** отправил заявку на оплата проезда
Вид транспорта: {{$transport}}

Click below to start working right now
@component('mail::button', ['url' => 'tel:'.$phone])
{{$phone}}
@endcomponent
Отправлено из https://paytravel77.ru/,  
Пилот авто {{date('Y')}}.
@endcomponent