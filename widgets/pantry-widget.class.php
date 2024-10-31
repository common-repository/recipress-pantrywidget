<?php
/**
 * Pantry Widget
 * 
 * @author Brian Zoetewey <Omicron7@gmail.com>
 */
class ReciPress_PantryWidget extends WP_Widget {
	/**
	 * Title attribute
	 * @var string
	 */
	const TITLE = 'title';
	
	/**
	 * Link attribute
	 * @var unknown_type
	 */
	const LINK  = 'link';
	
	/**
	 * Ingredients list attribute
	 * @var unknown_type
	 */
	const INGREDIENTS = 'ingredients';
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$config = array(
			'classname'   => 'recipress-pantrywidget',
			'description' => __( 'Display a list of ingredients currently in your pantry.', ReciPress_PantryPlugin::TEXT_DOMAIN ),
		);
		parent::__construct( 'recipress_pantrywidget', __( 'My Pantry', ReciPress_PantryPlugin::TEXT_DOMAIN ), $config );
	}
	
	/**
	 * Displays the widget content
	 * 
	 * @see WP_Widget::widget()
	 */
	public function widget( $args, $instance ) {
		$instance = (array) $instance;
		
		$title = empty( $instance[ self::TITLE ] ) ? '' : $instance[ self::TITLE ];
		echo $args[ 'before_widget' ];
		if( !empty( $title ) ) {
			echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];
		}
		?>
		<ul>
			<?php
				foreach( $instance[ self::INGREDIENTS ] as $term_id ) :
					$term = get_term( $term_id, 'ingredient' );
			?>
				<li>
				<?php if( $instance[ self::LINK ] ) : ?>
					<a href="<?php echo get_term_link( $term ); ?>"><?php echo esc_html( $term->name );  ?></a>
				<?php
					else :
						echo esc_html( $term->name );
					endif;
				?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Updates the widgets instance
	 * 
	 * @see WP_Widget::update()
	 */
	public function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = array();
		$instance[ self::TITLE ] = strip_tags( $new_instance[ self::TITLE ] );
		$instance[ self::LINK ] = isset( $new_instance[ self::LINK ] ) ? true : false;
		$instance[ self::INGREDIENTS ] = is_array( $new_instance[ self::INGREDIENTS ] ) ?
			(array) $new_instance[ self::INGREDIENTS ] : array();
		array_walk( $instance[ self::INGREDIENTS ], 'intval' );
		return $instance;
	}

	/**
	 * Displays the widgets settings form
	 * 
	 * @see WP_Widget::form()
	 */
	public function form( $instance) {
		//Default options
		$defaults = array(
			self::TITLE       => '',
			self::LINK        => true,
			self::INGREDIENTS => array(),
		);
		$instance = wp_parse_args( (array) $instance, (array) $defaults );
		
		$title = strip_tags( $instance[ self::TITLE ] );
		$ingredients = get_terms( 'ingredient', array( 'hide_empty' => false ) );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( self::TITLE ); ?>"><?php _e( 'Title:', ReciPress_PantryPlugin::TEXT_DOMAIN ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( self::TITLE ); ?>" name="<?php echo $this->get_field_name( self::TITLE ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				<br /><small><?php _e( 'optional', ReciPress_PantryPlugin::TEXT_DOMAIN ); ?></small>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance[ self::LINK ], true ) ?> id="<?php echo $this->get_field_id( self::LINK ); ?>" name="<?php echo $this->get_field_name( self::LINK ); ?>" />
				<label for="<?php echo $this->get_field_id( self::LINK ); ?>"><?php _e( 'Show Ingredient Links', ReciPress_PantryPlugin::TEXT_DOMAIN ); ?></label>
			</p>
			<p>
				<hr />
				<strong><?php _e( 'Ingredients', ReciPress_PantryPlugin::TEXT_DOMAIN ); ?></strong><br />
				<ul>
				<?php foreach( $ingredients as $ingredient ) : ?>
					<li>
						<input class="checkbox" type="checkbox" <?php checked( in_array( $ingredient->term_id, $instance[ self::INGREDIENTS ] ) ); ?> name="<?php echo $this->get_field_name( self::INGREDIENTS ); ?>[]" id="<?php echo $this->get_field_id( self::INGREDIENTS ) . "_{$ingredient->term_id}" ?>" value="<?php echo esc_attr( $ingredient->term_id ); ?>" />
						<label for="<?php echo $this->get_field_id( self::INGREDIENTS ) . "_{$ingredient->term_id}" ?>" ><?php echo esc_html( $ingredient->name)?></label>
					</li>
				<?php endforeach;?>
				</ul>
			</p>
			<p>
				<a href="<?php echo admin_url( 'edit-tags.php?taxonomy=ingredient' ); ?>"><?php _e( 'Manage Ingredients', ReciPress_PantryPlugin::TEXT_DOMAIN ); ?></a>
			</p>
		<?php
	}
}
