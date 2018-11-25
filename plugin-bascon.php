<?php

/*
Plugin Name: BASCON
Plugin URI: http:// www.farley.com.br
Description: BASCON is a WordPress Plugin that adds features for administration of a Knowledge Base to sites that use the WordPress Platform
Author: Farley Rangel
Version: 1.0
Author URI: http:// www.farley.com.br
*/

//
// Don't access this file directly
//

defined( 'ABSPATH' ) or die();

// 
// stylesheet and hide comment specific page 'bascon'
// https:// developer.wordpress.org/reference/functions/wp_enqueue_style/
// 

// locate page bascon, change stylesheet and, remove comment support
if ( ! is_page( array( 'links', 'bascon' ) ) ) {
	wp_enqueue_style( 'plugin-bascon', plugin_dir_url( __FILE__ ) . 'plugin-bascon.css', false, 'null', 'all' );
}

//
// Create new user Bascon Editor and yours capabilities
//

$result = add_role( 'bascon', __( 'Bascon' ),
	array(
		'read'                   => true,		// true allows this capability
		'delete_posts'           => true,		// Use false to explicitly deny
		'edit_posts'             => true,		// Allows user to edit their own posts
		'read'                   => true,		// true allows this capability
		'edit_pages'             => true,		// Allows user to edit pages
		'edit_others_posts'      => false,		// Allows user to edit others posts not just their own
		'create_posts'           => true,		// Allows user to create new posts
		'manage_categories'      => false,		// Allows user to manage post categories
		'publish_posts'          => true,		// Allows the user to publish, otherwise posts stays in draft mode'edit_themes' => true, // false denies this capability. User can’t edit your theme
		'edit_files'             => true,
		'edit_theme_options'     => false,
		'manage_options'         => false,
		'moderate_comments'      => false,
		'manage_links'           => false,
		'edit_others_pages'      => false,
		'edit_published_pages'   => true,
		'publish_pages'          => false,
		'delete_pages'           => false,
		'delete_others_pages'    => false,
		'delete_published_pages' => false,
		'delete_others_posts'    => false,
		'delete_private_posts'   => false,
		'edit_private_posts'     => false,
		'read_private_posts'     => false,
		'delete_private_pages'   => false,
		'edit_private_pages'     => true,
		'read_private_pages'     => false,
		'unfiltered_html'        => false,
		'edit_published_posts'   => true,
		'upload_files'           => false,
		'delete_published_posts' => true,
		'delete_posts'           => true,
		'install_plugins'        => false,
		'update_plugin'          => false,
		'update_core'            => false
	)
);

// 
// REGISTER a Custom Post Type
// http:// codex.wordpress.org/Function_Reference/register_post_type
// 

add_action( 'init', 'codex_bascon_init' );
function codex_bascon_init() {
	$labels = array(
		'name'               => _x( 'Listagem Geral', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Bascon', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'BASCON', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'BASCON', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Nova casuística', 'bascon', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Adicione sua casuística', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Bascon', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Cadastrar', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Bascon', 'your-plugin-textdomain' ),
		'all_items'          => __( 'Mostrar Todos', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Realizar Busca', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Bascon:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No bascons found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No bascons found in Trash.', 'your-plugin-textdomain' )
	);
	$args   = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-plus-alt',
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'bascon' ),
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);
	register_post_type( 'bascon', $args );
}

/**
 *
 * Register the Taxonomy “bascon” for the post type “post” using the init action hook
 *
 */

// 
// https://developer.wordpress.org/plugins/taxonomies/
// Especialidade
// 

add_action( 'init', 'wporg_register_taxonomy_especialidade' );
function wporg_register_taxonomy_especialidade() {
	$labels = [
		'name'              => _x( 'Especialidades', 'taxonomy general name' ),
		'singular_name'     => _x( 'Especialidade', 'taxonomy singular name' ),
		'search_items'      => __( 'Buscar Especialidade' ),
		'all_items'         => __( 'Todas as Especialidades' ),
		'parent_item'       => __( 'Especialidade Pai' ),
		'parent_item_colon' => __( 'Especialidade Pai:' ),
		'edit_item'         => __( 'Editar Especialidade' ),
		'update_item'       => __( 'Atualizar Especialidade' ),
		'add_new_item'      => __( 'Adicionar NOVA Especialidade' ),
		'new_item_name'     => __( 'Nova Especialidade' ),
		'menu_name'         => __( 'Nova Especialidade' ),
	];
	$args   = [
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'especialidade' ],
	];
	register_taxonomy( 'especialidade', [ 'bascon' ], $args );
}

