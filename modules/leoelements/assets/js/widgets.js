/**
 *  @Website: leotheme.com - prestashop template provider
 *  @author Leotheme <leotheme@gmail.com>
 *  @copyright  Leotheme
 *  @description: 
 */

var LeoElementsModule;
function LeoScrollObserver(a) {
    var o = 0
      , e = {
        root: a.root || null,
        rootMargin: a.offset || "0px",
        threshold: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0
              , t = [];
            if (0 < e && e <= 100)
                for (var i = 100 / e, n = 0; n <= 100; n += i)
                    t.push(n / 100);
            else
                t.push(0);
            return t
        }(a.sensitivity)
    };
    return new IntersectionObserver(function(e, t) {
        var i = e[0].boundingClientRect.y
          , n = e[0].isIntersecting
          , s = i < o ? "down" : "up"
          , e = Math.abs($((100 * e[0].intersectionRatio).toFixed(2)));
        a.callback({
            sensitivity: a.sensitivity,
            isInViewport: n,
            scrollPercentage: e,
            intersectionScrollDirection: s
        }),
        o = i
    }
    ,e)
}
!function(p) {
    p.fn.InfiniteAp = function(e) {
        var c = {
            trigger: ".widget-ajax-trigger",
            ajaxLoader: ".ajax-loader",
            triggerWrap: ".ajax-load-wrapper",
            data: e
        };
        return this.each(function() {
            var e = p.extend({}, c, d)
              , t = p(this)
              , i = e.data.options.paged
              , n = t.closest(".leo-grid-items").find(e.trigger).first()
              , s = t.closest(".leo-grid-items").find(e.ajaxLoader).first()
              , a = t.closest(".leo-grid-items").find(e.triggerWrap).first()
              , o = t.find(".swiper-wrapper")
              , r = !1
              , d = e.data
              , l = !1;
            n.on("click", function() {
                l || (l = !0,
                n.hide(),
                s.show(),
                i++,
                d.options.paged = i,
                p.ajax({
                    url: opLeoElements.ajax,
                    type: "POST",
                    data: d,
                    success: function(e) {
                        o.append(e.html),
                        e.lastPage && (r = !0)
                    },
                    error: function(e, t, i) {
                        console.error(i)
                    }
                }).always(function() {
                    prestashop.emit("updatedProductAjax", null),
                    s.hide(),
                    r ? a.hide() : (n.show(),
                    l = !1)
                }))
            })
        })
    }
}(jQuery),
function(a) {
    "use strict";
    LeoElementsModule = {
        init: function() {
            this.mdLinkList(),
            this.mdDropdown(),
            this.mdCarousel(),
            this.mdHotspot(),
            this.mdCountDownTimer(),
            this.mdLoadWidget(),
            this.mdLoadMore(),
            this.mdTabs(),
            this.mdSubscription(),
            this.mdContact()
        },
        mdDropdown: function() {
            a("body").on("click", "[data-toggle=leo-dropdown-widget]", function(e) {
                e.preventDefault(),
                a(".leo-dropdown-wrapper").not(a(this).closest(".leo-dropdown-wrapper")).removeClass("open"),
                a(this).closest(".leo-dropdown-wrapper").toggleClass("open")
            }),
            a("body").click(function(e) {
                e = a(e.target);
                e.is(".leo-dropdown-wrapper") || e.closest(".leo-dropdown-wrapper").length || a(".leo-dropdown-wrapper").removeClass("open")
            }),
            a(document).on("hidden_dropdown_widget", function() {
                a(".leo-dropdown-wrapper").removeClass("open")
            })
        },
        mdLinkList: function() {
            a("body").on("click", ".LeoBlockLink-toggle-all [data-toggle=linklist-widget]", function(e) {
                e.preventDefault(),
                a(this).closest(".LeoBlockLink").find(".linklist-menu").slideToggle(200)
            }),
            a("body").on("click", ".LeoBlockLink-toggle-mobile [data-toggle=linklist-widget]", function(e) {
                a(window).width() < 768 && (e.preventDefault(),
                a(this).closest(".LeoBlockLink").find(".linklist-menu").slideToggle(200))
            })
        },
        mdCountDownTimer: function() {
            a("[data-countdown-timer]").each(function() {
                var t = a(this)
                  , e = moment.tz(t.data("countdown-timer"), t.data("timezone"))
                  , i = t.data("expire-actions")
                  , n = t.parent().find(".elementor-countdown-expire--message");
                t.removeAttr("data-countdown-timer"),
                t.removeAttr("data-timezone"),
                t.removeAttr("data-expire-actions"),
                t.countdown(e.toDate(), function(e) {
                    t.find(".js-time-days").html(e.strftime("%D")),
                    t.find(".js-time-hours").html(e.strftime("%H")),
                    t.find(".js-time-minutes").html(e.strftime("%M")),
                    t.find(".js-time-seconds").html(e.strftime("%S")),
                    void 0 !== i && "finish" === e.type && i.forEach(function(e) {
                        switch (e.type) {
                        case "hide":
                            t.hide();
                            break;
                        case "redirect":
                            e.redirect_url && (window.location.href = e.redirect_url);
                            break;
                        case "message":
                            n.show()
                        }
                    })
                })
            })
        },
        mdHotspot: function() {
            a(".image-hotspot").each(function() {
                var t = a(this)
                  , e = t.find(".hotspot-btn");
                !t.parents(".image-hotspot-wrapper").hasClass("hotspot-click") && 1025 <= a(window).width() || (e.on("click", function() {
                    return t.hasClass("hotspot-opened") ? t.removeClass("hotspot-opened") : (t.addClass("hotspot-opened"),
                    t.siblings().removeClass("hotspot-opened")),
                    !1
                }),
                a(document).on("click", function(e) {
                    e = e.target;
                    if (t.hasClass("hotspot-opened") && !a(e).is(".image-hotspot") && !a(e).parents().is(".image-hotspot"))
                        return t.removeClass("hotspot-opened"),
                        !1
                }))
            }),
            a(".image-hotspot .hotspot-content").each(function() {
                var e = a(this)
                  , t = e.offset().left
                  , i = a(window).width() - (t + e.outerWidth());
                768 < a(window).width() && (t <= 0 && e.addClass("hotspot-overflow-right"),
                i <= 0 && e.addClass("hotspot-overflow-left")),
                a(window).width() <= 768 && (t <= 0 && e.css("marginLeft", Math.abs(t - 15) + "px"),
                i <= 0 && e.css("marginLeft", i - 15 + "px"))
            })
        },
        mdTabs: function() {
            a("[data-toggle=tabs-widget]").each(function() {
                var e = a(this)
                  , t = e.find(".widget-tab-title")
                  , i = e.find(".widget-tab-content")
                  , n = t.filter('[data-tab="1"]')
                  , s = i.filter('[data-tab="1"]');
                t.on("click", function() {
                    var e;
                    e = this.dataset.tab,
                    t.filter('[data-tab="' + e + '"]').hasClass("active") || (n && (n.removeClass("active"),
                    s.removeClass("active")),
                    (n = t.filter('[data-tab="' + e + '"]')).addClass("active"),
                    (s = i.filter('[data-tab="' + e + '"]')).addClass("active"),
                    setTimeout(function() {
                        LeoElementsModule.mdLoadWidget()
                    }, 400))
                })
            })
        },
        mdLoadWidget: function() {
            a(".is-load-widget[data-widget-options]").each(function() {
                var t, i, n = a(this);
                n.is(":visible") && "hidden" != n.css("visibility") && (t = n.data("widget-options"),
                n.removeClass("is-load-widget"),
                i = !1,
                new Waypoint({
                    element: n,
                    handler: function() {
                        var e = this;
                        i || (i = !0,
                        a.ajax({
                            type: "POST",
                            url: opLeoElements.ajax,
                            data: t,
                            success: function(e) {
                                n.find(".swiper-wrapper").html(e.html)
                            },
                            error: function(e, t, i) {
                                console.error(i)
                            }
                        }).always(function() {
                            switch (n.removeClass("widget-loading"),
                            n.addClass("is-" + t.options.view_type),
                            LeoElementsModule.mdCarousel(),
                            LeoElementsModule.mdLoadMore(),
                            e.destroy(),
                            t.type) {
                            case "product":
                                prestashop.emit("updatedProductAjax", null);
                                break;
                            case "blog":
                                prestashop.emit("mustUpdateLazyLoad", null)
                            }
                        }))
                    },
                    offset: "100%"
                }))
            })
        },
        mdLoadMore: function() {
            a(".is-grid[data-widget-options]").each(function() {
                var e = a(this)
                  , t = e.data("widget-options");
                e.removeAttr("data-widget-options"),
                e.removeClass("is-grid"),
                0 < e.closest(".leo-grid-items").find(".widget-ajax-trigger").length && e.InfiniteAp(t)
            })
        },
        mdCarousel: function() {
            a(".is-carousel[data-slider-options]").each(function() {
                var t = a(this)
                  , i = t.data("slider-options");
                t.removeAttr("data-slider-options"),
                t.removeAttr("data-widget-options"),
                t.removeClass("is-carousel");
                var e = {
                    slidesPerView: i.slidesToShowMobile,
                    slidesPerGroup: i.slidesToScrollMobile,
                    speed: i.speed,
                    loop: i.infinite,
                    navigation: {
                        nextEl: t.parent().find(".leo-swiper-arrow-next"),
                        prevEl: t.parent().find(".leo-swiper-arrow-prev")
                    },
                    pagination: {
                        el: t.parent().find(".leo-swiper-pagination"),
                        type: "bullets",
                        clickable: !0
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: i.slidesToShowTablet,
                            slidesPerGroup: i.slidesToScrollTablet
                        },
                        1025: {
                            slidesPerView: i.slidesToShow,
                            slidesPerGroup: i.slidesToScroll
                        }
                    },
                    on: {
                        init: function() {
                            var e = i.slidesToShow;
                            a(window).width() < 1025 && (e = i.slidesToShowTablet),
                            a(window).width() < 768 && (e = i.slidesToShowMobile),
                            t.find(".swiper-slide:not(.swiper-slide-duplicate)").length <= e && (t.closest(".leo-swiper-slider").find(".swiper-dots").addClass("swiper-dots-hidden"),
                            t.closest(".leo-swiper-slider").find(".swiper-arrows").addClass("swiper-arrows-hidden"))
                        },
                        resize: function() {
                            t.closest(".leo-swiper-slider").find(".swiper-arrows").removeClass("swiper-arrows-hidden"),
                            t.closest(".leo-swiper-slider").find(".swiper-dots").removeClass("swiper-dots-hidden");
                            var e = i.slidesToShow;
                            a(window).width() < 1025 && (e = i.slidesToShowTablet),
                            a(window).width() < 768 && (e = i.slidesToShowMobile),
                            t.find(".swiper-slide:not(.swiper-slide-duplicate)").length <= e && (t.closest(".leo-swiper-slider").find(".swiper-dots").addClass("swiper-dots-hidden"),
                            t.closest(".leo-swiper-slider").find(".swiper-arrows").addClass("swiper-arrows-hidden"))
                        }
                    }
                };
                i.autoplay && (e = a.extend({}, e, {
                    autoplay: {
                        delay: i.autoplaySpeed,
                        disableOnInteraction: i.pauseOnHover
                    }
                }));
                var n = new Swiper(t,e);
                i.pauseOnHover && i.autoplay ? t.on({
                    mouseenter: function() {
                        n.autoplay.stop()
                    },
                    mouseleave: function() {
                        n.autoplay.start()
                    }
                }) : t.off("mouseenter mouseleave")
            })
        },
        mdSubscription: function() {
            a(".ajax-elementor-subscription").on("submit", function(e) {
                e.preventDefault();
                var t = a(this);
                t.hasClass("has-processing") || (t.addClass("has-processing"),
                a.ajax({
                    type: "POST",
                    dataType: "JSON",
                    cache: !1,
                    data: t.serialize(),
                    url: opLeoElements.subscription,
                    beforeSend: function() {
                        t.find("[name=submitNewsletter]").addClass("leo-processing"),
                        t.find(".send-response").html("")
                    },
                    complete: function() {
                        t.removeClass("has-processing"),
                        t.find("[name=submitNewsletter]").removeClass("leo-processing")
                    },
                    success: function(e) {
                        e.nw_error ? t.find(".send-response").html('<div class="alert alert-danger">' + e.msg + "</div>") : (t.find(".send-response").html('<div class="alert alert-success">' + e.msg + "</div>"),
                        t.find("[name=email]").val(""),
                        t.find("[name=psgdpr_consent_checkbox]").prop("checked", !1))
                    },
                    error: function(e) {
                        console.log(e)
                    }
                }))
            })
        },
        mdContact: function() {
            a(".ajax-elementor-contact").on("submit", function(e) {
                e.preventDefault();
                var t = a(this);
                t.hasClass("has-processing") || (t.addClass("has-processing"),
                a.ajax({
                    url: opLeoElements.contact,
                    data: new FormData(this),
                    type: "POST",
                    headers: {
                        "cache-control": "no-cache"
                    },
                    dataType: "json",
                    contentType: !1,
                    processData: !1,
                    beforeSend: function() {
                        t.find("[name=submitMessage]").addClass("leo-processing"),
                        t.find(".send-response").html("")
                    },
                    complete: function() {
                        t.removeClass("has-processing"),
                        t.find("[name=submitMessage]").removeClass("leo-processing")
                    },
                    success: function(e) {
                        e.nw_error ? t.find(".send-response").html('<div class="alert alert-danger">' + e.messages + "</div>") : (t.find(".send-response").html('<div class="alert alert-success">' + e.messages + "</div>"),
                        t.find("[name=from]").val(""),
                        t.find("[name=fileUpload]").val(""),
                        t.find("[name=message]").val(""),
                        t.find(".bootstrap-filestyle input").val(""),
                        t.find("[name=psgdpr_consent_checkbox]").prop("checked", !1))
                    },
                    error: function(e) {
                        console.log(e)
                    }
                }))
            })
        }
    }
    
    var LeoProductCarousel = function($scope, $) {
        
        if ( $scope.find('.elementor-LeoProductCarousel.ApSlick').length)
        {
            // getElementSettings
            var elementSettings = {};
            var modelCID = $scope.data('model-cid');
            
            if (modelCID)
            {
                var settings = elementorFrontend.config.elements.data[modelCID];
                var attributes = settings.attributes;
                var type = attributes.widgetType || attributes.elType;

                if (attributes.isInner) {
                    type = 'inner-' + type;
                }

                var settingsKeys = elementorFrontend.config.elements.keys[type];

                if (!settingsKeys) {
                    settingsKeys = elementorFrontend.config.elements.keys[type] = [];
                    jQuery.each(settings.controls, function (name, control) {
                        if (control.frontend_available) {
                            settingsKeys.push(name);
                        }
                    });
                }
                jQuery.each(settings.getActiveControls(), function (controlKey) {
                    if (-1 !== settingsKeys.indexOf(controlKey)) {
                        elementSettings[controlKey] = attributes[controlKey];
                    }
                });
            }else {
                elementSettings = $scope.data('settings') || {};
            }
            var slidesToShow = +elementSettings.slides_to_show || 3;
            var isSingleSlide = 1 === slidesToShow;
            var defaultLGDevicesSlidesCount = isSingleSlide ? 1 : 2;
            var breakpoints = elementorFrontend.config.breakpoints;
            var is_rtl = false;
            if (prestashop.language.is_rtl == 1) {
                is_rtl = true;
            }
            
            $scope.find('.elementor-LeoProductCarousel.ApSlick').each(function() {
                
                var slickOptions = {
                    slidesToShow: slidesToShow,
                    autoplay: 'yes' === elementSettings.autoplay,
                    autoplaySpeed: elementSettings.autoplay_speed,
                    infinite: 'yes' === elementSettings.infinite,
                    pauseOnHover: 'yes' === elementSettings.pause_on_hover,
                    speed: elementSettings.speed,
                    arrows: -1 !== ['arrows', 'both'].indexOf(elementSettings.navigation),
                    dots: -1 !== ['dots', 'both'].indexOf(elementSettings.navigation),
                    rtl: is_rtl,
                    responsive: [{
                        breakpoint: breakpoints.lg,
                        settings: {
                            slidesToShow: +elementSettings.slides_to_show_tablet || defaultLGDevicesSlidesCount,
                            slidesToScroll: +elementSettings.slides_to_scroll_tablet || defaultLGDevicesSlidesCount
                        }
                    }, {
                        breakpoint: breakpoints.md,
                        settings: {
                            slidesToShow: +elementSettings.slides_to_show_mobile || 1,
                            slidesToScroll: +elementSettings.slides_to_scroll_mobile || 1
                        }
                    }]
                };
                if (isSingleSlide) {
                    slickOptions.fade = 'fade' === elementSettings.effect;
                } else {
                    slickOptions.slidesToScroll = +elementSettings.slides_to_scroll || defaultLGDevicesSlidesCount;
                }
                $(this).not('.slick-initialized').slick(slickOptions);
                
            });
        }
    }
    
    var LeoProductTab = function($scope, $) {
        $(".elementor-LeoProductTab").each(function() {
            var e = $(this)
              , t = e.find(".widget-tab-title")
              , i = e.find(".widget-tab-content")
              , n = t.filter('[data-tab="1"]')
              , s = i.filter('[data-tab="1"]');
            t.on("click", function() {
                var e;
                e = this.dataset.tab,
                t.filter('[data-tab="' + e + '"]').hasClass("active") || (n && (n.removeClass("active"),
                s.removeClass("active")),
                (n = t.filter('[data-tab="' + e + '"]')).addClass("active"),
                (s = i.filter('[data-tab="' + e + '"]')).addClass("active")
//                ,setTimeout(function() {
//                    LeoElementsModule.mdLoadWidget()
//                }, 400)
                        )
            });
        });
        
        LeoProductCarousel($scope, $);
    }
    
    
    var runJsTPL = function($scope, $) {
        
        var sub = $('.autojs', $scope);
        var form_id = sub.data('form_id');
        function fn_exist(function_name)
        {
            return eval('typeof ' + function_name) === 'function';
        }
        if( fn_exist(form_id) ){
            eval(form_id)();
        }
        
        return;
        
        // getElementSettings
        var elementSettings = {};
        var modelCID = $scope.data('model-cid');

        if (modelCID)
        {
            var settings = elementorFrontend.config.elements.data[modelCID];
            var attributes = settings.attributes;
            var type = attributes.widgetType || attributes.elType;

            if (attributes.isInner) {
                type = 'inner-' + type;
            }

            var settingsKeys = elementorFrontend.config.elements.keys[type];

            if (!settingsKeys) {
                settingsKeys = elementorFrontend.config.elements.keys[type] = [];
                jQuery.each(settings.controls, function (name, control) {
                    if (control.frontend_available) {
                        settingsKeys.push(name);
                    }
                });
            }
            jQuery.each(settings.getActiveControls(), function (controlKey) {
                if (-1 !== settingsKeys.indexOf(controlKey)) {
                    elementSettings[controlKey] = attributes[controlKey];
                }
            });
        }else {
            elementSettings = $scope.data('settings') || {};
        }
        
        return;
            
        
        var modelCID = $scope.data('model-cid');
        var settings = elementorFrontend.config.elements.data[modelCID];
        var attributes = settings.attributes;
        var form_id = settings.attributes.form_id;
        
        function fn_exist(function_name)
        {
            return eval('typeof ' + function_name) === 'function';
        }
        if( fn_exist(form_id) ){
        }
        return;
    }
    
    jQuery(window).on("elementor/frontend/init", function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/LeoProductCarousel.default', LeoProductCarousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/LeoProductTab.default', LeoProductTab);
        elementorFrontend.hooks.addAction('frontend/element_ready/LeoBlog.default', runJsTPL);
        elementorFrontend.hooks.addAction('frontend/element_ready/LeoBlockCarousel.default', runJsTPL);
        elementorFrontend.hooks.addAction('frontend/element_ready/LeoManufacturersCarousel.default', runJsTPL);
        elementorFrontend.hooks.addAction('frontend/element_ready/LeoInstagram.default', runJsTPL);
        elementorFrontend.hooks.addAction('frontend/element_ready/LeoCountDown.default', runJsTPL);
    });
    
    
}(jQuery),
jQuery(document).ready(function() {
    LeoElementsModule.init()
}),
        
