#Softpampa - Moip Assinaturas PHP

Biblioteca simples de integração com a API de Assinatura da Moip.

##Instalação

`$ composer require softpampa/moip-assinaturas-php`

##Documentação Oficial Moip

<!-- - [Wiki](https://github.com/andersao/moip-assinaturas-php/wiki) -->
- [Moip Assinaturas - Documentação Oficial](http://dev.moip.com.br/assinaturas-api/)

##Uso

####Incluindo a biblioteca

```
<?php

include 'vendor/autoload.php';

$client = new Softpampa\Moip\Subscription\MoipClient($token, $key, $env);
$api = new Softpampa\Moip\Subscription\Api($client);
```

####Recursos

```
$api->customers();
$api->subscriptions();
$api->payments();
$api->plans();
$api->invoices();
```

####Retornar todos

```
$subscriptions = $api->subscriptions()->all();
```

####Encontrar

```
$plan = $api->plans()->find('code');
```

####Verificar erros

```
$subscription = $api->subscriptions()->create([]);

if ($subscription->hasErrors()) {
    return $subscription->errors(); // Array com erros
}

```
