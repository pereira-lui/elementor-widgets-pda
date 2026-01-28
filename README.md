# Elementor Widgets PDA

Plugin de Widgets personalizados para Elementor com atualização automática via GitHub.

## Descrição

Este plugin fornece uma coleção de widgets customizados para o Elementor, permitindo criar layouts e funcionalidades avançadas de forma fácil e intuitiva.

## Requisitos

- WordPress 5.0 ou superior
- PHP 7.4 ou superior
- Elementor 3.0.0 ou superior

## Instalação

1. Faça o download do plugin
2. Acesse o painel do WordPress > Plugins > Adicionar Novo > Fazer upload do plugin
3. Ative o plugin
4. Os widgets estarão disponíveis na categoria "PDA Widgets" no editor do Elementor

## Estrutura do Plugin

```
elementor-widgets-pda/
├── elementor-widgets.php      # Arquivo principal do plugin
├── README.md                  # Este arquivo
├── assets/
│   ├── css/
│   │   ├── widgets-style.css  # Estilos do frontend
│   │   └── editor-style.css   # Estilos do editor
│   ├── js/
│   │   └── widgets-script.js  # Scripts do frontend
│   └── imgs/                  # Imagens do plugin
├── includes/
│   └── class-github-updater.php  # Atualizador via GitHub
└── widgets/
    └── class-widget-example.php  # Widget de exemplo
```

## Criando Novos Widgets

Para criar um novo widget:

1. Crie um arquivo em `widgets/` com o padrão `class-widget-nome.php`
2. A classe deve estender `\Elementor\Widget_Base`
3. Use a categoria `pda-widgets` para agrupar na seção "PDA Widgets"

### Exemplo de estrutura de widget:

```php
<?php
class Elementor_Widgets_PDA_MeuWidget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'pda_meu_widget';
    }

    public function get_title() {
        return __('PDA - Meu Widget', 'elementor-widgets-pda');
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_categories() {
        return ['pda-widgets'];
    }

    protected function register_controls() {
        // Adicione seus controles aqui
    }

    protected function render() {
        // Renderize o widget aqui
    }
}
```

## Atualizações

O plugin suporta atualizações automáticas via GitHub. Quando uma nova versão é publicada no repositório, o WordPress detectará a atualização automaticamente.

### Para publicar uma nova versão:

1. Atualize a versão no arquivo `elementor-widgets.php`
2. Faça commit e push das alterações
3. Crie uma nova tag no formato `vX.X.X` (ex: `v1.1.0`)
4. (Opcional) Crie uma Release no GitHub com changelog

## Changelog

### 1.0.0
- Versão inicial
- Widget de exemplo incluído
- Sistema de atualização via GitHub

## Licença

GPL v2 or later

## Autor

Lui - [GitHub](https://github.com/pereira-lui)
