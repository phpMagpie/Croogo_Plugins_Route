<?php

class RouteSchema extends CakeSchema {
    /**
     * Name
     *
     * @var string
     */
    public $name = 'Route';

    /**
     * Before callback
     *
     * @param string Event
     * @return boolean
     */
    public function before($event = array()) {
            return true;
    }

    /**
     * After callback
     *
     * @param string Event
     * @return boolean
     */
    public function after($event = array()) {
    }

    /**
     * Schema for routes table
     *
     * @var array
     */
    public $routes = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
        'alias' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'body' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
        'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
        'node_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20),
        'updated' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
    );
}		