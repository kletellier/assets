<?php 

namespace Kletellier\Assets; 

use GL\Core\Helpers\Utils;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Finder\Finder;
use GL\Core\Config\Config;

class AssetsUtils
{ 
	/**
	 * Return public webpath
	 * @return string
	 */
	public static function getPublicPath()
	{
		return Utils::getPublicPath();
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
		$targetDir = self::getPublicPath();
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

	 /**
	 * Verify and install Twig Helper
	 * @return type
	 */
	public static function verifyHelper()
	{
		try 
		{
			$cfg = new Config("twig");
			$values = $cfg->load();
			if(!array_key_exists("assets",$values))
			{
				$arr = array();
				$arr["class"] = "\Kletellier\Assets\AssetsTwigHelper";
				$values["assets"] = $arr;
				$cfg->save($values);
			}
		} 
		catch (Exception $e) 
		{
			
		}
	}
} 