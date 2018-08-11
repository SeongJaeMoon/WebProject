<?php
function hook_vbank_actions() {
	add_action( 'init', 'register_awaiting_vbank_order_status' );
	add_filter( 'wc_order_statuses', 'add_awaiting_vbank_to_order_statuses' );

	add_action( 'woocommerce_email_before_order_table', 'vbank_email_message' );
}

function register_awaiting_vbank_order_status() {
    register_post_status( 'wc-awaiting-vbank', array(
        'label'                     => __( '가상계좌 입금대기 중', 'iamport-for-woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( '가상계좌 입금대기 중 <span class="count">(%s)</span>', '가상계좌 입금대기 중 <span class="count">(%s)</span>' )
    ) );
}

// 가상계좌 입금예정 상태 추가
function add_awaiting_vbank_to_order_statuses( $order_statuses ) {

    $new_order_statuses = array();

    // pending status다음에 추가
    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[ $key ] = $status;

        if ( 'wc-pending' === $key ) {
            $new_order_statuses['wc-awaiting-vbank'] = __( '가상계좌 입금대기 중', 'iamport-for-woocommerce' );
        }
    }

    return $new_order_statuses;
}

function vbank_email_message($order) {
	$paymethod = get_post_meta($order->get_id(), '_iamport_paymethod', true);
	
	if ( $paymethod == 'vbank' && $order->has_status(array('processing', 'completed')) ) {
		echo __( '(고객님께서 입금해주신 내역이 정상적으로 확인되었습니다.)', 'iamport-for-woocommerce' );
	}
}

hook_vbank_actions();

class WC_Gateway_Iamport_Vbank extends Base_Gateway_Iamport {

	public function __construct() {
		parent::__construct();

		$this->method_title = __( '아임포트(가상계좌)', 'iamport-for-woocommerce' );
		$this->method_description = __( '=> 아임포트 서비스를 이용해 결제모듈을 연동할 수 있습니다.<br>=> [아임포트] X PG사 제휴할인혜택을 받아보세요! <a href="http://www.iamport.kr/pg#promotion" target="_blank">PG 신규계약 프로모션 안내</a><br>=> 아임포트의 최신 공지사항도 놓치지 마세요! <a href="http://www.iamport.kr/notice" target="_blank">공지사항보기</a>', 'iamport-for-woocommerce' );
		$this->has_fields = true;
		$this->supports = array( 'products', 'refunds' );

		//settings
		$this->title = $this->settings['title'];
		$this->description = $this->settings['description'];
		$this->escrow = $this->settings['escrow'];
		$this->pg_provider = $this->settings['pg_provider'];
		$this->pg_id 	     = $this->settings['pg_id'];
		$this->biz_num = $this->settings['biz_num'];

		//actions
		//add_action( 'woocommerce_thankyou_'.$this->id, array( $this, 'iamport_order_detail' ) ); woocommerce_order_details_after_order_table 로 대체. 중복으로 나오고 있음
		add_filter( 'woocommerce_thankyou_order_received_text', array( $this, 'iamport_order_received_text'), 10, 2 ); //since 2.2
		add_filter( 'woocommerce_valid_order_statuses_for_payment_complete', array($this, 'iamport_valid_order_statuses_for_payment_complete'), 10, 1 ); //since 2.2
	}

	protected function get_gateway_id() {
		return 'iamport_vbank';
	}

