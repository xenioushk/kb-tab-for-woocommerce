/************************************************************
 * Filename: jquery.bwlaccordion.js
 * Title: BWL Searchable Accordion jQuery Plugin
 * Description: Custom jQuery code for BWL Searchable Accordion jQuery Plugin
 * Author: xenioushk
 * Author Page: http://codecanyon.net/user/xenioushk
 * Website: http://bluewindalb.net
 * Plugin URL: http://codecanyon.net/item/bwl-searchable-accordion-jquery-plugin/8184405?ref=xenioushk
 * Version: 1.0.7
 * Create Date: 04-07-2014	
 * Last Update: 14-04-2016	
 ************************************************************/


if ( typeof Object.create !== 'function' ) {
    
    Object.create = function ( obj ) {
        
        function F() {};
        F.prototype = obj;
        return new F();
    }
    
}


; (function( $, window, document, undefind ){

    var bwlAccordion = {
        
        init: function( options, elem ) {
            
           var self = this;
                 self.elem = elem;
                 self.$elem = $( elem );
                
            /*------------------------------ DEFAULT OPTIONS ---------------------------------*/
              
            this.options = $.extend ( {}, $.fn.bwlAccordion.config, options); // Override old sutff     
            
            /*------------------------------ Attach Pagination Navigation  ---------------------------------*/
              
              if( self.options.pagination ) {
                  var $acc_nav_html = '<input type="hidden" id="current_page"><input type="hidden" id="show_per_page"><div id="acc_page_navigation" class="acc_page_navigation" data-paginate="" data-pag_limit=""></div>';
                  self.$elem.append($acc_nav_html);
              }
            
            /*------------------------------ BIND ALL CLICK EVENTS  ---------------------------------*/
            
             var animation_class = self.get_animation_class();
             
                this.options.inAnimation = animation_class[0];
                
             if( this.options.rtl == true ) {
                 self.addRTLSupport();
             }   
             
             self.displayAccordion();
             
             self.displaySearchBox();
             
             var $acc_title_bar = self.$elem.find('.acc_title_bar');
             
             var $accordion_search_input_box = self.$elem.find('.accordion_search_input_box'); // search input box container
             
             
              if (this.options.ctrl_btn == true) {
                  
                //@since: 1.0.6
                //Added Exapand/Collapse All Button.

                var $acc_ctrl_html = '<p class="acc-ctrl-btn"><span class="acc-expand-all"><i class="fa fa-plus"></i></span><span class="acc-collapsible-all"><i class="fa fa-minus"></i></span></p>';
                self.$elem.find('section:first').before($acc_ctrl_html);
                this.options.acc_ctrl_btn = self.$elem.find('.acc-ctrl-btn');

            }
             
             if( this.options.nav_box != "" ) {
                 $acc_title_bar.addClass('nav_'+this.options.nav_box);
             }
             
             
             if( this.options.nav_icon != "" ) {
                 $acc_title_bar.addClass('nav_icon_'+this.options.nav_icon);
             }
             
             
             // Reset all search box :)
             
             $accordion_search_input_box.each(function(){
                 $(this).val("").attr("placeholder", self.options.placeholder);
                 
                 if(self.options.rtl == true ) {
                     $(this).after('<span class="rtl_clear_btn"></span>');
                 } else {
                     $(this).after('<span class="acc_clear_btn"></span>');
                 }
                 
                 
             });
             
             
             // Attach Search Keyup Event.

            var theme_class= self.getThemeClasses( self.options.theme );
                  self.searchEvent( theme_class, animation_class );
             
             $acc_title_bar.on("click", function(){
                 
                 self.toggleEvent( $(this), theme_class, animation_class, self.$elem );
                 return false;
                
            });
            
            // Clear Button Event.
            var $acc_clear_btn;
            
            if(self.options.rtl == true ) {
                $acc_clear_btn = self.$elem.find('.rtl_clear_btn');
            } else {
                $acc_clear_btn = self.$elem.find('.acc_clear_btn');
            }
            $acc_clear_btn.on("click", function(){
                $(this).removeAttr("style");
                var $baf_section = self.$elem,
                     $accordion_search_input_box = $baf_section.find('.accordion_search_input_box');
                     $accordion_search_input_box.val("").attr("placeholder", self.options.placeholder);
                     self.removeHighlightEvent();
                     self.resetAccordion($baf_section, theme_class, animation_class);
                     
            });
            
            // Expand/Collapse Button Event.
            // @Since: 1.0.6
            
             if (this.options.ctrl_btn == 1) {
            
                var $acc_expand_all = self.$elem.find('.acc-expand-all'),
                       $acc_collapsible_all = self.$elem.find('.acc-collapsible-all');

                // Expand Event.
                
                $acc_expand_all.on("click", function () {
                    
                    self.$elem.find('section').each(function () {

                        $(this).find(".acc_title_bar").addClass(theme_class.title_active_class).slideDown();

                        $(this).find('.acc_container').slideDown(function () {
                            $(this).find(".block").css({
                                'opacity': 1
                            }).addClass(animation_class[0]);
                        });

                    });

                });

                // Collapse Event.
                
                $acc_collapsible_all.on("click", function () {

                    self.$elem.find('section').each(function () {

                        $(this).find(".acc_title_bar").removeClass(theme_class.title_active_class).slideDown();

                        $(this).find('.acc_container').slideUp(function () {

                            $(this).find(".block").css({
                                'opacity': 0
                            }).removeClass(animation_class[0]);

                        });

                    });

                });
          
             }
             
        },
        
        addRTLSupport: function(){
            
            var self = this;
            
                  self.$elem.addClass( 'bwl_acc_container_rtl_support' );
                  self.$elem.find('.acc_title_bar').addClass( 'rtl-title-bar' );
                  self.$elem.find('.accordion_search_input_box').addClass( 'search_icon_rtl' );
        },
        
        displaySearchBox: function(){
            
           var self = this;
           
           if ( self.options.search == false ) {
                self.$elem.find('.accordion_search_container').remove();
           } else {
                self.$elem.find('.accordion_search_container').css({
                    display: 'block'
                });
           }
           
        },
        
        displayAccordion: function() {
            
            var self = this;
                
                //set theme.
//                console.log("Pagination Status: "+self.options.pagination);
//                console.log("Pagination Limit: "+self.options.limit);
                var theme_class= self.getThemeClasses( self.options.theme );
                    
                // Add Theme Classes.
                self.$elem.find('.acc_title_bar').addClass( theme_class.title_bar_class ); 
                
                //Set default open/close settings
                self.$elem.find('.acc_container').slideUp(100); //Hide/close all containers
               
                self.$elem.find('.acc_container').find(".block").css({
                        'opacity': 1
                    }).addClass(self.options.inAnimation);
                 
                // Added in version 1.0.6
                if(self.options.closeall == false ) {
                 
                    self.$elem.find('.acc_title_bar:first').addClass( theme_class.title_active_class ).next().slideDown(700); //Add "active" class to first title_bar, then show/open the immediate next container
                }
                
                // Pagination Theme
                if( self.options.pagination ) {
                    self.$elem.find('.acc_page_navigation').addClass( theme_class.nav_class ); 
                }
                
                if( self.options.pagination ) {
                
                    var $baf_item_per_page_val = self.$elem.find('.acc_container').size(); // get all Items
                    var $baf_section = self.$elem;
                    var show_per_page = self.options.limit;
                    var number_of_items = $baf_item_per_page_val;

                    $baf_section.find('.acc_page_navigation').attr('data-paginate', self.options.pagination);
                    $baf_section.find('.acc_page_navigation').attr('data-pag_limit', self.options.limit);
                    self.baf_get_pagination_html($baf_section, show_per_page, number_of_items);
                
                }
                
                
                
        },
        
        baf_get_pagination_html: function ($baf_section, show_per_page, number_of_items, baf_search) {
            
            var self = this;
            
            // show_per_page == start_on
            // number_of_items = end_on
            
            
            
            var $baf_paginate_status = $baf_section.find('.acc_page_navigation').data('paginate');
            
//            console.log("Container: " + $baf_section);
//            console.log("Search Per Page: " + show_per_page);
//            console.log("Total Number Of Items: " + number_of_items);
//            console.log("Pagination Status: "+$baf_paginate_status);
//            console.log("Search Status: "+baf_search);
            
            var baf_display_limit = 10;
            var string_singular_page = "Page";
            var string_plural_page = "Pages";
            var string_total = "Total";
            
            
            if( typeof(baf_search) != 'undefined' && baf_search == 1 ) {
                
                if( $baf_paginate_status == 1 ) {
                    
//                    var $searched_faq_items = $baf_section.find("div.bwl-faq-container:visible");
                    var $searched_faq_items = $baf_section.find("section.filter");
//                    console.log("Searching....");
//                    $searched_faq_items.addClass("filter");

                    var total_faq_items = $searched_faq_items.size();
                    var number_of_items = number_of_items;
                    var $items_need_to_show = $searched_faq_items.slice(0, show_per_page);
                    var $items_need_to_hide = $searched_faq_items.slice(show_per_page, total_faq_items);
                    $items_need_to_hide.css('display', 'none');
                    
                }
                
                $baf_section.find("input[type=text]").removeClass('search_load').addClass('search_icon');
                
            } else {
            
                //getting the amount of elements inside content div
            
//                $baf_section.find("div.bwl-faq-container").css('display', 'none');
                $baf_section.find("section").css('display', 'none');

                //and show the first n (show_per_page) elements
                $baf_section.find("section").slice(0, show_per_page).css('display', 'block');    
                
                var number_of_items = $baf_section.find("section").size();
                
            }
           
            //calculate the number of pages we are going to have
            var number_of_pages = Math.ceil(number_of_items / show_per_page);

            //set the value of our hidden input fields
            $baf_section.find('#current_page').val(0);
            $baf_section.find('#show_per_page').val(show_per_page);
            //now when we got all we need for the navigation let's make it '

            /*
             what are we going to have in the navigation?
             - link to previous page
             - links to specific pages
             - link to next page
             */
            var navigation_html = '<a class="previous_link" href="#"><i class="fa fa-angle-left"></i></a>';
            var current_link = 0;
            
            var page_array = [];
            var display_none_class = "";
            var acc_pages_string = string_singular_page;
            while (number_of_pages > current_link) {
                
                page_array[current_link] = current_link;
 
                if( number_of_pages > baf_display_limit && current_link >= baf_display_limit ) {
                    display_none_class = " baf_dn";
                }
                
                navigation_html += '<a class="page_link'+display_none_class+'" href="#" longdesc="' + current_link + '">' + (current_link + 1) + '</a>';
                current_link++;
            }
            
            if( number_of_pages > 1 ) {
                acc_pages_string = string_plural_page;
            }
            
            navigation_html += '<a class="next_link" href="#"><i class="fa fa-angle-right"></i></a><br /><span class="total_pages">' + string_total + ' ' +number_of_pages+' ' + acc_pages_string +'</span>';
            
            $baf_section.find('#acc_page_navigation').html("").html(navigation_html);
            
            if ( $baf_paginate_status == 0 ) {
                $baf_section.find('#acc_page_navigation').remove();
            }
            
            if( page_array.length == 0 ) {
                $baf_section.find('#acc_page_navigation').css("display", "none");
            } else {
                $baf_section.find('#acc_page_navigation').css("display", "block");
            }
            
            //add active_page class to the first page link
            $baf_section.find('#acc_page_navigation .page_link:first').addClass('active_page');
            
            $baf_section.find(".next_link").on("click", function(){

                var new_page = parseInt($baf_section.find('#current_page').val()) + 1;
                
                //if there is an item after the current active link run the function
                
                var $active_page = $baf_section.find('.active_page').next('.page_link');
                
                if ( $active_page.length == true) {
                    
                    if ( $active_page.hasClass('baf_dn') ) {
                        
                        $active_page.removeClass('baf_dn');
                        
                        var total_link_need_to_hide = parseInt( $baf_section.find('a.page_link:visible').length ) - baf_display_limit;
                        
                        $baf_section.find('a.page_link:visible').slice(0, total_link_need_to_hide).addClass('baf_dn');
                        
                    }
                    
                    self.baf_go_to_page($baf_section, new_page);
                }
                return false;
            });
            
            $baf_section.find(".previous_link").on("click", function(){

                var new_page = parseInt($baf_section.find('#current_page').val()) - 1;
                //if there is an item before the current active link run the function
                
                var $active_page = $baf_section.find('.active_page').prev('.page_link');
                var number_of_items = $baf_section.find("div.bwl-faq-container").size();
                var start = parseInt( $baf_section.find('a.page_link:visible:first').attr('longdesc') ) -1;
               
                var end = $baf_section.find('a.page_link:visible:last').attr('longdesc');
             
                
                if ($active_page.length == true) {
                    
                    if ( start > -1 && end < number_of_items ) {
                 
                        $baf_section.find('a.page_link').addClass('baf_dn');
                        $baf_section.find('a.page_link').slice(start, end).removeClass('baf_dn');
                        
                    }
                    
                    self.baf_go_to_page($baf_section, new_page);
                }
                return false;
            });
            
            $baf_section.find('.page_link').on("click", function(){
                
                var current_link= $(this).attr('longdesc');
                
                    self.baf_go_to_page($baf_section, current_link);
                    return false;
            });
            
        },

        baf_go_to_page: function($baf_section, page_num) {
//            console.log("Holla");
//            console.log("Go To Page Search Status: "+search_status);
            var search_status = 0;

            if( $baf_section.find("input[type=text]").length && $baf_section.find("input[type=text]").val().length > 1 ) {
                search_status = 1;
            }

            var show_per_page = parseInt($baf_section.find('#show_per_page').val());

            //get the element number where to start the slice from
            var start_from = page_num * show_per_page;

            //get the element number where to end the slice
            var end_on = start_from + show_per_page;

            if( search_status == 1 ) {
                
                $baf_section.find("section.filter").css('display', 'none').slice(start_from, end_on).css('display', 'block');
                
            } else {
                
                $baf_section.find("section").css('display', 'none').slice(start_from, end_on).css('display', 'block');
                
            }

            /*get the page link that has longdesc attribute of the current page and add active_page class to it
             and remove that class from previously active page link*/
            $baf_section.find('.page_link[longdesc=' + page_num + ']').addClass('active_page').siblings('.active_page').removeClass('active_page');

            //update the current page input field
            $baf_section.find('#current_page').val(page_num);
        },
        
        getThemeClasses: function( theme_name ) {
            
            var self = this;
            
            var rtl_support_class = "";
            var nav_icon_active_class = "";
            
            if( self.options.nav_icon != "" ) {
                 nav_icon_active_class = ' nav_icon_'+self.options.nav_icon+'_active';
             }
            
             if( this.options.rtl == true ) {
                 rtl_support_class += " rtl-title-active";
             }
           
            if ( theme_name == 'theme-red' ){
                return {
                     'title_bar_class': 'theme-red-title-bar',
                     'title_active_class' : 'theme-red-title-active' + nav_icon_active_class + rtl_support_class,
                     'nav_class' : 'red_theme_nav'
                };
            } else if ( theme_name == 'theme-green' ){
                return {
                     'title_bar_class': 'theme-green-title-bar',
                     'title_active_class' : 'theme-green-title-active'+ nav_icon_active_class + rtl_support_class,
                     'nav_class' : 'green_theme_nav'
                };
            } else if ( theme_name == 'theme-blue' ){
                return {
                     'title_bar_class': 'theme-blue-title-bar',
                     'title_active_class' : 'theme-blue-title-active'+ nav_icon_active_class + rtl_support_class,
                     'nav_class' : 'blue_theme_nav'
                };
            } else if ( theme_name == 'theme-orange' ){
                return {
                     'title_bar_class': 'theme-orange-title-bar',
                     'title_active_class' : 'theme-orange-title-active'+ nav_icon_active_class + rtl_support_class,
                     'nav_class' : 'orange_theme_nav'
                };
            } else if ( theme_name == 'theme-yellow' ){
                return {
                     'title_bar_class': 'theme-yellow-title-bar',
                     'title_active_class' : 'theme-yellow-title-active'+ nav_icon_active_class + rtl_support_class,
                     'nav_class' : 'yellow_theme_nav'
                };
            } else {
                return {
                     'title_bar_class': 'default-title-bar',
                     'title_active_class' : 'default-title-bar-active'+ nav_icon_active_class + rtl_support_class,
                     'nav_class' : 'default_theme_nav'
                };
            }
            
        },
        
        get_animation_class: function() {

            var self = this;

            var inAnimation = "animated ";

            if (self.options.animation == "flash") {
                 
                inAnimation += 'flash';

            } else if (self.options.animation == "shake") {
                
                inAnimation += 'shake';

            } else if (self.options.animation == "tada") {
                
                inAnimation += 'tada';

            } else if (self.options.animation == "swing") {
              
                inAnimation += 'swing';

            } else if (self.options.animation == "wobble") {
                
                inAnimation += 'wobble';

            } else if (self.options.animation == "pulse") {

                inAnimation += 'pulse';

            } else if (self.options.animation == "flipx") {

                inAnimation += 'flipInX';

            } else if (self.options.animation == "faderight") {
                
                inAnimation += 'fadeInLeft';

            } else if (self.options.animation == "fadeleft") {
                
                inAnimation += 'fadeInRight';

            } else if (self.options.animation == "slide") {
                
                inAnimation += 'slideInRight';

            } else if (self.options.animation == "slideup") {
                
                inAnimation += 'slideInDown';

            } else if (self.options.animation == "bounce") {
                
                inAnimation += 'bounceIn';

            } else if (self.options.animation == "lightspeed") {
                inAnimation += 'lightSpeedIn';

            } else if (self.options.animation == "roll") {
                
                inAnimation += 'rollIn';

            } else if (self.options.animation == "rotate") {
                
                inAnimation += 'rotateIn';

            } else if (self.options.animation == "fade") {
                
                inAnimation += 'fadeInDown';

            } else if (self.options.animation == "none") {
                
                inAnimation = '';

            } else {
                
                inAnimation += 'fadeIn';

            }

            return [inAnimation];

        },
        
        toggleEvent: function( parent , theme_class, animation_class, elem) {
          
            var self= this;
           
            var toggle_status = self.options.toggle;
            
            var self = parent;
            
            if ( self.hasClass( theme_class.title_active_class ) ) {

                self.toggleClass( theme_class.title_active_class ).next().slideUp(function() {

                    $(this).find(".block").css({
                        'opacity': 0
                    }).removeClass( animation_class[0] );

                });

            }
            
            if ( toggle_status == true ) {
                
                var allAccordionBlocks = elem.find('.acc_container');
                var allAccordionTitles = elem.find('.acc_title_bar');
          
                allAccordionTitles.removeClass( theme_class.title_active_class );
                allAccordionBlocks.slideUp(function() {
                   $(this).find(".block").css({
                        'opacity': 0
                    }).removeClass( animation_class[0] );

                });
                 
            }
            
            
            if (self.next().is(':hidden')) { //If immediate next container is closed...

                self.removeClass( theme_class.title_active_class ).next().slideUp(function() {

                   $(this).find(".block").css({
                        'opacity': 0
                    }).removeClass( animation_class[0] );

                });

                self.toggleClass( theme_class.title_active_class ).next().slideDown(function() {
                    $(this).find(".block").css({
                        'opacity': 1
                    }).addClass( animation_class[0] );
                });

            }
            
        },
        
        searchEvent: function( theme_class, animation_class ){
            
            var self = this;
            var filter_timeout,
                  remove_filter_timeout,  
                  acc_live_search,
                  $acc_clear_btn,
                  search_result_container = self.$elem.find(".search_result_container");
            var $accordion_search_input_box = self.$elem.find('.accordion_search_input_box'); // search input box container
            var $baf_section = self.$elem;
            
            if(self.options.rtl == true ) {
                $acc_clear_btn = $baf_section.find('.rtl_clear_btn');
            } else {
                $acc_clear_btn = $baf_section.find('.acc_clear_btn');
            }
            
            var search_icon_rtl = "",
                  load_rtl = "";
            
            if( self.options.rtl == true ) {
                search_icon_rtl += " search_icon_rtl";
                 load_rtl += " load_rtl";
             }   
            
            
            $accordion_search_input_box.on("keyup", function(){
                   
                    
                    acc_live_search = $(this);

                    acc_live_search.addClass( 'load' + load_rtl );
                    
                    clearTimeout(remove_filter_timeout);
                    
                    clearTimeout(filter_timeout);
                    
                    var search_keywords = $.trim( acc_live_search.val() );
                    
                    if( search_keywords.length == 0 ) {
                         $acc_clear_btn.removeAttr("style");
                    }
                    
                    if ( search_keywords.length < 2 ) {
                        
                        acc_live_search.removeClass( 'load' + load_rtl );
                        self.$elem.find('section').removeAttr('class');
                        
                        if (self.options.closeall) {
                    
                            // Close All Accordion Section.
                            // @Since: 1.0.6

                            self.$elem.find(".acc_title_bar").removeClass(theme_class.title_active_class).slideDown();
                            self.$elem.find('.acc_container').slideUp(function () {

                                $(this).find(".block").css({
                                    'opacity': 0
                                }).removeClass(animation_class[0]);

                            });

                        } else {

                            self.$elem.find(".acc_title_bar:first").addClass( theme_class.title_active_class ).slideDown();

                            self.$elem.find('.acc_container:first').slideDown(function() {
                                $(this).find(".block").css({
                                    'opacity': 1
                                }).addClass( animation_class[0] );
                            });

                            self.$elem.find(".acc_title_bar:not(:first)").removeClass( theme_class.title_active_class ).slideDown();

                            self.$elem.find('.acc_container:not(:first)').slideUp(function() {

                                $(this).find(".block").css({
                                    'opacity': 0
                                }).removeClass( animation_class[0] );

                            });

                        }

                        search_result_container.slideUp();
                      
                        // For Controll
                        if ( self.options.ctrl_btn == true ) {
                            self.options.acc_ctrl_btn.slideDown();
                        }
                        
                        // For Pagnation.
                        if ( self.options.pagination ) {
                            self.baf_get_pagination_html($baf_section, self.options.limit);
                        }

                    }
                    
                    remove_filter_timeout = ( search_keywords.length < 2 ) && setTimeout(function() {
                        
                        self.removeHighlightEvent();
                        
                    }, 0);
                    

                    filter_timeout = ( search_keywords.length >= 2 ) && setTimeout(function() {

                        var count = 0;
//                        console.log("goo");
                        self.removeHighlightEvent();

                        self.$elem.find(".acc_title_bar").each(function() {
                            
                            var acc_heading = $(this).find('a');
                            var acc_container = $(this).next(".acc_container").find("*");

                            var search_string = $(this).text() + $(this).next(".acc_container").text();
                                
                            /*------------------------------  Start New Code---------------------------------*/
//                                setTimeout(function(){
                                    self.highlightEvent(acc_heading, search_keywords);
                                    self.highlightEvent(acc_container, search_keywords);
//                                },700);
                                
                            
                            /*------------------------------End New Code  ---------------------------------*/

                            if (search_string.search(new RegExp(search_keywords, "gi")) < 0) {

                                $(this).removeClass( theme_class.title_active_class ).slideUp();

                                $(this).next().removeClass( theme_class.title_active_class ).slideUp(function() {

                                    $(this).find(".block").css({
                                        'opacity': 0
                                    }).removeClass( animation_class[0] );
                                    
                                });
                                
                                // For Pagination.
                                if ( self.options.pagination ) {
                                    $(this).next().parent('section').removeAttr("class");
                                }

                            } else {
                                
                                self.highlightEvent(acc_heading, search_keywords);
                                self.highlightEvent(acc_container, search_keywords);
                                
                                $(this).addClass( theme_class.title_active_class ).slideDown();
                                $(this).next().addClass( theme_class.title_active_class ).slideDown(function() {
                                    $(this).find(".block").css({
                                        'opacity': 1
                                    }).addClass( animation_class[0] );
                                });
                                
                                // For Pagination.
                                if ( self.options.pagination ) {
                                
                                    $(this).next().parent('section').addClass("filter");
                                
                                }
                                
                                count++;
                                
                            }

                        });

                        if ( count == 0 ) {
                            
                            $acc_clear_btn.css({
                                'display' : 'inline-block'
                            });
                            
                            search_result_container.html( self.options.msg_no_result ).slideDown(function(){
                            
                                // For Controll Button
                                if ( self.options.ctrl_btn == true ) {
                                    self.options.acc_ctrl_btn.slideUp();
                               }
                               
                            });
                            
                            
                            // For Pagination.
                            if (self.options.pagination) {
                                self.baf_get_pagination_html($baf_section, self.options.limit, count, 1);
                            }
                            
                        } else {
                            
                            $acc_clear_btn.css({
                                'display' : 'inline-block'
                            });
                            
                            //Fixed in version 1.0.7
                            var item_found_count = self.$elem.find("i.highlight").length;
                            
                            search_result_container.html( item_found_count + self.options.msg_item_found).slideDown();
                            
                            // For Pagination.
                            if (self.options.pagination) {
                                setTimeout(function(){

                                    $baf_section.find('section.filter').css({
                                        'display': 'block'
                                    });

                                    self.baf_get_pagination_html($baf_section, self.options.limit,count,1);
                                }, 200);
                            }
                            
                            
                        }

                        acc_live_search.removeClass( 'load' + load_rtl );
                        acc_live_search.addClass( 'search_icon' + search_icon_rtl );

                    }, 200);
                 
             });
            
        },
        
        
        resetAccordion: function( $baf_section, theme_class, animation_class ) {
            
            var self = this;
            
            var search_result_container = $baf_section.find(".search_result_container");
            
//                acc_live_search.removeClass('load' + load_rtl);
                self.$elem.find('section').removeAttr('class');

                if (self.options.closeall) {
                    
                    // Close All Accordion Section.
                    // @Since: 1.0.6
                    
                    self.$elem.find(".acc_title_bar").removeClass(theme_class.title_active_class).slideDown();
                    self.$elem.find('.acc_container').slideUp(function () {

                        $(this).find(".block").css({
                            'opacity': 0
                        }).removeClass(animation_class[0]);

                    });
                    
                } else {
                    
                    // Only open the first section of accordion.
                    // @Since: 1.0.0
                    self.$elem.find(".acc_title_bar:first").addClass(theme_class.title_active_class).slideDown();

                    self.$elem.find('.acc_container:first').slideDown(function() {
                        $(this).find(".block").css({
                            'opacity': 1
                        }).addClass(animation_class[0]);
                    });

                    self.$elem.find(".acc_title_bar:not(:first)").removeClass(theme_class.title_active_class).slideDown();

                    self.$elem.find('.acc_container:not(:first)').slideUp(function() {

                        $(this).find(".block").css({
                            'opacity': 0
                        }).removeClass(animation_class[0]);

                    });
                    
                }
                    

                search_result_container.slideUp(function(){
                    
                     if ( self.options.ctrl_btn == true ) {
                        self.options.acc_ctrl_btn.slideDown();
                    }
                    
                });

                if (self.options.pagination) {
                    self.baf_get_pagination_html($baf_section, self.options.limit);
                }
        },
        
        highlightEvent: function(acc_content, search_keywords) {
            
            var self = this;
            var regex = new RegExp(search_keywords, "gi");
            
            // Fixed in 1.0.4 version.
                
            acc_content.highlightRegex(regex, {
                highlight_color: self.options.highlight_color,
                highlight_bg: self.options.highlight_bg
            });
            
        },
        
        removeHighlightEvent: function() {
            
            var self = this;
            
            self.$elem.find('i.highlight').each(function(){

                    $(this).replaceWith( $(this).text() );    

            });
            
        }
        
    };
    
    // Initialization Of Plugin

    $.fn.bwlAccordion = function( options ) {
        
        return this.each(function(){
           
            var bwlaccordion=  Object.create( bwlAccordion );
                  bwlaccordion.init( options, this );
            
        });
        
    };
    
    // Default Options Setion.
    
    $.fn.bwlAccordion.config = {
        search: true, // true/false
        placeholder: 'Search .....', // You can write any thing as a placeholder text
        theme: 'default', // theme-red/theme-blue/theme-green/theme-orange/theme-yellow
        animation: 'fade', // flash/shake/tada/swing/wobble/pulse/flipx/faderight/fadeleft/slide/slideup/bounce/lightspeed/roll/rotate/fade/none,
        rtl: false,
        msg_item_found : ' Item(s) Found !',
        msg_no_result : 'Nothing Found !',
        ctrl_btn : false, //Display expand all/ collapse all button.
        toggle: false, //Turn it on, If you want to open only one section and keep other section collapsed.
        closeall: true, // Closed all the section on initialization( Added in version 1.0.6),
        nav_box: '', // cross/square/arrow/circle (default: cross)
        nav_icon: '', // plus/angle/angle_double/angle_caret/angle_chevron (default: plus)
        highlight_bg: "#FFFF80", // founded item background color
        highlight_color: '#000000', // founded item text color.
        pagination: false, // pagination status.
        limit: 2 // item per page.
    };
    
})( jQuery, window, document);


