<?php
/*
Plugin Name: باکس بیشتر بخوانید در نوشته ها
Description: با استفاده از این شرت کد [related_post id="آیدی پست"]  میتوانید این باکس را اضافه کنید.
Version: 1.0.0
Author: bestwebneed.ir
Author URI: https://bestwebneed.ir
*/

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
