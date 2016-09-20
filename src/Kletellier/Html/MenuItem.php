<?php
 
namespace Kletellier\Html;
 

class MenuItem   
{
	protected $menu_items;
	protected $title;
	protected $link;
	protected $divider;
	protected $icon;
	
	public function __construct()
	{
		$this->init();
		
	}
	 
	private function init()
	{
		$this->menu_items = array();
		$this->divider = false;
		$this->link = "#";
		$this->title = "";
		$this->icon =  "";
	}
 
	public function getChildren()
	{
		return $this->menu_items;
	}
	

	public function addItem(\Kletellier\Html\MenuItem $mnuitem)
	{
		$this->menu_items[] = $mnuitem;
		return $this;
	}

	public function addItems(Array $menuitems)
	{
		$this->menu_items = array_merge($this->menu_items,$menuitems);
	}
 
	public function getTitle()
	{
		$title = $this->title;
		if($this->icon!="")
		{
			$title = "<i class='fa fa-". $this->icon . "'></i>&nbsp;".$title;
		}
		return $title;
	}
	 
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	} 
	  
	public function getLink()
	{
		return $this->link;
	}
	
	public function hasChildren()
	{
		return (count($this->menu_items)>0) ? true:false;
	}
	 
	public function setLink($link)
	{
		$this->link = (trim($link)!="") ? $link : "#";
		return $this;
	}	 
 
	public function getDivider()
	{
		return $this->divider;
	}	 
	 
	public function setDivider($divider)
	{
		$this->divider = $divider;
		return $this;
	}
  
	public function getMenuItems()
	{
		return $this->menu_items;
	}	 
   
	public function getIcon()
	{
		return $this->icon;
	}
	 
 
	public function setIcon($icon)
	{
		$this->icon = $icon;
		return $this;
	}
}