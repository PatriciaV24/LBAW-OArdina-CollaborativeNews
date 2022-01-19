@component('mail::message')
Olá **{{$name}}**,  {{-- espaço duplo para quebra de linha --}}

Clique abaixo para recuperar a sua senha
@component('mail::button', ['url' => $link])
Recuperar palavra-passe
@endcomponent
Cumprimentos,
Equipa "O Ardina".
@endcomponent