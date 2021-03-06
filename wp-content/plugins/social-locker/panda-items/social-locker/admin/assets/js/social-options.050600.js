if ( !window.bizpanda ) window.bizpanda = {};
if ( !window.bizpanda.socialOptions ) window.bizpanda.socialOptions = {};

(function($){
    
    window.bizpanda.socialOptions = {
        
        init: function() {
            var self = this;
            this.item = $('#opanda_item').val();
            
            this.initSocialTabs();
            this.initButtonStyles();
            this.lockPremiumFeatures();
            
            $.bizpanda.filters.add('opanda-preview-options', function( options ){
                var extraOptions = self.getSocialOptions();
                return $.extend(true, options, extraOptions);
            });
        },

        /**
         * Inits options for styling buttons.
         */
        initButtonStyles: function() {
            var self = this;

            this.$buttonsDisplay = $('#opanda_social_buttons_display_select');
            this.$buttonsSize = $('#opanda_social_buttons_size_select');
            this.$buttonsCounters = $('#opanda_social_buttons_counters_select');

            this.$buttonsDisplayInput = $('#opanda_social_buttons_display');
            this.$buttonsSizeInput = $('#opanda_social_buttons_size');
            this.$buttonsCountersInput = $('#opanda_social_buttons_counters');

            var selectedDisplay = this.$buttonsDisplayInput.val();
            var selectedSize = this.$buttonsSizeInput.val();
            var selectedCounters = this.$buttonsDisplayInput.val();

            if ( selectedDisplay ) {
                this.$buttonsDisplay.find('option[value="' + selectedDisplay + '"]').prop('selected', 'selected');
            }

            if ( selectedSize ) {
                this.$buttonsSize.find('option[value="' + selectedSize + '"]').prop('selected', 'selected');
            }

            if ( selectedCounters ) {
                this.$buttonsCounters.find('option[value="' + selectedCounters + '"]').prop('selected', 'selected');
            }

            this.$theme = $('#opanda_style');

            this.$theme.change(function(){
                self.updateAvailableButtonStyles( true );
            });

            self.updateAvailableButtonStyles();

            this.$buttonsDisplay.change(function(){

                var value = self.$buttonsDisplay.val();

                if ( $.inArray( value, ['native', 'covers-native'] ) >= 0 ) {
                    $('.opanda-social-buttons-counters-wrap').fadeIn();
                } else {
                    $('.opanda-social-buttons-counters-wrap').hide();
                }

                if ( $.inArray( value, ['covers'] ) >= 0 ) {
                    $('.opanda-social-buttons-size-wrap').fadeIn();
                } else {
                    $('.opanda-social-buttons-size-wrap').hide();
                }

                $('#opanda_social_buttons_display').val( value );
            });

            this.$buttonsSize.change(function(){
                var value = self.$buttonsSize.val();
                $('#opanda_social_buttons_size').val( value );
            });

            this.$buttonsCounters.change(function(){
                var value = self.$buttonsCounters.val();
                $('#opanda_social_buttons_counters').val( value );
            });

            this.$buttonsDisplay.change();
        },

        /**
         * Updates the list of available styles of the buttons.
         */
        updateAvailableButtonStyles: function( styleIsChanged ) {
            var $selectedThemeOption = this.$theme.find('option:selected');

            var allowedDisplay =  $selectedThemeOption.data('socialbuttonsalloweddisplay');
            if ( allowedDisplay ) allowedDisplay = allowedDisplay.split(',');

            var defaultDisplay = $selectedThemeOption.data('socialbuttonsdefaultdisplay');
            if ( !defaultDisplay ) defaultDisplay = 'native';

            var $options = this.$buttonsDisplay.find('option');
            var selectedDisplay = this.$buttonsDisplayInput.val();

            var isSelectionHidden = false;
            var firstVisibleValue = null;

            $options.each(function( ){
                var $option = $(this);
                var value = $option.val();

                if ( !allowedDisplay || $.inArray( value, allowedDisplay ) >= 0 ) {
                    $option.show();
                    if ( !firstVisibleValue ) firstVisibleValue = value;
                } else {
                    if ( selectedDisplay == value ) {
                        isSelectionHidden = true;
                    }
                    $option.hide();
                }
            });

            var isSelectedEmpty = !selectedDisplay;

            var valueToSelect = ( styleIsChanged ) ? defaultDisplay : firstVisibleValue;
            if ( isSelectedEmpty ) valueToSelect = defaultDisplay;

            if ( isSelectionHidden || styleIsChanged  || isSelectedEmpty ) {
                this.$buttonsDisplay.find('option[value="' + valueToSelect + '"]').prop('selected', 'selected');
                this.$buttonsDisplayInput.val(valueToSelect);
                this.$buttonsDisplay.change();
            }
        },

        /**
         * Inits social tabs.
        */
        initSocialTabs: function() {
            var self = this;
            var socialTabWrap = $(".factory-align-vertical .nav-tabs");
            var socialTabItem = $(".factory-align-vertical .nav-tabs li");

            $(".factory-align-vertical .nav-tabs li").click(function(){
                $(".opanda-overlay-tumbler-hint").hide().remove();                    
            });

            // current order

            var currentString = $("#opanda_buttons_order").val();
            if (currentString) {

                var currentSet = currentString.split(',');
                var originalSet = {};

                socialTabItem.each(function(){
                    var tabId = $(this).data('tab-id');
                    originalSet[tabId] = $(this).detach();
                });

                for(var index in currentSet) {
                    var currentId = currentSet[index];
                    socialTabWrap.append(originalSet[currentId]);
                    delete originalSet[currentId];
                }

                for(var index in originalSet) {
                    socialTabWrap.append(originalSet[index]);
                }

                $(function(){
                    $(socialTabWrap.find("li a").get(0)).tab('show');
                });
            }

            // make shortable
            $(".factory-align-vertical .nav-tabs").addClass("ui-sortable");
            $(".factory-align-vertical .nav-tabs").sortable({
                placeholder: "sortable-placeholder",
                opacity: 0.7,
                items: "> li",
                update: function(event, ui) {
                   self.updateButtonOrder();
                }
            });  

            socialTabWrap.find('li').each(function(){
                var tabId = $(this).data('tab-id');
                var item = $(this);
                var checkbox = $("#opanda_" + tabId + "_available");              

                checkbox.change(function(){
                    var isAvailable = checkbox.is(':checked'); 

                    if (!isAvailable) {
                        item.addClass('factory-disabled');
                    } else {
                        item.removeClass('factory-disabled');
                    }

                    self.updateButtonOrder();
                }).change();
            });

            // hides/shows the option "Message To Share" of the Facebook Share button

            $("#opanda_facebook_share_dialog").change(function(){
                var checked = $(this).is(":checked");
                if ( checked ) {
                    $("#factory-form-group-message-to-share").hide();
                } else {
                    $("#factory-form-group-message-to-share").fadeIn();
                }
            }).change();                
        },

        updateButtonOrder: function(value) {

            if (!value) {

                var socialTabWrap = $(".factory-align-vertical .nav-tabs");

                var resultArray = [];
                socialTabWrap.find('li:not(.sortable-placeholder):not(.factory-disabled)').each(function(){
                    var tabId = $(this).data('tab-id');

                    if ( window['sociallocker-next-build'] === 'free' && $.inArray( tabId, ['facebook-like', 'twitter-tweet', 'google-plus']) >= 0 ) {
                        resultArray.push( tabId );
                    } else if ( window['sociallocker-next-build'] !== 'free'  ) {
                        resultArray.push( tabId );
                    }
                    
                });
                var result = resultArray.join(',');

                $("#opanda_buttons_order").val(result).change();
            }
        },

        getSocialOptions: function() {
            var buttons = $("#opanda_buttons_order").val();

            var options = {

                groups: {
                    order: ['social-buttons']
                },

                socialButtons: {

                    counters: parseInt( $("#opanda_social_buttons_counters").val() ),

                    display: $("#opanda_social_buttons_display").val(),
                    coversSize: $("#opanda_social_buttons_size").val(),

                    order: buttons ? buttons.split(",") : buttons,

                    facebook: {
                        appId: window.opanda_facebook_app_id,
                        lang: window.opanda_lang,
                        version: window.opanda_facebook_version,
                        like: {
                            socialProxy: window.facebook_like_social_proxy,
                            url: $("#opanda_facebook_like_url").val(),
                            title: $("#opanda_facebook_like_title").val()
                        },
                        share: {
                            socialProxyAppId: window.facebook_share_social_proxy_app_id,
                            socialProxy: window.facebook_share_social_proxy,
                            title: $("#opanda_facebook_share_title").val(),
                            shareDialog: $("#opanda_facebook_share_dialog").is(':checked'),
                            url: $("#opanda_facebook_share_url").val(),
                            counter: $("#opanda_facebook_share_counter_url").val()
                        }
                    }, 
                    twitter: {
                        lang: window.opanda_short_lang,
                        tweet: {
                            socialProxy: window.twitter_social_proxy,
                            url: $("#opanda_twitter_tweet_url").val(),
                            text: $("#opanda_twitter_tweet_text").val(),
                            title: $("#opanda_twitter_tweet_title").val(),
                            skipCheck: $("#opanda_twitter_tweet_skip_auth").is(':checked'),
                            via: $("#opanda_twitter_tweet_via").val()              
                        },
                        follow: {
                            socialProxy: window.twitter_social_proxy,
                            url: $("#opanda_twitter_follow_url").val(),
                            title: $("#opanda_twitter_follow_title").val(),
                            skipCheck: $("#opanda_twitter_tweet_skip_auth").is(':checked'),
                            hideScreenName: $("#opanda_twitter_follow_hide_name").is(':checked')
                        }
                    },          
                    google: {
                        lang: window.opanda_short_lang,
                        
                        plus: {
                            url: $("#opanda_google_plus_url").val(),
                            title: $("#opanda_google_plus_title").val(),
                            prefilltext: $("#opanda_google_plus_text").val()
                        },   
                        share: {
                            url: $("#opanda_google_share_url").val(),
                            title: $("#opanda_google_share_title").val(),
                            prefilltext: $("#opanda_google_share_text").val()
                        }
                    },
                    youtube: {
                        subscribe: {
                            socialProxy: window.google_social_proxy,
                            clientId: window.opanda_google_client_id,
                            channelId: $("#opanda_google_youtube_channel_id").val(),                               
                            title: $("#opanda_google_youtube_title").val()
                        }
                    },
                    linkedin: {
                        share: {
                            url: $("#opanda_linkedin_share_url").val(),
                            title: $("#opanda_linkedin_share_title").val()
                        }
                    }
                }
            };
            console.log( options );
            return options;
        },
        
        lockPremiumFeatures: function() {

            if ( $.inArray( this.item, ['social-locker', 'email-locker', 'signin-locker'] ) === -1 ) return;
            
            $(".factory-tab-item.opanda-not-available").each( function(){ 
                
                var $overlay = $("<div class='opanda-overlay'></div>");
                var $note = $overlay.find(".opanda-premium-note");
                
                $(this).append( $overlay );
                $(this).append( $note );
            });
            
            return;
        }
    };
    
    $(function(){
        window.bizpanda.socialOptions.init();
    });
    
})(jQuery)

