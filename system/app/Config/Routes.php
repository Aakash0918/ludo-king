<?php

namespace Config;

use App\Models\ApplicationModel;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();



if (!cache('support_setting')) {
    $model = new ApplicationModel('settings', 'sid');
    $detail = $model->select('setting_value')->where('setting_key', 'support_setting')->first();
    $detail = json_decode($detail['setting_value'] ?? "{}", true);
    cache()->save('support_setting', $detail, 600);
}



/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override(function () {
    return view('404');
});
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::home');
$routes->match(['get', 'post'], '/super-login', 'Login::admin');
$routes->get('/term-condition', 'Home::term_condition');
$routes->get('/privacy-policy', 'Home::privacy_policy');
$routes->get('/refund-policy', 'Home::refund_policy');
$routes->get('/contact-us', 'Home::contact_us');
$routes->get('/responsible-gaming', 'Home::responsible_gaming');
$routes->get('/platform-commission', 'Home::platform_commission');
$routes->get('/tds-policy', 'Home::tds_policy');
$routes->get('/game-rules', 'Home::game_rules');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