// 
// https:// developer.wordpress.org/plugins/taxonomies/
// Patologia
// 

add_action( 'init', 'wporg_register_taxonomy_patologia' );
function wporg_register_taxonomy_patologia() {
	$labels = [
		'name'              => _x( 'Patologias', 'taxonomy general name' ),
		'singular_name'     => _x( 'Patologia', 'taxonomy singular name' ),
		'search_items'      => __( 'Buscar Patologia' ),
		'all_items'         => __( 'Todas as Patologias' ),
		'parent_item'       => __( 'Patologia Pai' ),
		'parent_item_colon' => __( 'Patologia Pai:' ),
		'edit_item'         => __( 'Editar Patologia' ),
		'update_item'       => __( 'Atualizar Patologia' ),
		'add_new_item'      => __( 'Adicionar NOVA Patologia' ),
		'new_item_name'     => __( 'Nova Patologia Name' ),
		'menu_name'         => __( 'Nova Patologia' ),
	];
	$args   = [
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'patologia' ],
	];
	register_taxonomy( 'patologia', [ 'bascon' ], $args );
}

// 
// https:// developer.wordpress.org/plugins/taxonomies/
// Capacitação
// 

add_action( 'init', 'wporg_register_taxonomy_capacitacao' );
function wporg_register_taxonomy_capacitacao() {
	$labels = [
		'name'              => _x( 'Capacitações', 'taxonomy general name' ),
		'singular_name'     => _x( 'Capacitação', 'taxonomy singular name' ),
		'search_items'      => __( 'Buscar Capacitação' ),
		'all_items'         => __( 'Todas as Capacitaçãos' ),
		'parent_item'       => __( 'Capacitação Pai' ),
		'parent_item_colon' => __( 'Capacitação Pai:' ),
		'edit_item'         => __( 'Editar Capacitação' ),
		'update_item'       => __( 'Atualizar Capacitação' ),
		'add_new_item'      => __( 'Adicionar NOVA Capacitação' ),
		'new_item_name'     => __( 'Nova Capacitação Name' ),
		'menu_name'         => __( 'Nova Capacitação' ),
	];
	$args   = [
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'capacitacao' ],
	];
	register_taxonomy( 'capacitacao', [ 'bascon' ], $args );
}

// 
// https:// developer.wordpress.org/plugins/taxonomies/
// Equipamento
// 

add_action( 'init', 'wporg_register_taxonomy_equipamento' );
function wporg_register_taxonomy_equipamento() {
	$labels = [
		'name'              => _x( 'Equipamentos', 'taxonomy general name' ),
		'singular_name'     => _x( 'Equipamento', 'taxonomy singular name' ),
		'search_items'      => __( 'Buscar Equipamento' ),
		'all_items'         => __( 'Todos os Equipamentos' ),
		'parent_item'       => __( 'Equipamento Pai' ),
		'parent_item_colon' => __( 'Equipamento Pai:' ),
		'edit_item'         => __( 'Editar Equipamento' ),
		'update_item'       => __( 'Atualizar Equipamento' ),
		'add_new_item'      => __( 'Adicionar NOVA Equipamento' ),
		'new_item_name'     => __( 'Nova Equipamento Name' ),
		'menu_name'         => __( 'Nova Equipamento' ),
	];
	$args   = [
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'equipamento' ],
	];
	register_taxonomy( 'equipamento', [ 'bascon' ], $args );
}

//
// Adds a meta box to the post editing screen
// https://themefoundation.com/wordpress-meta-boxes-guide/
//

add_action( 'add_meta_boxes', 'bascon_custom_meta' );
function bascon_custom_meta() {
	add_meta_box( 'bascon_meta', __( 'Informações Adicionais', 'bascon-textdomain' ), 'bascon_meta_callback', 'bascon', 'normal', 'high' );
}

