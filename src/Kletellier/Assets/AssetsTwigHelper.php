<?php 
namespace Kletellier\Assets;
  
use Symfony\Component\DependencyInjection\ContainerInterface;
use Kletellier\Assets\Assets;

/**
 * Add function to Twig
 */
class AssetsTwigHelper extends \Twig_Extension
{
  protected $container;   

  public function __construct(ContainerInterface $container = null)
  {
       $this->container = $container;
  }
  
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('assets_bootstrap', array($this,'bootstrap'),array('is_safe'=>array('html'))),  
            new \Twig_SimpleFunction('assets_jquery', array($this,'jquery'),array('is_safe'=>array('html'))),  
            new \Twig_SimpleFunction('assets_fontawesome', array($this,'fontawesome'),array('is_safe'=>array('html'))),  
            new \Twig_SimpleFunction('assets_ajaxsearch', array($this,'ajaxsearch'),array('is_safe'=>array('html'))),         
            new \Twig_SimpleFunction('assets_tablescroll', array($this,'tablescroll'),array('is_safe'=>array('html'))),
            new \Twig_SimpleFunction('assets_moment', array($this,'moment'),array('is_safe'=>array('html'))),       
            new \Twig_SimpleFunction('assets_leaflet', array($this,'leaflet'),array('is_safe'=>array('html'))),  
            new \Twig_SimpleFunction('assets_infinitescroll', array($this,'infinitescroll'),array('is_safe'=>array('html'))), 
            new \Twig_SimpleFunction('assets_flagiconcss', array($this,'flagiconcss'),array('is_safe'=>array('html'))), 
        );
    }
	
    public function getFilters()
    {
        return array(            
			 
        );
    }

    public function flagiconcss()
    {
        return Assets::getFlagIconCss();
    }

    public function moment()
    {
        return Assets::getMoment();
    }

    public function leaflet()
    {
        return Assets::getLeafLet();
    }

    public function infinitescroll()
    {
        return Assets::getInfiniteScroll();
    }

    public function tablescroll()
    {
        return Assets::getTableScroll();
    }

    public function ajaxsearch()
    {
        return Assets::getAjax();
    }

    public function jquery()
    {
        return Assets::getJquery();    
    }
    
	
    public function fontawesome()
    {
        return Assets::getFontAwesome();    
    }
    
    public function bootstrap()
    {
        return Assets::getBootstrap();    
    }
    
    
    public function getName()
    {
        return 'AssetsTwigHelper';
    }

}