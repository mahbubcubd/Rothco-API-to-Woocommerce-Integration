<?php
/**
 * Created by PhpStorm.
 * User: mahbub
 * Date: 16/06/18
 * Time: 01:34
 */


register_deactivation_hook(__FILE__, 'rothco_deactivation');

function rothco_deactivation() {
    wp_clear_scheduled_hook('hourly_sync');
}