// the meta box content
function bascon_meta_callback( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'bascon_nonce' );
	$bascon_stored_meta = get_post_meta( $post->ID );
	$meta_dynamic_1 = get_post_meta($post->ID, 'meta_dynamic_1', true);
	?>
	
	<div class="input_fields_wrap">
	<h3>Anotações</h3>
	<div style="margin: 10px 0 15px 0"><a class="add_field_button button-secondary">Adicionar Anotações <span style="line-height: 1.1; margin-left: 8px;" class="dashicons dashicons-editor-ul"></span></a></div>
	    <?php
	    if(isset($meta_dynamic_1) && is_array($meta_dynamic_1)) {
	        $i = 1;
	        $output = '';
	        
	        foreach($meta_dynamic_1 as $bascon_text){
	            $output  = '<div><input type="text" data-id="test" name="meta_dynamic_1[]" value="' . $bascon_text . '">';
	            $output .= ' <a href="#" class="remove_field">APAGAR</a></div>';
	            echo $output;
				$i++;
			}
	    } else {
			// echo '<div> <input type="text" name="meta_dynamic_1[]"> <a href="#" class="remove_field">APAGAR 2</a></div>';
		}
	    ?>
	</div>

    <label class="bascon-row-title" for="meta-text">
		<?php _e( 'Diagnóstico', 'bascon-textdomain' ) ?></label>
    <input class="bascon-row-input" type="" name="meta_text_1" id="meta_text_1" placeholder=""
           value="<?php if ( isset ( $bascon_stored_meta['meta_text_1'] ) ) {
		       echo $bascon_stored_meta['meta_text_1'][0];
	       } ?>"/>

    <label class="bascon-row-title" for="meta-text">
		<?php _e( 'Idade', 'bascon-textdomain' ) ?></label>
    <input class="bascon-row-input" type="" name="meta_text_2" id="meta_text_2" placeholder=""
           value="<?php if ( isset ( $bascon_stored_meta['meta_text_2'] ) ) {
		       echo $bascon_stored_meta['meta_text_2'][0];
	       } ?>"/>

    <label class="bascon-row-title" for="meta-text">
		<?php _e( 'Equipamento', 'bascon-textdomain' ) ?></label>
    <input class="bascon-row-input" type="" name="meta_text_3" id="meta_text_3" placeholder=""
           value="<?php if ( isset ( $bascon_stored_meta['meta_text_3'] ) ) {
		       echo $bascon_stored_meta['meta_text_3'][0];
	       } ?>"/>

    <label class="bascon-row-title" for="meta-text">
		<?php _e( 'Comentar Alta do Paciente', 'bascon-textdomain' ) ?></label>
    <input class="bascon-row-input" type="" name="meta_text_4" id="meta_text_4" placeholder=""
           value="<?php if ( isset ( $bascon_stored_meta['meta_text_4'] ) ) {
		       echo $bascon_stored_meta['meta_text_4'][0];
	       } ?>"/>

	<!-- meta select 1 -->

    <label class="bascon-row-title" for="meta_select_1">
		<?php _e( 'SEXO', 'bascon-textdomain' ) ?></label>
    <select class="bascon-row-input" name="meta_select_1" id="meta_select_1">
        <option value="MASC" <?php if ( isset ( $bascon_stored_meta['meta_select_1'] ) ) {
			selected( $bascon_stored_meta['meta_select_1'][0], 'MASC' );
		} ?>>
			<?php _e( 'MASC', 'bascon-textdomain' ) ?>
        </option>
        ';
        <option value="FEM" <?php if ( isset ( $bascon_stored_meta['meta_select_1'] ) ) {
			selected( $bascon_stored_meta['meta_select_1'][0], 'FEM' );
		} ?>>
			<?php _e( 'FEM', 'bascon-textdomain' ) ?>
        </option>
        ';
    </select>		   

	<!-- meta select 2 -->

    <label class="bascon-row-title" for="meta_select_2">
		<?php _e( 'COR', 'bascon-textdomain' ) ?></label>
    <select class="bascon-row-input" name="meta_select_2" id="meta_select_2">
        <option value="Branca" <?php if ( isset ( $bascon_stored_meta['meta_select_2'] ) ) {
			selected( $bascon_stored_meta['meta_select_2'][0], 'Branca' );
		} ?>>
			<?php _e( 'Branca', 'bascon-textdomain' ) ?>
        </option>
        ';
        <option value="Negra" <?php if ( isset ( $bascon_stored_meta['meta_select_2'] ) ) {
			selected( $bascon_stored_meta['meta_select_2'][0], 'Negra' );
		} ?>>
			<?php _e( 'Negra', 'bascon-textdomain' ) ?>
        </option>
        ';
        <option value="Mulata" <?php if ( isset ( $bascon_stored_meta['meta_select_2'] ) ) {
			selected( $bascon_stored_meta['meta_select_2'][0], 'Mulata' );
		} ?>>
			<?php _e( 'Mulata', 'bascon-textdomain' ) ?>
        </option>
        ';
		<option value="Outras" <?php if ( isset ( $bascon_stored_meta['meta_select_2'] ) ) {
			selected( $bascon_stored_meta['meta_select_2'][0], 'Outras' );
		} ?>>
			<?php _e( 'Outras', 'bascon-textdomain' ) ?>
        </option>
        ';
    </select>

	<?php
}

