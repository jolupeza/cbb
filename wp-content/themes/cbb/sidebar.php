<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('main-sidebar')) : ?>

  <div class="Sidebar-widget">

    <h4><?php bloginfo('title'); ?></h4>
    <p><?php bloginfo('description'); ?></p>

  </div>

<?php endif; ?>
