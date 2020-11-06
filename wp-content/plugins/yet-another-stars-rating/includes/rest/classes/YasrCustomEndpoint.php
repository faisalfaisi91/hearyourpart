<?php

if (!defined('ABSPATH')) {
    exit('You\'re not allowed to see this page');
} // Exit if accessed directly

class YasrCustomEndpoint extends WP_REST_Controller {

    /**
     * Constructor
     */
    public function restApiInit() {
        add_action('rest_api_init',  array( $this, 'customEndpoint'));
    }


    /**
     * All the functions that need parameters
     */
    public function customEndpoint () {
        /*
         * Param for this route must be
         * YOURSITE/wp-json/yet-another-stars-rating/v1/yasr-multiset/<ID>?post_id=<ID>
         *     OPTIONAL &visitor=1
         *
         */
        $namespace = 'yet-another-stars-rating/';
        $version = 'v1/';
        $base = 'yasr-multiset';

        register_rest_route(
            $namespace . $version . $base,
            '(?P<set_id>\d+)',
            array(
                'methods'  => WP_REST_Server::READABLE,
                'callback' => array($this, 'authorMultiSet'),
                'args' => array(
                    'set_id' => array(
                        'required' => true,
                        'sanitize_callback' => array($this, 'sanitizeInput')
                    ),
                    'post_id' => array(
                        'required' => true,
                        'sanitize_callback' => array($this, 'sanitizeInput')
                    ),
                    'visitor' => array(
                        'default'  => 0,
                        'required' => false,
                        'sanitize_callback' => array($this, 'sanitizeInput')
                    ),
                ),
                'permission_callback' => static function () {
                    return true;
                }
            )
        );
    }

    /**
     *
     * Returns Author Multi Set
     * must be public
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function authorMultiSet ($request) {
        /*
         * Get cleaned params
         */
        $set_id  = $request['set_id'];
        $post_id = $request['post_id'];
        $visitor = $request['visitor'];

        $data_to_return = array(
            'set_id' => $set_id
        );

        $invalid_set = false;

        //if $visitor === 1 then get data from yasr_visitor_multiset
        if($visitor === 1) {
            $data_to_return['yasr_visitor_multiset'] = YasrMultiSetData::returnVisitorMultiSetContent($post_id, $set_id);
            if ($data_to_return['yasr_visitor_multiset'] === false) {
                $invalid_set = true;
            }
        } else {
            $data_to_return['yasr_multiset'] = YasrMultiSetData::returnMultisetContent($post_id, $set_id);
            if ($data_to_return['yasr_multiset'] === false) {
                $invalid_set = true;
            }
        }

        if ($invalid_set === true) {
            return new WP_Error(
                'invalid_multiset',
                __('This Multi Set doesn\'t exists', 'yet-another-stars-rating'),
                400
            );
        }

        $response = new WP_REST_Response($data_to_return);
        $response->set_status(200);

        return $response;
    }

    /**
     * Sanitizie input, must be public
     *
     * @param $param
     * @param $request
     * @param $key
     *
     * @return int|void|WP_Error
     */
    public function sanitizeInput ($param, $request, $key) {
        if($key === 'set_id') {
            return (int)$param;
        }

        if($key === 'post_id') {
            $post_id = (int)$param;

            /*if post_id is null means that is not set in the request.
             * (int) will convert it to 0.
             * When WordPress is installed, the first post has ID = 1
             */
            if ($post_id === 0) {
                return new WP_Error (
                    'wrong_post_id',
                    __('Invalid Post ID', 'yet-another-stars-rating'),
                    400
                );
            }

            //Check if exists a post with this ID
            if (get_post($post_id) === null) {
                return new WP_Error (
                    'wrong_post_id',
                    __('Post ID doesn\'t exists', 'yet-another-stars-rating'),
                    404
                );
            }
            return $post_id;
        }

        if($key === 'visitor') {
            return (int)$param;
        }
        return;
    }
}