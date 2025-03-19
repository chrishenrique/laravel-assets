# Laravel-assets

### Gerencie seus assets dinamicamente no Laravel

O `Laravel-assets` é um package que permite adicionar dinamicamente scripts e estilos ao HTML em tempo de execução. Ele facilita a gestão de assets e bibliotecas externas, garantindo injeção otimizada e controle de ordem de carregamento.

## 📌 Recursos Principais

✅ Registro simplificado de bibliotecas e assets.
✅ Definição de ordem de carregamento.
✅ Injeção otimizada para melhor performance.
✅ Gestão fácil e centralizada dos assets.

## 📦 Instalação

Para instalar o package via Composer, execute o seguinte comando:

```sh
composer require infinitty-coffee/laravel-assets
```

Se necessário, publique a configuração:

```sh
php artisan vendor:publish --tag=config --provider="LaravelAssets\LaravelAssetsServiceProvider"
```

## 🚀 Como Usar

### 1️⃣ Registrando Assets

Registre os assets no seu controller ou service provider:

```php
use LaravelAssets\Asset;

Asset::add('app-css', '/css/app.css', 'style');
Asset::add('app-js', '/js/app.js', 'script')->order(1);
```

### 2️⃣ Injetando no HTML

No seu Blade, adicione os assets onde desejar:

```blade
<head>
    {!! Asset::renderStyles() !!}
</head>
<body>
    {!! Asset::renderScripts() !!}
</body>
```

### 3️⃣ Definição de Ordem

Defina a ordem de carregamento de scripts e estilos facilmente:

```php
Asset::add('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', 'script')->order(1);
Asset::add('app-js', '/js/app.js', 'script')->order(2);
```

### 4️⃣ Removendo Assets

Se precisar remover um asset:

```php
Asset::remove('app-js');
```

## 📜 Licença

Este projeto é distribuído sob a licença MIT.

---

💡 **Dúvidas ou sugestões?** Fique à vontade para contribuir ou relatar issues no repositório!
