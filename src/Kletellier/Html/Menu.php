<?php
 
namespace Kletellier\Html;
 

class Menu   {

	protected $menu_items;
	protected $title;
	protected $url;

	
	public function __construct()
	{
		$this->init();
		
	}
	 
	private function init()
	{
		$this->title = "";
		$this->url = \GL\Core\Helper\Utils::url('');
		$this->menu_items = array();
	}
 
	 
	public function getMenuItems()
	{
		return $this->menu_items;
	}
	

	public function addItem(\Kletellier\Html\MenuItem $mnuitem)
	{
		$this->menu_items[] = $mnuitem;
		return $this;
	}
 
	public function getTitle()
	{
		return $this->title;
	}
	 
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}
 
	/**
	* Set value of menu_items.
	*
	* @param mixed $menu_items the menu items
	*
	* @return self
	*/
	public function setMenuItems($menu_items)
	{
		$this->menu_items = $menu_items;
		return $this;
	}
	 
	/**
	* Get value of url.
	*/
	public function getUrl()
	{
		return $this->url;
	}
	 
	/**
	* Set value of url.
	*
	* @param mixed $url the url
	*
	* @return self
	*/
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

	public function getHtmlMenu()
	{		 
		$container = \GL\Core\DI\ServiceProvider::GetDependencyContainer();
	 	$tpl = new \GL\Core\Blade\Blade5Service();	 	 
	 	$tpl->setContainer($container);
	 	$tpl->setController('');
	 	$html = $tpl->render('menu',array('menu'=>$this));
	 	return $html;
	}
}