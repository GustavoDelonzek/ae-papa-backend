@component('mail::message')
# Olá!

Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Redefinir Senha
@endcomponent

Este token expirará em 60 minutos. Por favor, utilize o link acima o mais breve possível.

Se você não solicitou uma redefinição de senha, nenhuma ação é necessária e você pode ignorar este e-mail.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
