<?php
class IamportSettingTab
{

	public function __construct() 
	{
		add_action( 'woocommerce_settings_tabs_iamport', array($this, 'settings') );
		add_action( 'woocommerce_update_options_iamport', array($this, 'save') );
		// add_action( 'woocommerce_sections_' . 'iamport', array($this, 'tab') );
	}

	public function label($settings_tabs)
	{
		$settings_tabs['iamport'] = __( '아임포트', 'iamport-for-woocommerce' );
		return $settings_tabs;
	}

	public function settings()
	{
		woocommerce_admin_fields( $this->getSettings() );
	}

	public function save()
	{
		woocommerce_update_options( $this->getSettings() );
	}

	private function getSettings()
	{
		$settings = array(
			array(
				'name'		=> __( '아임포트 공통 결제 설정', 'iamport-for-woocommerce' ),
				'type'		=> 'title',
				'desc'		=> '',
				'id'		=> 'wc_settings_tab_iamport_section_title'
			),
			array(
				'title'		=> __( '자동 완료됨 처리', 'iamport-for-woocommerce' ),
				'desc'    => __( '처리중 상태를 거치지 않고 완료됨으로 자동 변경하시겠습니까?<br>우커머스에서 "처리중"상태는 결제가 완료되었음을, "완료됨"상태는 상품발송이 완료되었음을 의미합니다. 아래의 경우 사용하시면 유용합니다.<br> ㄴ 온라인 강의와 같이 발송될 상품이 없어 결제가 되면 곧 서비스가 개시되어야 하는 경우<br> ㄴ 구매자가 직접 환불을 못하도록 막아야 하는 경우("처리중"상태에서는 구매자가 환불이 가능하므로 "완료됨"상태로 변경하여 환불을 방지)', 'iamport-for-woocommerce' ),
				'id'		=> 'woocommerce_iamport_auto_complete',
				'default'	=> 'no',
				'type'		=> 'checkbox'
			),
			array(
				'title'		=> __( '교환요청/환불요청 활성화', 'iamport-for-woocommerce' ),
				'desc'		=> __( '결제된 주문이 "완료됨" 상태일 때에도 구매자가 교환/환불 요청을 할 수 있도록 버튼을 생성합니다.' ),
				'id'		=> 'woocommerce_iamport_exchange_capable',
				'default'	=> 'yes',
				'type'		=> 'checkbox'
			),
		
			array(
				 'type' => 'sectionend',
				 'id' => 'wc_settings_tab_iamport_section_title'
			),
			array(
				'name'     => __( '아임포트 정기 결제 설정', 'iamport-for-woocommerce' ),
				'type'     => 'title',
				'desc'     => '',
				'id'       => 'wc_settings_tab_iamport_subscription_section_title'
			),
			array(
				'title'		=> __( '카드 유효성 테스트 금액', 'iamport-for-woocommerce' ),
				'desc'		=> __( '0보다 큰 숫자인 경우에만 테스트 결제를 수행합니다.<br>정기결제 카드정보 등록 시, 카드정보의 유효성 검사는 이뤄지지만 결제가 가능한 카드인지 판별하기 어려운 예외적인 경우가 있습니다.(ex. 분실정지된 카드, 한도초과 카드)<br>카드정보 확인과 동시에 테스트 결제를 진행해봄으로써 분실정지되거나 한도초과된 카드의 등록을 사전에 방지할 수 있습니다.<br>테스트결제는 결제 후 3~4초 후에 자동 취소됩니다.' ),
				'id'		=> 'woocommerce_iamport_subscription_checking_amount',
				'default'	=> '0',
				'type'		=> 'text'
			),
			array(
				 'type' => 'sectionend',
				 'id' => 'wc_settings_tab_iamport_subscription_section_title'
			),
		);

		return $settings;
	}
	
}