	public function init_form_fields() {
		parent::init_form_fields();

		$allProducts = array(
			"all" => "[모든 상품]",
		);
		$allProducts += IamportHelper::get_all_products();

		$this->form_fields = array_merge( array(
			'enabled' => array(
				'title' => __( 'Enable/Disable', 'woocommerce' ),
				'type' => 'checkbox',
				'label' => __( '아임포트(가상계좌) 결제 사용', 'iamport-for-woocommerce' ),
				'default' => 'yes'
			),
			'title' => array(
				'title' => __( 'Title', 'woocommerce' ),
				'type' => 'text',
				'description' => __( '구매자에게 표시될 구매수단명', 'iamport-for-woocommerce' ),
				'default' => __( '가상계좌 결제', 'iamport-for-woocommerce' ),
				'desc_tip'      => true,
			),
			'description' => array(
				'title' => __( 'Customer Message', 'woocommerce' ),
				'type' => 'textarea',
				'description' => __( '구매자에게 결제수단에 대한 상세설명을 합니다.', 'iamport-for-woocommerce' ),
				'default' => __( '주문확정 버튼을 클릭하시면 가상계좌 주문개설 창이 나타나 결제를 진행하실 수 있습니다.', 'iamport-for-woocommerce' )
			),
			'escrow' => array(
				'title' => __( '가상계좌 에스크로', 'iamport-for-woocommerce' ),
				'type' => 'checkbox',
				'label' => __( '가상계좌 결제수단을 에스크로 방식으로 제공할까요?', 'iamport-for-woocommerce' ),
				'default' => 'no',
				'description' => __( '일반 가상계좌가 에스크로(구매자 안전결제)방식의 가상계좌로 대체됩니다.', 'iamport-for-woocommerce' )
			),
			'notice_url' => array(
				'title' => __( '가상계좌 입금통지설정', 'iamport-for-woocommerce' ),
				'description' => __( '아임포트 관리자 페이지 시스템설정 > PG연동 설정의 Notification URL에 위 값을 복사해 입력해주셔야합니다.', 'iamport-for-woocommerce' ),
				'custom_attributes' => array('readonly'=>'true'),
				'default' => add_query_arg( 'wc-api', 'WC_Gateway_Iamport_Vbank', site_url() )
			),
			'pg_provider' => array(
				'title' => __( 'PG사 설정', 'iamport-for-woocommerce' ),
				'type' => 'select',
				'default' => '',
				'description' => __( '2개 이상의 PG사를 이용 중이라면, 가상계좌를 서비스할 PG사를 선택해주세요. 선택된 PG사의 결제창이 호출됩니다.', 'iamport-for-woocommerce' ),
				'options' => array(
					'none' => '해당사항없음',
					'html5_inicis' => 'KG이니시스-웹표준결제',
					'kcp' => 'NHN KCP',
					'uplus' => 'LGU+',
					'nice' => '나이스정보통신',
					'jtnet' => 'JTNet',
					'danal_tpay' => '다날-가상계좌',
					'kicc' => 'KICC',
				)
			),
			'pg_id' => array(
				'title' => __( 'PG상점아이디', 'woocommerce' ),
				'type' => 'text',
				'description' => __( '동일한 PG사에서 여러 개의 상점아이디(MID)를 사용하는 경우 원하시는 PG상점아이디(MID)를 지정하여 결제할 수 있습니다.', 'iamport-for-woocommerce' ),
			),
			'pg_products' => array(
				'title'		=> __( 'PG설정 적용대상(상품)', 'iamport-for-woocommerce' ),
				'type'		=> 'multiselect',
				'default' => 'all',
				'description'		=> __( '위에서 설정한 [PG사 설정] 및 [PG상점아이디] 가 적용될 상품을 선택합니다. 선택된 상품에 포함되지 않는 경우 [PG사 설정] 및 [PG상점아이디] 는 적용되지 않습니다.' ),
				'options' => $allProducts,
			),
			'vbank_due' => array(
				'title' => __( '가상계좌입금기한 설정', 'iamport-for-woocommerce' ),
				'type' => 'select',
				'default' => '',
				'description' => __( '가상계좌입금기한을 강제로 설정하고싶을 때 사용합니다. 미설정시 결제창에서 구매자가 선택할 수 있습니다.', 'iamport-for-woocommerce' ),
				'options' => array(
					'none' => '설정하지않음',
					'hour1' => '1시간 후 까지',
					'hour2' => '2시간 후 까지',
					'hour3' => '3시간 후 까지',
					'hour4' => '4시간 후 까지',
					'hour5' => '5시간 후 까지',
					'hour6' => '6시간 후 까지',
					'hour7' => '7시간 후 까지',
					'hour8' => '8시간 후 까지',
					'hour9' => '9시간 후 까지',
					'hour10' => '10시간 후 까지',
					'hour11' => '11시간 후 까지',
					'hour12' => '12시간 후 까지',
					'day0' => '당일자정까지',
					'day1' => '1일 후 자정까지',
					'day2' => '2일 후 자정까지',
					'day3' => '3일 후 자정까지',
					'day4' => '4일 후 자정까지',
					'day5' => '5일 후 자정까지',
					'day6' => '6일 후 자정까지',
					'day7' => '7일 후 자정까지',
					'day8' => '8일 후 자정까지',
					'day9' => '9일 후 자정까지',
					'day10' => '10일 후 자정까지',
					'day11' => '11일 후 자정까지',
					'day12' => '12일 후 자정까지',
					'day13' => '13일 후 자정까지',
					'day14' => '14일 후 자정까지',
				)
			),
			'biz_num' => array(
				'title' => __( '사업자등록번호', 'iamport-for-woocommerce' ),
				'type' => 'text',
				'description' => __( '사업자등록번호10자리(다날Tpay이용자는 반드시 입력해주세요. 숫자만 입력해주세요)', 'iamport-for-woocommerce' )
			)
		), $this->form_fields);
	}

