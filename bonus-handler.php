<?php
/**
 * Обработчик начисления баллов за отзыв
 */
add_action('init', function() {
    if (!isset($_GET['action']) || $_GET['action'] !== 'yandex_reviews') return;
    
    // Получаем и валидируем параметры
    $user_id = (int) ($_GET['user_id'] ?? 0);
    $order_id = (int) ($_GET['order_id'] ?? 0);
    $token = sanitize_text_field($_GET['token'] ?? '');
    
    // Проверяем существование пользователя
    if (!get_user_by('id', $user_id)) {
        wp_die('Пользователь не найден', 'Ошибка', 404);
    }
    
    // Проверяем, что баллы еще не начислялись
    $meta_key = '_yandex_reviews_' . $order_id;
    if (get_user_meta($user_id, $meta_key, true)) {
        show_success_page('Баллы уже были начислены за этот отзыв!', 'warning');
        return;
    }
    
    // Начисляем 500 баллов
    $current_points = (float) BfwPoints::getPoints($user_id);
    $new_points = $current_points + 500;
    
    $result = BfwPoints::updatePoints($user_id, $new_points);
    
    if ($result) {
        $updated_points = (float) BfwPoints::getPoints($user_id);
        if ($updated_points != $new_points) {
            update_user_meta($user_id, 'computy_point', $new_points);
        }
    } else {
        update_user_meta($user_id, 'computy_point', $new_points);
    }
    
    // Записываем в историю
    BfwHistory::add_history(
        $user_id,
        '+',
        500,
        $order_id,
        'Бонус за отзыв на Яндекс'
    );
    
    // Записываем в таблицу отзывов
    global $wpdb;
    $wpdb->insert($wpdb->prefix . 'yandex_reviews_points', [
        'user_id' => $user_id,
        'order_id' => $order_id,
        'point_on_review' => 'yes',
        'created_at' => current_time('mysql')
    ]);
    
    // Помечаем как начисленные
    update_user_meta($user_id, $meta_key, 'yes');
    
    // Показываем красивую страницу успеха
    show_success_page('Баллы успешно добавлены!', 'success');
});

/**
 * Красивая страница успеха
 */
function show_success_page($message, $type = 'success') {
    $icon = $type === 'success' ? '🎉' : '⚠️';
    $color = $type === 'success' ? '#05d3c9' : '#ff9800';
    
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://colla-gen.com/wp-content/themes/avanam/assets/css/global.min.css?ver=1742212187" />
                <link rel="stylesheet" id="base-fonts-css" href="https://fonts.googleapis.com/css?family=Montserrat:regular,600,700,500&#038;display=swap" />
<link rel="stylesheet" id="base-footer-css" href="https://colla-gen.com/wp-content/themes/avanam/assets/css/footer.min.css?ver=1742212187" />

        <title>Начисление баллов - COLLA-GEN</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { 
                font-family: 'Montserrat', sans-serif;
                background: linear-gradient(135deg, #05d3c9 0%, #074754 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .success-container {
                background: white;
                border-radius: 20px;
                padding: 50px 40px;
                text-align: center;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                max-width: 500px;
                width: 100%;
                position: relative;
                overflow: hidden;
            }
            .success-container::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 5px;
                background: linear-gradient(90deg, #05d3c9, #074754);
            }
            .icon {
                font-size: 80px;
                margin-bottom: 20px;
                animation: bounce 2s infinite;
            }
            .title {
                font-size: 32px;
                color: #074754;
                margin-bottom: 15px;
                font-weight: bold;
            }
            .message {
                font-size: 18px;
                color: #666;
                margin-bottom: 30px;
                line-height: 1.6;
            }
            .points-info {
                background: linear-gradient(45deg, #05d3c9, #074754);
                color: white;
                padding: 20px;
                border-radius: 15px;
                margin-bottom: 30px;
                font-size: 20px;
                font-weight: bold;
            }
            .btn {
                display: inline-block;
                background: linear-gradient(45deg, #05d3c9, #074754);
                color: white;
                padding: 15px 30px;
                border-radius: 50px;
                text-decoration: none;
                font-weight: bold;
                font-size: 16px;
                transition: transform 0.3s ease;
                box-shadow: 0 5px 15px rgba(5, 211, 201, 0.4);
            }
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(5, 211, 201, 0.6);
                color:#ffffffd1;
            }
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }
            @media (max-width: 480px) {
                .success-container { padding: 30px 20px; }
                .title { font-size: 24px; }
                .icon { font-size: 60px; }
            }
        </style>
    </head>
    <body>
        <div class="success-container">
            <div class="icon"><?php echo $icon; ?></div>
            <h1 class="title"><?php echo esc_html($message); ?></h1>
            
            <?php if ($type === 'success'): ?>
                <p class="message">
                    Спасибо за ваш отзыв!<br>
                    Ваш отзыв поможет другим клиентам сделать правильный выбор.
                </p>
                
                <div class="points-info">
                    💰 +100 бонусных баллов
                </div>
            <?php else: ?>
                <p class="message">
                    Не переживайте, ваши баллы уже на счету!<br>
                    Спасибо за активность.
                </p>
            <?php endif; ?>
            
            <a href="<?php echo home_url(); ?>" class="btn">
                🏠 Вернуться на главную
            </a>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>
