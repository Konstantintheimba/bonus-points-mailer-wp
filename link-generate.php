<?php

/**
 * Улучшенная функция генерации ссылки с валидацией
 */
function generate_yandex_reviews_link($user_id, $order_id = 0) {
    try {
        if (!$user_id) {
            // error_log('Некорректный User ID');
        }
        
        $token = wp_create_nonce("yandex_reviews_{$user_id}_{$order_id}");
        
        if (empty($token)) {
            error_log('Не удалось сгенерировать токен безопасности');
        }
        
        $params = [
            'action'    => 'yandex_reviews',
            'user_id'   => (int)$user_id,
            'order_id'  => (int)$order_id,
            'token'     => $token
        ];
        
        $link = add_query_arg($params, home_url('/'));
        
        // Логирование параметров
        // error_log('Сгенерирована ссылка с параметрами: '.print_r($params, true));
        
        return $link;
        
    } catch (Exception $e) {
        // error_log('Ошибка в generate_yandex_reviews_link: '.$e->getMessage());
        return false;
    }
}
