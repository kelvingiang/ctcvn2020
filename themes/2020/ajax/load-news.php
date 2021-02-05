<?php

define('WP_USE_THEMES', false);
require('../../../../wp-load.php');
$lastID = $_POST['lastID'];
$caterogy = $_POST['caterogy'];

$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $postCount,
    'category_name' => $caterogy,
    'offset' => $lastID,
    'orderby' => 'date',
    'order' => 'DESC',
);

$wp_query = new WP_Query($args);
if ($wp_query->have_posts()) {
    $stt = $lastID + 1;
    while ($wp_query->have_posts()) : $wp_query->the_post();
        $html .= "<li data-id = '" . $stt . "'>";
        $html .= "<a href = '" . get_the_permalink() . "'>" . get_the_title() . "</a>";
        $html .= "</li>";
        $stt += 1;
    endwhile;
    $response = array(
        'status' => 'done',
        'html' => $html,
    );
} else {
    $response = array(
        'status' => 'empty',
    );
}

echo json_encode($response);
