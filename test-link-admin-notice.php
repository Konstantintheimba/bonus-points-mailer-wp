<?php

/**
 * Выводим тестовую ссылку в админке с подробным логированием
 */
add_action('admin_notices', function() {
    // Проверяем права администратора
    if (!current_user_can('administrator')) {
        // error_log('Попытка доступа к тестовой ссылке без прав администратора');
        return;
    }
    
    $user_id = $order->get_user_id(); // Поменять при включении на USER ID
    $order_id = $order->get_id(); // Поменять при включении на ORDER ID
    
    try {
        // Генерируем и проверяем ссылку
        $test_link = generate_yandex_reviews_link($user_id, $order_id);
        
        if (empty($test_link)) {
            throw new Exception('Не удалось сгенерировать ссылку');
        }
        
        // Красивый вывод в админке
        echo '
        <div class="notice notice-success" style="padding:15px;border-left:4px solid #46b450;">
            <h3 style="margin-top:0;color:#23282d;">🔗 Тестовая ссылка для начисления баллов</h3>
            <div style="background:#f8f9fa;padding:10px;border-radius:4px;margin-bottom:15px;">
                <input type="text" value="'.esc_url($test_link).'" 
                       style="width:100%;padding:8px;border:1px solid #ddd;border-radius:3px;font-family:monospace;" 
                       readonly onclick="this.select()">
            </div>
            <div>
                <a href="'.esc_url($test_link).'" target="_blank" 
                   class="button button-primary" style="margin-right:10px;">
                   🚀 Перейти по ссылке
                </a>
                <button class="button" onclick="navigator.clipboard.writeText(\''.esc_url($test_link).'\')">
                    📋 Скопировать ссылку
                </button>
            </div>
            <p style="margin-top:15px;color:#666;">
                User ID: '.$user_id.' | Order ID: '.$order_id.'
            </p>
        </div>';
        
        // error_log('Тестовая ссылка сгенерирована для user_id: '.$user_id.' и order_id: '.$order_id);
        
    } catch (Exception $e) {
        // error_log('Ошибка генерации тестовой ссылки: '.$e->getMessage());
        echo '
        <div class="notice notice-error">
            <p>Ошибка при генерации тестовой ссылки: '.esc_html($e->getMessage()).'</p>
        </div>';
    }
});