//
// save meta-data
// https://developer.wordpress.org/reference/functions/update_post_meta/
//

add_action( 'save_post', 'bascon_meta_save' );
function bascon_meta_save( $post_id ) {
	// Checks save status
	$is_autosave    = wp_is_post_autosave( $post_id );
	$is_revision    = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST['bascon_nonce'] ) && wp_verify_nonce( $_POST['bascon_nonce'], basename( __FILE__ ) ) ) ? 'true' : 'false';
	
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
		return;
	}
	// Checks for input and sanitizes/saves if needed
	if ( isset( $_POST['meta_text_1'] ) ) {
		update_post_meta( $post_id, 'meta_text_1', sanitize_text_field( $_POST['meta_text_1'] ) );
	}
	if ( isset( $_POST['meta_text_2'] ) ) {
		update_post_meta( $post_id, 'meta_text_2', sanitize_text_field( $_POST['meta_text_2'] ) );
	}
	if ( isset( $_POST['meta_text_3'] ) ) {
		update_post_meta( $post_id, 'meta_text_3', sanitize_text_field( $_POST['meta_text_3'] ) );
	}
	if ( isset( $_POST['meta_text_4'] ) ) {
		update_post_meta( $post_id, 'meta_text_4', sanitize_text_field( $_POST['meta_text_4'] ) );
	}
	// Checks for input and saves if needed
	if ( isset( $_POST['meta_select_1'] ) ) {
		update_post_meta( $post_id, 'meta_select_1', $_POST['meta_select_1'] );
	}	
	// Checks for input and saves if needed
	if ( isset( $_POST['meta_select_2'] ) ) {
		update_post_meta( $post_id, 'meta_select_2', $_POST['meta_select_2'] );
	}

	// if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
 
    // now we can actually save the data
    $allowed = array(
        'a' => array(			// on allow a tags
            'href' => array()	// and those anchors can only have href attribute
        )
    );
    // If any value present in input field, then update the post meta
    if(isset($_POST['meta_dynamic_1'])) {
        update_post_meta( $post_id, 'meta_dynamic_1', $_POST['meta_dynamic_1'] );
    }
}

// 
// [bascon] shortcode
//

