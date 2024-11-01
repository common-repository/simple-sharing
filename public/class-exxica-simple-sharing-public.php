<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://exxica.com
 * @since      1.0.0
 *
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/admin
 * @author     Gaute Rønningen <gaute@exxica.com>
 */
class Exxica_Simple_Sharing_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->name.'-public', plugin_dir_url( __FILE__ ) . 'css/exxica-simple-sharing-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->name.'-public', plugin_dir_url( __FILE__ ) . 'js/exxica-simple-sharing-public.js', array( 'jquery' ), $this->version, FALSE );
		wp_enqueue_script( 'fontawesome', 'https://use.fontawesome.com/acd86ae435.js', array('jquery'), '4.7.0', false);
	}

	public function init_shortcodes() {
		add_shortcode('exxica_sharing', array($this, 'sharing_shortcode'));
	}

	public function sharing_shortcode( $atts ) {
		global $wp, $post;
		$out = "";
        $id = $post->ID;
			
		$current_url = get_permalink($id);
		$current_title = get_the_title($id);
		$current_excerpt = get_the_excerpt($id);
		$blogname = get_bloginfo('name');

        // Settings
        $enabled = get_option('exxica_sharing_enabled_default');
        if(!empty($enabled) && $enabled === "1") {
            $_button_size = get_option('exxica_sharing_button_size_default');
            $_icon_type = get_option('exxica_sharing_button_icon_type_default');
            $_with_text = get_option('exxica_sharing_button_has_text_default');
            $_horizontal = get_option('exxica_sharing_list_horizontal_default');
            $_sharing_title_enabled = get_option('exxica_sharing_title_enabled_default');
            $_sharing_title = get_option('exxica_sharing_title_default');

			$sharers = array(
				array(
					'name' => __('Facebook', $this->name),
					'title' => sprintf('%s %s', ($_sharing_title_enabled === "1") ? $_sharing_title : __('Share the article on', $this->name), __('Facebook', $this->name)),
					'url' => sprintf("http://www.facebook.com/sharer/sharer.php?u=%s", urlencode($current_url)),
					'iconCls' => ($_icon_type === "1") ? 'fa-facebook-official' : 'fa-facebook-square',
					'cls' => 'sharing-link-facebook'
				),
				array(
					'name' => __('Twitter', $this->name),
					'title' => sprintf('%s %s', ($_sharing_title_enabled === "1") ? $_sharing_title : __('Share the article on', $this->name), __('Twitter', $this->name)),
					'url' => sprintf("https://twitter.com/home?status=%s%s", urlencode($current_title.__(' on ', $this->name).html_entity_decode($blogname)), '%20'.urlencode($current_url)),
					'iconCls' => ($_icon_type === "1") ? 'fa-twitter' : 'fa-twitter-square',
					'cls' => 'sharing-link-twitter'
				),
				array(
					'name' => __('Google+', $this->name),
					'title' => sprintf('%s %s', ($_sharing_title_enabled === "1") ? $_sharing_title : __('Share the article on', $this->name), __('Google+', $this->name)),
					'url' => sprintf("https://plus.google.com/share?url=%s", urlencode($current_url)),
					'iconCls' => ($_icon_type === "1") ? 'fa-google-plus-official' : 'fa-google-plus-square',
					'cls' => 'sharing-link-googleplus'
				),
				array(
					'name' => __('LinkedIn', $this->name),
					'title' => sprintf('%s %s', ($_sharing_title_enabled === "1") ? $_sharing_title : __('Share the article on', $this->name), __('LinkedIn', $this->name)),
					'url' => sprintf("https://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s&source=%s", urlencode($current_url), urlencode($current_title), urlencode($blogname) ),
					'iconCls' => ($_icon_type === "1") ? 'fa-linkedin' : 'fa-linkedin-square',
					'cls' => 'sharing-link-linkedin'
				),
				array(
					'name' => __('E-mail', $this->name),
					'title' => sprintf('%s %s', ($_sharing_title_enabled === "1") ? $_sharing_title : __('Share the article on', $this->name), __('E-mail', $this->name)),
					'url' => sprintf(
						"mailto:?subject=%s&body=%s%s", 
							__($post->post_type.'_email', $this->name).$current_title,
							$current_excerpt,
							'%0D%0A%0D%0A'.__('Read more about ',$this->name).$current_title.' ('.urlencode($current_url).')'.__(' on ', $this->name). preg_replace("/\+/", " ", urlencode(html_entity_decode($blogname)))
						),
					'iconCls' => ($_icon_type === "1") ? 'fa-envelope-o' : 'fa-envelope-square',
					'cls' => 'sharing-link-mail'
				)
			);

			ob_start();
			?>
            <div id="exxica-simple-sharing-float">
                <?php if($_sharing_title_enabled === "1") : ?>
                <strong><?= $_sharing_title ?></strong><br/>
                <?php endif; ?>
                <?php if($_horizontal === "1") : ?><ul><?php endif; ?>
                <?php foreach($sharers as $row) : ?>
                <?php if($_horizontal === "1") : ?><li><?php endif; ?>
                    <a class="exxica-simple-sharing-link <?= $row['cls'] ?>" href="<?= $row['url'] ?>" target="_blank" title="<?= $row['title'] ?>">
                        <i class="fa <?= $row['iconCls'] ?> <?= $_button_size ?>" aria-hidden="true"></i><span class="hidden-xs"><?php if($_with_text === "1") echo ' '.$row['name']; ?></span>
                    </a>
                <?php if($_horizontal === "1") : ?></li><?php else: ?><br/><?php endif; ?>
                <?php endforeach; ?>
                <?php if($_horizontal === "1") : ?></ul><?php endif; ?>
            </div>
			<?php
			$out = ob_get_contents();
			ob_end_clean();
		}
		return $out;
	}

	public function insert_sharing_shortcode($content) {
		return $content;
	}
}
