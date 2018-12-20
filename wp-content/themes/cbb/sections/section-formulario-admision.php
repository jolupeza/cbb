<?php $options = get_option('cbb_custom_settings'); ?>

<div id="app">
  <section class="Page Page--contact" id="<?php echo $post->post_name; ?>">
    <app-message></app-message>

    <?php $idParent = get_the_id(); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h2 class="Page-title text-celeste">Admisión <?php echo has_excerpt() ? get_the_excerpt() : date('Y') + 1; ?></h2>
          <?php the_content(); ?>

          <?php
            $placeholderCalendar = !empty($options['placeholder_calendar']) ? esc_attr($options['placeholder_calendar']) : '';
            $hourStart = !empty($options['hour_start']) ? esc_attr($options['hour_start']) : '';
            $hourEnd = !empty($options['hour_end']) ? esc_attr($options['hour_end']) : '';
            $hourStep = !empty($options['hour_step']) ? esc_attr($options['hour_step']) : '';
            $disabledDays = !empty($options['disabled_days']) ? esc_attr($options['disabled_days']) : '';
            $calendarOther = !empty($options['calendar_other']) ? esc_attr($options['calendar_other']) : '';
          ?>
          <app-admission :year-admission="'<?php !empty($options['admision_year']) ? _e($options['admision_year']) : _e(date("Y") + 1); ?>'"
                        :url-terms="'<?php _e(home_url('condiciones-del-proceso-de-admision')); ?>'"
                        :placeholder-datepicker="'<?php _e($placeholderCalendar); ?>'"
                        hour-start="<?php _e($hourStart); ?>"
                        hour-end="<?php _e($hourEnd); ?>"
                        hour-step="<?php _e($hourStep); ?>"
                        :days="'<?php _e($disabledDays); ?>'"
                        calendar-other="<?php _e($calendarOther); ?>"></app-admission>
        </div>
        <div class="col-md-6">
          <?php if (has_post_thumbnail($idParent)) : ?>
            <figure class="Page-figure text-center">
              <?php echo get_the_post_thumbnail($idParent, 'full', [
                  'class' => 'img-responsive center-block',
                  'alt' => get_the_title()
                ]);
              ?>
            </figure>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <app-progress></app-progress>
  </section>
</div>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