add_shortcode( 'bascon', 'new_plugin_shortcode_template' );
function new_plugin_shortcode_template() {

	// https:// wordpress.stackexchange.com/questions/203750/how-to-paginate-this-custom-loop
	// get the current page
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	// pagination fixes prior to loop
	$temp  = $query;
	$query = null;
	
	// custom loop using WP_Query
	$query = new WP_Query( array(
		'post_type'			=> 'bascon',
		'post_status'		=> 'publish',
		'posts_per_page'	=> 1,
		'paged'				=> $paged
	) );

	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post();	
				?>
				<div class="bascon-div">
					<?php
					if ( has_post_thumbnail() ) :
						echo '<img>' . the_post_thumbnail() . '</img>';
					endif;
					?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><h1 class="bascon-the_title"><?php the_title(); ?></h1></a>
					<div class="bascon-content"><? the_content(); ?></div>
					<div>
						<?php
							echo the_content();
							echo '<h6>Informações Complementares</h6>';
						
						echo '<table>';

							echo '<tr>';
							echo '<td style="width: 150px">Idade</td>';
							echo '<td>' . get_post_meta( get_the_id(), 'meta_text_2', true ) . '</td>';
							echo '</tr>';

							echo '<tr>';
							echo '<td style="width: 150px">Sexo</td>';
							echo '<td>' . get_post_meta( get_the_id(), 'meta_select_1', true ) . '</td>';
							echo '</tr>';

							echo '<tr>';
							echo '<td style="width: 150px">Cor</td>';
							echo '<td>' . get_post_meta( get_the_id(), 'meta_select_2', true ) . '</td>';
							echo '</tr>';

							echo '<tr>';
							echo '<td style="width: 150px">Diagnóstico</td>';
							echo '<td>' . get_post_meta( get_the_id(), 'meta_text_1', true ) . '</td>';
							echo '</tr>';

							echo '<tr>';
							echo '<td style="width: 150px">Equipamento</td>';
							echo '<td>' . get_post_meta( get_the_id(), 'meta_text_3', true ) . '</td>';
							echo '</tr>';

							echo '<tr>';
							echo '<td style="width: 150px">Alta</td>';
							echo '<td>' . get_post_meta( get_the_id(), 'meta_text_4', true ) . '</td>';
							echo '</tr>';

						echo '</table>';

						echo '<hr style="margin-bottom: 10px">';
						$meta_dynamic_1 =   get_post_meta($post->ID, 'meta_dynamic_1', true);
							if(isset($meta_dynamic_1) && is_array($meta_dynamic_1)) {
								foreach($meta_dynamic_1 as $bascon_text){
									echo '<li class="bascon-meta">Nota: ' . $bascon_text . '</li>';
								}
									echo '<hr style="margin-bottom: 10px">';
							}
						?>
					</div>
					
					<li class="bascon-wp_tag_cloud"><span class="dashicons dashicons-tag"></span> <span>Patologia: </span>
						<?php
						// https://codex.wordpress.org/Function_Reference/wp_tag_cloud
						wp_tag_cloud( array(
							'smallest'                  => 10,
							'largest'                   => 15,
							'unit'                      => 'pt',
							'number'                    => 45,
							'format'                    => 'flat',
							'separator'                 => ",",
							'orderby'                   => 'name',
							'order'                     => 'ASC',
							'exclude'                   => null,
							'include'                   => null,
							'topic_count_text_callback' => default_topic_count_text,
							'show_count'				=> 'true', // display quantity of posts in category
							'link'                      => 'view',
							'taxonomy'                  => 'patologia',
							'echo'                      => true,
							'child_of'                  => null, // see Note!
						) );
						?>
					</li>
					<li class="bascon-wp_tag_cloud"><span class="dashicons dashicons-tag"></span> <span>Especialidade: </span>
						<?php
						// https://codex.wordpress.org/Function_Reference/wp_tag_cloud
						wp_tag_cloud( array(
							'smallest'                  => 10,
							'largest'                   => 15,
							'unit'                      => 'pt',
							'number'                    => 45,
							'format'                    => 'flat',
							'separator'                 => ",",
							'orderby'                   => 'name',
							'order'                     => 'ASC',
							'exclude'                   => null,
							'include'                   => null,
							'topic_count_text_callback' => default_topic_count_text,
							'show_count'				=> 'true', // display quantity of posts in category
							'link'                      => 'view',
							'taxonomy'                  => 'especialidade',
							'echo'                      => true,
							'child_of'                  => null, // see Note!
						) );
						?>
					</li>
					<li class="bascon-wp_tag_cloud"><span class="dashicons dashicons-tag"></span> <span>Capacitação: </span>
						<?php
						// https://codex.wordpress.org/Function_Reference/wp_tag_cloud
						wp_tag_cloud( array(
							'smallest'                  => 10,
							'largest'                   => 15,
							'unit'                      => 'pt',
							'number'                    => 45,
							'format'                    => 'flat',
							'separator'                 => ",",
							'orderby'                   => 'name',
							'order'                     => 'ASC',
							'exclude'                   => null,
							'include'                   => null,
							'topic_count_text_callback' => default_topic_count_text,
							'show_count'				=> 'true', // display quantity of posts in category
							'link'                      => 'view',
							'taxonomy'                  => 'capacitacao',
							'echo'                      => true,
							'child_of'                  => null, // see Note!
						) );
						?>
					</li>
					<li class="bascon-wp_tag_cloud"><span class="dashicons dashicons-tag"></span> <span>Equipamento: </span>
						<?php
						// https://codex.wordpress.org/Function_Reference/wp_tag_cloud
						wp_tag_cloud( array(
							'smallest'                  => 10,
							'largest'                   => 15,
							'unit'                      => 'pt',
							'number'                    => 45,
							'format'                    => 'flat',
							'separator'                 => ",",
							'orderby'                   => 'name',
							'order'                     => 'ASC',
							'exclude'                   => null,
							'include'                   => null,
							'topic_count_text_callback' => default_topic_count_text,
							'show_count'				=> 'true', // display quantity of posts in category
							'link'                      => 'view',
							'taxonomy'                  => 'equipamento',
							'echo'                      => true,
							'child_of'                  => null, // see Note!
						) );
						?>
					</li>			
				</div>
			<?php
			echo '<div class="bascon-clear-3"></div>';
		endwhile;
		$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
			'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'	=> '?paged=%#%',
			'current'	=> get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
			'total'		=> $query->max_num_pages
		) );
	endif;
}

//
// Extend WordPress search to include custom fields
// https://adambalee.com
// https://adambalee.com/search-wordpress-by-custom-fields-without-a-plugin/
//

//
// Join posts and postmeta tables
// http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
//

