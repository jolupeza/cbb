<?php $options = get_option('cbb_custom_settings'); ?>

<section class="Page Page--contact" id="<?php echo $post->post_name; ?>">
  <?php $idParent = get_the_id(); ?>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="Page-title text-celeste">Admisión <?php echo has_excerpt() ? get_the_excerpt() : date('Y') + 1; ?></h2>
        <?php the_content(); ?>

        <form class="Form Form--fields" action="" method="POST" id="js-frm-admision">
          <h3 class="Form-title">1. Datos del padre de familia</h3>

          <div class="form-group">
            <label for="parent_name" class="sr-only">Nombre completo</label>
            <input type="text" class="form-control" name="parent_name" placeholder="Nombre completo" autocomplete="off" required />
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="parent_dni" class="sr-only">DNI / CE</label>
                <input type="text" class="form-control" name="parent_dni" placeholder="DNI / CE" autocomplete="off" maxlength="8" minlength="8" data-fv-stringlength-message="Debe contener 8 dígitos" required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="parent_phone" class="sr-only">Teléfono / Celular</label>
                <input type="text" class="form-control" name="parent_phone" placeholder="Teléfono / Celular" autocomplete="off" minlength="7" maxlength="9" data-fv-stringlength-message="Debe contener 7 ó 9 dígitos" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="parent_email" class="sr-only">Correo electrónico</label>
            <input type="email" class="form-control" name="parent_email" placeholder="Correo electrónico" autocomplete="off" required />
          </div>
          <?php
            $args = [
              'post_type' => 'locals',
              'posts_per_page' => -1,
              'post_parent' => 0,
              'orderby' => 'menu_order',
              'order' => 'ASC'
            ];
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) :
          ?>
            <div class="form-group">
              <label for="parent_sede" class="sr-only">Sede</label>
              <select name="parent_sede" class="form-control" required data-fv-notempty-message="Debe seleccionar la sede">
                <option value="">-- Seleccione la sede de interés --</option>
                <?php while ($the_query->have_posts()) : ?>
                  <?php $the_query->the_post(); ?>
                  <option value="<?php echo get_the_ID(); ?>"><?php echo get_the_excerpt(); ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          <?php endif; ?>
          <?php wp_reset_postdata(); ?>

          <div class="form-group">
            <label for="schedule" class="sr-only">Horario</label>
            <select name="schedule" class="form-control" required data-fv-notempty-message="Debe seleccionar horario">
              <option value="">-- Seleccione el horario que mejor le convenga --</option>
            </select>
          </div>

          <h3 class="Form-title">2. Datos del hijo a postular</h3>
          <div class="form-group">
            <label for="son_name" class="sr-only">Nombre completo</label>
            <input type="text" class="form-control" name="son_name" placeholder="Nombre completo" autocomplete="off" required>
          </div>

          <?php
            $levels = get_terms([
              'taxonomy' => 'levels',
              'hide_empty' => false,
              'orderby' => 'term_id',
              'order' => 'ASC'
            ]);

            if (count($levels)) :
          ?>
            <div class="form-group">
              <label for="son_level" class="sr-only">Grado</label>
              <select name="son_level" class="form-control" required data-fv-notempty-message="Debe seleccionar el grado">
                <option value="">-- Seleccione el grado al que desea postular --</option>
                <?php foreach ($levels as $level) : ?>
                  <option value="<?php echo $level->term_id ?>"><?php echo $level->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php endif; ?>

          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="parent_terms" required data-fv-notempty-message="Debe aceptar las condiciones del proceso de admisión"> Acepto las <a href="<?php echo home_url('condiciones-del-proceso-de-admision'); ?>" target="_blank" rel="noopener noreferrer">condiciones del proceso de admisión <?php echo isset($options['admision_year']) && !empty($options['admision_year']) ? $options['admision_year'] : date("Y") + 1; ?></a>
              </label>
            </div>
          </div>

          <p class="text-center">
            <button type="submit" class="btn Button Button--blue Button--medium">enviar <span class="Form-loader rotateIn hidden" id="js-form-admision-loader"><i class="glyphicon glyphicon-refresh"></i></span></button>
          </p>

          <div class="alert text-center h4" id="js-form-admision-msg"></div>
        </form>
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
</section>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
