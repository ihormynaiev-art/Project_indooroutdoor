import swal from 'sweetalert2';
import AOS from 'aos';
import * as bootstrap from 'bootstrap'
import './backToTop.js';

window.Swal = swal;

(function ($) {
	"use strict";

	var $slimScrolls = $('.slimscroll');
	var $wrapper = $('.main-wrapper');

	// Sidebar

	if ($(window).width() <= 991) {
		var Sidemenu = function () {
			this.$menuItem = $('.main-nav a');
		};

		function init() {
			var $this = Sidemenu;
			$('.main-nav a').on('click', function (e) {
				if ($(this).parent().hasClass('has-submenu')) {
					e.preventDefault();
				}
				if (!$(this).hasClass('submenu')) {
					$('ul', $(this).parents('ul:first')).slideUp(350);
					$('a', $(this).parents('ul:first')).removeClass('submenu');
					$(this).addClass('submenu');
                    $(this).next('ul').slideDown(350);
				} else if ($(this).hasClass('submenu')) {
					$(this).removeClass('submenu');
					$(this).next('ul').slideUp(350);
                    $(this).next('div').find('a.submenu').removeClass('submenu');
				}
			});
		}

		// Sidebar Initiate
		init();
	}

	// Sticky Header
	$(window).scroll(function () {
		var sticky = $('.header'),
			scroll = $(window).scrollTop();
		if (scroll >= 50) sticky.addClass('fixed');
		else sticky.removeClass('fixed');
	});

	// Mobile menu sidebar overlay
	$('.header-fixed').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btn', function () {
		$('main-wrapper').toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').addClass('menu-opened');
		return false;
	});


	$(document).on('click', '.sidebar-overlay', function () {
		$('html').removeClass('menu-opened');
		$(this).removeClass('opened');
		$('main-wrapper').removeClass('slide-nav');
		$('#task_window').removeClass('opened');
	});

	$(document).on('click', '#menu_close', function () {
		$('html').removeClass('menu-opened');
		$('.sidebar-overlay').removeClass('opened');
		$('main-wrapper').removeClass('slide-nav');
	});

	// Select 2
	if ($('.select').length > 0) {
		$('.select').select2({
			minimumResultsForSearch: -1,
			width: '100%',
            placeholder: function() {
                return $(this).data('placeholder');
            },
		});
	}

	// Select Favourite
	$('.fav-icon').on('click', function () {
		$(this).toggleClass('selected');
		//$(this).children().toggleClass("feather-heart fa-solid fa-heart");
	});

	// Small Sidebar

	$(document).on('click', '#toggle_btn', function () {
		if ($('body').hasClass('mini-sidebar')) {
			$('body').removeClass('mini-sidebar');
			$('.subdrop + ul').slideDown();
		} else {
			$('body').addClass('mini-sidebar');
			$('.subdrop + ul').slideUp();
		}
		return false;
	});


	$(document).on('mouseover', function (e) {
		e.stopPropagation();
		if ($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
			var targ = $(e.target).closest('.sidebar').length;
			if (targ) {
				$('body').addClass('expand-menu');
				$('.subdrop + ul').slideDown();
			} else {
				$('body').removeClass('expand-menu');
				$('.subdrop + ul').slideUp();
			}
			return false;
		}
	});

	// fade in scroll

	if ($('.main-wrapper .aos').length > 0) {
		AOS.init({
			duration: 1200,
			once: true
		});
	}

	// Mobile menu sidebar overlay

	$('body').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btns', function () {
		$wrapper.toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').toggleClass('menu-opened');
		return false;
	});

	// Sidebar

	var Sidemenu = function () {
		this.$menuItem = $('#sidebar-menu a');
	};

	function initi() {
		var $this = Sidemenu;
		$('#sidebar-menu a').on('click', function (e) {
			if ($(this).parent().hasClass('submenu')) {
				e.preventDefault();
			}
			if (!$(this).hasClass('subdrop')) {
				$('ul', $(this).parents('ul:first')).slideUp(350);
				$('a', $(this).parents('ul:first')).removeClass('subdrop');
				$(this).next('ul').slideDown(350);
				$(this).addClass('subdrop');
			} else if ($(this).hasClass('subdrop')) {
				$(this).removeClass('subdrop');
				$(this).next('ul').slideUp(350);
			}
		});
		$('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger('click');
	}

	// Sidebar Initiate
	initi();


	// Sidebar Slimscroll

	if ($slimScrolls.length > 0) {
		$slimScrolls.slimScroll({
			height: 'auto',
			width: '100%',
			position: 'right',
			size: '7px',
			color: '#ccc',
			allowPageScroll: false,
			wheelStep: 10,
			touchScrollStep: 100
		});
		var wHeight = $(window).height() - 76;
		$slimScrolls.height(wHeight);
		$('.sidebar .slimScrollDiv').height(wHeight);
		$(window).resize(function () {
			var rHeight = $(window).height() - 76;
			$slimScrolls.height(rHeight);
			$('.sidebar .slimScrollDiv').height(rHeight);
		});
	}

	if ($('#data-table').length > 0) {
		$('#data-table').DataTable({
			"language": {
				search: ' ',
				searchPlaceholder: "Search...",
				info: "_START_ - _END_ of _TOTAL_",
				paginate: {
					next: 'Next <i class="fas fa-chevron-right ms-2"></i>',
					previous: '<i class="fas fa-chevron-left me-2"></i> Previous'

				}
			},
			"bFilter": false,
			initComplete: (settings, json) => {
				$('.dataTables_length').appendTo('#tablelength');
				$('.dataTables_paginate').appendTo('#tablepagination');
				$('.dataTables_info').appendTo('#tableinfo');
			},

		});
	}

	// catering slider
	if ($('.owl-carousel.catering-slider').length > 0) {
		$('.owl-carousel.catering-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// Catering Feature slider
	if ($('.owl-carousel.features-four-slider').length > 0) {
		$('.owl-carousel.features-four-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	//for slider
	$(window).on('load resize', function () {
		var window_width = $(window).outerWidth();
		var container_width = $('.container').outerWidth();
		var full_width = window_width - container_width
		var right_position_value = full_width / 2
		$('.slider-service').css('padding-left', right_position_value);

	});

	// Catering Feature slider
	if ($('.owl-carousel.client-four-slider').length > 0) {
		$('.owl-carousel.client-four-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	if ($('#company-slider').length > 0) {
		$('#company-slider').owlCarousel({
			items: 8,
			margin: 30,
			dots: false,
			nav: false,
			autoplay: true,
			smartSpeed: 2000,
			navText: [
				'<i class="fas fa-chevron-left"></i>',
				'<i class="fas fa-chevron-right"></i>'
			],
			loop: true,
			responsiveClass: true,
			responsive: {
				0: {
					items: 2
				},
				768: {
					items: 3
				},
				1170: {
					items: 6
				}
			}
		});
	}

	// Interesting & Useful Blogs
	if ($('.owl-carousel.useful-four-slider').length > 0) {
		$('.owl-carousel.useful-four-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	// Top Caterers Around the World slider
	if ($('.owl-carousel.world-four-slider').length > 0) {
		$('.owl-carousel.world-four-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.car-blog-slider').length > 0) {
		$('.owl-carousel.car-blog-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.top-providers-five').length > 0) {
		$('.owl-carousel.top-providers-five').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.provider-nine-slider').length > 0) {
		$('.owl-carousel.provider-nine-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}


	// Service slider
	if ($('.owl-carousel.categories-slider-seven').length > 0) {
		$('.owl-carousel.categories-slider-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}


	// Service slider
	if ($('.owl-carousel.top-projects-seven').length > 0) {
		$('.owl-carousel.top-projects-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav-seven-three',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.blogs-nine-slider').length > 0) {
		$('.owl-carousel.blogs-nine-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav-seven-three',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	// Quote-slider
	if ($('.owl-carousel.quote-slider').length > 0) {
		$('.owl-carousel.quote-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: false,
			smartSpeed: 2000,
			autoplay:true,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 5
				},
				1400: {
					items: 5
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.recent-projects-seven').length > 0) {
		$('.owl-carousel.recent-projects-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav-seven-two',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// JQuery counterUp

    if($('.counter').length > 0) {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
          });
        $('.counter').addClass('animated fadeInDownBig');
    }

	// Service slider
	if ($('.owl-carousel.customer-review-slider').length > 0) {
		$('.owl-carousel.customer-review-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.popular-service-seven').length > 0) {
		$('.owl-carousel.popular-service-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.service-slider').length > 0) {
		$('.owl-carousel.service-slider').owlCarousel({
			loop: false,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			navContainer: '.mynav',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.our-recent-blog').length > 0) {
		$('.owl-carousel.our-recent-blog').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.car-testimonials-five-slider').length > 0) {
		$('.owl-carousel.car-testimonials-five-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.testimonals-seven-slider').length > 0) {
		$('.owl-carousel.testimonals-seven-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			navContainer: '.mynav-test',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.testimonals-eight-slider').length > 0) {
		$('.owl-carousel.testimonals-eight-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.category-eight-slider').length > 0) {
		$('.owl-carousel.category-eight-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 6
				},
				1400: {
					items: 6
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.blog-eight-slider').length > 0) {
		$('.owl-carousel.blog-eight-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.professional-eight-slider').length > 0) {
		$('.owl-carousel.professional-eight-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.service-nine-slider').length > 0) {
		$('.owl-carousel.service-nine-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: true,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}
	// Service slider
	if ($('.owl-carousel.feature-service-five-slider').length > 0) {
		$('.owl-carousel.feature-service-five-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 3
				},
				1400: {
					items: 3
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.partners-slider').length > 0) {
		$('.owl-carousel.partners-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: false,
            autoplay:true,
            slideTransition: 'linear',
            autoplayHoverPause:true,
            autoplayTimeout: 4000,
            autoplaySpeed: 4000,
			responsive: {
				0: {
					items: 1
				},
				450: {
					items: 2
				},
				550: {
					items: 3
				},
				800: {
					items: 4
				},
				1200: {
					items: 5
				},
				1400: {
					items: 5
				}
			}
		})
	}

    if ($('.owl-carousel.edition-slider').length > 0) {
        $('.owl-carousel.edition-slider').owlCarousel({
            loop: true,
            margin: 24,
            nav: false,
            dots: false,
            autoplay:true,
            slideTransition: 'linear',
            autoplayHoverPause:true,
            autoplayTimeout: 6000,
            autoplaySpeed: 4000,
            responsive: {
                0: {
                    items: 1
                },
                450: {
                    items: 1
                },
                550: {
                    items: 1
                },
                800: {
                    items: 1
                },
                1200: {
                    items: 1
                },
                1400: {
                    items: 1
                }
            }
        })
    }

    if ($('.owl-carousel.categories-slider').length > 0) {
        $('.owl-carousel.categories-slider').owlCarousel({
            loop: true,
            margin: 24,
            nav: true,
            dots: false,
            autoplay:false,
            autoplayHoverPause:true,
            autoplayTimeout: 4000,
            autoplaySpeed: 4000,
            responsive: {
                0: {
                    items: 2
                },
                550: {
                    items: 3
                },
                850: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            }
        })
    }

    if ($('.owl-carousel.top-categories-slider').length > 0) {
        $('.owl-carousel.top-categories-slider').owlCarousel({
            loop: true,
            margin: 80,
            nav: false,
            dots: false,
            autoplay:true,
            autoplayHoverPause:true,
            autoplayTimeout: 3850,
            autoplaySpeed: 3850,
            responsive: {
                0: {
                    items: 1
                },
                550: {
                    items: 2,
                    margin: 50
                },
                800: {
                    items: 3
                }
            }
        })
    }

    if ($('.owl-carousel.testimonials-slider').length > 0) {
        $('.owl-carousel.testimonials-slider').owlCarousel({
            loop: false,
            margin: 24,
            nav: true,
            dots: false,
            autoplay: false,
            navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
            autoplayHoverPause:true,
            smartSpeed: 2000,
            responsive: {
                0: {
                    items: 1
                },

                550: {
                    items: 2
                },
                700: {
                    items: 2
                },
                1200: {
                    items: 4
                },
                1400: {
                    items: 4
                }
            }
        })
    }
	// Service slider
	if ($('.owl-carousel.partners-slider-seven').length > 0) {
		$('.owl-carousel.partners-slider-seven').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: false,
			smartSpeed: 2000,
			autoplay: true,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 5
				},
				1400: {
					items: 5
				}
			}
		})
	}

	// Service slider
	if ($('.owl-carousel.partners-five-slider').length > 0) {
		$('.owl-carousel.partners-five-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			dots: false,
			autoplay: true,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 5
				},
				1400: {
					items: 5
				}
			}
		})
	}

	// services-slider
	if ($('.owl-carousel.services-slider').length > 0) {
		$('.owl-carousel.services-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// latest-slider
	if ($('.owl-carousel.latest-slider').length > 0) {
		$('.owl-carousel.latest-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 3
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// services-slider
	if ($('.owl-carousel.stylists-slider').length > 0) {
		$('.owl-carousel.stylists-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='feather-arrow-left'></i>", "<i class='feather-arrow-right'></i>"],
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 1
				},
				700: {
					items: 2
				},
				1200: {
					items: 4
				},
				1400: {
					items: 4
				}
			}
		})
	}

	// Related slider
	if ($('.owl-carousel.related-slider').length > 0) {
		$('.owl-carousel.related-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			navContainer: '.mynav',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 2
				}
			}
		})
	}

	// Gallery slider
	if ($('.owl-carousel.gallery-slider').length > 0) {
		$('.owl-carousel.gallery-slider').owlCarousel({
			loop: false,
			margin: 24,
			nav: true,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			dots: false,
			navContainer: '.mynav3',
			responsive: {
				0: {
					items: 1
				},

				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}


	// Popular Service slider
	if ($('.owl-carousel.provider-gallery-slider').length > 0) {
		$('.owl-carousel.provider-gallery-slider').owlCarousel({
			loop: false,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 1500,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			navContainer: '.mynav1',
            autoHeight:true,
			responsive: {
				0: {
					items: 1
				},
				550: {
					items: 2
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	// Ad Gallery slider (single item)
	if ($('.owl-carousel.ad-gallery-slider').length > 0) {
		$('.owl-carousel.ad-gallery-slider').owlCarousel({
			loop: false,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 1500,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
            autoHeight:true,
			responsive: {
				0: {
					items: 1
				},
				550: {
					items: 1
				},
				700: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	}

    if ($('.owl-carousel.editing-slider').length > 0) {
        $('.owl-carousel.editing-slider').owlCarousel({
            margin: 0,
            nav: true,
            dots: false,
            smartSpeed: 2000,
            navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
            responsive: {
                0: {
                    items: 2
                },
                1000: {
                    items: 2,
                    slideBy: 2
                }
            }
        })
    }

	// Testimonial slider
	if ($('.owl-carousel.testimonial-slider').length > 0) {
		$('.owl-carousel.testimonial-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			smartSpeed: 2000,
			navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
			responsive: {
				0: {
					items: 1
				},
				700: {
					items: 2
				},
				1000: {
					items: 2
				}
			}
		})
	}

	// Testimonial slider
	if ($('.owl-carousel.client-slider').length > 0) {
		$('.owl-carousel.client-slider').owlCarousel({
			loop: true,
			margin: 24,
			nav: false,
			smartSpeed: 2000,
			responsive: {
				0: {
					items: 1
				},
				700: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		})
	}

	//Home slider
	if ($('.banner-slider').length > 0) {
		$('.banner-slider').slick({
			dots: false,
			autoplay: false,
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			responsive: [{
				breakpoint: 992,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 800,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 776,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 567,
				settings: {
					slidesToShow: 1
				}
			}]
		});
	}
	// Slick testimonial two

	if ($('.say-about.slider-for').length > 0) {
		$('.say-about.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.client-img.slider-nav'
		});
	}

	if ($('.client-img.slider-nav').length > 0) {
		$('.client-img.slider-nav').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: '.say-about.slider-for',
			dots: false,
			arrows: false,
			centerMode: true,
			focusOnSelect: true

		});
	}

	// Payment Method

	$('.payment-card').on('click', function () {
		$('.card-payment').each(function () {
			$(this).closest('.payment-card').removeClass('payment-bg');
		});
		$(this).closest('.payment-card').addClass('payment-bg');
		$(this).find(".card-payment").prop("checked", true);

		if ($(this).find(".credit-card-option").length > 0) {
			$(".payment-list").css('display', 'block');
		} else {
			$(".payment-list").css('display', 'none');
		}
	});

	// Datetimepicker Date

	if ($('.datetimepicker').length > 0) {
		$('.datetimepicker').datetimepicker({
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
	}

	$('body').append('<div class="sidebar-notification"></div>');
	$(document).on('click', '.notify-link', function() {
	 $('.sidebar-notification').toggleClass('opened');
	 return false;
	 });

	$(document).on('click', '.sidebar-notification', function() {
	 $('.sidebar-notification').removeClass('opened');
	 });


	//Custom Country Code Selector

	if ($('#phone').length > 0) {
		var input = document.querySelector("#phone");
		window.intlTelInput(input, {
			utilsScript: "assets/plugins/intltelinput/js/utils.js",
		});
	}

	if ($('#phone1').length > 0) {
		var input = document.querySelector("#phone1");
		window.intlTelInput(input, {
			utilsScript: "assets/plugins/intltelinput/js/utils.js",
		});
	}

	//Otp verfication

	$('.digit-group').find('input').each(function () {
		$(this).attr('maxlength', 1);
		$(this).on('keyup', function (e) {
			var parent = $($(this).parent());

			if (e.keyCode === 8 || e.keyCode === 37) {
				var prev = parent.find('input#' + $(this).data('previous'));

				if (prev.length) {
					$(prev).select();
				}
			} else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
				var next = parent.find('input#' + $(this).data('next'));

				if (next.length) {
					$(next).select();
				} else {
					if (parent.data('autosubmit')) {
						parent.submit();
					}
				}
			}
		});
	});

	$('.digit-group input').on('keyup', function () {
		var self = $(this);
		if (self.val() != '') {
			self.addClass('active');
		} else {
			self.removeClass('active');
		}
	});

	// Toggle Password

	if ($('#time-slot').length > 0) {
		$('#time-slot').on('click', function () {
			$(".timeslot-sec").show();
			$(".timepicker-sec").hide();
		});
		$('#time-picker').on('click', function () {
			$(".timepicker-sec").show();
			$(".timeslot-sec").hide();
		});
	}

	// Tooltip

	if($('[data-bs-toggle="tooltip"]').length > 0 ){
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
		})
	}
	if($('[data-bs-toggle="popover"]').length > 0 ){
		var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
		var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl)
	})
	}



	// Counters
	if ($('.counters').length > 0) {
		$('.counters').each(function () {
			var $this = $(this),
				countTo = $this.attr('data-count');
			$({ countNum: $this.text() }).animate({
				countNum: countTo
			},
				{
					duration: 3000,
					easing: 'linear',
					step: function () {
						$this.text(Math.floor(this.countNum));
					},
					complete: function () {
						$this.text(this.countNum);
					}

				});
		});
	}

	// CURSOR

	// function mim_tm_cursor() {
    //
	// 	var myCursor = jQuery('.mouse-cursor');
    //
	// 	if (myCursor.length) {
	// 		if ($("body")) {
    //
	// 			const e = document.querySelector(".cursor-inner"),
	// 				t = document.querySelector(".cursor-outer");
	// 			let n, i = 0,
	// 				o = !1;
	// 			window.onmousemove = function (s) {
	// 				o || (t.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)"), e.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)", n = s.clientY, i = s.clientX
	// 			}, $("body").on("mouseenter", "a, .cursor-pointer", function () {
	// 				e.classList.add("cursor-hover"), t.classList.add("cursor-hover")
	// 			}), $("body").on("mouseleave", "a, .cursor-pointer", function () {
	// 				$(this).is("a") && $(this).closest(".cursor-pointer").length || (e.classList.remove("cursor-hover"), t.classList.remove("cursor-hover"))
	// 			}), e.style.visibility = "visible", t.style.visibility = "visible"
	// 		}
	// 	}
	// };
    //
    // if ($(window).width() > 991) {
    //     mim_tm_cursor()
    // }

	// Create Service Wizard

	$(document).ready(function () {
		/*---------------------------------------------------------*/
		$(".service-inform-fieldset .next_btn").on('click', function () { // Function Runs On NEXT Button Click
			$(this).closest('fieldset').next().fadeIn('slow');
			$(this).closest('fieldset').css({
				'display': 'none'
			});
			// Adding Class Active To Show Steps Forward;
			$('#progressbar .active').removeClass('active').addClass('activated').next().addClass('active');


		});
		$(".service-inform-fieldset .prev_btn").on('click', function () { // Function Runs On NEXT Button Click
			$(this).closest('fieldset').prev().fadeIn('slow');
			$(this).closest('fieldset').css({
				'display': 'none'
			});
			// Adding Class Active To Show Steps Forward;
			$('#progressbar .active').removeClass('active').prev().removeClass('activated').addClass('active');


		});
	});

	// Booking Wizard Popup

	$(document).ready(function () {
		/*---------------------------------------------------------*/
		$(".next_btnn").on('click', function () { // Function Runs On NEXT Button Click
			$(this).closest('.hide-show').next().fadeIn('slow');
			$(this).closest('.hide-show').css({
				'display': 'none'
			});

		});
		$(".prev_btnn").on('click', function () { // Function Runs On NEXT Button Click
			$(this).closest('.hide-show').prev().fadeIn('slow');
			$(this).closest('.hide-show').css({
				'display': 'none'
			});

		});
	});

    const passInput = document.querySelector('.pass-input')
    const togglePass = document.querySelector('.toggle-password')

    if (togglePass) {
        togglePass.addEventListener('click', function () {
            $(this).toggleClass("feather-eye");

            const currentType = passInput.getAttribute('type')

            passInput.setAttribute('type', currentType === 'password' ? 'text' : 'password')
        })
    }

    const confPassInput = document.querySelector('.confirm-pass-input')
    const toggleConfPass = document.querySelector('.toggle-confirm-password')

    if (toggleConfPass) {
        toggleConfPass.addEventListener('click', function() {
            $(this).toggleClass("feather-eye");

            const currentType = confPassInput.getAttribute('type')

            confPassInput.setAttribute('type',currentType === 'password' ? 'text' : 'password')
        })
    }

    const newPassInput = document.querySelector('.pass-input-new')
    const toggleNewPass = document.querySelector('.toggle-password-new')

    if (toggleNewPass) {
        toggleNewPass.addEventListener('click', function () {
            $(this).toggleClass("feather-eye");

            const currentType = newPassInput.getAttribute('type')

            newPassInput.setAttribute('type', currentType === 'password' ? 'text' : 'password')
        })
    }

    const curPassInput = document.querySelector('.pass-input-current')
    const toggleCurPass = document.querySelector('.toggle-password-current')
    if (toggleCurPass) {
        toggleCurPass.addEventListener('click', function () {
            $(this).toggleClass("feather-eye");

            const currentType = curPassInput.getAttribute('type')

            curPassInput.setAttribute('type', currentType === 'password' ? 'text' : 'password')
        })
    }

	$('.card-payments').on('click', function () {
		$('.card-payments').removeClass('active');
		$(this).addClass('active');
	});

	// Reply Comment

	$('.reply-box').on('click', function () {
		$(this).closest('.review-box').find('.reply-com').toggle();
	});

	$(".top-close").on('click', function () {
		$(this).closest('.top-bar').slideUp(500);
		return false;
	});

	// Ck Editor

	if ($('.ck-editor').length > 0) {
		ClassicEditor
			.create(document.querySelector('.ck-editor'), {
				toolbar: {
					items: [
						'heading', '|',
						'fontfamily', 'fontsize', '|',
						'alignment', '|',
						'fontColor', 'fontBackgroundColor', '|',
						'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
						'link', '|',
						'outdent', 'indent', '|',
						'bulletedList', 'numberedList', 'todoList', '|',
						'code', 'codeBlock', '|',
						'insertTable', '|',
						'uploadImage', 'blockQuote', '|',
						'undo', 'redo'
					],
					shouldNotGroupWhenFull: true
				}
			})
			.then(editor => {
				window.editor = editor;
			})
			.catch(err => {
				console.error(err.stack);
			});
	}

	// Datetimepicker time

	if ($('.timepicker').length > 0) {
		$('.timepicker').datetimepicker({
			format: 'HH:mm A',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
	}

	// Add Service Information

	$(".addservice-info").on('click', '.trash', function () {
		$(this).closest('.service-cont').remove();
		return false;
	});

	$(".add-extra").on('click', function () {

		var servicecontent = '<div class="row service-cont">' +
			'<div class="col-md-4">' +
			'<div class="form-group">' +
			'<label class="col-form-label">Additional Service</label>' +
			'<input type="text" class="form-control" placeholder="Enter Service Item">' +
			'</div>' +
			'</div>' +
			'<div class="col-md-4">' +
			'<div class="form-group">' +
			'<label class="col-form-label">Price</label>' +
			'<input type="text" class="form-control" placeholder="Enter Price">' +
			'</div>' +
			'</div>' +
			'<div class="col-md-4">' +
			'<div class="d-flex align-items-center">' +
			'<div class="form-group w-100">' +
			'<label class="col-form-label">Duration</label>' +
			'<input type="text" class="form-control" placeholder="Enter Service Duration">' +
			'</div>' +
			'<div class="form-group">' +
			'<label class="col-form-label">&nbsp;</label>' +
			'<a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';

		$(".addservice-info").append(servicecontent);
		return false;
	});

	// Add More Cards
	$(".add-more-cards").on('click', function () {
		var debitcards = '<div class="payment-card save-cards">' +
		'<div class="payment-head">' +
			'<div class="payment-title">' +
			'<label class="custom_radio">' +
			'<input type="radio" name="payment"  class="card-payment" checked>' +
			'<span class="checkmark"></span>' +
			'</label>' +
			'<img src="assets/img/icons/saved-card-icon.svg" alt="image">	' +
			'<h6>Mastercard</h6>' +
			'</div>' +
			'<div class="card-number">' +
			'<span> ********* 1234</span>' +
			'</div>' +
			'</div>' +
			'</div>' ;
			$(".card-pay-saved").append(debitcards);
			return false;
	});
	// Add Hours

	// Reschedule Open Popup

	$(document).ready(function() {
		$('#reschedule-book-modal').modal('show');
	});

	$(".hours-info").on('click', '.trash', function () {
		$(this).closest('.hours-cont').remove();
		return false;
	});

	$(".add-hours").on('click', function () {

		var hourscontent = '<div class="row hours-cont">' +
			'<div class="col-md-4">' +
			'<div class="form-group">' +
			'<label class="col-form-label">From</label>' +
			'<div class="form-icon">' +
			'<input type="text" class="form-control timepicker" placeholder="Select Time">' +
			'<span class="cus-icon"><i class="feather-clock"></i></span>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="col-md-4">' +
			'<div class="form-group">' +
			'<label class="col-form-label">To</label>' +
			'<div class="form-icon">' +
			'<input type="text" class="form-control timepicker" placeholder="Select Time">' +
			'<span class="cus-icon"><i class="feather-clock"></i></span>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="col-md-4">' +
			'<div class="d-flex">' +
			'<div class="form-group w-100">' +
			'<label class="col-form-label">Slots</label>' +
			'<input type="text" class="form-control" placeholder="Enter Slot">' +
			'</div>' +
			'<div class="form-group">' +
			'<label class="col-form-label">&nbsp;</label>' +
			'<a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';

		$(this).parent().find(".hours-info").append(hourscontent);
		$('.timepicker').datetimepicker({
			format: 'HH:mm A',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
		return false;
	});

	// Add Timepicker Hours

	$(".hrs-info").on('click', '.trash', function () {
		$(this).closest('.hrs-cont').remove();
		return false;
	});

	$(".add-hrs").on('click', function () {

		var hrscontent = '<div class="row hrs-cont">' +
			'<div class="col-md-6">' +
			'<div class="form-group form-info">' +
			'<label class="col-form-label">From</label>' +
			'<div class="input-group input-icon">' +
			'<input type="text" class="form-control timepicker"  placeholder="Select Time">' +
			'<span class="input-group-addon">' +
			'<i class="feather-clock"></i>' +
			'</span>' +
			'</div>' +
			'</div>' +
			'</div> ' +
			'<div class="col-md-6">' +
			'<div class="d-flex">' +
			'<div class="form-group form-info">' +
			'<label class="col-form-label">To</label>' +
			'<div class="input-group input-icon">' +
			'<input type="text" class="form-control timepicker"  placeholder="Select Time">' +
			'<span class="input-group-addon">' +
			'<i class="feather-clock"></i>' +
			'</span>' +
			'</div>' +
			'<div class="form-group">' +
			'<label class="col-form-label">&nbsp;</label>' +
			'<a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';
		'</div>';

		$(this).parent().find(".hrs-info").append(hrscontent);
		$('.timepicker').datetimepicker({
			format: 'HH:mm A',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
		return false;
	});

	// Add Timepicker Hours

	$(".day-info").on('click', '.trash', function () {
		$(this).closest('.day-cont').remove();
		return false;
	});

	$(".add-day").on('click', function () {

		var daycontent = '<div class="row day-cont">' +
			'<div class="col-md-6">' +
			'<div class="form-group">' +
			'<label class="col-form-label">From</label>' +
			'<div class="form-icon">' +
			'<input type="text" class="form-control timepicker" placeholder="Select Time">' +
			'<span class="cus-icon"><i class="feather-clock"></i></span>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="col-md-6">' +
			'<div class="d-flex">' +
			'<div class="form-group w-100">' +
			'<label class="col-form-label">To</label>' +
			'<div class="form-icon">' +
			'<input type="text" class="form-control timepicker" placeholder="Select Time">' +
			'<span class="cus-icon"><i class="feather-clock"></i></span>' +
			'</div>' +
			'</div>' +
			'<div class="form-group">' +
			'<label class="col-form-label">&nbsp;</label>' +
			'<a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';

		$(this).parent().parent().find(".day-info").append(daycontent);
		$('.timepicker').datetimepicker({
			format: 'HH:mm A',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
		return false;
	});

	// Timer countdown

	// Timer countdown

	if ($('.countdown-container').length > 0) {
		const daysEl = document.getElementById("days");
		const hoursEl = document.getElementById("hours");
		const minsEl = document.getElementById("mins");

		const newYears = "1 Jan 2023";

		function countdown() {
			const newYearsDate = new Date(newYears);
			const currentDate = new Date();

			const totalSeconds = (newYearsDate - currentDate) / 1000;

			const days = Math.floor(totalSeconds / 3600 / 24);
			const hours = Math.floor(totalSeconds / 3600) % 24;
			const mins = Math.floor(totalSeconds / 60) % 60;

			daysEl.innerHTML = days;
			hoursEl.innerHTML = formatTime(hours);
			minsEl.innerHTML = formatTime(mins);
		}

		function formatTime(time) {
			return time < 10 ? '0${time}' : time;
		}

		// initial call
		countdown();

		setInterval(countdown, 1000);
	}

    let heightStyle = '';
    let buttonHtml = '';
    $('.filter-more-view').on('click', function (el) {
        var viewMore = $(el.target).closest('.filter-more-view');
        if (!$(viewMore).hasClass('filter-opened')) {
            heightStyle = 'unset';
            buttonHtml = "Show less <i class='feather-arrow-up-circle ms-1'>";
        } else {
            heightStyle = '185px';
            buttonHtml = "Show more <i class='feather-arrow-down-circle ms-1'></i>";
        }

        $(viewMore)
            .toggleClass('filter-opened')
            .closest('.filter-content')
            .find('.filter-fill-more')
            .css('max-height', heightStyle);

        $(viewMore).html(buttonHtml);
    });


	// Calendar

	if ($('#calendar').length > 0) {
		document.addEventListener('DOMContentLoaded', function () {
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				themeSystem: 'bootstrap5',

				headerToolbar: {
					left: 'title, prev,today next',
					//center: '',
					right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
				},
				initialDate: '2023-11-12',
				navLinks: true, // can click day/week names to navigate views
				// businessHours: true, // display business hours
				editable: true,
				selectable: true,
				events: [
					{
						title: 'Leave',
						start: '2023-11-16',
						end: '2023-11-16',
						color: '#E8E8E8',
						textColor: '#585757'
					},
					{
						title: 'Leave',
						start: '2023-11-03',
						end: '2023-11-03',
						color: '#E8E8E8',
						textColor: '#585757'
					},
					{
						title: 'Weekly Holiday',
						start: '2023-11-06',
						end: '2023-11-06',
						color: '#ff3b3b1a',
						textColor: '#E92C2C'
					},
					{
						title: 'Weekly Holiday',
						start: '2023-11-13',
						end: '2023-11-13',
						color: '#ff3b3b1a',
						textColor: '#E92C2C'
					},
					{
						title: 'Weekly Holiday',
						start: '2023-11-20',
						end: '2023-11-20',
						color: '#ff3b3b1a',
						textColor: '#E92C2C'
					},
					{
						title: 'Weekly Holiday',
						start: '2023-11-27',
						end: '2023-11-27',
						color: '#ff3b3b1a',
						textColor: '#E92C2C'
					},
				]
			});

			calendar.render();
		});
	}

	// Calendar Booking

	if ($('#calendar-book').length > 0) {
		document.addEventListener('DOMContentLoaded', function () {
			var calendarEl = document.getElementById('calendar-book');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				themeSystem: 'bootstrap5',

				headerToolbar: {
					left: 'title, prev,today next',
					//center: '',
					right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
				},
				initialDate: '2023-11-12',
				navLinks: true, // can click day/week names to navigate views
				// businessHours: true, // display business hours
				editable: true,
				selectable: true,
				events: [
					{
						title: '12:30am Laptop serv...',
						start: '2023-11-02',
						end: '2023-11-02',
						color: '#4c40ed1a',
						textColor: '#4C40ED',
						"className": "popup-toggle",
					},
					{
						title: '10:00am House Clean..',
						start: '2023-11-04',
						end: '2023-11-04',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
					{
						title: '11:00am Washing ...',
						start: '2023-11-05',
						end: '2023-11-05',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
					{
						title: '02:00pm Toughened...',
						start: '2023-11-10',
						end: '2023-11-10',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
					{
						title: '05:00pm Interior ...',
						start: '2023-11-16',
						end: '2023-11-16',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
					{
						title: '01:00pm Building....',
						start: '2023-11-18',
						end: '2023-11-18',
						color: '#4c40ed1a',
						textColor: '#4C40ED'
					},
				],
				eventClick: function (event, calEvent, jsEvent, view) {
					$(".fc-event-title").on("click", function () {
						$('.toggle-sidebar').addClass('sidebar-popup');
					});
					$(".sidebar-close").on("click", function () {
						$('.toggle-sidebar').removeClass('sidebar-popup');
					});
				}
			});

			calendar.render();
		});
	}

	// Checkbox Select

	$('.select-set').on("click", function () {
		$(this).parent().find('#dropboxes').fadeToggle();
		$(this).parent().parent().siblings().find('#dropboxes').fadeOut();
	});

	// Maximize

	if ($('.win-maximize').length > 0) {
		$('.win-maximize').on('click', function (e) {
			if (!document.fullscreenElement) {
				document.documentElement.requestFullscreen();
			} else {
				if (document.exitFullscreen) {
					document.exitFullscreen();
				}
			}
		})
	}

	// Chat

	var chatAppTarget = $('.chat-window');
	(function () {
		if ($(window).width() > 991)
			chatAppTarget.removeClass('chat-slide');

		$(document).on("click", ".chat-window .chat-users-list a.media", function () {
			if ($(window).width() <= 991) {
				chatAppTarget.addClass('chat-slide');
			}
			return false;
		});
		$(document).on("click", "#back_user_list", function () {
			if ($(window).width() <= 991) {
				chatAppTarget.removeClass('chat-slide');
			}
			return false;
		});
	})();

	if ($('#datetimepickershow').length > 0) {
		$('#datetimepickershow').datetimepicker({

			inline: true,
			sideBySide: true,
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}

		});
	}

	// Chat sidebar overlay

	if ($(window).width() <= 1199) {
		if ($('#task_chat').length > 0) {
			$(document).on('click', '#task_chat', function () {
				$('.sidebar-overlay').toggleClass('opened');
				$('#task_window').addClass('opened');
				return false;
			});
		}
	}

	if ($(window).width() > 767) {
		if ($('.theiaStickySidebar').length > 0) {
			$('.theiaStickySidebar').theiaStickySidebar({
				// Settings
				additionalMarginTop: 125
			});
		}
	}

	// Wizard

	$(document).ready(function () {
		let progressVal = 0;
		let businessType = 0;

		$(".next_btns").on('click', function () {
			$(this).parent().parent().parent().next().fadeIn('slow');
			$(this).parent().parent().parent().css({
				'display': 'none'
			});
			progressVal = progressVal + 1;
			$('.progress-active').removeClass('progress-active').addClass('progress-activated').next().addClass('progress-active');
		});
		$(".prev_btns").on('click', function () {
			$(this).parent().parent().parent().prev().fadeIn('slow');
			$(this).parent().parent().parent().css({
				'display': 'none'
			});
			progressVal = progressVal - 1;
			$('.progress-active').removeClass('progress-active').prev().removeClass('progress-activated').addClass('progress-active');
		});
  });


  //Chat Resize

	$("#back_user_lists").on("click", function () {
		$('.chat-window-long').toggleClass('window-full-width');
	});

	let verifie = document.getElementById("phone-veri");
	function verifiePhone(){
		verifie.classList.add("verified-phone");
	}

	$(".chat-profile-open").on("click", function () {
		$('.chat-window-long').toggleClass('window-full-width');
	});

	$(".add-more-card").on("click", function () {
		$('.add-more-card-details').addClass('show-card-details');
	});

	// Otp Verfication  
	 $('.digit-group').find('input').each(function () {
		$(this).attr('maxlength', 1);
		$(this).on('keyup', function (e) {
			var parent = $($(this).parent());
			if (e.keyCode === 8 || e.keyCode === 37) {
				var prev = parent.find('input#' + $(this).data('previous'));
				if (prev.length) {   $(prev).select();
				}
			}
			else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
				var next = parent.find('input#' + $(this).data('next'));
				if (next.length) {
					$(next).select();
				} else {
					if (parent.data('autosubmit')) {
						parent.submit();
					}
				}
			}
		});
	});
	$('.digit-group input').on('keyup', function () {
		var self = $(this);
		if (self.val() != '') {
			self.addClass('active');
		} else {
			self.removeClass('active');
		}
	});

	// Rating Star Review

	const stars = document.querySelectorAll('.rating-select i');
	const starsNone = document.querySelector('.form-info');

	// ---- ---- Stars ---- ---- //
	stars.forEach((star, index1) => {
	star.addEventListener('click', () => {
		stars.forEach((star, index2) => {
		// ---- ---- Active Star ---- ---- //
		index1 >= index2
			? star.classList.add('active')
			: star.classList.remove('active');
		});
	});
	});

    var isAdvancedUpload = function() {
        var div = document.createElement('div');
        return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }();

    let draggableFileArea = document.querySelector(".drag-file-area");
    let fileInput = document.querySelector("#file-input");
    var newFileIndex = 0;

    if (fileInput) {
        fileInput.addEventListener("change", e => {
            addFilesInfo(fileInput.files)
        });

    }

    if(isAdvancedUpload && draggableFileArea) {
        ["drag", "dragstart", "dragend", "dragover", "dragenter", "dragleave", "drop"].forEach( evt =>
            draggableFileArea.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
            })
        );

        ["dragover", "dragenter"].forEach( evt => {
            draggableFileArea.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        draggableFileArea.addEventListener("drop", e => {
            let files = e.dataTransfer.files;
            fileInput.files = files;
            addFilesInfo(fileInput.files)
        });
    }
    let uploadedFiles = [];

    $('input[type="file"]').change(function(e) {
        let newFiles = e.target.files;
        uploadedFiles.push(...newFiles);

        let dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        this.files = dataTransfer.files;
    });
    function addFilesInfo(files){
        $('.file-block').remove()
        $.each(files, function(index, file) {
            index = newFileIndex++
            var html  =   `
                <div class="file-block">
                    <div class="file-info justify-content-around">
                        <span class="material-icons-outlined file-icon"><i class="fa fa-file-text"></i></span>
                        <span class="file-name">` + file.name.slice(0,15) + `</span>
                    |   <span class="file-size">` + (file.size/1024).toFixed(1) + " KB" + `</span>
                        <span data-name="${file.name}" class="material-icons remove-file-icon"><i class="fa fa-remove"></i></span>
                    </div>
                </div>
                `
            $(".form-uploads-path").append(html);
            let reader = new FileReader();

            reader.onload = (e) => {
                let html = '';
                if (file.type.startsWith('video/')) {
                    html = `
                                <li>
                                    <div class="img-preview">
                                        <video src="${e.target.result}" controls></video>
                                        <a href="javascript:void(0);" data-id="new-${index}" data-name="${file.name}" class="remove-gallery">
                                            <i class="feather-trash-2"></i>
                                        </a>
                                    </div>
                                </li>
                            `;
                } else if (file.type.startsWith('image/')) {
                    html = `
                           <li>
                                <div class="img-preview">
                                    <img src="${e.target.result}" alt="Service Image">
                                    <a href="javascript:void(0);" data-id="new-${index}" data-name="${file.name}" class="remove-gallery"><i class="feather-trash-2"></i></a>
                                </div>
                            </li>
                            `
                }
                $(".gallery-selected-img").append(html);
            }

            reader.readAsDataURL(file);
        })
    }

    $(".row, div").on("click", '.remove-gallery, .remove-file-icon', function (){
        const fileArray = Array.from(fileInput.files);
        const fileNameToRemove = $(this).data('name');
        const newFileArray = fileArray.reduce((acc, file) => {
            if (file.name.toLowerCase() !== fileNameToRemove.toLowerCase()) {
                acc.push(file);
            }
            return acc;
        }, []);
        const dataTransfer = new DataTransfer();

        uploadedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        fileInput.files = dataTransfer.files
        $(this).parent().parent().remove()
    })

    $(".upload-file").on("click", function (){
        $('.text-danger').html('');
        let url = '/provider/' + $('#user-id').val() + '/fileUpload'
        var files = $('#file-input').prop('files');
        var fileData = files[files.length - 1];
        var fileName = fileData.name;
        var documentType = $('.file-block[data-file-name="' + fileName + '"]').find('input[type="radio"]:checked').val();
        var formData = new FormData();
        formData.append('file', fileData);
        formData.append('name', $('#name').val());
        formData.append('document_type', documentType);
        formData.append('_method', 'PATCH');
        $.ajax({
            type: 'POST',
            url: url,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': $('#token').val() },
            data: formData,
            success: function(response) {
                let html = `<div class="document-upload-file row">
                                        <div class="col-12">
                                             <a target="_blank" href="${response.url}">
                                                <img src="${filePdfIconUrl}" class="document-icon img-fluid"
                                                    alt="Pdf">
                                                ${response.name}
                                            </a>
                                        </div>
                                        <div class="col-12 document-type-selection mt-2 d-flex justify-content-between">
                                            <p class="mb-2">Document type:</p>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input document-type-radio" type="radio"
                                                       name="document_type_${response.id}"
                                                       id="certificate-type-${response.id}"
                                                       value="certificate"
                                                       data-file-id="${response.id}"
                                                       ${response.type === 'certificate' ? 'checked' : ''}>
                                                <label class="form-check-label" for="certificate-type-${response.id}">
                                                    Certificate
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input document-type-radio" type="radio"
                                                       name="document_type_${response.id}"
                                                       id="insurance-type-${response.id}"
                                                       value="insurance"
                                                       data-file-id="${response.id}"
                                                       ${response.type === 'insurance' ? 'checked' : ''}>
                                                <label class="form-check-label" for="insurance-type-${response.id}">
                                                    Insurance
                                                </label>
                                            </div>
                                        </div>
                                    </div>`
                $('.file-uploaded-mail').after(html)

                $('#file-input').val('')
                $('#name').val('')
                $('.file-block').remove()
            },
            error: function(response) {
                if (response.status === 422) {
                    var errors = response.responseJSON.errors;
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            $('#' + key + '-error').html(errors[key][0]);
                        }
                    }
                }
            }
        });
    })

    if($('#category') && $('#sub-category'))
    {
        $('#category').on('change', function() {
            var categoryId = $(this).val();

            if(categoryId) {
                $.ajax({
                    url: '/categories/subcategories',
                    data: {
                        categoriesIds : [categoryId]
                    },
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#sub-category').empty();
                        $('#sub-category').append('<option value="">Select a subcategory</option>');
                        const allowed = document.querySelector('#allowed_subcategories')

                        $.each(response.data, function(key, value) {
                            if(allowed) {
                                const values = JSON.parse(allowed.value)
                                if (values.includes(parseInt(value.id))) {
                                    $('#sub-category').append('<option value="' + value.id + '">' + value.name + '</option>');
                                }
                            } else {
                                $('#sub-category').append('<option value="' + value.id + '">' + value.name + '</option>');
                            }
                        });
                    }
                });
            } else {
                $('#sub-category').empty();
                $('#sub-category').append('<option value="">Select a subcategory</option>');
            }
        });
    }

    $('.category-checkbox').on('change', function (el) {
        toggleSubcategories();
        updateShowResultsButton();
    });

    function toggleSubcategories() {
        let checkedCategories = $('.category-checkbox:checked');
        const $subcategorySection = $('#subcategory-section');

        if (checkedCategories.length > 0) {
            if ($subcategorySection.is(':hidden')) {
                $subcategorySection.slideDown(400);
            }

            checkedCategories.each(function (i, el) {
                $('.subcategory-checkbox[data-parent-slug='+ $(el).val() +']')
                    .closest('li')
                    .show();
            });
            $('.category-checkbox:not(:checked)').each(function (i, el) {
                $('.subcategory-checkbox[data-parent-slug='+ $(el).val() +']')
                    .prop('checked', false)
                    .closest('li')
                    .hide();
            });
        } else {
            if ($subcategorySection.is(':visible')) {
                $subcategorySection.slideUp(400);
            }

            $('.subcategory-checkbox')
                .closest('li')
                .show();
        }
    }

    $('.subcategory-checkbox').on('change', function (el) {
        if ($(el.target).prop('checked')) {
            $('.category-checkbox[value='+ $(el.target).data('parent-slug') +']').prop('checked', true);
            updateShowResultsButton();
        }
    });

    $('#search-autocomplete-services').on('input', function() {
        updateShowResultsButton();
    });

    function updateShowResultsButton() {
        const hasCategory = $('.category-checkbox:checked').length > 0;
        const hasSearchText = $('#search-autocomplete-services').val().trim().length > 0;
        const showResultsBtn = document.getElementById('show-results-btn');

        if (showResultsBtn) {
            if (hasCategory || hasSearchText) {
                showResultsBtn.disabled = false;
            } else {
                showResultsBtn.disabled = true;
            }
        }
    }

    if ($('.toast').length) {
        new bootstrap.Toast($('.toast')).show();
    }

    $('#services-link').on('click', function(event) {
        if (window.innerWidth < 992) {
            event.preventDefault();
        }
    });

    const modal = document.getElementById('request-quote')

    // Сохраняем оригинальные options для последующего восстановления
    let originalCategoryOptions = null
    let originalSubcategoryOptions = null

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget
        const title = button.getAttribute('data-bs-title')
        modal.querySelector('.modal-title').textContent = title

        const providerId = button.getAttribute('data-provider-id')
        const providerCategoryId = button.getAttribute('data-provider-categories')
        const providerSubcategoryId = button.getAttribute('data-provider-subcategories')
        const providerSubcategoriesList = button.getAttribute('data-provider-subcategories-list')
        const providerCategoriesList = button.getAttribute('data-provider-allowed-categories-list')
        const providerAllowedSubcategoriesList = button.getAttribute('data-provider-allowed-subcategories-list')

        const form = modal.querySelector('form')

        // --- Добавляем / убираем скрытый инпут ---
        if (form) {
            let hiddenInput = form.querySelector('#allowed_subcategories')
            if (providerAllowedSubcategoriesList) {
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input')
                    hiddenInput.type = 'hidden'
                    hiddenInput.id = 'allowed_subcategories'
                    hiddenInput.name = 'allowed_subcategories'
                    form.appendChild(hiddenInput)
                }
                hiddenInput.value = providerAllowedSubcategoriesList
            } else if (hiddenInput) {
                hiddenInput.remove()
            }
        }

        // --- Работа с селектами ---
        const categorySelect = document.getElementById('category')
        const subcategorySelect = document.getElementById('sub-category')

        if (!originalCategoryOptions && categorySelect) {
            originalCategoryOptions = Array.from(categorySelect.options).map(opt => opt.cloneNode(true))
        }
        if (!originalSubcategoryOptions && subcategorySelect) {
            originalSubcategoryOptions = Array.from(subcategorySelect.options).map(opt => opt.cloneNode(true))
        }

        // Перед каждым открытием — восстанавливаем оригинальные options
        if (categorySelect && originalCategoryOptions) {
            categorySelect.innerHTML = ''
            originalCategoryOptions.forEach(opt => categorySelect.appendChild(opt.cloneNode(true)))
        }
        if (subcategorySelect && originalSubcategoryOptions) {
            subcategorySelect.innerHTML = ''
            originalSubcategoryOptions.forEach(opt => subcategorySelect.appendChild(opt.cloneNode(true)))
        }

        // Разблокировать перед фильтрацией
        if (categorySelect) categorySelect.disabled = false
        if (subcategorySelect) subcategorySelect.disabled = false

        // --- Фильтруем категории, если нужно ---
        if (providerCategoriesList && categorySelect) {
            let allowedCategories = []
            try {
                allowedCategories = JSON.parse(providerCategoriesList)
            } catch (e) {
                console.warn('Invalid providerCategoriesList format:', providerCategoriesList)
            }

            if (Array.isArray(allowedCategories) && allowedCategories.length > 0) {
                const allowedCategoryIds = allowedCategories.map(c => parseInt(c))
                Array.from(categorySelect.options).forEach(opt => {
                    if (opt.innerHTML !== 'Select Category' && !allowedCategoryIds.includes(parseInt(opt.value))) {
                        opt.remove()
                    }
                })
            }
        }

        // --- Устанавливаем выбранную категорию и подкатегорию ---
        if (providerId && providerCategoryId && categorySelect) {
            categorySelect.value = providerCategoryId
            $(categorySelect).trigger('change')
            categorySelect.disabled = true

            if (providerSubcategoriesList && subcategorySelect) {
                let allowedIds = []
                try {
                    allowedIds = JSON.parse(providerSubcategoriesList)
                } catch (e) {
                    console.warn('Invalid providerSubcategoriesList format:', providerSubcategoriesList)
                }

                if (Array.isArray(allowedIds) && allowedIds.length > 0) {
                    setTimeout(() => {
                        Array.from(subcategorySelect.options).forEach(opt => {
                            if (
                                !allowedIds.includes(parseInt(opt.value)) &&
                                opt.innerHTML !== "Select a subcategory"
                            ) {
                                opt.remove()
                            }

                            if (allowedIds.length === 1) {
                                subcategorySelect.value = allowedIds[0]
                                $(subcategorySelect).trigger('change')
                            }

                        })
                    }, 500)
                }
            }

            if (providerSubcategoryId) {
                setTimeout(() => {
                    if (subcategorySelect) {
                        subcategorySelect.value = providerSubcategoryId
                        $(subcategorySelect).trigger('change')
                        subcategorySelect.disabled = true
                    }
                }, 500)
            }
        }
    })


    $('#search-autocomplete-input')
        .on('keyup', function(){
            const form = $(this).closest('form');
            let query = $(this).val();
            if(query !== '') {
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: form.data('autocomplete-url'),
                    method: "GET",
                    data: {query:query, _token:_token},
                    success:function(data){
                        $('#search-autocomplete-list').show().html(data);
                    }
                });
            }

            if (query === '') {
                $('#search-autocomplete-list').hide();
            }
        })
        .on('focusout', function() {
            setTimeout(() => $('#search-autocomplete-list').hide(), 300);
        });

    $('#search-autocomplete-services')
        .on('keyup', function(){
            const form = $(this).closest('form');
            let query = $(this).val();

            if(query.length > 2) {
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: form.data('autocomplete-url'),
                    method: "GET",
                    data: {query:query, _token:_token},
                    success:function(data){
                        $('#search-autocomplete-service').show().html(data);
                    }
                });
            }

            if (query === '') {
                $('#search-autocomplete-service').hide();
            }
        })
        .on('focusout', function() {
            setTimeout(() => $('#search-autocomplete-list').hide(), 300);
        });

    // Remove empty fields from filter form before submit
    $('.filter-div form').on('submit', function(e) {
        const $form = $(this);

        // Disable empty text and hidden inputs
        $form.find('input[type="text"], input[type="hidden"]').each(function() {
            if ($(this).val() === '') {
                $(this).prop('disabled', true);
            }
        });

        // Check if there are any parameters to send
        const hasTextInputs = $form.find('input[type="text"]:not(:disabled)').filter(function() {
            return $(this).val() !== '';
        }).length > 0;

        const hasHiddenInputs = $form.find('input[type="hidden"]:not(:disabled)').filter(function() {
            return $(this).val() !== '';
        }).length > 0;

        const hasCheckedBoxes = $form.find('input[type="checkbox"]:checked').length > 0;

        // If no parameters at all, redirect to clean URL without query string
        if (!hasTextInputs && !hasHiddenInputs && !hasCheckedBoxes) {
            e.preventDefault();
            window.location.href = $form.attr('action');
        }
    });

    $('.quick-tips').on('click', function (el) {
    	$('.quick-tips-content').fadeToggle(100);
    });

    const copyEmailButton = document.getElementById('copyEmailButton');
    const copyNotification = document.getElementById('copyNotification');
    if (copyEmailButton) {
        copyEmailButton.addEventListener('click', () => {
            const email = copyEmailButton.textContent;
            navigator.clipboard.writeText(email).then(() => {
                copyNotification.classList.add('show');
                setTimeout(() => {
                    copyNotification.classList.remove('show');
                }, 2000);
            }).catch(err => {
                console.error('copy error', err);
            });
        });
    }

})(jQuery);

const tabPaneIds = [
    'service-categories',
    'provider-details',
    'pills-contact'
];

const buttonsIds = [
    'provider-details-tab',
    'service-categories-tab',
    'pills-contact-tab'
];

const smBreakpoint = 576;

let currentScreenState = null;

function checkAllTabScreens() {
    // Check if any of the tab elements exist on this page
    const hasTabElements = tabPaneIds.some(id => document.getElementById(id) !== null);

    if (!hasTabElements) {
        // Not on the provider details page, skip this functionality
        return;
    }

    const screenWidth = window.innerWidth;

    const isSmallScreen = screenWidth < smBreakpoint;

    if (currentScreenState !== null && currentScreenState === isSmallScreen) {
        return;
    }

    currentScreenState = isSmallScreen;

    const shouldActivate = isSmallScreen;

    tabPaneIds.forEach(id => {
        const element = document.getElementById(id);

        if (!element) {
            return;
        }

        if (shouldActivate) {
            element.classList.add('show', 'active');
        } else {
            if (element.id !== 'provider-details') {
                element.classList.remove('show', 'active');
            }
        }
    });

    buttonsIds.forEach(id => {
        const element = document.getElementById(id);

        if (!element) {
            return;
        }

        if (!shouldActivate) {
            if (element.id === 'provider-details-tab') {
                element.classList.add('active');
            } else {
                element.classList.remove('active');
            }
        } else {
            element.classList.remove('active');
        }
    });
}

document.addEventListener('DOMContentLoaded', checkAllTabScreens);

let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(checkAllTabScreens, 100); // Задержка 100 мс
});

document.addEventListener('DOMContentLoaded', function () {
    const copyDiv = document.getElementById('copy-link');

    if (!copyDiv) {
        return;
    }

    const copyTextSpan = copyDiv.querySelector('.copy-text');

    if (!copyTextSpan) {
        return;
    }

    copyDiv.addEventListener('click', function () {
        const linkToCopy = copyDiv.getAttribute('data-link');

        navigator.clipboard.writeText(linkToCopy).then(() => {
            const originalText = copyTextSpan.textContent;
            copyTextSpan.textContent = 'Link copied!';

            setTimeout(() => {
                copyTextSpan.textContent = originalText;
            }, 1500);
        }).catch(err => {
            console.error('Copy error: ', err);
        });
    });
});
