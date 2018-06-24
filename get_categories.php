<?php

require __DIR__ . '/vendor/autoload.php';


use Automattic\WooCommerce\Client;
//require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-config.php');
//require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');





// Making a Cron Scheduler for category syncronization

add_filter( 'cron_schedules', 'cat_sync' );
function cat_sync( $schedules ) {
    $schedules['every_x_hour'] = array(
        'interval'  => 3600,
        'display'   => __( 'Cron Job for Category sync', 'textdomain' )
    );
    return $schedules;
}


if ( ! wp_next_scheduled( 'cat_sync' ) ) {
    wp_schedule_event( time(), 'every_x_hour', 'cat_sync' );
}

add_action( 'cat_sync', 'update_rothco_cat' );

/* Cron Scheduler End */


function update_rothco_cat(){
    global $wpdb;
    $available_slugs = $wpdb->get_results( "SELECT slug FROM wpkc_terms");

    $slugs  = array();
    foreach ($available_slugs as $sl){
        $s = $sl->slug;
        array_push($slugs,$s);
    }


    $cat_url  = 'https://www.rothco.com/api/categories?format=json&key=58580a658e442647cf98ccdbb5aa737c9571db10&ids=';


    for ($i=1;$i<634;$i++){
        if (empty(in_array($i, $slugs))) {
            $new_cat = $cat_url.$i;
            $load_content= file_get_contents($new_cat);
            $load_json = json_decode($load_content);
            $check_null=$load_json->categories;
            if (!empty($check_null)) {
                $id = $load_json->categories[0]->id;
                $name = $load_json->categories[0]->category_name;
                $woocommerce = new Client(
                    'https://wolfgarholsters.com',
                    'ck_4b991b9563f48a11ccd86b775c166132b935a437',
                    'cs_fd00d9201756bc5fe0b749bc59a9d1c83a259e09',
                    [
                        'wp_api' => true,
                        'version' => 'wc/v2',
                    ]
                );

                $data = [
                    'name' => $name,
                    'slug' => $id
                ];

                $woocommerce->post('products/categories', $data);
                sleep(3);

            }else{
                print("No Category");
            }
        }else{
            print("already exits");
        }

    }













}


