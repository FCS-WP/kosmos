<?php 
add_action('woocommerce_product_query', 'storeapps_exclude_categories_from_shop_page');
function storeapps_exclude_categories_from_shop_page($q)
{
  $tax_query = (array) $q->get('tax_query');

  if (is_user_logged_in()) {
    return $tax_query;
  }

  $tax_query[] = array(
    'taxonomy' => 'product_cat',
    'field' => 'slug',
    'terms' => array('special-product'), // Define an array of hidden categories.
    'operator' => 'NOT IN'
  );
  $q->set('tax_query', $tax_query);  // Return the modified tax query.
}

//Function to redirect to shop page when non_logged_in_user access to special product
function redirect_non_logged_in_users_from_special_products($q) {
    if (!is_user_logged_in() && is_singular('product')) {
        global $post;
        $terms = wp_get_post_terms($post->ID, 'product_cat');
        $special_product_found = false;

        foreach ($terms as $term) {
            if ($term->slug === 'special-product') {
                $special_product_found = true;
                break;
            }
        }

        if ($special_product_found) {
            wp_redirect(get_permalink(wc_get_page_id('shop')));
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_non_logged_in_users_from_special_products');

//function display none special category on widget when non logged in users access shop page
function display_none_special_category_on_widget_non_logged_in() {
    if ( !is_user_logged_in() ) {
        echo '
        <style>
        .cat-item.cat-item-190 {
            display: none !important;
        }
        </style>
        ';
    }
}
add_action( 'wp_head', 'display_none_special_category_on_widget_non_logged_in' );

add_action( 'woocommerce_cart_calculate_fees', 'promotion_bulk_purchase' );

function promotion_bulk_purchase( $cart ) {
   $cart_items = WC()->cart->get_cart();
   $total_fee_promotion = 0;

   foreach( $cart_items as $cart_item_key => $cart_item ) {
      $quantity = $cart_item['quantity'];
      
      if($quantity >= 100){
         $total_fee_promotion_product = $quantity*(-2);
         
      }elseif( $quantity>= 50 && $quantity < 100 ){
         $total_fee_promotion_product = $quantity*(-1);
      }else{
         $total_fee_promotion_product = 0;
      }

      $total_fee_promotion = ($total_fee_promotion + $total_fee_promotion_product);
   }

	$cart->add_fee( 'Promotion Bulk Purchase', $total_fee_promotion );
} 


function ahirwp_translate_woocommerce_strings( $translated, $untranslated, $domain ) {
 
   if ( ! is_admin() && 'woocommerce' === $domain ) {
 
      switch ( $translated ) {
 
         case 'Ship to a different address?':
 
            $translated = 'Residential Details';
            break;
            
         case 'First name':
 
            $translated = 'First Student Name';
            break;
        
         case 'Last name':
 
            $translated = 'Last Student Name';
            break;
        
         
         // ETC
       
      }
 
   }   
  
   return $translated;
 
}
// Add custom fields to the checkout page
add_action( 'woocommerce_before_order_notes', 'add_parent_checkout_fields' );
function add_parent_checkout_fields( $checkout ) {

    echo '<div id="school_checkout_fields"><h3>' . __('School Information') . '</h3>';

    woocommerce_form_field( 'school_customer', array(
        'type'        => 'text',
        'class'       => array('school_customer form-row-wide'),
        'label'       => __('School Name'),
    ), $checkout->get_value( 'school_customer' ));

    woocommerce_form_field( 'class_customer', array(
        'type'        => 'text',
        'class'       => array('customer form-row-wide'),
        'label'       => __('Class Name'),
    ), $checkout->get_value( 'class_customer' ));

    echo '</div>';
    echo '<div id="parent_checkout_fields"><h3>' . __('Parent Information') . '</h3>';

    woocommerce_form_field( 'parent_contact_number', array(
        'type'        => 'text',
        'class'       => array('parent_contact_number form-row-wide'),
        'label'       => __('Parent\'s Contact Number'),
    ), $checkout->get_value( 'parent_contact_number' ));

    woocommerce_form_field( 'parent_email_address', array(
        'type'        => 'email',
        'class'       => array('parent_email_address form-row-wide'),
        'label'       => __('Parent\'s Email Address'),
    ), $checkout->get_value( 'parent_email_address' ));

    echo '</div>';
}

// Save the custom fields to the order metadata
add_action( 'woocommerce_checkout_update_order_meta', 'save_parent_checkout_fields' );
function save_parent_checkout_fields( $order_id ) {
    if ( ! empty( $_POST['class_customer'] ) ) {
        update_post_meta( $order_id, 'class_customer', sanitize_text_field( $_POST['class_customer'] ) );
    }
    if ( ! empty( $_POST['school_customer'] ) ) {
        update_post_meta( $order_id, 'school_customer', sanitize_text_field( $_POST['school_customer'] ) );
    }
    if ( ! empty( $_POST['parent_contact_number'] ) ) {
        update_post_meta( $order_id, 'parent_contact_number', sanitize_text_field( $_POST['parent_contact_number'] ) );
    }
    if ( ! empty( $_POST['parent_email_address'] ) ) {
        update_post_meta( $order_id, 'parent_email_address', sanitize_email( $_POST['parent_email_address'] ) );
    }
}

// Display the custom fields in the WooCommerce admin order details
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_parent_fields_in_admin', 10, 1 );
function display_parent_fields_in_admin( $order ){
    $parent_contact_number = get_post_meta( $order->get_id(), 'parent_contact_number', true );
    $parent_email_address = get_post_meta( $order->get_id(), 'parent_email_address', true );
    $class_customer = get_post_meta( $order->get_id(), 'class_customer', true );
    $school_customer = get_post_meta( $order->get_id(), 'school_customer', true );

    if ( $school_customer ) {
        echo '<p><strong>' . __('School') . ':</strong> ' . $school_customer . '</p>';
    }

    if ( $class_customer ) {
        echo '<p><strong>' . __('Class') . ':</strong> ' . $class_customer . '</p>';
    }

    if ( $parent_contact_number ) {
        echo '<p><strong>' . __('Parent\'s Contact Number') . ':</strong> ' . $parent_contact_number . '</p>';
    }

    if ( $parent_email_address ) {
        echo '<p><strong>' . __('Parent\'s Email Address') . ':</strong> ' . $parent_email_address . '</p>';
    }
}

// Display the custom fields in the thank you page and WooCommerce emails
add_action( 'woocommerce_thankyou', 'display_parent_fields_in_thankyou', 20 );
add_action( 'woocommerce_email_after_order_table', 'display_parent_fields_in_thankyou', 20 );
function display_parent_fields_in_thankyou( $order_id ) {
    $parent_contact_number = get_post_meta( $order_id, 'parent_contact_number', true );
    $parent_email_address = get_post_meta( $order_id, 'parent_email_address', true );
    $class_customer = get_post_meta( $order_id, 'class_customer', true );
    $school_customer = get_post_meta( $order_id, 'school_customer', true );

    if ( $school_customer ) {
        echo '<p><strong>' . __('School') . ':</strong> ' . $school_customer . '</p>';
    }

    if ( $class_customer ) {
        echo '<p class="checkout-class"><strong>' . __('Class') . ':</strong> ' . $class_customer . '</p>';
    }

    if ( $parent_contact_number ) {
        echo '<p class="checkout-parent-phone"><strong>' . __('Parent\'s Contact Number') . ':</strong> ' . $parent_contact_number . '</p>';
    }

    if ( $parent_email_address ) {
        echo '<p class="checkout-parent-email"><strong>' . __('Parent\'s Email Address') . ':</strong> ' . $parent_email_address . '</p>';
    }
}


add_filter( 'woocommerce_checkout_fields', 'rwf_checkout_fields', 10 );
function rwf_checkout_fields( $fields ) {
    unset( $fields['billing']['billing_company'] );

    return $fields;
}

//function add information box range bulk purchase
add_action('woocommerce_before_add_to_cart_button', 'display_product_price_bulk_purchase');
function display_product_price_bulk_purchase() {
    global $product; 

    if ($product) {
        $price = $product->get_price();
        ?>

        <div class="box-range-price">
            <p>Price range: </p>
        	<ul>
        		<li>20 - 49 pieces - <?php echo wc_price($price) ?></li>
        		<li>50 - 99 pieces - <?php echo wc_price($price-1) ?></li>
        		<li>≥ 100 pieces - <?php echo wc_price($price-2) ?></li>
        	</ul>
        </div>
		<p style="margin-bottom: 20px">
				If you need printing or customisation, please click on "Get a Quote" button to contact us!
		</p>
    
        <?php
    }
}

//function create link enquiry when simple product no price
add_shortcode('enquiry_link', 'create_enquiry_link_for_no_price');

function create_enquiry_link_for_no_price() {
    global $product; 

    if ($product) {
        
        $price = $product->get_price();
        $description = $product->get_description();

        if (!$price) {
            echo '<div class="product-full-description">' . wpautop($description) . '</div>';
            echo '<a href="/contacts" class="link-enquiry-now" style="color:#fff; padding: 10px 30px;">Enquiry Now</a>';
            echo '<style>.section-description-product{display:none}</style>';
        } else {
           return;
        }
    }
}

// Change WooCommerce product gallery image size to full
add_filter('woocommerce_get_image_size_gallery_thumbnail', 'custom_woocommerce_gallery_thumbnail_size');
function custom_woocommerce_gallery_thumbnail_size($size) {
    return array(
        'width'  => 1024, 
        'height' => 1024, 
        'crop'   => 0,    
    );
}

//function add rule shipping
function custom_flat_rate_shipping( $rates, $package ) {
   $cart_items = WC()->cart->get_cart();
	$quantity_total = 0;
   foreach( $cart_items as $cart_item_key => $cart_item ) {
      $quantity = $cart_item['quantity'];
      $quantity_total = $quantity_total + $quantity;
      
   }
	if($quantity_total >= 100){
		unset( $rates['flat_rate:1']);     
    }else{
    	unset( $rates['flat_rate:2']);
   }
   return $rates;
}
add_filter( 'woocommerce_package_rates', 'custom_flat_rate_shipping', 10, 2 );

//function add rule minimum order quantity
add_filter( 'woocommerce_quantity_input_min', 'zippy_woocommerce_quantity_input_min_filter', 10, 2 );
function zippy_woocommerce_quantity_input_min_filter( $empty, $product ){
    $product_id = $product->get_id();
    
    $terms = wp_get_post_terms( $product_id, 'product_cat' );
   
    if ( !empty( $terms )) {
        $category_slug = $terms[0]->slug;

        if ( $category_slug == 'plain-t-shirts' ) { 
            ?>
    <script type="text/javascript">
		"use strict";
		$ = jQuery;

		jQuery(document).ready(function ($) {
		
  		$(
    	".quantity"
	  ).each(function () {
		$(this).on("click", ">span", function () {
			console.log($(this));
		  minimum_quantity_order($(this));
			console.log("check");
		});
	  });

	  function minimum_quantity_order(button) {
		$('.quantity input').on('change', function() {
			if ($(this).val() < 20) {
				alert('Minimum order quantity of products to 20 items');
				$(this).val(20);
			}
			});
			}
		});

    </script>
    <?php
            return 20; 
        }
    }
	
	return $empty;
}

// add_filter( 'woocommerce_add_to_cart_validation', 'zippy_woocommerce_add_to_cart_validation_filter', 10, 5 );
function zippy_woocommerce_add_to_cart_validation_filter( $passed_validation, $product_id, $quantity, $variation_id, $variation ) {

    if ( $quantity < 20 ) {
        wc_add_notice( 'Minimum order quantity of products to 20 items', 'error' );
        return false; 
    }

    return $passed_validation; 
}
