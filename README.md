# Chat
Chat simples usando Laravel, Pusher e jQuery.

## Comandos
````
composer install
npm install && npm run dev
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
```` 

## Importante
Mantenha no .env o driver do pusher para o broadcast

````
BROADCAST_DRIVER=pusher
````

Insira as crendenciais do pusher
````
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
````

## Possíveis problemas
Problema de ssl

>`cURL error 60: SSL certificate problem: unable to get local issuer certificate`

Solução em: https://noorsplugin.com/how-to-fix-curl-error-60-ssl-certificate-problem-unable-to-get-local-issuer-certificate/


## Referência
https://github.com/samironbarai/laravel_chat
