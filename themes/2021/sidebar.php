<div>
    <?php get_template_part('templates/template', 'login'); ?>
</div>

<div>
    <?php get_template_part('templates/template', 'supervisor'); ?>
</div>

<div>
    <?php
    if (!home_url()) {
        get_template_part('templates/template', 'friendlink');
    }
    ?>
</div>

<?php
//if (is_active_sidebar('main-sidebar')) {
//    dynamic_sidebar('main-sidebar');
//} else {
//    _e('This is widget area. Go to Appearance -> Widgets to add some widgets.', 'suite');
//}
