<?php

class WCBP_Test extends WP_UnitTestCase {

	public function setUp() {
		/** @var WP_Rewrite $wp_rewrite */
		global $wp_rewrite;
		parent::setUp();

		$woo_permalinks = array(
			'product_base' => '/shop'
		);

		update_option( 'woocommerce_permalinks', $woo_permalinks );
		$wp_rewrite->init();
		$wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%day%/%postname%' );
		create_initial_taxonomies();
		update_option( 'page_comments', true );
		update_option( 'comments_per_page', 5 );
		do_action('init');

	}

	public function test_woo_loaded() {

		$this->assertTrue( class_exists('WooCommerce') );
	}

	public function test_post_type_link() {
		$id = $this->factory->post->create( array( 'post_type' => 'product') );
		$term_id = $this->factory->term->create( array('taxonomy' => 'product_cat') );
		wp_set_object_terms($id, $term_id, 'product_cat');
		$this->assertEquals( $id, url_to_postid( get_permalink($id) ) );

	}
}

