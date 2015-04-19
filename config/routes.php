<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `InflectedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */

    $routes->connect('/config/:action/*', ['controller' => 'Utilities']);

    //http://cakephpblog.com/thanhvien/add      //thanhvien/add has conflicted
    //example alias controller
    //the action is required for this route
    $routes->connect('/thanhvien/:action/*', ['controller' => 'Users']);

    $routes->connect(
        '/job/:id-:title_url',
        ['controller' => 'Articles', 'action' => 'view'],
        ['_name' => 'friendly_url_job'],
        [
            'pass' => ['id', 'title_url'],
            'id' => '[0-9]+'
        ]
    );


    //MUST use http://cakephpblog.com/users/2 instead of http://cakephpblog.com/users/view/1
    //set default action
    //this config can cause lots of conflict (collide)
    //Inside the view() method, you would need to access the passed ID at $this->request->params['id'].
    $routes->connect(
        '/:controller/:id',
        ['action' => 'view'],
        ['id' => '[0-9]+', 'routeClass' => 'InflectedRoute']
    );

    $routes->fallbacks('InflectedRoute');
});

Router::prefix('admin', function ($routes) {
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'index']);
});

/*
Router::scope('/blog', function ($routes) {
    //http://cakephpblog.com/blog
    $routes->connect('/', ['controller' => 'Articles']);

    //http://cakephpblog.com/blog/write
    $routes->connect('/write', ['controller' => 'Articles', 'action' => 'add']);
    $routes->connect(
        '/*',
        ['controller' => 'Articles', 'action' => 'view'],
        ['id' => '[0-9]+']
    );

    //http://cakephpblog.com/blog/update/2
    $routes->connect(
        '/update/*',
        ['controller' => 'Articles', 'action' => 'edit']
    );
});
*/

/**
 * For REST access
 * Example url:
 *     http://cakephpblog.com/api/is/rest_articles.xml
 */

Router::scope('/api/is', function ($routes) {
    $routes->extensions(['json', 'xml']);
    $routes->resources('RestArticles');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
