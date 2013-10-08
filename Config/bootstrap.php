<?php
/**
 * Routes
 *
 * example_routes.php will be loaded in main app/config/routes.php file.
 */
Croogo::hookRoutes('Route', array('priority' => 1));

/**
 * Behavior
 *
 * This plugin's Route behavior will be attached whenever Node model is loaded.
 */
Croogo::hookBehavior('Node', 'Route.Route', array());

/**
 * Component
 *
 * This plugin's Example component will be loaded in ALL controllers.
 */
Croogo::hookComponent('Nodes', 'Route.CRoute');

/**
 * Admin menu (navigation)
 */
CroogoNav::add('extensions.children.route', array(
    'title' => __d('croogo', 'Routes'),
    'url' => array(
        'plugin' => 'route',
        'controller' => 'routes',
        'action' => 'index',
    ),
    'access' => array('admin'),
    'children' => array(
        'createroutes' => array(
            'title' => __d('croogo', 'Create Route'),
            'url' => array(
                'plugin' => 'route',
                'controller' => 'routes',
                'action' => 'add',
            ),
            'weight' => 5,
        ),
        'regenerateroutes' => array(
            'title' => __d('croogo', 'Regenerate Routes File'),
            'url' => array(
                'plugin' => 'route',
                'controller' => 'routes',
                'action' => 'regenerate_custom_routes_file',
            ),
            'weight' => 10,
        ),
    ),
));

/**
 * Admin row action
 *
 * When browsing the content list in admin panel (Content > List),
 * an extra link called 'Route' will be placed under 'Actions' column.
 */
// Croogo::hookAdminRowAction('Nodes/admin_index', 'Route', 'plugin:route/controller:route/action:index/:id');

/**
 * Admin tab
 *
 * When adding/editing Content (Nodes),
 * an extra tab with title 'Route' will be shown with markup generated from the plugin's admin_tab_node element.
 *
 * Useful for adding form extra form fields if necessary.
 */
Croogo::hookAdminTab('Nodes/admin_add', 'Route', 'Route.admin_tab_node');
Croogo::hookAdminTab('Nodes/admin_edit', 'Route', 'Route.admin_tab_node');
