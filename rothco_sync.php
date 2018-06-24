<?php
/**
 * Created by PhpStorm.
 * User: mahbub
 * Date: 16/06/18
 * Time: 01:28
 */

//authentication
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;
//require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-config.php');
//require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');






/*User defined Functions*/

function create_product($item_index,$prize,$image,$sku){

    $woocommerce = new Client(
                    'https://wolfgarholsters.com',
                    'ck_4b991b9563f48a11ccd86b775c166132b935a437',
                    'cs_fd00d9201756bc5fe0b749bc59a9d1c83a259e09',
                    [
                        'wp_api' => true,
                        'version' => 'wc/v2',
                    ]
                );

    $item_url = 'https://www.rothco.com/api/products/items?format=json&key=58580a658e442647cf98ccdbb5aa737c9571db10&fields=description,categories,short_description&item_indexes='.$item_index;
    $seek_name = file_get_contents($item_url);
    $seek_name = json_decode($seek_name);
    $name  = $seek_name->items[0]->item_name;
    $product_short_desc = $seek_name -> items[0]-> item_short_desc;
    $product_description = $seek_name -> items[0] -> description;
    $data = [
        'name' => $name,
        'type' => 'simple',
        'sku' => $sku,
        'regular_price' => $prize,
        'description' => $product_description,
        'short_description' => $product_short_desc,
        'categories' => [
        ],
        'images' => [
            [
                'src' => $image,
                'position' => 0
            ]
        ]
    ];

    print_r($woocommerce->post('products', $data));


}

function update_product($item_index,$prize,$product_id,$weight){

    $woocommerce = new Client(
                    'https://wolfgarholsters.com',
                    'ck_4b991b9563f48a11ccd86b775c166132b935a437',
                    'cs_fd00d9201756bc5fe0b749bc59a9d1c83a259e09',
                    [
                        'wp_api' => true,
                        'version' => 'wc/v2',
                    ]
                );

    $item_url = 'https://www.rothco.com/api/products/items?format=json&key=58580a658e442647cf98ccdbb5aa737c9571db10&fields=description,categories,short_description&item_indexes='.$item_index;
    $seek_name = file_get_contents($item_url);
    $seek_name = json_decode($seek_name);
    $name  = $seek_name->items[0]->item_name;
    $product_short_desc = $seek_name -> items[0]-> item_short_desc;
    $product_description = $seek_name -> items[0] -> description;
    $categories = $seek_name->items[0] ->categories[0];
    $id = 683; //This Generic Category ID Need to be created first
    if(!empty($categories)){
        global $wpdb;
        $row_id = $wpdb->get_results( "SELECT term_id FROM wpkc_terms where slug =".$categories);
        $id=$row_id[0]->term_id;
    }
    $data = [
        'name' => $name,
        'regular_price' => $prize,
        'weight' => $weight,
        'description' => $product_description,
        'short_description' => $product_short_desc,
        'categories' => [
            [
                'id' => $id
            ]
            ]
    ];

    print_r($woocommerce->post('products/'.$product_id, $data));


}




/*User defined Function END*/










// Making a Cron Scheduler 1

add_filter( 'cron_schedules', 'first_sync' );
function first_sync( $schedules ) {
    $schedules['every_first_hour'] = array(
        'interval'  => 3*3600,
        'display'   => __( 'Cron Job for first Rothco sync', 'textdomain' )
    );
    return $schedules;
}


if ( ! wp_next_scheduled( 'first_sync' ) ) {
    wp_schedule_event( time(), 'every_first_hour', 'first_sync' );
}

add_action( 'first_sync', 'update_rothco_first' );

/* Cron Scheduler End */

// Making a Cron Scheduler 2

add_filter( 'cron_schedules', 'second_sync' );
function second_sync( $schedules ) {
    $schedules['every_second_hour'] = array(
        'interval'  => 3*3800,
        'display'   => __( 'Cron Job for Second Rothco sync', 'textdomain' )
    );
    return $schedules;
}


if ( ! wp_next_scheduled( 'second_sync' ) ) {
    wp_schedule_event( time(), 'every_second_hour', 'second_sync' );
}

add_action( 'second_sync', 'update_rothco_second' );

/* Cron Scheduler End */


// Making a Cron Scheduler 3

add_filter( 'cron_schedules', 'third_sync' );
function third_sync( $schedules ) {
    $schedules['every_third_hour'] = array(
        'interval'  => 3*4000,
        'display'   => __( 'Cron Job for third Rothco sync', 'textdomain' )
    );
    return $schedules;
}


if ( ! wp_next_scheduled( 'third_sync' ) ) {
    wp_schedule_event( time(), 'every_third_hour', 'third_sync' );
}

add_action( 'third_sync', 'update_rothco_third' );

/* Cron Scheduler End */


