(function($) {
    $(function() {
		var jcarousel = $('.mb-board .jcarousel');
        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
			.swipe({
				swipeLeft: function(event, direction, distance, duration, fingerCount) {   
					jcarousel.jcarousel('scroll', '+=1');
				},
				swipeRight: function(event, direction, distance, duration, fingerCount) {
					jcarousel.jcarousel('scroll', '-=1');
				}
			})
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });

		$('.jcarousel-control-1')
			.on('click', function(e) {
                jcarousel.jcarousel('scroll', 0);
            })
		$('.jcarousel-control-2')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 1);
            })
		$('.jcarousel-control-3')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 2);
            })
		$('.jcarousel-control-4')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 3);
            })
		$('.jcarousel-control-5')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 4);
            })
		$('.jcarousel-control-6')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 5);
            })
		$('.jcarousel-control-7')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 6);
            })
		$('.jcarousel-control-8')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 7);
            })
		$('.jcarousel-control-9')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 8);
            })
		$('.jcarousel-control-10')
            .on('click', function(e) {
                jcarousel.jcarousel('scroll', 9);
            })

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselPagination({
                perPage: 1,
                item: function(page) {
                    return '<a href="#' + page + '">' + page + '</a>';
                }
            });
    });
})(jQuery);