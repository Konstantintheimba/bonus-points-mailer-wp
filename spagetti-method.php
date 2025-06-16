<?php
/**
 * Plugin Name: Bonus Points Mailer
 * Plugin URI: https://fastfixsite.ru
 * Description: Плагин для начисления бонусных баллов через email с одноразовыми ссылками
 * Version: 1.0.0
 * Author: FFX
 * Requires Plugins: woocommerce
 * Text Domain: bonus-points-mailer
 * Domain Path: /languages
 */

// Запрещаем прямой доступ
if (!defined('ABSPATH')) {
    exit;
}

// Определяем константы плагина
define('BPM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('BPM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('BPM_VERSION', '1.0.0');

// Подключаем админку только если находимся в админ-панели
if (is_admin()) {
    require_once __DIR__ . '/admin.php';
}

    require_once __DIR__ . '/link-generate.php';
    require_once __DIR__ . '/mail-block.php';
    require_once __DIR__ . '/bonus-handler.php';
