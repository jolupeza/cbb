<?php

namespace CBB_WorkWithUs\Admin\Taxonomies;

use CBB_WorkWithUs\Includes\Loader;

class JobSpeciality
{
    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    private $loader;

    private $domain;

    /**
     * @param Loader $loader
     */
    public function __construct(Loader $loader, $domain)
    {
        $this->loader = $loader;
        $this->domain = $domain;
    }

    public function init()
    {
        $this->loader->add_action('init', $this, 'addTaxonomyJobSpeciality');
        $this->loader->add_action('job_specialities_add_form_fields', $this, 'addFieldAreas');
        $this->loader->add_action('created_job_specialities', $this, 'saveFieldAreas', 10, 2);
        $this->loader->add_action('job_specialities_edit_form_fields', $this, 'updateFieldAreas', 10, 2);
        $this->loader->add_action('edited_job_specialities', $this, 'updatedFieldAreas', 10, 2);
        $this->loader->add_action('rest_api_init', $this, 'registerRestRouteByArea');
    }

    public function addTaxonomyJobSpeciality()
    {
        $args = array(
            'labels' => $this->getLabelsTaxonomyJobSpeciality(),
            'public' => false,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => false,
        );

        register_taxonomy('job_specialities', 'jobapplications', $args);
    }

    public function addFieldAreas($taxonomy)
    {
        $areas = get_terms(array(
            'taxonomy' => 'joblevels',
            'hide_empty' => false,
            'fields' => 'id=>name'
        ));
        if (!empty($areas) && ! is_wp_error($areas)) :
    ?>
        <div class="form-field term-areas-wrap">
            <h4>Áreas</h4>
            <?php foreach ($areas as $id => $area) : ?>
            <div class="form-field-group">
                <p>
                    <label for="tag-areas-<?php echo $id; ?>">
                        <input type="checkbox" name="areas[]" id="tag-areas-<?php echo $id; ?>" value="<?php echo $id; ?>" /> <?php echo $area; ?>
                    </label>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    <?php
        endif;
    }

    public function saveFieldAreas($termId, $tt_id)
    {
        if (isset($_POST['areas']) && '' !== $_POST['areas']) {
            $areas = $_POST['areas'];
            add_term_meta($termId, 'areas', $areas, true);
        }
    }

    public function updateFieldAreas($term, $taxonomy)
    {
        $areasSelected = get_term_meta($term->term_id, 'areas', true);
        $areasSelected = !empty($areasSelected) ? explode(',', $areasSelected) : '';

        $areas = get_terms(array(
            'taxonomy' => 'joblevels',
            'hide_empty' => false,
            'fields' => 'id=>name'
        ));
        if (!empty($areas) && ! is_wp_error($areas)) :
    ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label><?php _e( 'Áreas', $this->domain ); ?></label>
            </th>
            <td>
                <?php foreach ($areas as $id => $area) : ?>
                    <p>
                        <label for="tag-areas-<?php echo $id; ?>">
                            <?php $checked = is_array($areasSelected) && in_array($id, $areasSelected) ? ' checked' : ''; ?>
                            <input type="checkbox" name="areas[]" id="tag-areas-<?php echo $id; ?>" value="<?php echo $id; ?>"<?php echo $checked; ?> /> <?php echo $area; ?>
                        </label>
                    </p>
                <?php endforeach; ?>
            </td>
        </tr>
    <?php
        endif;
    }

    public function updatedFieldAreas($termId, $tt_id)
    {
        if (isset($_POST['areas']) && '' !== $_POST['areas']) {
            $areas = implode(',', $_POST['areas']);
            update_term_meta($termId, 'areas', $areas);
        } else {
            delete_term_meta($termId, 'areas');
        }
    }

    public function registerRestRouteByArea()
    {
        register_rest_route('workwithus/v1', '/speciality/area=(?P<area>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'getByArea'),
            'args' => array(
                'type' => array(
                    'validate_callback' => function ($param, $request, $key) {
                        return is_numeric($param);
                    }
                )
            )
        ));
    }

    public function getByArea(\WP_REST_Request $request)
    {
        $area = (int) $request['area'];

        $specialities = get_terms(array(
            'taxonomy' => 'job_specialities',
            'hide_empty' => false,
            'fields' => 'id=>name',
            'meta_query' => array(
                array(
                    'key' => 'areas',
                    'value' => $area,
                    'compare' => 'LIKE'
                )
            )
        ));

        if (empty($specialities) || is_wp_error($specialities)) {
            return new \WP_Error('no_specialities', 'Invalid type', array('status' => 404));
        }

        return $specialities;
    }

    /**
     * Return labels for declaration taxonomy job_specialities
     *
     * @return array
     */
    private function getLabelsTaxonomyJobSpeciality()
    {
        return array(
            'name' => _x('Especialidades', 'Taxonomy plural name', $this->domain),
            'singular_name' => _x('Especialidad', 'Taxonomy singular name', $this->domain),
            'search_items' => __('Buscar Especialidad', $this->domain),
            'popular_items' => __('Especialidades Populares', $this->domain),
            'all_items' => __('Todos las Especialidades', $this->domain),
            'parent_item' => __('Especialidad Padre', $this->domain),
            'parent_item_colon' => __('Especialidad Padre', $this->domain),
            'edit_item' => __('Editar Especialidad', $this->domain),
            'update_item' => __('Actualizar Especialidad', $this->domain),
            'add_new_item' => __('Añadir nueva Especialidad', $this->domain),
            'new_item_name' => __('Nueva  Especialidad', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Especialidad', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Especialidades', $this->domain),
        );
    }
}
