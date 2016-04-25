<?php 

namespace Kletellier\Assets; 

use GL\Core\Helpers\Utils;
use Stringy\Stringy as S;

class Assets
{ 
	 
    
	/**
	 * Return Html Buffer
	 * @param Array $jsfiles 
	 * @param Array $cssfiles 
	 * @return string
	 */
	private static function getHtml($jsfiles,$cssfiles)
	{
		$ret = "";
		
		foreach ($cssfiles as $cssfile) 
		{
			$ret.=self::getCssDeclaration($cssfile)."\n";
		}	
	
		foreach ($jsfiles as $jsfile) 
		{
			$ret.=self::getJsDeclaration($jsfile)."\n";
		}		
		
		return $ret;
	}

	private static function getCssDeclaration($cssfile)
	{
		$url = Utils::url($cssfile);		 
		return S::create("<link href='##file##' rel='stylesheet'>")->replace('##file##',$url)->__toString();
	}

	private static function getJsDeclaration($jsfile)
	{
		$url = Utils::url($jsfile);		 
		return S::create("<script src='##file##'></script>")->replace('##file##',$url)->__toString();
	}

	/**
	 * Get Ajax keypress search helper
	 * @return type
	 */
	public static function getAjax()
	{
		$jsfiles = array('gl/js/jquery.glajax.plugin.js');
   		$cssfiles = array();
   		return self::getHtml($jsfiles,$cssfiles);
	}

	/**
	 * Get tablescroll system with fixed header
	 * @return type
	 */
	public static function getTableScroll()
	{
		$jsfiles = array('gl/js/jquery.tablescroll.js');
   		$cssfiles = array('gl/css/jquery.tablescroll.css');
   		return self::getHtml($jsfiles,$cssfiles);
	}

	/**
	 * Return bootstrap declaration
	 * @return string
	 */
   public static function getBootstrap()
   {
   		$jsfiles = array('bootstrap/js/bootstrap.min.js');
   		$cssfiles = array('bootstrap/css/bootstrap.min.css');
   		return self::getHtml($jsfiles,$cssfiles);
   }

   /**
    * Return FontAwesome declaration
    * @return string
    */
   public static function getFontAwesome()
   {   		
   		$jsfiles = array();
   		$cssfiles = array('font-awesome/css/font-awesome.min.css');
   		return self::getHtml($jsfiles,$cssfiles);
   }

   /**
    * Return Leaflet declaration
    * @return type
    */
   public static function getLeafLet()
   {
   		$jsfiles = array('leaflet/leaflet.js');
   		$cssfiles = array('leaflet/leaflet.css');
   		return self::getHtml($jsfiles,$cssfiles);
   }

   /**
    * Return jquery declaration
    * @return string
    */
   public static function getJquery()
   {
   		$jsfiles = array('jquery/jquery.min.js');
   		$cssfiles = array();
   		return self::getHtml($jsfiles,$cssfiles);
   }

   /**
    * Return Moment.js declaration
    * @return type
    */
   public static function getMoment()
   {
   		$jsfiles = array('moment/moment.js');
   		$cssfiles = array();
   		return self::getHtml($jsfiles,$cssfiles);
   }

   /**
    * Get Infinite scroll with ajax loading
    * @return type
    */
    public static function getInfiniteScroll()
   {
   		$jsfiles = array('gl/js/jquery.scroll.js');
   		$cssfiles = array();
   		return self::getHtml($jsfiles,$cssfiles);
   }
   
}