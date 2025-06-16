<?


/**
 * Добавляем страницу статистики в админке
 */
add_action('admin_menu', 'add_yandex_reviews_stats_page');
function add_yandex_reviews_stats_page() {
    add_submenu_page(
        'woocommerce',
        'Статистика Отзывов Яндекса',
        'Статистика Отзывов',
        'manage_options',
        'yandex-reviews-stats',
        'render_yandex_reviews_stats_page'
    );
}

/**
 * Рендеринг страницы статистики
 */
function render_yandex_reviews_stats_page() {
    global $wpdb;
    
    // Получаем данные из таблицы отзывов
    $table_name = $wpdb->prefix . 'yandex_reviews_points';
    $results = $wpdb->get_results("
        SELECT r.*, 
               u.user_email, 
               u.display_name,
               o.post_date as order_date
        FROM {$table_name} r
        LEFT JOIN {$wpdb->users} u ON r.user_id = u.ID
        LEFT JOIN {$wpdb->posts} o ON r.order_id = o.ID
        ORDER BY r.created_at DESC
    ");
    
    ?>
    <div class="wrap">
        <h1>Статистика Отзывов Яндекса</h1>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="post">
                    <input type="text" name="search" placeholder="Поиск по email или ID">
                    <input type="submit" class="button" value="Поиск">
                </form>
            </div>
        </div>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Email</th>
                    <th>Заказ</th>
                    <th>Дата заказа</th>
                    <th>Дата получения баллов</th>
                    <th>Разница</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row) : 
                    $order_date = new DateTime($row->order_date);
                    $review_date = new DateTime($row->created_at);
                    $diff = $order_date->diff($review_date);
                    
                    $diff_text = '';
                    if ($diff->d > 0) $diff_text .= $diff->d . 'д ';
                    if ($diff->h > 0) $diff_text .= $diff->h . 'ч ';
                    if ($diff->i > 0) $diff_text .= $diff->i . 'м ';
                    if ($diff_text == '') $diff_text = 'менее минуты';
                ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= esc_html($row->display_name) ?></td>
                    <td><?= esc_html($row->user_email) ?></td>
                    <td>
                        <a href="<?= admin_url('post.php?post='.$row->order_id.'&action=edit') ?>">
                            #<?= $row->order_id ?>
                        </a>
                    </td>
                    <td><?= $order_date->format('d.m.Y H:i') ?></td>
                    <td><?= $review_date->format('d.m.Y H:i') ?></td>
                    <td><?= $diff_text ?></td>
                    <td>
                        <span style="color: <?= $row->point_on_review == 'yes' ? 'green' : 'red' ?>">
                            <?= $row->point_on_review == 'yes' ? 'Начислено' : 'Не начислено' ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <style>
            .wp-list-table th, .wp-list-table td {
                padding: 8px 10px;
                vertical-align: middle;
            }
        </style>
    </div>
    <?php
}