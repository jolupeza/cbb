<?php
/***********************************************************************************************/
/* Widget that displays four 320x320 ad blocks */
/***********************************************************************************************/

  class Cbb_Ad_320_Widget extends WP_Widget {

    public function __construct() {
      parent::__construct(
        'cbb_ad_320_w',
        'Widget Personalizado: 320x320 Ads',
        array('description' => __('Mostrar publicidad o banner de 320 x 320', THEMEDOMAIN))
      );
    }

    public function form($instance) {
      $defaults = array(
        // 'title' => __('Ads', 'adaptive-framework'),
        'banner' => IMAGES . '/demo/ad-125x125-1.gif',
      );

      $instance = wp_parse_args((array) $instance, $defaults);
      ?>

      <!-- Banner -->
      <?php
        $args = array(
          'posts_per_page' => -1,
          'post_type' => 'banners',
        );
        $the_query = new WP_Query($args);
      ?>
      <p>
        <label for="<?php echo $this->get_field_id('banner') ?>"><?php _e('Banner:', THEMEDOMAIN); ?></label>
        <?php if($the_query->have_posts()) : ?>
          <select id="<?php echo $this->get_field_id('banner') ?>" name="<?php echo $this->get_field_name('banner'); ?>">
            <option value="">-- Indicar banner --</option>
            <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
              <?php $id = get_the_ID(); ?>
              <option value="<?php echo $id; ?>" <?php selected( $instance['banner'], $id); ?>><?php the_title(); ?></option>
            <?php endwhile; ?>
          </select>
        <?php endif; wp_reset_postdata(); ?>
      </p>

      <?php
    }

    public function update($new_instance, $old_instance) {
      $instance = $old_instance;

      // The Banner
      $instance['banner'] = $new_instance['banner'];

      return $instance;
    }

    public function widget($args, $instance) {
      extract($args);

      // Get the banner
      $banner = $instance['banner'];

      echo $before_widget;

      echo '<article class="Ad Ad-320">';

      if ($banner) : ?>
      <?php
        $args = [
          'post_type' => 'banners',
          'p' => $banner
        ];
        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) :
      ?>
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>

          <?php
            $values = get_post_custom(get_the_id());
            $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
            $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
            $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
          ?>

          <?php if (!empty($url)) : ?>
            <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer">
          <?php endif; ?>

          <?php
            if (has_post_thumbnail()) {
              the_post_thumbnail('full', [
                'class' => 'img-responsive center-block',
                'alt' => get_the_title()
              ]);
            }
          ?>

          <?php if (!empty($url)) : ?>
            </a>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php endif;
        wp_reset_postdata();

      endif;

      echo '</article>';
      echo $after_widget;
    }
  }

  register_widget('Cbb_Ad_320_Widget');

?>