add_filter( 'posts_join', 'cf_search_join' );
function cf_search_join( $join ) {
	global $wpdb;
	if ( is_search() ) {
		$join .= ' LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	}

	return $join;
}

//
// Modify the search query with posts_where
// http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
//

add_filter( 'posts_where', 'cf_search_where' );
function cf_search_where( $where ) {
	global $pagenow, $wpdb;
	if ( is_search() ) {
		$where = preg_replace(
			"/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)", $where );
	}

	return $where;
}

//
// Prevent duplicates
// http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
//

add_filter( 'posts_distinct', 'cf_search_distinct' );
function cf_search_distinct( $where ) {
	global $wpdb;
	if ( is_search() ) {
		return "DISTINCT";
	}

	return $where;
}

// limit dashboard and functions without admin user

function hide_menu() {
	global $current_user;
	$user_id = get_current_user_id();
	if ( $user_id != '1' ) {
		remove_menu_page( 'themes.php' );
		remove_menu_page( 'index.php' );
		remove_submenu_page( 'index.php', 'update-core.php' );
		remove_submenu_page( 'themes.php', 'themes.php' );
		remove_submenu_page( 'themes.php', 'theme-editor.php' );
		remove_submenu_page( 'themes.php', 'theme_options' );
		remove_menu_page( 'users.php' );
		remove_submenu_page( 'users.php', 'user-new.php' );
		remove_submenu_page( 'users.php', 'profile.php' );
		remove_menu_page( 'upload.php' );
		remove_submenu_page( 'upload.php', 'media-new.php' );
		remove_submenu_page( 'upload.php', 'upload.php?page=wp-smush-bulk' );
		remove_menu_page( 'admin.php?page=Wordfence' );
		remove_submenu_page( 'admin.php?page=Wordfence', 'media-new.php' );
		remove_menu_page( 'edit.php?post_type=dt_teachers' );
		remove_submenu_page( 'edit.php?post_type=dt_teachers', 'post-new.php?post_type=dt_teachers' );
		remove_menu_page( 'edit.php?post_type=dt_portfolios' );
		remove_submenu_page( 'edit.php?post_type=dt_portfolios', 'post-new.php?post_type=dt_portfolios' );
		remove_submenu_page( 'edit-tags.php?taxonomy=portfolio_entries', 'edit-tags.php?taxonomy=portfolio_entries&post_type=dt_portfolios' );
		remove_menu_page( 'edit.php' );
		remove_submenu_page( 'edit.php', 'post-new.php' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
		remove_menu_page( 'edit.php?post_type=page' );
		remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' );

		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'admin.php?page=parent' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'options-general.php' );
		remove_menu_page( 'plugins.php' );
		remove_menu_page( 'edit.php?post_type=product' );

		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );		// Remove "At a Glance"
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );			// Remove "Activity" which includes "Recent Comments"
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );   // Incoming Links
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );          // Plugins
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );        // Quick Press
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );      // Recent Drafts
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );            // WordPress blog
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );          // Other WordPress News
		remove_action( 'welcome_panel', 'wp_welcome_panel' );                   // Remove WordPress Welcome Panel

		function remove_admin_bar_links() {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu( 'wp-logo' );          // Remove the Wordpress logo
			$wp_admin_bar->remove_menu( 'about' );            // Remove the about Wordpress link
			$wp_admin_bar->remove_menu( 'wporg' );            // Remove the Wordpress.org link
			$wp_admin_bar->remove_menu( 'documentation' );    // Remove the Wordpress documentation link
			$wp_admin_bar->remove_menu( 'support-forums' );   // Remove the support forums link
			$wp_admin_bar->remove_menu( 'feedback' );         // Remove the feedback link
			$wp_admin_bar->remove_menu( 'site-name' );        // Remove the site name menu
			$wp_admin_bar->remove_menu( 'view-site' );        // Remove the view site link
			$wp_admin_bar->remove_menu( 'updates' );          // Remove the updates link
			$wp_admin_bar->remove_menu( 'comments' );         // Remove the comments link
			$wp_admin_bar->remove_menu( 'new-content' );      // Remove the content link
			$wp_admin_bar->remove_menu( 'w3tc' );             // If you use w3 total cache remove the performance link
		}

		add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
	}
}

add_action( 'admin_head', 'hide_menu' );

//
// Admin footer modification
//

add_filter( 'admin_footer_text', 'remove_footer_admin' );
 
function remove_footer_admin() {
	echo '<span class="bascon-footer-thankyou">Developed by <a href="https://www.agddesign.com" target="_blank">www.agddesign.com</a></span>';
}

//
// List Content Individual CPT
//