/*
 * Highlight Scripts
 */

;
(function($) {

    var normalize = function(node) {
        if (!(node && node.childNodes))
            return

        var children = $.makeArray(node.childNodes)
                , prevTextNode = null

        $.each(children, function(i, child) {
            if (child.nodeType === 3) {
                if (child.nodeValue === "") {

                    node.removeChild(child)

                } else if (prevTextNode !== null) {

                    prevTextNode.nodeValue += child.nodeValue;
                    node.removeChild(child)

                } else {

                    prevTextNode = child

                }
            } else {
                prevTextNode = null

                if (child.childNodes) {
                    normalize(child)
                }
            }
        })
    }


    $.fn.highlightRegex = function(regex, options) {

        if (typeof regex === 'object' && !(regex.constructor.name == 'RegExp' || regex instanceof RegExp)) {
            options = regex
            regex = undefined
        }

        if (typeof options === 'undefined')
            options = {}

        options.className = options.className || 'highlight'
        options.tagType = options.tagType || 'i'
        options.highlight_color = options.highlight_color || ''
        options.highlight_bg = options.highlight_bg || ''
        options.attrs = options.attrs || {}

        if (typeof regex === 'undefined' || regex.source === '') {

            $(this).find(options.tagType + '.' + options.className).each(function() {

                $(this).replaceWith($(this).text())

                normalize($(this).parent().get(0))

            })

        } else {

            $(this).each(function() {

                var elt = $(this).get(0)
                
                normalize(elt);

                $.each($.makeArray(elt.childNodes), function(i, searchnode) {

                    var spannode, middlebit, middleclone, pos, match, parent

                    normalize(searchnode)

                    if (searchnode.nodeType == 3) {

                        // don't re-highlight the same node over and over
                        if ($(searchnode).parent(options.tagType + '.' + options.className).length) {
                            return;
                        }

                        while (searchnode.data &&
                                (pos = searchnode.data.search(regex)) >= 0) {

                            match = searchnode.data.slice(pos).match(regex)[ 0 ]

                            if (match.length > 0) {
                                

                                spannode = document.createElement(options.tagType)
                                spannode.className = options.className;
                                spannode.style.backgroundColor=options.highlight_bg;
                                spannode.style.color = options.highlight_color;
                                $(spannode).attr(options.attrs);

                                parent = searchnode.parentNode;
                                middlebit = searchnode.splitText(pos)
                                searchnode = middlebit.splitText(match.length)
                                middleclone = middlebit.cloneNode(true)

                                spannode.appendChild(middleclone)
                                parent.replaceChild(spannode, middlebit)

                            } else
                                break
                        }

                    } else {

                        $(searchnode).highlightRegex(regex, options)

                    }
                })
            })
        }

        return $(this)
    }
})(jQuery);