// Making a Cron Scheduler 4

add_filter( 'cron_schedules', 'fourth_sync' );
function fourth_sync( $schedules ) {
    $schedules['every_fourth_hour'] = array(
        'interval'  => 3*4200,
        'display'   => __( 'Cron Job for fourth Rothco sync', 'textdomain' )
    );
    return $schedules;
}


if ( ! wp_next_scheduled( 'fourth_sync' ) ) {
    wp_schedule_event( time(), 'every_fourth_hour', 'fourth_sync' );
}

add_action( 'fourth_sync', 'update_rothco_fourth' );

/* Cron Scheduler End */


// Making a Cron Scheduler 5

add_filter( 'cron_schedules', 'fifth_sync' );
function fifth_sync( $schedules ) {
    $schedules['every_fifth_hour'] = array(
        'interval'  => 3*4400,
        'display'   => __( 'Cron Job for fifth Rothco sync', 'textdomain' )
    );
    return $schedules;
}


if ( ! wp_next_scheduled( 'fifth_sync' ) ) {
    wp_schedule_event( time(), 'every_fifth_hour', 'fifth_sync' );
}

add_action( 'fifth_sync', 'update_rothco_fifth' );

/* Cron Scheduler End */









function update_rothco_first() {

    $product_url = 'https://www.rothco.com/api/products/variations?format=json&fields=specs,price,weight,image,catalog_page,msrp,map,caseprice,ship_size&key=58580a658e442647cf98ccdbb5aa737c9571db10';
    $loader = file_get_contents($product_url);
    $json_load = json_decode($loader);
    $products = $json_load -> item_variations;
    $products = array_slice($products,0,19);




    $sku_list = array();
    $sku_id = array();

    global $wpdb;
    $all_products = $wpdb->get_results( "SELECT meta_value,post_id FROM wpkc_postmeta where meta_key ='_sku'");
    foreach ($all_products as $sk){
        $single_sku = $sk->meta_value;
        $id = $sk->post_id;
        if(!empty($single_sku)) {
            array_push($sku_list, $single_sku);
            $sku_id[$single_sku] = $id;
        }
    }


    foreach ($products as $woo) {
        $index = $woo -> item_index;
        $prize = $woo -> price;
        $inventory = $woo ->inventory;
        $weight = $woo -> weight;
        $image_file = $woo -> image_filename;
        $image = 'https://www.rothco.com/upload/product/product/large/'.$image_file;
        $sku = $woo-> upc;
        if (in_array($sku, $sku_list)){
            $product_id = $sku_id[$sku];
            update_product($index,$prize,$product_id,$weight);
        }else{
            create_product($index,$prize,$image,$sku);
        }

    }




}


function update_rothco_second() {

    $product_url = 'https://www.rothco.com/api/products/variations?format=json&fields=specs,price,weight,image,catalog_page,msrp,map,caseprice,ship_size&key=58580a658e442647cf98ccdbb5aa737c9571db10';
    $loader = file_get_contents($product_url);
    $json_load = json_decode($loader);
    $products = $json_load -> item_variations;
    $products = array_slice($products,20,39);



    $sku_list = array();
    $sku_id = array();
    global $wpdb;
    $all_products = $wpdb->get_results( "SELECT meta_value,post_id FROM wpkc_postmeta where meta_key ='_sku'");
    foreach ($all_products as $sk){
        $single_sku = $sk->meta_value;
        $id = $sk->post_id;
        if(!empty($single_sku)) {
            array_push($sku_list, $single_sku);
            $sku_id[$single_sku] = $id;
        }
    }



    foreach ($products as $woo) {
        $index = $woo -> item_index;
        $prize = $woo -> price;
        $weight = $woo -> weight;
        $image_file = $woo -> image_filename;
        $image = 'https://www.rothco.com/upload/product/product/large/'.$image_file;
        $sku = $woo-> upc;
        if (in_array($sku, $sku_list)){
            $product_id = $sku_id[$sku];
            update_product($index,$prize,$product_id,$weight);
        }else{
            create_product($index,$prize,$image,$sku);
        }

    }




}




