<?php
namespace Chrishenrique\LaravelAssets;

use Illuminate\Support\Facades\Config;

class AssetManager
{
    protected $scripts = [];
    protected $styles = [];
    protected $assetGroups = [];
    protected $globalAssets = [];
    protected ?string $lastAdded = null;

    public function __construct()
    {
        $this->assetGroups = Config::get('laravel-assets.asset_groups', []);
        $this->globalAssets = Config::get('laravel-assets.global_assets', []);

        foreach ($this->globalAssets['script'] ?? [] as $name => $asset) {
            $this->addScript($name, $asset['url'])
                    ->setPosition($asset['position'] ?? 'body')
                    ->setOrder($asset['order'] ?? null);
        }

        foreach ($this->globalAssets['style'] ?? [] as $name => $asset) {
            $this->addStyle($name, $asset['url'])
                    ->setPosition($asset['position'] ?? 'head')
                    ->setOrder($asset['order'] ?? null);
        }
    }

    public function addScript($name, $url = null)
    {
        $config = Config::get("laravel-assets.assets.$name.script", []);

        $url = $url ?? $config['url'] ?? null;
        $position = $config['position'] ?? 'body';
        $order = $config['order'] ?? null;

        if (!$url) {
            throw new \Exception("URL do asset '$name' não encontrada.");
        }

        if (!isset($this->scripts[$name])) {
            $this->scripts[$name] = [
                'url' => $url,
                'position' => $position,
                'order' => $order,
            ];
            $this->lastAdded = $name;
        }

        $this->setOrder($order);
        $this->setPosition($position);

        return $this;
    }

    public function addStyle($name, $url = null)
    {
        $config = Config::get("laravel-assets.assets.$name.style", []);

        $url = $url ?? $config['url'] ?? null;
        $position = $config['position'] ?? 'head';
        $order = $config['order'] ?? null;

        if (!$url) {
            throw new \Exception("URL do asset '$name' não encontrada.");
        }

        if (!isset($this->styles[$name])) {
            $this->styles[$name] = [
                'url' => $url,
                'position' => $position,
                'order' => $order,
            ];
            $this->lastAdded = $name;
        }

        $this->setOrder($order);
        $this->setPosition($position);

        return $this;
    }

    // Remove um asset baseado no nome e tipo
    public function remove($name, $type = null)
    {
        if ($type === null || $type === 'script') {
            unset($this->scripts[$name]);
        }

        if ($type === null || $type === 'style') {
            unset($this->styles[$name]);
        }
    }

    // Define a ordem de um asset
    public function setOrder($order = null)
    {
        if ($this->lastAdded === null) {
            return $this;
        }

        if ($order === null) {
            $order = count($this->scripts) + count($this->styles) + 1;
        }

        if (isset($this->scripts[$this->lastAdded])) {
            $this->scripts[$this->lastAdded]['order'] = $order;
        }

        if (isset($this->styles[$this->lastAdded])) {
            $this->styles[$this->lastAdded]['order'] = $order;
        }


        return $this;
    }

    public function setPosition($position)
    {
        if (!in_array($position, ['head', 'body'])) {
            throw new \Exception("Posição inválida. Use 'head' ou 'body'.");
        }

        if ($this->lastAdded) {
            if (isset($this->scripts[$this->lastAdded])) {
                $this->scripts[$this->lastAdded]['position'] = $position;
            } elseif (isset($this->styles[$this->lastAdded])) {
                $this->styles[$this->lastAdded]['position'] = $position;
            }
        }

        return $this;
    }

    // Agrupa assets conforme a configuração
    public function addGroup($group)
    {
        if (isset($this->assetGroups[$group])) {
            $groupAssets = $this->assetGroups[$group];

            foreach ($groupAssets as $type => $assets) {
                foreach ($assets as $name => $asset) {
                    if ($type === 'script') {
                        $this->addScript($name, $asset['url'], $asset['position']);
                    } elseif ($type === 'style') {
                        $this->addStyle($name, $asset['url'], $asset['position']);
                    }
                }
            }
        }
    }

    // Retorna a URL de um asset com versão (cache busting)
    protected function getAssetUrl($url)
    {
        // Verifica se é um arquivo local
        if (strpos($url, 'http') === false) {
            return $this->versionedUrl($url);
        }

        // Caso seja um CDN, retorna a URL diretamente
        return $url;
    }

    // Adiciona uma versão ao asset para cache busting
    protected function versionedUrl($url)
    {
        return $url . '?v=' . filemtime(public_path($url)); // Timestamp baseado no arquivo
    }

    // Verifica se a URL do CDN é acessível
    public function checkCdn($url)
    {
        // Implementação fictícia de verificação do CDN
        return true;
    }

    public function renderStyles(): string
    {
        $output = '';

        usort($this->styles, fn($a, $b) => $a['order'] <=> $b['order']);

        foreach ($this->styles as $style) {
            $output .= "<link rel='stylesheet' href='{$style['url']}'>\n";
        }

        return $output;
    }

    public function renderScripts($position = 'body'): string
    {
        $output = '';

        $filteredScripts = array_filter($this->scripts, fn($script) => $script['position'] === $position);
        usort($filteredScripts, fn($a, $b) => $a['order'] <=> $b['order']);

        foreach ($filteredScripts as $script) {
            $output .= "<script type='text/javascript' src='{$script['url']}'></script>\n";
        }

        return $output;
    }

    public function clear()
    {
        $this->scripts = [];
        $this->styles = [];
    }

    public function all()
    {
        return [
            'scripts' => $this->scripts,
            'styles' => $this->styles,
        ];
    }
}
