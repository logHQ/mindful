<?php

/**
 * mindful Top Posts Widget
 * mindful
 */
class mindful_Popular_Posts extends WP_Widget {
	function __construct() {
		add_action( 'admin_init', array( $this, 'enqueue' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
		$widget_ops = array(
			'classname' => 'mindful-popular-posts',
			'description' => esc_html__( 'mindful Popular Posts Widget', 'mindful' ),
		);
		  parent::__construct( 'mindful_popular_posts', esc_html__( 'mindful Popular Posts Widget','mindful' ), $widget_ops );
	}

	public function enqueue() {

		if ( is_admin() ) {
			wp_enqueue_script( 'mindful-popular-post-script', get_template_directory_uri() . '/assets/js/widget.js', array( 'jquery' ) );
			$args = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			);
			wp_localize_script( 'mindful-popular-post-script', 'mindful', $args );
		}

	}

	function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Popular Posts', 'mindful' );
		$limit = isset( $instance['limit'] ) ? $instance['limit'] : 5;
		$default_image = isset( $instance['default_image'] ) ? $instance['default_image'] : '';

		echo $args['before_widget'];
		echo $args['before_title'];
		echo $title;
		echo $args['after_title'];

		/**
		 * Widget Content
		 */
	?>

	<!-- popular posts -->
		  <div class="popular-posts-wrapper">

				<?php

				  $featured_args = array(
					  'posts_per_page' => $limit,
					  'orderby' => 'comment_count',
					  'order' => 'DESC',
					  'ignore_sticky_posts' => 1,
				  );

				  $featured_query = new WP_Query( $featured_args );

				  /**
				   * Check if zilla likes plugin exists
				   */
				if ( $featured_query->have_posts() ) : while ( $featured_query->have_posts() ) : $featured_query->the_post();

					?>

					<?php if ( get_the_content() != '' ) : ?>

						<!-- post -->
						<div class="post">

						  <!-- image -->
						  <div class="post-image <?php echo get_post_format(); ?>">

								<a href="<?php echo get_permalink(); ?>">
								<?php
								if ( has_post_thumbnail() ) {
									echo get_the_post_thumbnail( get_the_ID() , 'tab-small' );
								}elseif ( $default_image ) {
									echo wp_get_attachment_image( $default_image, 'tab-small' );
								}
								?>
								</a>

						  </div> <!-- end post image -->

						  <!-- content -->
						  <div class="post-content">

							  <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
							  <span class="date"><?php

								// echo get_the_date( 'd M , Y' );
								// the_excerpt();
							  echo mindful_excerpt(15);
							  ?></span>


						  </div><!-- end content -->
						</div><!-- end post -->

						<?php endif; ?>

					<?php

				  endwhile;
endif;
				wp_reset_query();

					?>

		  </div> <!-- end posts wrapper -->

		<?php

		echo $args['after_widget'];
	}

	function form( $instance ) {

		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Popular Posts', 'mindful' );
		}
		if ( ! isset( $instance['limit'] ) ) {
			$instance['limit'] = 5;
		}
		if ( ! isset( $instance['default_image'] ) ) {
			$instance['default_image'] = '';
		}else{
			$instance['default_image'] = wp_get_attachment_image_url( $instance['default_image'], 'medium' );
		}

		?>

	  	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'mindful' ) ?></label>

	  	<input  type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"
			  name="<?php echo $this->get_field_name( 'title' ); ?>"
			  id="<?php $this->get_field_id( 'title' ); ?>"
			  class="widefat" />
	  	</p>

	  	<p><label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php esc_html_e( 'Limit Posts Number', 'mindful' ) ?></label>

	  	<input  type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>"
			  name="<?php echo $this->get_field_name( 'limit' ); ?>"
			  id="<?php $this->get_field_id( 'limit' ); ?>"
			  class="widefat" />
	  	<p>
	  	<div class="mindful-media-container media-widget-control">
	  		<p>
		  		<label for="<?php echo $this->get_field_id( 'default_image' ); ?>"><?php esc_html_e( 'Default Image', 'mindful' ) ?></label>
		  		<input  type="hidden" value="<?php echo esc_attr( $instance['default_image'] ); ?>"
				  name="<?php echo $this->get_field_name( 'default_image' ); ?>"
				  id="<?php echo $this->get_field_id( 'default_image' ); ?>"
				  class="widefat" />
		  	</p>
		  	<div class="media-widget-preview">
				<div class="attachment-media-view">
					<div class="placeholder" <?php echo $instance['default_image'] ? 'style="display:none;"' : '' ?>><?php echo esc_html__( 'No media selected', 'mindful' ); ?></div>
					<?php if ( $instance['default_image'] ): ?>
						<img src="<?php echo $instance['default_image'] ?>">
					<?php endif ?>
				</div>
			</div>
			<p class="media-widget-buttons">
				<button type="button" class="button upload-button">
					<?php echo esc_html_x( 'Add Media', 'label for button in the media widget', 'mindful' ); ?>
				</button>
				<button type="button" class="button remove-button">
					<?php echo esc_html_x( 'Remove Media', 'label for button in the media widget; should preferably not be longer than ~13 characters long', 'mindful' ); ?>
				</button>
			</p>
		</div>

		<?php
	}
}
?>
