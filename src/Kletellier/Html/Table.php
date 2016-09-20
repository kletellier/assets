<?php
 
namespace Kletellier\Html;
 

class Table   {
 
	protected $colonnes;
	protected $data;
	protected $url_tri;
	protected $id;
	protected $classes;
	protected $has_footer;
	protected $id_tbody;
	protected $is_responsive;

	public static function create()
	{
		return new Table();
		
	}
	
	public function __construct()
	{
		$this->init();
	
	}
	
	private function init()
	{
		$this->has_footer = false;
		$this->data = null;
		$this->colonnes = array();
		$this->url_tri = "";
		$this->classes = array();
		$this->is_responsive = false;
		$this->id_tbody = "tbody_".uniqid();
	}
	 
	public function donneClasses()
	{		 
		return implode(" ",$this->classes);
	}
	
 
	/**
	* Retourne value of colonnes.
	*/
	public function getColonnes()
	{
		return $this->colonnes;
	}
	 
	/**
	* Definit value of colonnes.
	*
	* @param mixed $colonnes the colonnes
	*
	* @return self
	*/
	public function addColonne($colonne)
	{
		$tmp = $colonne;
		if($tmp->getTriable())
		{
			if(trim($tmp->getTriUrl())=="" && $this->url_tri!="")
			{
				$tmp->setTriUrl($this->url_tri);
			}
		}
		$this->colonnes[] = $tmp;
		return $this;
	}
	 
	/**
	* Retourne value of data.
	*/
	public function getData()
	{
		return $this->data;
	}
	 
	/**
	* Definit value of data.
	*
	* @param mixed $data the data
	*
	* @return self
	*/
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}
	 
 
	 
	/**
	* Definit value of colonnes.
	*
	* @param mixed $colonnes the colonnes
	*
	* @return self
	*/
	public function setColonnes($colonnes)
	{
		$this->colonnes = $colonnes;
		return $this;
	}
	 
	/**
	* Retourne value of id.
	*/
	public function getId()
	{
		return $this->id;
	}
	 
	/**
	* Definit value of id.
	*
	* @param mixed $id the id
	*
	* @return self
	*/
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
 
	/**
	* Retourne value of classes.
	*/
	public function getClasses()
	{
		return $this->classes;
	}
	 
	/**
	* Definit value of classes.
	*
	* @param mixed $classes the classes
	*
	* @return self
	*/
	public function setClasses($classes)
	{
		if(is_array($classes))
		{
			$this->classes = array_merge($this->classes, $classes);
		}
		if(is_string($classes))
		{
			$this->classes[] = $classes;
		}
		
		return $this;
	}
	 
	/**
	* Retourne value of url_tri.
	*/
	public function getUrlTri()
	{
		return $this->url_tri;
	}
	 
	/**
	* Definit value of url_tri.
	*
	* @param mixed $url_tri the url tri
	*
	* @return self
	*/
	public function setUrlTri($url_tri)
	{
		$this->url_tri = $url_tri;
		return $this;
	}
	 
	/**
	* Retourne value of has_footer.
	*/
	public function getHasFooter()
	{
		return $this->has_footer;
	}
	 
	/**
	* Definit value of has_footer.
	*
	* @param mixed $has_footer the has footer
	*
	* @return self
	*/
	public function setHasFooter($has_footer)
	{
		$this->has_footer = $has_footer;
		return $this;
	}
	 
	/**
	* Retourne value of id_tbody.
	*/
	public function getIdTbody()
	{
		return $this->id_tbody;
	}
	 
	/**
	* Definit value of id_tbody.
	*
	* @param mixed $id_tbody the id tbody
	*
	* @return self
	*/
	public function setIdTbody($id_tbody)
	{
		$this->id_tbody = $id_tbody;
		return $this;
	}
	 
	/**
	* Retourne value of is_responsive.
	*/
	public function getIsResponsive()
	{
		return $this->is_responsive;
	}
	 
	/**
	* Definit value of is_responsive.
	*
	* @param mixed $is_responsive the is responsive
	*
	* @return self
	*/
	public function setIsResponsive($is_responsive)
	{
		$this->is_responsive = $is_responsive;
		return $this;
	}
	}