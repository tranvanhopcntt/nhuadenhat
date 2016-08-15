<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Utility\Utility;

class NewsController extends AbstractActionController
{
    protected $_view;
    protected $_variableLayout;
    protected $_utility;

    public function __construct()
    {
        $this->_view = new ViewModel();
        $this->_variableLayout = array('title' => 'News');
        $this->_utility = new Utility();

        $menus = $this->_utility->getMenus('News');
        $this->_variableLayout = array_merge($this->_variableLayout, array('menus' => $menus));
    }

    public function indexAction()
    {
        $this->layout()->setVariables($this->_variableLayout);
        return $this->_view;
    }

    public function getNewsAction()
    {
        $this->_view->setTerminal(true);
        $request = $this->getRequest();

        if($request->isGet())
        {
            $commonDAO = $this->getServiceLocator()->get('CommonDAO');
            $news = $commonDAO->executeQuery('NEWS_GET_ALL', array());
            $this->_view->setVariable('news', $news);
            $this->_view->setTemplate('application/news/template/items.phtml');
        }

        return $this->_view;
    }

    public function getNewsItemAction()
    {
        $this->_view->setTerminal(true);
        $request = $this->getRequest();

        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        if($request->isGet())
        {
            $commonDAO = $this->getServiceLocator()->get('CommonDAO');
            $items = $commonDAO->executeQuery('NEWS_GET_BY_ID', array($id));
            if(count($items) > 0)
            {
                $this->_view->setVariable('item', $items[0]);
                $this->_view->setTemplate('application/news/template/item.phtml');
            }
        }

        return $this->_view;
    }
}