jQuery(window).on("elementor/frontend/init", function() {
    elementorFrontend.isEditMode();
});
var LeoHeadLine = elementorModules.frontend.handlers.Base.extend({
    svgPaths: {
        circle: ["M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7"],
        underline_zigzag: ["M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9"],
        x: ["M497.4,23.9C301.6,40,155.9,80.6,4,144.4", "M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7"],
        strikethrough: ["M3,75h493.5"],
        curly: ["M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6"],
        diagonal: ["M13.5,15.5c131,13.7,289.3,55.5,475,125.5"],
        double: ["M8.4,143.1c14.2-8,97.6-8.8,200.6-9.2c122.3-0.4,287.5,7.2,287.5,7.2", "M8,19.4c72.3-5.3,162-7.8,216-7.8c54,0,136.2,0,267,7.8"],
        double_underline: ["M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6", "M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4"],
        underline: ["M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"]
    },
    getDefaultSettings: function() {
        var e = this.getElementSettings("rotate_iteration_delay")
          , e = {
            animationDelay: e || 2500,
            lettersDelay: .02 * e || 50,
            typeLettersDelay: .06 * e || 150,
            selectionDuration: .2 * e || 500,
            revealDuration: .24 * e || 600,
            revealAnimationDelay: .6 * e || 1500,
            highlightAnimationDuration: this.getElementSettings("highlight_animation_duration") || 1200,
            highlightAnimationDelay: this.getElementSettings("highlight_iteration_delay") || 8e3
        };
        return e.typeAnimationDelay = e.selectionDuration + 800,
        e.selectors = {
            headline: ".elementor-headline",
            dynamicWrapper: ".elementor-headline-dynamic-wrapper",
            dynamicText: ".elementor-headline-dynamic-text"
        },
        e.classes = {
            dynamicText: "elementor-headline-dynamic-text",
            dynamicLetter: "elementor-headline-dynamic-letter",
            textActive: "elementor-headline-text-active",
            textInactive: "elementor-headline-text-inactive",
            letters: "elementor-headline-letters",
            animationIn: "elementor-headline-animation-in",
            typeSelected: "elementor-headline-typing-selected",
            activateHighlight: "e-animated",
            hideHighlight: "e-hide-highlight"
        },
        e
    },
    getDefaultElements: function() {
        var e = this.getSettings("selectors");
        return {
            $headline: this.$element.find(e.headline),
            $dynamicWrapper: this.$element.find(e.dynamicWrapper),
            $dynamicText: this.$element.find(e.dynamicText)
        }
    },
    getNextWord: function(e) {
        return e.is(":last-child") ? e.parent().children().eq(0) : e.next()
    },
    switchWord: function(e, t) {
        e.removeClass("elementor-headline-text-active").addClass("elementor-headline-text-inactive"),
        t.removeClass("elementor-headline-text-inactive").addClass("elementor-headline-text-active"),
        this.setDynamicWrapperWidth(t)
    },
    singleLetters: function() {
        var n = this.getSettings("classes");
        this.elements.$dynamicText.each(function() {
            var t = jQuery(this)
              , e = t.text().split("")
              , i = t.hasClass(n.textActive);
            t.empty(),
            e.forEach(function(e) {
                e = jQuery("<span>", {
                    class: n.dynamicLetter
                }).text(e);
                i && e.addClass(n.animationIn),
                t.append(e)
            }),
            t.css("opacity", 1)
        })
    },
    showLetter: function(e, t, i, n) {
        var s = this
          , a = this.getSettings("classes");
        e.addClass(a.animationIn),
        e.is(":last-child") ? i || setTimeout(function() {
            s.hideWord(t)
        }, s.getSettings("animationDelay")) : setTimeout(function() {
            s.showLetter(e.next(), t, i, n)
        }, n)
    },
    hideLetter: function(e, t, i, n) {
        var s = this
          , a = this.getSettings();
        e.removeClass(a.classes.animationIn),
        e.is(":last-child") ? i && setTimeout(function() {
            s.hideWord(s.getNextWord(t))
        }, s.getSettings("animationDelay")) : setTimeout(function() {
            s.hideLetter(e.next(), t, i, n)
        }, n)
    },
    showWord: function(e, t) {
        var i = this
          , n = i.getSettings()
          , s = i.getElementSettings("animation_type");
        "typing" === s ? (i.showLetter(e.find("." + n.classes.dynamicLetter).eq(0), e, !1, t),
        e.addClass(n.classes.textActive).removeClass(n.classes.textInactive)) : "clip" === s && i.elements.$dynamicWrapper.animate({
            width: e.width() + 10
        }, n.revealDuration, function() {
            setTimeout(function() {
                i.hideWord(e)
            }, n.revealAnimationDelay)
        })
    },
    hideWord: function(e) {
        var t, i = this, n = i.getSettings(), s = n.classes, a = "." + s.dynamicLetter, o = i.getElementSettings("animation_type"), r = i.getNextWord(e);
        !this.isLoopMode && e.is(":last-child") || ("typing" === o ? (i.elements.$dynamicWrapper.addClass(s.typeSelected),
        setTimeout(function() {
            i.elements.$dynamicWrapper.removeClass(s.typeSelected),
            e.addClass(n.classes.textInactive).removeClass(s.textActive).children(a).removeClass(s.animationIn)
        }, n.selectionDuration),
        setTimeout(function() {
            i.showWord(r, n.typeLettersDelay)
        }, n.typeAnimationDelay)) : i.elements.$headline.hasClass(s.letters) ? (t = e.children(a).length >= r.children(a).length,
        i.hideLetter(e.find(a).eq(0), e, t, n.lettersDelay),
        i.showLetter(r.find(a).eq(0), r, t, n.lettersDelay),
        i.setDynamicWrapperWidth(r)) : "clip" === o ? i.elements.$dynamicWrapper.animate({
            width: "2px"
        }, n.revealDuration, function() {
            i.switchWord(e, r),
            i.showWord(r)
        }) : (i.switchWord(e, r),
        setTimeout(function() {
            i.hideWord(r)
        }, n.animationDelay)))
    },
    setDynamicWrapperWidth: function(e) {
        var t = this.getElementSettings("animation_type");
        "clip" !== t && "typing" !== t && this.elements.$dynamicWrapper.css("width", e.width())
    },
    animateHeadline: function() {
        var e = this
          , t = e.getElementSettings("animation_type")
          , i = e.elements.$dynamicWrapper;
        "clip" === t ? i.width(i.width() + 10) : "typing" !== t && e.setDynamicWrapperWidth(e.elements.$dynamicText),
        setTimeout(function() {
            e.hideWord(e.elements.$dynamicText.eq(0))
        }, e.getSettings("animationDelay"))
    },
    getSvgPaths: function(e) {
        var e = this.svgPaths[e]
          , t = jQuery();
        return e.forEach(function(e) {
            t = t.add(jQuery("<path>", {
                d: e
            }))
        }),
        t
    },
    addHighlight: function() {
        var e = this.getElementSettings()
          , e = jQuery("<svg>", {
            xmlns: "http://www.w3.org/2000/svg",
            viewBox: "0 0 500 150",
            preserveAspectRatio: "none"
        }).html(this.getSvgPaths(e.marker));
        this.elements.$dynamicWrapper.append(e[0].outerHTML)
    },
    rotateHeadline: function() {
        var e = this.getSettings();
        this.elements.$headline.hasClass(e.classes.letters) && this.singleLetters(),
        this.animateHeadline()
    },
    initHeadline: function() {
        var e = this.getElementSettings("headline_style");
        "rotate" === e ? this.rotateHeadline() : "highlight" === e && (this.addHighlight(),
        this.activateHighlightAnimation()),
        this.deactivateScrollListener()
    },
    activateHighlightAnimation: function() {
        var e = this
          , t = this.getSettings()
          , i = t.classes
          , n = this.elements.$headline;
        n.removeClass(i.hideHighlight).addClass(i.activateHighlight),
        this.isLoopMode && (setTimeout(function() {
            n.removeClass(i.activateHighligh).addClass(i.hideHighlight)
        }, t.highlightAnimationDuration + .8 * t.highlightAnimationDelay),
        setTimeout(function() {
            e.activateHighlightAnimation(!1)
        }, t.highlightAnimationDuration + t.highlightAnimationDelay))
    },
    activateScrollListener: function() {
        var t = this;
        this.intersectionObservers.startAnimation.observer = LeoScrollObserver({
            offset: "0px 0px ".concat(-100, "px"),
            callback: function(e) {
                e.isInViewport && t.initHeadline()
            }
        }),
        this.intersectionObservers.startAnimation.element = this.elements.$headline[0],
        this.intersectionObservers.startAnimation.observer.observe(this.intersectionObservers.startAnimation.element)
    },
    deactivateScrollListener: function() {
        this.intersectionObservers.startAnimation.observer.unobserve(this.intersectionObservers.startAnimation.element)
    },
    onInit: function() {
        elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments),
        this.intersectionObservers = {
            startAnimation: {
                observer: null,
                element: null
            }
        },
        this.isLoopMode = "yes" === this.getElementSettings("loop"),
        this.activateScrollListener()
    }
})
  , LeoSlidesHandler = elementorModules.frontend.handlers.Base.extend({
    getDefaultSettings: function() {
        return {
            selectors: {
                slider: ".elementor-slides-wrapper",
                slide: ".swiper-slide",
                slideInnerContents: ".swiper-slide-contents",
                activeSlide: ".swiper-slide-active",
                activeDuplicate: ".swiper-slide-duplicate-active"
            },
            classes: {
                animated: "animated",
                kenBurnsActive: "elementor-ken-burns--active",
                slideBackground: "swiper-slide-bg"
            },
            attributes: {
                dataSliderOptions: "slider_options",
                dataAnimation: "animation"
            }
        }
    },
    getDefaultElements: function() {
        var e = this.getSettings("selectors")
          , t = {
            $swiperContainer: this.$element.find(e.slider)
        };
        return t.$slides = t.$swiperContainer.find(e.slide),
        t
    },
    getSwiperOptions: function() {
        var e = this
          , t = this.getElementSettings()
          , i = {
            autoplay: this.getAutoplayConfig(),
            grabCursor: !0,
            initialSlide: this.getInitialSlide(),
            slidesPerView: 1,
            slidesPerGroup: 1,
            loop: "yes" === t.infinite,
            speed: t.transition_speed,
            effect: t.transition,
            observeParents: !0,
            observer: !0,
            handleElementorBreakpoints: !0,
            on: {
                slideChange: function() {
                    e.handleKenBurns()
                }
            }
        }
          , n = "arrows" === t.navigation || "both" === t.navigation
          , t = "dots" === t.navigation || "both" === t.navigation;
        return n && (i.navigation = {
            prevEl: ".elementor-swiper-button-prev",
            nextEl: ".elementor-swiper-button-next"
        }),
        t && (i.pagination = {
            el: ".swiper-pagination",
            type: "bullets",
            clickable: !0
        }),
        !0 === i.loop && (i.loopedSlides = this.getSlidesCount()),
        "fade" === i.effect && (i.fadeEffect = {
            crossFade: !0
        }),
        i
    },
    getAutoplayConfig: function() {
        var e = this.getElementSettings();
        return "yes" === e.autoplay && {
            stopOnLastSlide: !0,
            delay: e.autoplay_speed,
            disableOnInteraction: "yes" === e.pause_on_interaction
        }
    },
    initSingleSlideAnimations: function() {
        var e = this.getSettings()
          , t = this.elements.$swiperContainer.data(e.attributes.dataAnimation);
        this.elements.$swiperContainer.find("." + e.classes.slideBackground).addClass(e.classes.kenBurnsActive),
        t && this.elements.$swiperContainer.find(e.selectors.slideInnerContents).addClass(e.classes.animated + " " + t)
    },
    initSlider: function() {
        var e = this.elements.$swiperContainer
          , t = this.getSettings()
          , i = this.getElementSettings()
          , n = e.data(t.attributes.dataAnimation);
        this.swiper = new Swiper(e,this.getSwiperOptions()),
        e.data("swiper", this.swiper),
        this.handleKenBurns(),
        i.pause_on_hover && this.togglePauseOnHover(!0),
        this.swiper.on("slideChangeTransitionStart", function() {
            e.find(t.selectors.slideInnerContents).removeClass(t.classes.animated + " " + n).hide()
        }),
        this.swiper.on("slideChangeTransitionEnd", function() {
            e.find(t.selectors.slideInnerContents).show().addClass(t.classes.animated + " " + n)
        })
    },
    onInit: function() {
        elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments),
        this.getSlidesCount() < 2 ? this.initSingleSlideAnimations() : this.initSlider()
    },
    getChangeableProperties: function() {
        return {
            pause_on_hover: "pauseOnHover",
            pause_on_interaction: "disableOnInteraction",
            autoplay_speed: "delay",
            transition_speed: "speed"
        }
    },
    updateSwiperOption: function(e) {
        if (0 !== e.indexOf("width")) {
            var t = this.getElementSettings()
              , i = t[e]
              , n = this.getChangeableProperties()[e]
              , s = i;
            switch (e) {
            case "autoplay_speed":
                n = "autoplay",
                s = {
                    delay: i,
                    disableOnInteraction: "yes" === t.pause_on_interaction
                };
                break;
            case "pause_on_hover":
                this.togglePauseOnHover("yes" === i);
                break;
            case "pause_on_interaction":
                s = "yes" === i
            }
            "pause_on_hover" !== e && (this.swiper.params[n] = s),
            this.swiper.update()
        } else
            this.swiper.update()
    },
    onElementChange: function(e) {
        this.getSlidesCount() <= 1 || this.getChangeableProperties().hasOwnProperty(e) && this.updateSwiperOption(e)
    },
    onEditSettingsChange: function(e) {
        this.getSlidesCount() <= 1 || "activeItemIndex" === e && this.swiper.slideToLoop(this.getEditSettings("activeItemIndex") - 1)
    },
    getInitialSlide: function() {
        var e = this.getEditSettings();
        return e.activeItemIndex ? e.activeItemIndex - 1 : 0
    },
    getSlidesCount: function() {
        return this.elements.$slides.length
    },
    togglePauseOnHover: function(e) {
        var t = this;
        e ? this.elements.$swiperContainer.on({
            mouseenter: function() {
                t.swiper.autoplay.stop()
            },
            mouseleave: function() {
                t.swiper.autoplay.start()
            }
        }) : this.elements.$swiperContainer.off("mouseenter mouseleave")
    },
    handleKenBurns: function() {
        var e = this.getSettings();
        this.$activeImageBg && this.$activeImageBg.removeClass(e.classes.kenBurnsActive),
        this.activeItemIndex = this.swiper ? this.swiper.activeIndex : this.getInitialSlide(),
        this.swiper ? this.$activeImageBg = jQuery(this.swiper.slides[this.activeItemIndex]).children("." + e.classes.slideBackground) : this.$activeImageBg = jQuery(this.elements.$slides[0]).children("." + e.classes.slideBackground),
        this.$activeImageBg.addClass(e.classes.kenBurnsActive)
    }
});
jQuery(window).on("elementor/frontend/init", function() {
    elementorFrontend.hooks.addAction("frontend/element_ready/animated-headline.default", function(e, t) {
        elementorFrontend.elementsHandler.addHandler(LeoHeadLine, {
            $element: e
        })
    }),
    elementorFrontend.hooks.addAction("frontend/element_ready/slides.default", function(e, t) {
        elementorFrontend.elementsHandler.addHandler(LeoSlidesHandler, {
            $element: e
        })
    })
});
jQuery(document).ready(function() {
    void 0 !== opLeoElements.languages.length && $("[data-btn-lang]").each(function() {
        $(this).attr("href", opLeoElements.languages[$(this).data("btn-lang")])
    }),
    void 0 !== opLeoElements.currencies.length && $("[data-btn-currency]").each(function() {
        $(this).attr("href", opLeoElements.currencies[$(this).data("btn-currency")])
    })
});
