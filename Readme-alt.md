
# Laravel Assets

Laravel Assets é um package que facilita o gerenciamento dinâmico de scripts e estilos em aplicações Laravel. Ele permite a adição, remoção e organização de assets de forma otimizada, evitando duplicações e melhorando a performance.

## 📌 Recursos
- Definição de assets globais.
- Adição dinâmica de scripts e estilos.
- Controle de ordem de carregamento.
- Suporte a diferentes posições (head, body).
- Evita duplicação de assets.
- Comandos Artisan para gerenciamento.
- Diretivas Blade para renderização fácil.
- Suporte a versões de assets e carregamento condicional.

## 📦 Instalação

Adicione o package ao seu projeto via Composer:
```bash
composer require chrishenrique/laravel-assets
```

Após a instalação, publique a configuração:
```bash
php artisan vendor:publish --tag=config --provider="Chrishenrique\LaravelAssets\LaravelAssetsServiceProvider"
```

## ⚙️ Configuração

O arquivo de configuração `config/laravel-assets.php` permite definir assets globais:

```php
return [
    'global_assets' => [
        'script' => [
            'jquery' => [
                'url' => 'https://code.jquery.com/jquery-3.6.0.min.js',
                'position' => 'head',
                'order' => 1,
            ],
        ],
        'style' => [
            'bootstrap' => [
                'url' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
                'position' => 'head',
                'order' => 1,
            ],
        ],
    ],
    'assets' => [
        'fullcalendar' => [
            'script' => [
                'url' => 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js',
                'position' => 'body',
                'order' => 2,
            ],
        ],
    ],
];
```

## 🚀 Uso

### Adicionando Assets Dinamicamente

Adicione um asset de script ou estilo, usando a chave configurada:

```php
AssetManager::addScript('fullcalendar');
```

Caso precise, ainda pode sobrescrever as informações, como URL, posição ou ordem:

```php
AssetManager::addScript('fullcalendar', 'https://meu-servidor.com/fullcalendar.js', 'head', 1);
```

### Alterando a Posição com `setPosition()`

Após adicionar um asset, você pode modificar a posição (head ou body):

```php
AssetManager::addScript('fullcalendar')->setPosition('head');
```

### Removendo Assets

```php
AssetManager::remove('fullcalendar');
```

### Limpando Todos os Assets

```bash
php artisan assets:clear
```

### Listando Assets Ativos

```bash
php artisan assets:list
```

### Diretivas Blade

```blade
@renderStyles
@renderScripts('head')
@renderScripts('body')
```

## 📄 Licença
Este package é distribuído sob a licença MIT.