function theme_slug_filter_the_content( $content ) {
    if( is_single() ) {
		global $post;
		$content     	 .= '<hr style="margin: 0px 0px 10px 0">';
		$taxonomy_names   = get_post_taxonomies( );
		$patologia		  = get_the_terms( get_the_ID(), 'patologia' ); 
		$especialidade	  = get_the_terms( get_the_ID(), 'especialidade' ); 
		$get_meta		  = get_post_meta($post->ID);
		$meta_dynamic_1   = unserialize($get_meta["meta_dynamic_1"][0]);
		if(!empty($meta_dynamic_1)){
			$content     .= "NOTAS COMPLEMENTARES";
			$content     .= '<hr style="margin: 10px 0">';
			$sizeof		  = sizeof($meta_dynamic_1);
			 for($i		  = 0; $i< $sizeof; $i++){
				$content .= '<span class="bascon-label">Nota: </span>' . $meta_dynamic_1[$i] . '<br>';
				$content .= '<hr style="margin: 1px 0 5px 0; border:1px solid #EAEAEA">';
			}
		}
		
		if(!empty($get_meta["meta_text_1"  ][0])){ $content .= $get_meta["meta_text_1"  ][0] . "<span class='bascon-label'> (Diagnóstico)</span><br>"; }
		if(!empty($get_meta["meta_text_2"  ][0])){ $content .= $get_meta["meta_text_2"  ][0] . "<span class='bascon-label'> (Idade)</span><br>"; }
		if(!empty($get_meta["meta_text_3"  ][0])){ $content .= $get_meta["meta_text_3"  ][0] . "<span class='bascon-label'> (Equipamento usado)</span><br>"; }
		if(!empty($get_meta["meta_text_4"  ][0])){ $content .= $get_meta["meta_text_4"  ][0] . "<span class='bascon-label'> (Alta Comentada)</span><br>"; }
		if(!empty($get_meta["meta_select_1"][0])){ $content .= $get_meta["meta_select_1"][0] . "<span class='bascon-label'> (Sexo)</span><br>"; }
		if(!empty($get_meta["meta_select_2"][0])){ $content .= $get_meta["meta_select_2"][0] . "<span class='bascon-label'> (Cor)</span><br>"; }

					echo '<li class="bascon-wp_tag_cloud"><span class="dashicons dashicons-tag"></span> <span>Patologia: </span>';
						// https://codex.wordpress.org/Function_Reference/wp_tag_cloud
						// https://developer.wordpress.org/reference/functions/wp_generate_tag_cloud/
						wp_tag_cloud( array(
							'smallest'                  => 10,
							'largest'                   => 15,
							'unit'                      => 'pt',
							'number'                    => 45,
							'format'                    => 'flat',
							'separator'                 => "\n",
							'orderby'                   => 'name',
							'order'                     => 'ASC',
							'exclude'                   => null,
							'include'                   => null,
							'topic_count_text_callback' => default_topic_count_text,
							'show_count'				=> 'true', // display quantity of posts in category
							'link'                      => 'view',
							'taxonomy'                  => 'patologia',
							'echo'                      => true,
							'child_of'                  => null, // see Note!
						) );
						echo '</li>';
						echo '<li class="bascon-wp_tag_cloud"><span class="dashicons dashicons-tag"></span> <span>Especialidade: </span>';
						// https://codex.wordpress.org/Function_Reference/wp_tag_cloud
						// https://developer.wordpress.org/reference/functions/wp_generate_tag_cloud/
						wp_tag_cloud( array(
							'smallest'                  => 10,
							'largest'                   => 15,
							'unit'                      => 'pt',
							'number'                    => 45,
							'format'                    => 'flat',
							'separator'                 => "\n",
							'orderby'                   => 'name',
							'order'                     => 'ASC',
							'exclude'                   => null,
							'include'                   => null,
							'topic_count_text_callback' => default_topic_count_text,
							'show_count'				=> 'true', // display quantity of posts in category
							'link'                      => 'view',
							'taxonomy'                  => 'especialidade',
							'echo'                      => true,
							'child_of'                  => null, // see Note!
						) );
					echo '</li>';
					echo '<li class="bascon-wp_tag_cloud"><span class="dashicons dashicons-tag"></span> <span>Capacitação: </span>';
					// https://codex.wordpress.org/Function_Reference/wp_tag_cloud
					// https://developer.wordpress.org/reference/functions/wp_generate_tag_cloud/
					wp_tag_cloud( array(
						'smallest'                  => 10,
						'largest'                   => 15,
						'unit'                      => 'pt',
						'number'                    => 45,
						'format'                    => 'flat',
						'separator'                 => "\n",
						'orderby'                   => 'name',
						'order'                     => 'ASC',
						'exclude'                   => null,
						'include'                   => null,
						'topic_count_text_callback' => default_topic_count_text,
						'show_count'				=> 'true', // display quantity of posts in category
						'link'                      => 'view',
						'taxonomy'                  => 'capacitacao',
						'echo'                      => true,
						'child_of'                  => null, // see Note!
					) );
					echo '</li>';
					echo '<li class="bascon-wp_tag_cloud"><span class="dashicons dashicons-tag"></span> <span>Equipamento: </span>';
					// https://codex.wordpress.org/Function_Reference/wp_tag_cloud
					// https://developer.wordpress.org/reference/functions/wp_generate_tag_cloud/
					wp_tag_cloud( array(
						'smallest'                  => 10,
						'largest'                   => 15,
						'unit'                      => 'pt',
						'number'                    => 45,
						'format'                    => 'flat',
						'separator'                 => "\n",
						'orderby'                   => 'name',
						'order'                     => 'ASC',
						'exclude'                   => null,
						'include'                   => null,
						'topic_count_text_callback' => default_topic_count_text,
						'show_count'				=> 'true', // display quantity of posts in category
						'link'                      => 'view',
						'taxonomy'                  => 'equipamento',
						'echo'                      => true,
						'child_of'                  => null, // see Note!
					) );
					echo '</li>';
					echo '<br>';
		// $get_the_post_thumbnail = get_the_post_thumbnail($post->ID, 'thumbnail');
		// if(!empty($get_the_post_thumbnail)){
		// 	$content .= $get_the_post_thumbnail."<br>";
		// }
    }
    return $content;
}
add_filter( 'the_content', 'theme_slug_filter_the_content' );

