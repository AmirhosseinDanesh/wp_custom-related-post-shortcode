<?php
/*
Plugin Name: read more box
Description: با استفاده از شورت‌کدهای [related_post id="آیدی پست"] و [related_custompost id="آیدی پست" post_type="نوع پست"] می‌توانید این باکس‌ها را اضافه کنید.
Version: 1.0.0
Author: Amir Danesh
Author URI: https://bestwebneed.ir/plugins/read-more-box
*/

// شورت‌کد برای پست‌های وبلاگ
function related_post_by_id_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => 0 // ID پیش‌فرض پست
    ), $atts);

    $post_id = intval($atts['id']); // دریافت ID پست از پارامتر شورت‌کد

    if ($post_id > 0) {
        $query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 1,
            'p' => $post_id, // جستجوی پست بر اساس ID
            'post_status' => 'publish'
        ));

        ob_start();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <p>
                    <a href="<?php the_permalink(); ?>" style="padding:5px 15px;display: flex;flex-wrap:wrap;align-items: center;margin: 20px 0;border: 1px solid #ddd;border-radius: 5px;">
                        <?php the_post_thumbnail('thumbnail', ['style' => 'width:50px;height:50px;border-radius:5px;object-fit:cover;']); ?>
                        <span style="color: blue;margin: 0 15px 0 5px;font-weight: bold;display: inline-block">بیشتر بخوانید:</span>
                        <b style="color: #222;"><?php the_title(); ?></b>
                    </a>
                </p>
                <?php
            }
        }
        wp_reset_postdata();

        return ob_get_clean();
    }

    return '';
}
add_shortcode('related_post', 'related_post_by_id_shortcode');

// شورت‌کد برای پست‌های سفارشی
function related_custompost_by_id_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => 0, // ID پیش‌فرض پست
        'post_type' => 'post' // نوع پست پیش‌فرض
    ), $atts);

    $post_id = intval($atts['id']); // دریافت ID پست از پارامتر شورت‌کد
    $post_type = sanitize_text_field($atts['post_type']); // دریافت نوع پست

    if ($post_id > 0) {
        $query = new WP_Query(array(
            'post_type' => $post_type, // جستجوی پست بر اساس نوع پست
            'posts_per_page' => 1,
            'p' => $post_id, // جستجوی پست بر اساس ID
            'post_status' => 'publish'
        ));

        ob_start();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <p>
                    <a href="<?php the_permalink(); ?>" style="padding:5px 15px;display: flex;flex-wrap:wrap;align-items: center;margin: 20px 0;border: 1px solid #ddd;border-radius: 5px;">
                        <?php the_post_thumbnail('thumbnail', ['style' => 'width:50px;height:50px;border-radius:5px;object-fit:cover;']); ?>
                        <span style="color: blue;margin: 0 15px 0 5px;font-weight: bold;display: inline-block">بیشتر بخوانید:</span>
                        <b style="color: #222;"><?php the_title(); ?></b>
                    </a>
                </p>
                <?php
            }
        }
        wp_reset_postdata();

        return ob_get_clean();
    }

    return '';
}
add_shortcode('related_custompost', 'related_custompost_by_id_shortcode');
