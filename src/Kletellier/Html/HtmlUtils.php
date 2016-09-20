<?php 

namespace Kletellier\Html; 

use GL\Core\Helpers\Utils;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Finder\Finder;
use GL\Core\Config\Config;

class HtmlUtils
{ 
	/**
	 * Return public webpath
	 * @return string
	 */
	public static function getTemplatePath()
	{
		return TEMPLATEPATH;
	}
	
	/**
	 * Return assets path to copy
	 * @return string
	 */
	public static function getAssetPath()
	{
		$ds =   DIRECTORY_SEPARATOR;
		$root = dirname(__FILE__);
		
		$path = $root . $ds . "assets";
		return $path;
	}
	
	/**
	 * Install all assets in public folder
	 * @return void
	 */
	public static function install()
	{
		$targetDir = self::getTemplatePath();
		$fs = new Filesystem();
		$originDir = self::getAssetPath();	
		try 
        {		
			$fs->mkdir($targetDir, 0777);
			$fs->mirror($originDir, $targetDir, Finder::create()->ignoreDotFiles(false)->in($originDir)); 		 
        } 
        catch (IOExceptionInterface $e) 
        {
            
        }		 
	}
 
} 