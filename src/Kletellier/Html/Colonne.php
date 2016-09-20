<?php
 
namespace Kletellier\Html;

class Colonne   {

	protected $nom;
	protected $footer_value;
	protected $colonne;
	
	protected $classesFoot;
	protected $classesHead;
	protected $classes;
	
	protected $triable;
	protected $tri_ordre;
	protected $tri_code;
	protected $tri_icone;
	protected $tri_param; 
	protected $tri_url;
	
 	protected $use_all_data;
	protected $is_relation;

	protected $formatages;
	protected $formatageClasses;

	/**
	 * constructeur static
	 * @return type
	 */
	public static function create()
	{
		return new Colonne();
	}

	/**
	 * Constructeur
	 * @return void
	 */
	public function __construct()
	{
	
		$this->init();
	}
	
	/**
	 * Fonction privée d'initialisation des variables internes
	 * @return void
	 */
	private function init()
	{
		$this->nom = "";
		$this->footer_value = "";
		$this->colonne = "";
		$this->tri = "";
		$this->triparam = "";
		$this->tricode = "";

		$this->classes = array();
		$this->classesHead= array();
		$this->classesFoot = array();
		$this->formatages = array(); 

		$this->formatageClasses = array();

		$this->triable = false;
		$this->use_all_data = false;
		$this->triicone = false;
		$this->is_relation= false;
		$this->urltri = "";
	}

	/**
	 * Retourne l'url de tri pour cette colonne
	 * @return string
	 */
	public function donneTriUrl()
	{
		$nom = $this->nom;
		$contains = (strpos($this->tri_url,"?")===FALSE) ? false:true; 
		$url = ($contains) ? $this->tri_url."&" : $this->tri_url."?";
		$url.= $this->tri_param."=".$this->tri_code;
		$actcode = $this->tri_ordre;
		$nextcode = ($this->tri_ordre=="asc") ? "desc" : "asc";
		$url.="&ordre=".$nextcode;
		$icone = "";
		if($this->tri_icone)
		{
			$icone = "<span class='fa fa-sort-alpha-$actcode'></span>&nbsp;";
		}
		$ret = "<a href='$url'>$icone $nom</a>";
  
		return $ret;
	}

	/**
	 * Retourne les classes pour les TD de cette colonne
	 * @return string
	 */
	public function donneClasses()
	{
		return implode(" ",$this->classes);
	}

	/**
	 * Retourne les classes pour les TD du TFOOT de cette colonne
	 * @return string 
	 */
	public function donneClassesFooter()
	{
		return implode(" ",$this->classesFoot);
	}

	/**
	 * Retourne les classes pour les TH du THEAD de cette colonne
	 * @return string
	 */
	public function donneClassesHead()
	{
		return implode(" ",$this->classesHead);
	}

	/**
	 * Retourne une classe pour le TD en fonction des données de la ligne fournie
	 * @param Eloquent Row $data ligne de data complète (l'ensemble des colonnes)
	 * @return string
	 */
	public function donneClassesFromData($data)
	{	
		$ret = "";
		if(!$this->use_all_data)
		{
			$colonne = $this->colonne;
			$ret = $data->$colonne;	
		}		
		$formatages = $this->formatageClasses;
		if(isset($formatages))
		{
			$classes = array();
			foreach ($formatages as $ft) 
			{	 
				if($this->use_all_data)
				{
					$classes[] = call_user_func_array($ft,array($data));
				}	
				else 
				{
					$classes[] = call_user_func_array($ft,array($ret));
				}					
			}
			$ret = (count($classes)>0) ? implode(" ",$classes) : "";
		}	
		return $ret; 
	} 	 	 

	/**
	 * Fonction privée pour la template qui retourne la valeur contenu dans le TD
	 * @param Eloquent Row $data ligne de data complète (l'ensemble des colonnes)
	 * @return string
	 */
	private function getvalue($data)
	{		 
		$ret = "";
		if(!$this->use_all_data)
		{
			switch ($this->is_relation) {
				case true:
					$arr = explode(".",$this->colonne);
					$ret = $data;
					foreach ($arr as $value) 
					{
						if(isset($ret->$value))
						{
							$ret = $ret->$value;
						}
						else
						{
							$ret = "";
						}
						
					}					 		 
					break;
				case false:
					$colonne = $this->colonne;
					$ret = $data->$colonne;
					break;				 
			}
		}		
		$formatages = $this->formatages;
		if(isset($formatages))
		{
			foreach ($formatages as $ft) 
			{	 
				if($this->use_all_data)
				{
					$ret = call_user_func_array($ft,array($data));
				}	
				else 
				{
					$ret = call_user_func_array($ft,array($ret));
				}					
			}
		}	
		return $ret;
	} 	

