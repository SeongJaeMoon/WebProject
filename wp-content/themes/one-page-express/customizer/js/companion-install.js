jQuery(document).ready(function () {
    tb_show('One Page Express Companion', '#TB_inline?width=400&height=430&inlineId=one_page_express_homepage');
    jQuery('#TB_closeWindowButton').hide();
    jQuery('#TB_window').css({
        'z-index': '5000001',
        'height': '460px',
        'width': '630px'
    })
    jQuery('#TB_overlay').css({
        'z-index': '5000000'
    })
})