// relative permissions
// http://pt.wordpressask.com/impedir-que-os-autores-vejam-os-outros-posts.html

add_action( 'load-edit.php', 'wpse14230_load_edit' );
function wpse14230_load_edit()
{
    add_action( 'request', 'wpse14230_request' );
}

function wpse14230_request( $query_vars )
{
    if ( ! current_user_can( $GLOBALS['post_type_object']->cap->edit_others_posts ) ) {
        $query_vars['author'] = get_current_user_id();
    }
    return $query_vars;
}

// https://codex.wordpress.org/Function_Reference/add_cap

function add_theme_caps() {
	$role = get_role( 'bascon' );
}
add_action( 'admin_init', 'add_theme_caps');

// add dynamic custom fields (dynamic notes) JS/JQuery

function add_jquery_data() {
   ?>
		<script type="text/javascript">
			$(document).ready(function($){
			var max_fields = 50;
			var wrapper    = $(".input_fields_wrap");
			var add_button = $(".add_field_button");
			var x 		   = 1;
			$(add_button).click(function(e){
			e.preventDefault();
			if(x < max_fields){
				x++;
				$(wrapper).append('<div><input type="text" placeholder="EX.: Iniciada a primeira sessão com 10 joules, logo após anamnese!" name="meta_dynamic_1[]"/> <a href="#" class="remove_field">APAGAR</a></div>');
			}
			})
			$(wrapper).on("click",".remove_field", function(e){
			e.preventDefault();
			$(this).parent('div').remove(); x--;
			})
			});
		</script> 
   <?php
}
add_filter('admin_head', 'add_jquery_data');

// Custom placeholder text for custom post type title input box
// https://gist.github.com/FStop/3094617
// Developer Resources: Dashicons
// https://developer.wordpress.org/resource/dashicons/#admin-customizer

function wpfstop_change_default_title( $title ) {
    $screen = get_current_screen();
    if( isset( $screen->post_type ) ) {
        if ( 'bascon' == $screen->post_type ) {
            $title = '<span class="dashicons dashicons-format-quote"></span> ' . 'Crie um Título Sucinto' . ' <span class="dashicons dashicons-format-quote"></span>';
        }
    }
    return $title;
}
add_filter( 'enter_title_here', 'wpfstop_change_default_title' );

// How to put placeholder text in the main post input area?
// https://wordpress.stackexchange.com/questions/57907/how-to-put-placeholder-text-in-the-main-post-input-area

add_filter( 'default_content', 'wpse57907_default_content', 10, 2 );
function wpse57907_default_content( $content, $post ) {
    if ( 'bascon' == $post->post_type )
        $content = 'ANAMNESE: ';
    return $content;
}

// Other placeholder format to more option

// add_filter('the_editor','wpse57907_add_placeholder');
// function wpse57907_add_placeholder( $html ){
//     $html = preg_replace('/<textarea/', '<textarea placeholder="ANAMNESE: "', $html);
//     return $html;
// }