	public function iamport_payment_info( $order_id ) {
		$iamport_info = parent::iamport_payment_info( $order_id );
		$iamport_info['escrow'] = ($this->escrow == 'yes');
		$iamport_info['biz_num'] = $this->biz_num;
		if ( !empty($this->pg_provider) && $this->pg_provider != 'none' ) {
			$iamport_info['pg'] = $this->pg_provider;
			
			if ( !empty($this->pg_id) ) {
				$iamport_info['pg'] = sprintf("%s.%s", $this->pg_provider, $this->pg_id);
			}

			//조건에 해당되지 않으면 pg 파라메터 unset
			if ( !empty($this->settings['pg_products']) && !in_array("all", $this->settings['pg_products']) ) {
				//타겟이 특정되어있을 때에만 검사한다.
				$target = $this->settings['pg_products'];

				if ( IamportHelper::has_excluded_product($order_id, $target) )	unset($iamport_info['pg']);
			}
		}

		$vbank_due = $this->vbank_due_string();
		if ( $vbank_due )	$iamport_info['vbank_due'] = $vbank_due;

		//kcpProducts
		if ( $iamport_info['escrow'] && $iamport_info['pg'] === 'kcp' ) {
			$iamport_info['kcpProducts'] = $this->getKcpProducts( $order_id );
		}

		return $iamport_info;
	}

	public function iamport_order_detail( $order_id ) {
		global $woocommerce;

		$order = new WC_Order( $order_id );

		$paymethod = get_post_meta($order_id, '_iamport_paymethod', true);
		$receipt_url = get_post_meta($order_id, '_iamport_receipt_url', true);
		$vbank_name = get_post_meta($order_id, '_iamport_vbank_name', true);
		$vbank_num = get_post_meta($order_id, '_iamport_vbank_num', true);
		$vbank_date = get_post_meta($order_id, '_iamport_vbank_date', true);
		$tid = $order->get_transaction_id();

        ob_start();
		?>
		<h2><?=__( '결제 상세', 'iamport-for-woocommerce' )?></h2>
		<table class="shop_table order_details">
			<tbody>
				<tr>
					<th><?=__( '결제수단', 'iamport-for-woocommerce' )?></th>
					<td><?=__( '가상계좌', 'iamport-for-woocommerce' )?></td>
				</tr>
				<tr>
					<th><?=__( '가상계좌 입금은행', 'iamport-for-woocommerce' )?></th>
					<td><?=$vbank_name?></td>
				</tr>
				<?php if ( $order->has_status(array('processing', 'completed')) ) : //이미 결제 완료 됨 ?>
				<tr>
					<th><?=__( '가상계좌번호', 'iamport-for-woocommerce' )?></th>
					<td><?=sprintf( __( '입금완료( %s )', 'iamport-for-woocommerce' ), trim($vbank_num) )?></td>
				</tr>
				<tr>
					<th><?=__( '가상계좌 입금기한', 'iamport-for-woocommerce' )?></th>
					<td><?=__( '입금완료', 'iamport-for-woocommerce' )?></td>
				</tr>
				<tr>
					<th><?=__( '매출전표', 'iamport-for-woocommerce' )?></th>
					<td><a target="_blank" href="<?=$receipt_url?>"><?=sprintf( __( '영수증보기(%s)', 'iamport-for-woocommerce' ), $tid )?></a></td>
				</tr>
				<?php else : ?>
				<tr>
					<th><?=__( '가상계좌번호', 'iamport-for-woocommerce' )?></th>
					<td><?=sprintf( __( '%s 입금을 부탁드립니다.', 'iamport-for-woocommerce' ), trim($vbank_num) )?></td>
				</tr>
				<tr>
					<th><?__( '가상계좌 입금기한', 'iamport-for-woocommerce' )?></th>
					<td><?=date('Y-m-d H:i:s', $vbank_date+( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ))?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		<?php 
		ob_end_flush();
	}

	public function iamport_order_received_text($thank_you_your_order_has_been_received, $order) {
		$paymethod = get_post_meta($order->get_id(), '_iamport_paymethod', true);
		if ( $paymethod == 'vbank' ) {
			if ( $order->has_status(array('processing', 'completed')) ) {
				return $thank_you_your_order_has_been_received . '<br>' . __( '가상계좌 입금내역이 확인되었습니다.', 'iamport-for-woocommerce' );
			} else {
				return $thank_you_your_order_has_been_received . '<br>' . __( '아래의 가상계좌로 입금해주셔야 최종적으로 주문이 완료처리됩니다.', 'iamport-for-woocommerce' );
			}
		}

		return $thank_you_your_order_has_been_received;
	}

	public function iamport_valid_order_statuses_for_payment_complete($statuses) {
		$statuses[] = 'awaiting-vbank';

		return $statuses;
	}

	private function vbank_due_string() {
		$vbank_due = strval($this->settings['vbank_due']);

		if ( strpos($vbank_due, 'hour') === 0 ) { //시간 지정형
			$hour_after = intval( substr($vbank_due, 4) );

			return date('YmdHi', time() + (get_option( 'gmt_offset' )+$hour_after) * HOUR_IN_SECONDS );
		} else if ( strpos($vbank_due, 'day') === 0 ) { //일자 지정형
			$day_after = intval( substr($vbank_due, 3) );

			return date('Ymd', time() + (get_option( 'gmt_offset' )+$day_after*24) * HOUR_IN_SECONDS );
		}

		return null;
	}
	
}