<?php

class OPanda_SignInLocker_Profits_StatsTable extends OPanda_StatsTable {
    
    public function getColumns() {
        
        $columns = array(
            'index' => array(
                'title' => ''
            ),
            'title' => array(
                'title' => __('Post Title', 'signinlocker')
            ),
            'unlock' => array(
                'title' => __('Unlocks', 'signinlocker'),
                'hint' => __('The number of unlocks made by visitors.', 'signinlocker'),
                'highlight' => true,
                'cssClass' => 'opanda-col-number'
            )
        );

        $columns['leads'] = array(
            'title' => __('Leads', 'signinlocker'),
            'hint' => __('The number of new leads collected via the locker.', 'signinlocker'),
            'cssClass' => 'opanda-col-number'
        );

        $columns['account-registered'] = array(
            'title' => __('Users Registered', 'signinlocker'),
            'hint' => __('The number of new accounts created via the locker.', 'signinlocker'),
            'cssClass' => 'opanda-col-number',
            'prefix' => '+'
        );
        
        if ( BizPanda::hasPlugin('sociallocker') ) {
            
            $columns['got-twitter-follower'] = array(
                'title' => __('Twitter Followers', 'signinlocker'),
                'hint' => __('The number of new followers attracted via the locker.', 'signinlocker'),
                'cssClass' => 'opanda-col-number',
                'prefix' => '+'
            );
            
            $columns['tweet-posted'] = array(
                'title' => __('Tweets', 'signinlocker'),
                'hint' => __('The number of new tweets posted via the locker.', 'signinlocker'),
                'cssClass' => 'opanda-col-number',
                'prefix' => '+'
            );
            
            $columns['got-youtube-subscriber'] = array(
                'title' => __('Youtube Subscribers', 'signinlocker'),
                'hint' => __('The number of new subscribers attracted via the locker.', 'signinlocker'),
                'cssClass' => 'opanda-col-number',
                'prefix' => '+'
            );

            /*
            $columns['got-linkedin-follower'] = array(
                'title' => __('LinkedIn Followers', 'signinlocker'),
                'hint' => __('The number of new followers attracted via the locker.', 'signinlocker'),
                'cssClass' => 'opanda-col-number',
                'prefix' => '+'
            );
            */
        }
        
        return $columns;
    }
    
    public function columnLeads( $row ) {
        if ( !isset( $row['email-received'] ) ) $row['email-received'] = 0;
        
        if ( $row['email-received'] > 0 ) echo '+';
        echo $row['email-received'];
    }
}

class OPanda_SignInLocker_Profits_StatsChart extends OPanda_StatsChart {
    
    public $type = 'line';
    
    public function getFields() {
        
        $fields = array();
        
        $fields['aggregate_date'] = array(
            'title' => __('Date')
        );

        if ( BizPanda::hasPlugin('optinpanda') ) {
            
            $fields['got-twitter-follower'] = array(
                'title' => __('Emails', 'signinlocker'),
                'color' => '#FFCC66'
            );
        }

        $fields['leads'] =  array(
            'title' => __('Leads Collected', 'signinlocker'),
            'color' => '#FFCC66'
        );
        
        $fields['account-registered'] =  array(
            'title' => __('Users Registered', 'signinlocker'),
            'color' => '#336699'
        );
        
        if ( BizPanda::hasPlugin('sociallocker') ) {

            $fields['tweet-posted'] = array(
                'title' => __('Twitter Tweets', 'signinlocker'),
                'color' => '#3bb4ea'
            );
            $fields['got-twitter-follower'] = array(
               'title' => __('Twitter Followers', 'signinlocker'),
               'color' => '#1e92c9'
            );
            $fields['got-youtube-subscriber'] = array(
               'title' => __('Youtube Subscribers', 'signinlocker'),
               'color' => '#ba5145'
            );

            /*
            $fields['got-linkedin-follower'] = array(
               'title' => __('LinkedIn Followers', 'signinlocker'),
               'color' => '#006080'
            );
            */
        }
        
        return $fields;
    }
}