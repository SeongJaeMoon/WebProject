<?php

if ( !class_exists('IamportHelper') ) {

  class IamportHelper {

    public static function get_customer_uid($order) {
      $prefix = get_option('_iamport_customer_prefix');
      if ( empty($prefix) ) {
        require_once( ABSPATH . 'wp-includes/class-phpass.php');
        $hasher = new PasswordHash( 8, false );
        $prefix = md5( $hasher->get_random_bytes( 32 ) );

        if ( !add_option( '_iamport_customer_prefix', $prefix ) ) throw new Exception( __( "정기결제 구매자정보 생성에 실패하였습니다.", 'iamport-for-woocommerce' ), 1);
      }

      $user_id = $order->get_user_id(); // wp_cron에서는 get_current_user_id()가 없다.
      if ( empty($user_id) )    throw new Exception( __( "정기결제기능은 로그인된 사용자만 사용하실 수 있습니다.", 'iamport-for-woocommerce' ), 1);

      return $prefix . 'c' . $user_id;
    }

    public static function has_excluded_product($order_id, $target) {
      $order = new WC_Order( $order_id );

      $items = $order->get_items();
      foreach ($items as $it) {
        $product = $it->get_product();

        // subscription in target && item is subscription || item in array => included
        $product_id = $product->get_id();
        if ( !empty($product->get_parent_id()) )  $product_id = $product->get_parent_id();

        if ( !((in_array("subscription", $target) && self::is_subscription_product($product)) ||
             in_array($product_id, $target)) )   return true;
      }

      return false;
    }

    public static function is_subscription_product($product) {
      return class_exists( 'WC_Subscriptions_Product' ) && WC_Subscriptions_Product::is_subscription( $product );
    }

    public static function get_all_products($search=null) {
      $condition = array(
        "return" => "ids", //성능이슈 : ids만 받아서 get_posts로 title 조회하는 것이 성능에 좋다.
        "limit"  => 50, //안전성을 위해 최대 50개까지만(성능이슈 : SQL이 빨라져도 500개 조회하면 메모리가 부족함)
        "status" => "publish",
        "type"   => array( 'simple', 'variable', 'subscription', 'subscription_variation', 'variable-subscription' ),
      );

      if ( is_array($search) )  $condition += $search;

      //성능이슈 : return : "object" 인경우 개수만큼 Query를 다시 날리는 것으로 확인 됨. wc_get_products에서는 id만 반환한 다음 title 은 get_posts로 구함
      $allProductIDs = wc_get_products($condition);

      $allProducts = get_posts(array(
        "include"   => $allProductIDs, 
        "post_type" => array('product_variation', 'product')
      ));

      $productNames = array();
      foreach ($allProducts as $p) {
        $productNames[ $p->ID ] = $p->post_title;
      }

      return $productNames;
    }

  }

}