function update_rothco_third() {

    $product_url = 'https://www.rothco.com/api/products/variations?format=json&fields=specs,price,weight,image,catalog_page,msrp,map,caseprice,ship_size&key=58580a658e442647cf98ccdbb5aa737c9571db10';
    $loader = file_get_contents($product_url);
    $json_load = json_decode($loader);
    $products = $json_load -> item_variations;
    $products = array_slice($products,40,59);




    $sku_list = array();
    $sku_id = array();
    global $wpdb;
    $all_products = $wpdb->get_results( "SELECT meta_value,post_id FROM wpkc_postmeta where meta_key ='_sku'");
    foreach ($all_products as $sk){
        $single_sku = $sk->meta_value;
        $id = $sk->post_id;
        if(!empty($single_sku)) {
            array_push($sku_list, $single_sku);
            $sku_id[$single_sku] = $id;
        }
    }



    foreach ($products as $woo) {
        $index = $woo -> item_index;
        $prize = $woo -> price;
        $weight = $woo -> weight;
        $image_file = $woo -> image_filename;
        $image = 'https://www.rothco.com/upload/product/product/large/'.$image_file;
        $sku = $woo-> upc;
        if (in_array($sku, $sku_list)){
            $product_id = $sku_id[$sku];
            update_product($index,$prize,$product_id,$weight);
        }else{
            create_product($index,$prize,$image,$sku);
        }

    }




}

function update_rothco_fourth() {

    $product_url = 'https://www.rothco.com/api/products/variations?format=json&fields=specs,price,weight,image,catalog_page,msrp,map,caseprice,ship_size&key=58580a658e442647cf98ccdbb5aa737c9571db10';
    $loader = file_get_contents($product_url);
    $json_load = json_decode($loader);
    $products = $json_load -> item_variations;
    $products = array_slice($products,60,79);



    $sku_list = array();
    $sku_id = array();
    global $wpdb;
    $all_products = $wpdb->get_results( "SELECT meta_value,post_id FROM wpkc_postmeta where meta_key ='_sku'");
    foreach ($all_products as $sk){
        $single_sku = $sk->meta_value;
        $id = $sk->post_id;
        if(!empty($single_sku)) {
            array_push($sku_list, $single_sku);
            $sku_id[$single_sku] = $id;
        }
    }



    foreach ($products as $woo) {
        $index = $woo -> item_index;
        $prize = $woo -> price;
        $weight = $woo -> weight;
        $image_file = $woo -> image_filename;
        $image = 'https://www.rothco.com/upload/product/product/large/'.$image_file;
        $sku = $woo-> upc;
        if (in_array($sku, $sku_list)){
            $product_id = $sku_id[$sku];
            update_product($index,$prize,$product_id,$weight);
        }else{
            create_product($index,$prize,$image,$sku);
        }

    }




}




function update_rothco_fifth() {

    $product_url = 'https://www.rothco.com/api/products/variations?format=json&fields=specs,price,weight,image,catalog_page,msrp,map,caseprice,ship_size&key=58580a658e442647cf98ccdbb5aa737c9571db10';
    $loader = file_get_contents($product_url);
    $json_load = json_decode($loader);
    $products = $json_load -> item_variations;
    $products = array_slice($products,80,99);




    $sku_list = array();
    $sku_id = array();
    global $wpdb;
    $all_products = $wpdb->get_results( "SELECT meta_value,post_id FROM wpkc_postmeta where meta_key ='_sku'");
    foreach ($all_products as $sk){
        $single_sku = $sk->meta_value;
        $id = $sk->post_id;
        if(!empty($single_sku)) {
            array_push($sku_list, $single_sku);
            $sku_id[$single_sku] = $id;
        }
    }


    foreach ($products as $woo) {
        $index = $woo -> item_index;
        $prize = $woo -> price;
        $weight = $woo -> weight;
        $image_file = $woo -> image_filename;
        $image = 'https://www.rothco.com/upload/product/product/large/'.$image_file;
        $sku = $woo-> upc;
        if (in_array($sku, $sku_list)){
            $product_id = $sku_id[$sku];
            update_product($index,$prize,$product_id,$weight);
        }else{
            create_product($index,$prize,$image,$sku);
        }

    }




}





//function update_category(){
//    $woocommerce = new Client(
//        'http://wolfgar22.designproofs.net',
//        'ck_331d297d1cc6ae3ac364cf9b10a5a0a923c6de4a',
//        'cs_f257aad86a1c04c06e230e9cb362fd3e79acae3a',
//        [
//            'wp_api' => true,
//            'version' => 'wc/v2',
//        ]
//    );

//Get available category
//    $category_url = 'https://www.rothco.com/api/categories?format=json&key=58580a658e442647cf98ccdbb5aa737c9571db10';
//    $json = file_get_contents($category_url);
//    $rothco = json_decode($json);
//    $rothco_categories=$rothco ->categories;
//
//    $existing_category = $woocommerce->get('products/categories');
//    $all_woo_cat = array();
//    foreach ($existing_category as $cat){
//        $item = $cat->name;
//        if(!empty($item)) {
//            array_push($all_woo_cat, $item);
//        }
//    }
//
//    foreach ($rothco_categories as $category) {
//        $category_name = $category->category_name;
//        if (!(in_array($category_name, $all_woo_cat))) {
//            $data = [
//                'name' => $category_name
//            ];
//
//            print_r($woocommerce->post('products/categories', $data));
//        }
//
//    }
//}