	/**
	 * Fonction pour la template qui retourne la valeur contenu dans le TD
	 * @param Eloquent Row $data ligne de data complète (l'ensemble des colonnes)
	 * @return string
	 */
	public function donneValeurTd($data)
	{
		return $this->getvalue($data);			 
	}	 
 
	/**
	* Retourne le texte dans le TH du THEAD.
	*/
	public function getTHEAD_Html()
	{
		$ret = $this->nom;
		if($this->triable)
		{
			$ret = $this->donneTriUrl();
		}
		 
		return $ret;
	}
	 
	/**
	* Definit le texte dans le TH du THEAD.
	*
	* @param mixed $nom the nom
	*
	* @return self
	*/
	public function setTHEAD_Html($nom)
	{
		$this->nom = $nom;
		return $this;
	}
	 
	/**
	* Retourne le nom de la colonne dans la base de données
	*/
	public function getColonne()
	{
		return $this->colonne;
	}
	 
	/**
	* Definit le nom de la colonne dans la base de données
	*
	* @param mixed $colonne the colonne
	*
	* @return self
	*/
	public function setColonne($colonne)
	{
		$this->colonne = $colonne;
		return $this;
	}
	 
 
	 
	/**
	* Retourne les classes pour le TD.
	*/
	public function getClasses()
	{
		return $this->classes;
	}
	 
	/**
	* Ajoute une ou des classes pour le TD
	*
	* @param array|string $classes the classes
	*
	* @return self
	*/
	public function addClasses($classes)
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
	* retourne si la colonne est triable
	*/
	public function getTriable()
	{
		return $this->triable;
	}
	 
	/**
	* Definit si la colonne est triable
	*
	* @param mixed $triable the triable
	*
	* @return self
	*/
	public function setTriable($triable)
	{
		$this->triable = $triable;
		return $this;
	}
	 
	/**
	* Retourne les fonctions de formatages qui seront appliquées au TD
	*/
	public function getFormatages()
	{
		return $this->formatages;
	}
	 
	/**
	* Definit une fonction de formatage à appliquer à la valeur du TD.
	*
	* @param callable $formatage fonction callable
	*
	* @return self
	*/
	public function addFormatage($formatage)
	{
		if(!is_callable($formatage))
		{
			throw new Exception("le formatage doit être un callable voir doc : http://php.net/manual/fr/language.types.callable.php ");
		}
		$this->formatages[] = $formatage;
		return $this;
	}
 
	/**
	* Retourne la classe qui sera appliqué au TH du THEAD
	*/
	public function getClassesHead()
	{
		return $this->classesHead;
	}
	 
	/**
	* Definit value of classesHead.
	*
	* @param mixed $classesHead the classes head
	*
	* @return self
	*/
	public function addClassesHead($classesHead)
	{
		if(is_array($classesHead))
		{
			 $this->classesHead = array_merge( $this->classesHead, $classesHead);
		}
		if(is_string($classesHead))
		{
			 $this->classesHead[] = $classesHead;
		}
		return $this;
	} 

	public function addClassesFooter($classesFooter)
	{
		if(is_array($classesFooter))
		{
			 $this->classesFoot = array_merge( $this->classesFoot, $classesFooter);
		}
		if(is_string($classesFooter))
		{
			 $this->classesFoot[] = $classesFooter;
		}
		return $this;
	}
  
	 
	/**
	* Retourne si on doit utiliser l'ensemble de la ligne de data pour générer le contenu du TD
	*/
	public function getUseAllData()
	{
		return $this->use_all_data;
	}
	 
	/**
	* Definit si on doit utiliser l'ensemble de la ligne de data pour générer le contenu du TD
	*
	* @param mixed $use_all_data the use all data
	*
	* @return self
	*/
	public function setUseAllData($use_all_data)
	{
		$this->use_all_data = $use_all_data;
		return $this;
	}
	 
	 
	 
	/**
	* Retourne les fonction de formatage qui permettent d'afficher des classes pour le TD en fonction des données
	*/
	public function getFormatageClasses()
	{
		return $this->formatageClasses;
	}
	 
