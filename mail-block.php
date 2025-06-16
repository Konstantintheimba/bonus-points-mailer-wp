<?php
/**
 * Генератор красивой кнопки для письма
 */
function bmp_generate_review_button($order) {
    if (!$order || !$order->get_user_id()) return '';
    
    $user_id = $order->get_user_id();
    $order_id = $order->get_id();
    $link_review = 'https://yandex.ru/maps/org/pervy_zhivoy_kollagen/38194510565/reviews/?ll=37.550882%2C55.801966&z=16';
    
    $link = generate_yandex_reviews_link($user_id, $order_id);
    
    if (!$link) return '';
    
    $customer_name = $order->get_billing_first_name() ?: 'Уважаемый клиент';
    
    ob_start(); ?>
    
    <!--[if mso]>
    <style type="text/css">
        .bpm-review-section { padding: 20px !important; }
        .bpm-review-button { padding: 15px 30px !important; }
    </style>
    <![endif]-->
    
    <div style="margin: 30px 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
        <!-- Основной блок с градиентом -->
        <table cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse; background: linear-gradient(135deg, #05d3c9 0%, #074754 100%); border-radius: 12px; overflow: hidden; box-shadow: 0 8px 32px rgba(7, 71, 84, 0.3);">
            <tr>
                <td style="padding: 0;">
                    <!-- Верхняя секция с логотипом -->
                    <table cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td align="center" style="padding: 25px 20px 15px 20px; background: rgba(255, 255, 255, 0.1);">
                                <img src="https://colla-gen.com/wp-content/uploads/2025/06/9cecd5483665928ae1c8da70405117da.jpg" 
                                     alt="COLLA-GEN" 
                                     style="border-radius:20px; max-width: 180px; height: auto; display: block;">
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Основной контент -->
                    <table cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 25px 30px;">
                                <!-- Заголовок -->
                                <h2 style="margin: 0 0 20px 0; color: #ffffff; font-size: 24px; font-weight: bold; text-align: center; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    🌟 Поделитесь впечатлениями!
                                </h2>
                                
                                <!-- Основной текст -->
                                <p style="margin: 0 0 25px 0; color: #ffffff; font-size: 18px; line-height: 1.6; text-align: center; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                                    <?php echo esc_html($customer_name); ?>, спасибо за ваш заказ!<br>
                                    Оставьте отзыв и получите <strong style="color: #05d3c9; font-size: 20px;">100 бонусных баллов</strong> 🎁
                                </p>
                                
                                <!-- Кнопка -->
                                <table cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td align="center" style="padding: 10px 0 25px 0;">
                                            <a href="<?php echo esc_url($link_review); ?>" 
                                               target="_blank" 
                                               style="display: inline-block; 
                                                      background: linear-gradient(45deg, #ffffff, #f0f9ff); 
                                                      color: #074754; 
                                                      text-decoration: none; 
                                                      font-size: 18px; 
                                                      font-weight: bold; 
                                                      padding: 15px 35px; 
                                                      border-radius: 50px; 
                                                      box-shadow: 0 6px 20px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.8); 
                                                      transition: all 0.3s ease;
                                                      border: 2px solid rgba(255,255,255,0.3);
                                                      text-transform: uppercase;
                                                      letter-spacing: 1px;">
                                                ⭐ Оставить отзыв на Яндекс.Картах
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Дополнительная информация -->
                                <div style="border-radius: 8px; padding: 20px; margin: 20px 0;">
                                    <table cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 60px; vertical-align: top; padding-right: 15px;">
                                                <div style="max-width: 50px; height: 50px; background: rgba(5, 211, 201, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                                    <img src="https://colla-gen.com/wp-content/uploads/2025/06/free-icon-review-9592932.png" 
                                                            alt="COLLA-GEN" 
                                                            style="border-radius:20px; max-width: 60px; height: auto; display: block;">
                                                </div>
                                            </td>
                                            <td style="vertical-align: top;">
                                                <h3 style="margin: 0 0 8px 0; color: #05d3c9; font-size: 16px; font-weight: bold;">
                                                    Почему это важно?
                                                </h3>
                                                <p style="margin: 0; color: rgba(255, 255, 255, 0.9); font-size: 14px; line-height: 1.5;">
                                                    Ваш отзыв поможет другим людям сделать правильный выбор и улучшить качество нашего сервиса
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <!-- Условия -->
                                <div style="background: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 20px; margin: 20px 0 0 0; border-left: 4px solid #05d3c9; text-align: center;">
                                    <p style="margin: 0 0 15px 0; color: rgba(255, 255, 255, 0.9); font-size: 14px; line-height: 1.6;">
                                        💰 <strong>Баллы начисляются после перехода по ссылке</strong><br>
                                        🔒 <strong>Ссылка действительна только один раз</strong>
                                    </p>
                                    
                                    <a href="<?php echo esc_url($link); ?>" 
                                       target="_blank" 
                                       style="display: inline-block; 
                                              background: #f0f9ff;
                                              color: #074754; 
                                              text-decoration: none; 
                                              font-size: 16px; 
                                              font-weight: bold; 
                                              padding: 12px 25px; 
                                              border-radius: 25px; 
                                              box-shadow: 0 4px 15px rgba(5, 211, 201, 0.4); 
                                              text-transform: uppercase;
                                              letter-spacing: 0.5px;">
                                        🎁 ПОЛУЧИТЬ БАЛЛЫ ЗА ОТЗЫВ
                                    </a>
                                </div>

                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
    </div>
    
    <?php
    return ob_get_clean();
}

/**
 * Добавляем кнопку в письмо WooCommerce
 */
add_action('woocommerce_email_after_order_table', 'bmp_add_review_button_to_email', 20, 4);
function bmp_add_review_button_to_email($order, $sent_to_admin, $plain_text, $email) {
    // Добавляем только в определенные типы писем
    $allowed_emails = [
        'customer_completed_order',
       // 'customer_on_hold_order', 
       // 'customer_processing_order'
    ];
    
    if (in_array($email->id, $allowed_emails)) {
        echo bmp_generate_review_button($order);
    }
}
?>
