<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('main-sidebar')) : ?>

  <div class="Sidebar-widget">

    <h2 class="Sidebar-title Single-related-title"><?php bloginfo('title'); ?></h2>
    <p><?php bloginfo('description'); ?></p>

  </div>

<?php endif; ?>
