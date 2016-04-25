(function($) {

	$.fn.update = function(options) {

		var settings = {
			'valeur' : '', // valeur	� affecter au textbox de saisie	
			'propriete' : 'value' // propri�t� � modifier dans le controle HTML
		};

		var parametres = $.extend(settings, options);	

		this.each(function(options) {
			// mise � jour de la textbox et envoi du trigger change pour la m�morisation de la derni�re valeur saisie
			$(this).prop(parametres.propriete,parametres.valeur);
			$(this).trigger('change');
		});
	};

	$.fn.ajax = function(options) {

		var settings = {
			'divretour' : 'glajax_result', // nom du div de resultat (par defaut glajax_result) si le div n'existe pas il est cr�e
			'url' : '', // url de la requ�te pour l'AJAX o� se rajoutera la value du textbox
			'divclass' : '', // class appliqu�e � la div de r�sultat
			'nbmin' : 1, // nb de caract�res minimum avant de lancer la requ�te AJAX
			'positionmanuel' : false, // positionnement automatique sous le textbox si la valeur est � false
			'sauvervaleur': true, // sauvegarde de la valeur d�j� saisie dans le textbox
			'gardervaleurinitiale':true // si sauvegarde de la valeur on ne garde que la valeur initiale
		};

		var parametres = $.extend(settings, options);
		var vSelec = "#" + parametres.divretour;		 
		var vOldValue = "";
		var vClicOnDiv = false;
		var vId = "";
		var vFrappe  = "";
		var ajaxReq;
		var vInitiale = "";
		var vSaisie = false;

		this.each(function(options) {

			// le div de r�sultat n'existe pas, on le cr�e
			if ($(vSelec).length == 0) {
				var vIns = "<div id='" + parametres.divretour + "'><div>";				
				$('body').append(vIns);				
			}

			// r�cup de l'id tu textbox
			vId = $(this).prop('id');


			// on cache le div retour
			$("#"+parametres.divretour).hide();

			// r�cup�ration de la valeur initiale
			vInitiale = $("#"+vId).val();
			if(parametres.gardervaleurinitiale)
			{
				vOldValue = vInitiale;
			}
		
			// on detecte les clic sur le div de retour
			$("#"+parametres.divretour).click(function(){				
				vClicOnDiv = true;
			});

			// � chaque changement de valeur dans le textbox on v�rifie si l'on doit m�moriser une nouvelle valeur
			$(this).change(function(){
				if(parametres.sauvervaleur && !parametres.gardervaleurinitiale)
				{					
					vValue = $("#" + vId).prop("value");							
					if(vValue!=vOldValue && vValue!=vFrappe)
					{
						vOldValue=vValue;
					}
				}				
			});

			// fermeture du div sur un clic
			$(document).click(function() {
				// test si le div est ouvert			
				var vOpen = ($("#"+parametres.divretour).css('display')=='block') ? true : false;		
				 	
				if(vOpen)
				{
					if(parametres.sauvervaleur)
					{
						if(!vClicOnDiv && vOldValue!="")
						{	
							// on est sorti sans cliquer dans le div, si il existait une valeur avant la saisie
							// on la remet
							$("#" + vId).val(vOldValue);						  
						}
						vClicOnDiv = false;						
					}				
					$(vSelec).fadeOut("slow");						 
				}		
				else
				{					
					if(vSaisie)
					{
						if(parametres.sauvervaleur)
						{
							$("#" + vId).val(vOldValue);
						}						 
					}					 
				} 
				vSaisie = false;				
			});

			// reinit de la recherche sur un clic
			$(this).click(function(e) {
				// test si le div de retour est ouvert				
				//var vOpen = ($("#"+parametres.divretour).css('display')=='block') ? true : false;				
				 
				if(vSaisie)
				{					
					//if(vOpen)
					//{
						//if(parametres.sauvervaleur)
						//{										 			 			
							//$(this).val(vOldValue);
						//}
					//}	
					if(parametres.sauvervaleur)
					{			
						$(this).val(vOldValue);
					}		
					$(vSelec).fadeOut("slow");						
					vSaisie = false;
				}
				else
				{
					if(parametres.sauvervaleur)
					{
						if($(this).val()!="")
						{
							// sauvegarde de la valeur actuelle du champ avant la saisie
							if(!parametres.gardervaleurinitiale)
							{
								vOldValue = $(this).val();
							} 								 
						}
					}					 			 			
					$(this).val("");
					vSaisie = true;
				}
				$(vSelec).fadeOut("slow");										
				 
				e.stopPropagation();								 
			});

			 
			// lancement de la requ�te ajax
			$(this).keyup(function(e) {

				vSaisie = true;
				 
				// si open 
				// test touche echap
				if (e.keyCode == 27) 
				{ 
					if(ajaxReq!=null)
					{
						ajaxReq.abort();
					}
					$(vSelec).fadeOut("slow");	
					if(parametres.gardervaleurinitiale)
					{
						$(this).val(vOldValue);
					}
					vSaisie = false;
				} 
				 
				if(vSaisie)
				{
					var req = $(this).prop("value");
					// m�morisation de la frappe pour la gestion des valeurs d�j� saisies
					vFrappe = req;

					// si une requ�te est d�j� en cours on l'annule
					if(ajaxReq!=null)
					{
						ajaxReq.abort();
					}
					
					if (req.length >= parametres.nbmin) 
					{

						// r�cup position du textbox par rapport � son parent et sa hauteur
						var vOffset = $(this).offset();
						var vOH = $(this).outerHeight();
						
						// protection texte
						if (req.indexOf("\'")) 
						{
							req = req.replace("\'", "\\\'");
						}
						
						// GL pb GDN d'appel de page en dehors du rep, on teste si . en premier carc
						var vUrlTxt = parametres.url;
						/*if(vUrlTxt.length>0)
							{
								var vChar = vUrlTxt.charAt(0);
								if(vChar!='.')
									{
										vUrlTxt = "./" + vUrlTxt;
									}
							
							}*/
						 
						// requ�te AJAX
						ajaxReq = $.ajax(
						{
							type : "GET",
							url : vUrlTxt + req ,
							dataType : "html",
							error : function(msg, string) 
							{ // fonction erreur
								 
							},
							success : function(data) 
							{ // fonction ok
								// vidage du div resultat
								$(vSelec).html("");
								$(vSelec).empty();
								vClicOnDiv = false;
								// th�me par d�faut
								
								// GL 18.06.14 bug GDN quand on fixe une largeur, hauteur
								//$(vSelec).css("width", "250px");
								//$(vSelec).css("height", "100px");
								
								$(vSelec).css("overflow", "auto");
								// ajout de la classe d'affichage
								if (parametres.divclass != '') 
								{
									$(vSelec).addClass(parametres.divclass);								
								}
								else
								{
									$(vSelec).css("background-color", "#ffffff");								
								}
								// test si les valeur width et height sont d�finies
								// GL 18.06.14 bug GDN quand on fixe une largeur, hauteur
								var vTmpW = $(vSelec).css("width");
								var vTmpH = $(vSelec).css("height");

								if(vTmpW=="0px" || vTmpW=="0")
								{
									$(vSelec).css("width", "250px");
								}
								if(vTmpH=="0px" || vTmpH=="0")
								{
									$(vSelec).css("height", "100px");
								}	
												
								if (!parametres.positionmanuel) 
								{
									// positionnement du div de r�sultat
									$(vSelec).css("position", "absolute");
									$(vSelec).css("left", vOffset.left);
									$(vSelec).css("top", vOffset.top + vOH);
								}
								// affichage du div
								$(vSelec).show();
								// ajout du html dans le div
								$(vSelec).append(data);

							}
						});
					}
				}
			});
			return this;
		});
	};

})(jQuery);