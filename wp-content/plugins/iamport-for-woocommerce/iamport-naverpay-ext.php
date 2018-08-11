<?php
class WC_Gateway_Iamport_NaverPayExt extends Base_Gateway_Iamport {

  const GATEWAY_ID = "iamport_naverpay_ext";

  public function __construct() {
    parent::__construct();

    //settings
    $this->method_title = __( '아임포트(결제형-네이버페이)', 'iamport-for-woocommerce' );
    $this->method_description = __( '<b>네이버페이 정책상, 결제형-네이버페이는 사전 승인된 일부 가맹점에 한하여 제공되고 있으며 일반적으로는 "아임포트(네이버페이)"를 사용해주셔야 합니다. 결제형-네이버페이 가입기준에 대해서는 아임포트 고객센터(1670-5176)으로 문의 부탁드립니다.</b>', 'iamport-for-woocommerce' );
    $this->has_fields = true;
    $this->supports = array( 'products', 'refunds' );

    $this->title = $this->settings['title'];
    $this->description = $this->settings['description'];
  }

  protected function get_gateway_id() {
    return self::GATEWAY_ID;
  }

  public function init_form_fields() {
    parent::init_form_fields();

    $this->form_fields = array_merge( array(
      'enabled' => array(
        'title' => __( 'Enable/Disable', 'woocommerce' ),
        'type' => 'checkbox',
        'label' => __( '아임포트(결제형-네이버페이) 사용. (결제형-네이버페이 설정을 위해서는 네이버페이 가입승인 후 아임포트 고객센터로 연락부탁드립니다.)', 'iamport-for-woocommerce' ),
        'default' => 'no'
      ),
      'title' => array(
        'title' => __( 'Title', 'woocommerce' ),
        'type' => 'text',
        'description' => __( '구매자에게 표시될 구매수단명', 'iamport-for-woocommerce' ),
        'default' => __( '네이버페이(결제형)', 'iamport-for-woocommerce' ),
        'desc_tip'      => true,
      ),
      'description' => array(
        'title' => __( 'Customer Message', 'woocommerce' ),
        'type' => 'textarea',
        'description' => __( '구매자에게 결제수단에 대한 상세설명을 합니다.', 'iamport-for-woocommerce' ),
        'default' => __( '주문확정 버튼을 클릭하시면 네이버페이 결제창이 나타나 결제를 진행하실 수 있습니다.', 'iamport-for-woocommerce' )
      ),
    ), $this->form_fields);
  }

  public function iamport_order_detail( $order_id ) {
    ob_start();
    ?>
    <h2><?=__( '결제 상세', 'iamport-for-woocommerce' )?></h2>
    <table class="shop_table order_details">
      <tbody>
        <tr>
          <th><?=__( '결제수단', 'iamport-for-woocommerce' )?></th>
          <td><?=__( '네이버페이', 'iamport-for-woocommerce' )?></td>
        </tr>
      </tbody>
    </table>
    <?php 
    ob_end_flush();
  }

  public function iamport_payment_info( $order_id ) {
    $response = parent::iamport_payment_info($order_id);

    $order = new WC_Order( $order_id );
    //naverProducts 생성

    $naverProducts = array();
    $product_items = $order->get_items(); //array of WC_Order_Item_Product
    foreach ($product_items as $item) {
      $naverProducts[] = array(
        "categoryType" => "BOOK",
        "categoryId"   => "GENERAL",
        "uid"          => $this->get_product_uid($item),
        "name"         => $item->get_name(),
        "count"        => $item->get_quantity(),
      );
    }

    $response["pg"] = "naverpay";
    $response["naverV2"] = true;
    $response["naverProducts"] = $naverProducts;

    return $response;
  }

  protected function get_order_name($order) { // "XXX 외 1건" 같이 외 1건이 붙으면 안됨
    $product_items = $order->get_items(); //array of WC_Order_Item_Product

    foreach ($product_items as $item) {
      return $item->get_name();
    }

    return "#" . $order->get_order_number() . "번 주문";
  }

  private function get_product_uid($item) {
    $product_id   = $item->get_product_id();
    $variation_id = $item->get_variation_id();

    if ( $variation_id )  return sprintf("%s-%s", $product_id, $variation_id);

    return strval( $product_id );
  }

}