<?php
namespace Application\Controller;

use Application\Utility\Utility;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionController
{
    protected $_view;
    protected $_variableLayout;
    protected $_utility;

    public function __construct()
    {
        $this->_view = new ViewModel();
        $this->_variableLayout = array('title' => 'Project');
        $this->_utility = new Utility();

        $menus = $this->_utility->getMenus('Project');
        $this->_variableLayout = array_merge($this->_variableLayout, array('menus' => $menus));
    }

    public function indexAction()
    {

        $this->layout()->setVariables($this->_variableLayout);
        return $this->_view;
    }
}