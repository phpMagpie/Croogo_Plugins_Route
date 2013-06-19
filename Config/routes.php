<?php
CroogoRouter::connect('/new-organs', array(
  'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'view', 
  'type' => 'page', 'slug' => 'new-organs'
));
Router::promote();