	/**
	* Definit les fonction de formatage qui permettent d'afficher des classes pour le TD en fonction des données
	*
	* @param mixed $formatageClasses the formatage classes
	*
	* @return self
	*/
	public function addFormatageClasses($formatage)
	{
		if(!is_callable($formatage))
		{
			throw new Exception("le formatage doit être un callable voir doc : http://php.net/manual/fr/language.types.callable.php");
		}
		$this->formatageClasses[] = $formatage;
		return $this;
	}
 
	/**
	* Retourne value of nom.
	*/
	public function getNom()
	{
		return $this->nom;
	}
	 
	/**
	* Definit value of nom.
	*
	* @param mixed $nom the nom
	*
	* @return self
	*/
	public function setNom($nom)
	{
		$this->nom = $nom;
		return $this;
	}
	 
	/**
	* Definit value of classesHead.
	*
	* @param mixed $classesHead the classes head
	*
	* @return self
	*/
	public function setClassesHead($classesHead)
	{
		$this->classesHead = $classesHead;
		return $this;
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
		$this->classes = $classes;
		return $this;
	}
	 
	/**
	* Retourne l'ordre du tri qui sera mis dans l'url de tri (ex : ASC ou DESC)
	*/
	public function getTriOrdre()
	{
		return $this->tri_ordre;
	}
	 
	/**
	* Definit l'ordre du tri qui sera mis dans l'url de tri (ex : ASC ou DESC)
	*
	* @param mixed $tri_ordre the tri ordre
	*
	* @return self
	*/
	public function setTriOrdre($tri_ordre)
	{
		$this->tri_ordre = $tri_ordre;
		return $this;
	}
	 
	/**
	* Retourne le code qui sera rattaché au parametre dans la querystring de l'url de tri
	*/
	public function getTriCode()
	{
		return $this->tri_code;
	}
	 
	/**
	* Definit le code qui sera rattaché au parametre dans la querystring de l'url de tri
	*
	* @param mixed $tri_code the tri code
	*
	* @return self
	*/
	public function setTriCode($tri_code)
	{
		$this->tri_code = $tri_code;
		return $this;
	}
	 
	/**
	* Retourne si une iconde de tri doit être affichée
	*/
	public function getTriIcone()
	{
		return $this->tri_icone;
	}
	 
	/**
	* Definit si une iconde de tri doit être affichée
	*
	* @param mixed $tri_icone the tri icone
	*
	* @return self
	*/
	public function setTriIcone($tri_icone)
	{
		$this->tri_icone = $tri_icone;
		return $this;
	}
	 
	/**
	* Retourne le paramêtre qui sera ajouté dans l'url de tri
	*/
	public function getTriParam()
	{
		return $this->tri_param;
	}
	 
	/**
	* Definit le paramêtre qui sera ajouté dans l'url de tri
	*
	* @param mixed $tri_param the tri param
	*
	* @return self
	*/
	public function setTriParam($tri_param)
	{
		$this->tri_param = $tri_param;
		return $this;
	}
	  
	 
	 
	/**
	* Retourne la valeur de l'url de tri de base
	*/
	public function getTriUrl()
	{
		return $this->tri_url;
	}
	 
	/**
	* Definit la valeur de l'url de tri de base
	*
	* @param mixed $tri_url the tri url
	*
	* @return self
	*/
	public function setTriUrl($tri_url)
	{
		$this->tri_url = $tri_url;
		return $this;
	}
	 
	/**
	* Definit value of formatages.
	*
	* @param mixed $formatages the formatages
	*
	* @return self
	*/
	public function setFormatages($formatages)
	{
		$this->formatages = $formatages;
		return $this;
	}
	 
	/**
	* Definit value of formatageClasses.
	*
	* @param mixed $formatageClasses the formatage classes
	*
	* @return self
	*/
	public function setFormatageClasses($formatageClasses)
	{
		$this->formatageClasses = $formatageClasses;
		return $this;
	}
	 
	/**
	* Retourne value of is_relation.
	*/
	public function getIsRelation()
	{
		return $this->is_relation;
	}
	 
	/**
	* Definit value of is_relation.
	*
	* @param mixed $is_relation the is relation
	*
	* @return self
	*/
	public function setIsRelation($is_relation)
	{
		$this->is_relation = $is_relation;
		return $this;
	}
	 
	/**
	* Retourne value of footer_value.
	*/
	public function getFooterValue()
	{
		return $this->footer_value;
	}
	 
	/**
	* Definit value of footer_value.
	*
	* @param mixed $footer_value the footer value
	*
	* @return self
	*/
	public function setFooterValue($footer_value)
	{
		$this->footer_value = $footer_value;
		return $this;
	}
	}