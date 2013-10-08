<?php
/**
 * Routes Controller
 *
 * PHP version 5
 *
 * @category Routes.Controller
 * @package  Croogo.Route
 * @version  1.5
 * @author   Damian Grant <codebogan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
App::uses('RoutesAppController', 'Route.Controller');
App::uses('Croogo', 'Lib');

class RoutesController extends RoutesAppController {

    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array('Route.Route', 'Nodes.Node');

    /**
     * Plugin name
     *
     * @var string
     */
    public $pluginName = 'Route';

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Routes';
	
    /**
     * Components used by the Controller
     *
     * @var array
     * @access public
     */	
    public $components = array(
        'Search.Prg',
        'Route.CRoute'
    );

    /**
     * Preset Variable Search
     *
     * @var array
     * @access public
     */
    public $presetVars = true;

    /**
     * Default pagination options
     *
     * @var array
     * @access public
     */
    public $paginate = array(
        'limit' => 25,
        'order' => array (
            'Route.alias' => 'asc',
        ),
    );
    
    /**
     * beforeFilter
     *
     * @return void
     * @access public
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions[] = 'admin_toggle';
    }

    /**
     * Route List/ Index
     */
    public function admin_index() {
        $this->set('title_for_layout', __d('croogo', 'List Routes'));
        $this->Prg->commonProcess();
        $this->Route->recursive = 0;
        
        $searchFields = array('alias');
        
        $routes = $this->paginate($this->Route->parseCriteria($this->passedArgs));
        $this->set(compact('searchFields', 'routes'));		
    }

    /**
     * Add route
     */
    public function admin_add() {
        $this->set('title_for_layout', __d('croogo', 'Create Route'));
        
        if (!empty($this->data)) {
            $this->Route->create();
            if ($this->Route->save($this->data)) {
                $this->Session->setFlash(__d('croogo', 'Route has been created sucessfully.'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'admin_regenerate_custom_routes_file'));				
            } else {
                $this->Session->setFlash(__d('croogo', 'Could not create Route. Please, try again!'), 'default', array('class' => 'error'));
            }
        }
    }

    /**
     * Edit route
     *
     * @param integer $id
     */
    public function admin_edit($id = null) {
        
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__d('croogo', 'Cannot edit missing Route'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        if (!empty($this->request->data)) {
            $this->request->data['Route']['id'] = $id;					  
            //if node id is not empty, load in node information
            $linkedNode = null;

            if ($this->request->data['Route']['node_id'] != null) {
                $linkedNode = $this->Node->read(null, $this->request->data['Route']['node_id']);
            }
            $this->set('linkedNode', $linkedNode);

            if ($this->Route->save($this->request->data)) {
                $this->Session->setFlash(__d('croogo', 'Route has been edited sucessfully.'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'admin_regenerate_custom_routes_file'));				
            } else {
                $this->Session->setFlash(__d('croogo', 'Route could not be edited. Please, try again.'), 'default', array('class' => 'error'));
                $this->set('title_for_layout', __d('croogo', 'Edit a Route'));				
            }
        }

        if (empty($this->request->data)) {
            $this->set('title_for_layout', __d('croogo', 'Edit Route'));
            
            $this->request->data = $this->Route->read(null, $id);
            
            //if node id is not empty, load in node information
            $linkedNode = null;
            if ($this->request->data['Route']['node_id'] != null) {
                $linkedNode = $this->Node->read(null, $this->request->data['Route']['node_id']);
            }
            $this->set('linkedNode', $linkedNode);
        }
    }

    /**
     * Delete route
     *
     * @param integer $id (route id)
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Route->id = $id;
        if (!$this->Route->exists()) {
                throw new NotFoundException(__d('croogo', 'Invalid Route'));
        }
        if ($this->Route->delete()) {
            $this->Session->setFlash(__d('croogo', 'Route deleted successfully.'), 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'admin_regenerate_custom_routes_file'));
        }
        $this->Session->setFlash(__d('croogo', 'Route could not be deleted. Please try again.'), 'default', array('class' => 'error'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Generate custom routes file
     */		
    public function admin_regenerate_custom_routes_file() {
        $this->set('title_for_layout', __d('croogo', 'Regenerating Custom Routes File...'));
        
        $result = $this->CRoute->write_custom_routes_file();
        
        $this->set('output_for_layout', $result['output']);
        if ($result['code'] != '') {
            $result['code'] = '<textarea wrap="off" style="margin-top: 10px; font-size: 11px;" readonly="readonly">' . $result['code'] . '</textarea>';
        }
        $this->set('code_for_layout', $result['code']);			 
    }

    /**
     * Enable all routes
     */	
    public function admin_enable_all() {
        $this->Route->updateAll(array('Route.status' => 1), array('Route.status' => 0));
        $this->Session->setFlash(__d('croogo', 'All Routes have been enabled sucessfully.'), 'default', array('class' => 'success'));
        $this->redirect(array('action' => 'admin_regenerate_custom_routes_file'));				
    }

    /**
     * Disable all routes
     */		
    public function admin_disable_all() {
        $this->Route->updateAll(array('Route.status' => 0), array('Route.status' => 1));
        $this->Session->setFlash(__d('croogo', 'All Routes have been disabled sucessfully.'), 'default', array('class' => 'success'));
        $this->redirect(array('action' => 'admin_regenerate_custom_routes_file'));				
    }

    /**
     * Delete all routes
     */		
    public function admin_delete_all() {
        $this->Route->deleteAll('1');
        $this->Session->setFlash(__d('croogo', 'All Routes have been deleted sucessfully.'), 'default', array('class' => 'success'));
        $this->redirect(array('action' => 'admin_regenerate_custom_routes_file'));				
    }
    
    /**
     * Admin process
     *
     * @return void
     * @access public
     */
    public function admin_process() {
        $action = $this->request->data['Route']['action'];
        $ids = array();
        
        foreach ($this->request->data['Route'] as $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__d('croogo', 'No Routes selected.'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($action == 'delete' && $this->Route->deleteAll(array('Route.id' => $ids), true, true)) {
            $this->Session->setFlash(__d('croogo', 'Routes deleted successfully.'), 'default', array('class' => 'success'));
        } elseif ($action == 'enable_routes' && $this->Route->updateAll(array('Route.status' => true), array('Route.id' => $ids))) {
            $this->Session->setFlash(__d('croogo', 'Routes enabled successfully.'), 'default', array('class' => 'success'));
        } elseif ($action == 'disable_routes' && $this->Route->updateAll(array('Route.status' => false), array('Route.id' => $ids))) {
            $this->Session->setFlash(__d('croogo', 'Routes disabled successfully.'), 'default', array('class' => 'success'));
        } else {    
            $this->Session->setFlash(__d('croogo', 'An error occurred. Please try again.'), 'default', array('class' => 'error'));
        }
        $this->redirect(array('action' => 'admin_regenerate_custom_routes_file'));
    }
}