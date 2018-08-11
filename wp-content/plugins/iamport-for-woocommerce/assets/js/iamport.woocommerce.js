jQuery(function($) {
	var iamport_gateways = [
		'iamport_card',
		'iamport_samsung',
		'iamport_trans',
		'iamport_vbank',
		'iamport_phone',
		'iamport_kakao',
		'iamport_kpay',
		'iamport_payco',
		'iamport_eximbay',
		'iamport_subscription_ex',
		'iamport_naverpay_ext'
	];

	var iamport_checkout_types = (function() {
		var arr = [],
			len = iamport_gateways.length;
		for (var i = 0; i < len; i++) {
			arr.push( 'checkout_place_order_' + iamport_gateways[i] );
		};

		return arr;
	}());

	function versionCompare(a, b) {
		var va = a.split('.'),
			vb = b.split('.');

		for (var i = 0; i < 3; i++) {
			if ( parseInt(va[i]) > parseInt(vb[i]) ) {
				return 1;
			} else if ( parseInt(va[i]) < parseInt(vb[i]) ) {
				return -1;
			}
		}

		return 0;
	}

	function isSamsungPayRunnable() {
		var runnable = false;
		var isAndroid = navigator.userAgent.match(/Android/i);

		if(isAndroid){
			var mydata = JSON.parse(device);
			var i = 0;
			while (mydata[i]) {
				if(navigator.userAgent.indexOf(mydata[i])>0){
					runnable = true;
					break;
				}
				i++;
			}
		}
		return runnable;
	}

	function in_iamport_gateway(gateway) {
		for (var i = iamport_gateways.length - 1; i >= 0; i--) {
			if ( gateway === iamport_gateways[i] )	return true;
		};

		return false;
	}

	function handle_error($form, err) {
		// Reload page
		if ( err.reload === 'true' ) {
			window.location.reload();
			return;
		}

		// Remove old errors
		//error.messages가 plain text일 수도 있고, <ul class="woocommerce-error"></ul>일 수도 있어서 한 번 더 감싼다
		$( '.iamport-error-wrap' ).remove();

		// Add new errors
		$form.prepend( '<div class="iamport-error-wrap">' + err.messages + '</div>' );

		// Cancel processing
		$form.removeClass( 'processing' ).unblock();

		// Lose focus for all fields
		$form.find( '.input-text, select' ).blur();

		// Scroll to top
		$( 'html, body' ).animate({
			scrollTop: ( $form.offset().top - 100 )
		}, 1000 );

		// Trigger update in case we need a fresh nonce
		if ( err.refresh === 'true' )
			$( 'body' ).trigger( 'update_checkout' );

		$( 'body' ).trigger( 'checkout_error' );
	}

	function error_html(plain_message) {
		return '<ul class="woocommerce-error">\n\t\t\t<li>' + plain_message + '<\/li>\n\t<\/ul>\n';
	}

	// <form id="order_review" name="checkout"></form>인 테마가 존재할 수 있음.
	// 중복으로 event handler가 등록되지 않도록
	// iamport.woocommerce.rsa.js와는 달리 #order_review대신 name="checkout"에서 처리하는 것이 맞을 것 같다.(order_key가 없는 문제)
	$('form[name="checkout"]').on(iamport_checkout_types.join(' '), function() {
		//woocommerce의 checkout.js의 기본동작을 그대로..woocommerce 버전바뀔 때마다 확인 필요
		var $form = $(this),
			gateway_name = $form.find('input[name="payment_method"]:checked').val();

		var pay_method = 'card',
			prefix = 'iamport_';
		if ( gateway_name.indexOf(prefix) == 0 )	pay_method = gateway_name.substring(prefix.length);

		//카카오페이 처리
		if ( pay_method == 'kakao' )				pay_method = 'card';
		//삼성페이 처리
		/*
		if ( pay_method == 'samsung' && !isSamsungPayRunnable() ) {
			if ( !confirm('현재 삼성페이가 지원되지 않는 단말입니다. 일반 신용카드 결제를 진행하시겠습니까?') )	return false;

			pay_method = 'card'; //지원안되는 단말인데 결제시도하면 card로 시도
		}
		*/

		$form.addClass( 'processing' );
		var form_data = $form.data();

		if ( 1 !== form_data['blockUI.isBlocked'] ) {
			$form.block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
		}

		$.ajax({
			type: 	'POST',
			url: 	wc_checkout_params.checkout_url,
			data: 	$form.serialize(),
			dataType: 'json',
			dataFilter : function(data) {
				var regex_json = /{(.*)}/;
				var m = data.match(regex_json);
				if ( m )	return m[0];
				
				return data;
			},
			success: function( result ) {
				try {
					if ( result.result === 'success' ) {
						//iamport process
						var req_param = {
							pay_method : result.iamport.pay_method || pay_method,
						    escrow : result.iamport.escrow,
						    merchant_uid : result.iamport.merchant_uid,
						    name : result.iamport.name,
						    amount : parseInt(result.iamport.amount),
						    buyer_email : result.iamport.buyer_email,
						    buyer_name : result.iamport.buyer_name,
						    buyer_tel : result.iamport.buyer_tel,
						    buyer_addr : result.iamport.buyer_addr,
						    buyer_postcode : result.iamport.buyer_postcode,
						    vbank_due : result.iamport.vbank_due,
						    m_redirect_url : result.iamport.m_redirect_url,
						    currency : result.iamport.currency,
						    digital : result.iamport.digital || false,
						    custom_data : {woocommerce:result.order_id},
						    biz_num : result.iamport.biz_num,
						    niceMobileV2 : true
						};

						if ( result.iamport.pg )		     			req_param.pg = result.iamport.pg;
						if ( typeof result.iamport.vat == "number" )	req_param.vat = result.iamport.vat;
						if ( result.iamport.language )	     	req_param.language = result.iamport.language;
						if ( result.iamport.customer_uid )	 	req_param.customer_uid = result.iamport.customer_uid;
						if ( result.iamport.kcpProducts )			req_param.kcpProducts = result.iamport.kcpProducts;
						if ( gateway_name == "iamport_eximbay" && result.iamport.currency == "KRW" )	throw {reload: false, refresh: false, messages: "Eximbay는 KRW결제가 지원되지 않습니다. (Eximbay does not support KRW currency in payment)"};
						if ( result.iamport.naverV2 )         req_param.naverV2 = true;
						if ( result.iamport.naverProducts )   req_param.naverProducts = result.iamport.naverProducts;

						if ( versionCompare($.fn.jquery, "1.8.0") >= 0 ) {
							if ( typeof window.$ == 'undefined' ) window.$ = $;
							req_param.kakaoOpenApp = true; //iOS 카카오페이 바로 오픈
						}

						IMP.init(result.iamport.user_code);
						IMP.request_pay(req_param, function(rsp) {
							if ( rsp.success ) {
								window.location.href = result.iamport.m_redirect_url + "&imp_uid=" + rsp.imp_uid; //IamportPlugin.check_payment_response() 에서 필수
							} else {
								alert(rsp.error_msg);
								window.location.reload();
							}
						});
					} else if ( result.result === 'failure' ) {
						throw result;
					} else {
						throw result;
					}
				} catch( err ) {
					handle_error($form, err);
                }
            },
            error:  function( jqXHR, textStatus, errorThrown ) {
            	alert(errorThrown);
            	window.location.reload();
            }
        });

		return false; //기본 checkout 프로세스를 중단
	});


	$('form#order_review:not([name="checkout"])').on('submit', function(e) {
		var $form = $(this),
			gateway_name = $( '#order_review input[name=payment_method]:checked' ).val(),
			prefix = 'iamport_';

		if ( !in_iamport_gateway(gateway_name) )	return true; //다른 결제수단이 submit될 수 있도록

		e.preventDefault(); // iamport와 관련있는 것일 때만
		e.stopImmediatePropagation(); //theme에 따라서 다른 submit handler에서 submit을 시켜버리는 경우가 있음
		
		var pay_method = gateway_name.substring(prefix.length),
			order_key = $.url('?key');

		//카카오페이 처리
		if ( pay_method == 'kakao' )				pay_method = 'card';
		//삼성페이 처리
		/*
		if ( pay_method == 'samsung' && !isSamsungPayRunnable() ) {
			if ( !confirm('현재 삼성페이가 지원되지 않는 단말입니다. 일반 신용카드 결제를 진행하시겠습니까?') )	return false;

			pay_method = 'card'; //지원안되는 단말인데 결제시도하면 card로 시도
		}
		*/

		$.ajax({
			type: 	'GET',
			url: 	wc_checkout_params.ajax_url,
			data: 	{
				action: 'iamport_payment_info',
				pay_method: pay_method,
				order_key: order_key
			},
			dataType: 'json',
			dataFilter : function(data) {
				var regex_json = /{(.*)}/;
				var m = data.match(regex_json);
				if ( m )	return m[0];
				
				return data;
			},
			success: function( result ) {
				try {
					if ( result.result === 'success' ) {
						//iamport process
						var req_param = {
							pay_method : result.iamport.pay_method || pay_method,
						    escrow : result.iamport.escrow,
						    merchant_uid : result.iamport.merchant_uid,
						    name : result.iamport.name,
						    amount : parseInt(result.iamport.amount),
						    buyer_email : result.iamport.buyer_email,
						    buyer_name : result.iamport.buyer_name,
						    buyer_tel : result.iamport.buyer_tel || '01012341234',
						    buyer_addr : result.iamport.buyer_addr,
						    buyer_postcode : result.iamport.buyer_postcode,
						    vbank_due : result.iamport.vbank_due,
						    m_redirect_url : result.iamport.m_redirect_url,
						    currency : result.iamport.currency,
						    digital : result.iamport.digital || false,
						    custom_data : {woocommerce:result.order_id},
						    biz_num : result.iamport.biz_num,
						    niceMobileV2 : true
						};

						if ( result.iamport.pg )			req_param.pg = result.iamport.pg;
						if ( typeof result.iamport.vat == "number" )	req_param.vat = result.iamport.vat;
						if ( result.iamport.language )		req_param.language = result.iamport.language;
						if ( result.iamport.customer_uid )	req_param.customer_uid = result.iamport.customer_uid;
						if ( result.iamport.kcpProducts )			req_param.kcpProducts = result.iamport.kcpProducts;
						if ( gateway_name == "iamport_eximbay" && result.iamport.currency == "KRW" )	throw {reload: false, refresh: false, messages: "Eximbay는 KRW결제가 지원되지 않습니다. (Eximbay does not support KRW currency in payment)"};
						if ( result.iamport.naverV2 )         req_param.naverV2 = true;
						if ( result.iamport.naverProducts )   req_param.naverProducts = result.iamport.naverProducts;

						if ( versionCompare($.fn.jquery, "1.8.0") >= 0 ) {
							if ( typeof window.$ == 'undefined' ) window.$ = $;
							req_param.kakaoOpenApp = true; //iOS 카카오페이 바로 오픈
						}

						IMP.init(result.iamport.user_code);
						IMP.request_pay(req_param, function(rsp) {
							if ( rsp.success ) {
								window.location.href = result.iamport.m_redirect_url + "&imp_uid=" + rsp.imp_uid;
							} else {
								alert(rsp.error_msg);
								window.location.reload();
							}
						});
					} else if ( result.result === 'failure' ) {
						throw result;
					} else {
						throw result;
					}
				} catch( err ) {
					handle_error($form, err);
                }
            },
            error:  function( jqXHR, textStatus, errorThrown ) {
            	alert(errorThrown);
            	window.location.reload();
            }
        });

		return false;
	})
})