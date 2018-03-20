//cette fonction n'est plus utilisée j'ai mis un autocomplete à la place
//se lance quand l'adresse change
//elle met à jour la liste des adresses commençant par ce qui a été saisi par l'utilisateur
function remplirListeDesAdresses()
{
  //recup du debut du code postal de la commune
  var debutAdresse=document.getElementById('idAdresse').value;
  if(debutAdresse.length >10)//à partir de 10 caractères
  {
	  var dataListeAdresses=document.getElementById('datalistAdresses');
	  //j'efface toutes les options de la datalist
	  //essais
	  $(dataListeAdresses).empty();
	  var noAdresse;
	  var nbAdresses=dataListeAdresses.length;
	  for (noAdresse = 0; noAdresse < nbAdresses; noAdresse++) 
	  {
	    dataListeAdresses.remove(0);
	  }
	  //je cree ma requete vers le serveur data.gouv.fr
	  var request = new XMLHttpRequest();
	  // prise en charge des chgts d'état de la requete
	  request.onreadystatechange = function(response) 
	  {
	    if (request.readyState === 4) 
	    {
	      if (request.status === 200) 
	      {
			// j'obtient la reponse au format json et l'analyse on obtient un tableau
			var tabJsonOptions = JSON.parse(request.responseText);
			//alert (tabJsonOptions.features[0].properties.label);
			//alert(request.responseText);
			// pour chaque ligne du tableau.
			var noLigne;
			if(tabJsonOptions.features.length==1)
			{
				//remplir les zones de saisie cpostal et ville
				var laVille=document.getElementById("idVille");
				laVille.setAttribute("value",tabJsonOptions.features[0].properties.city);
				var leCp=document.getElementById("idCP");
				leCp.setAttribute("value",tabJsonOptions.features[0].properties.postcode);
				var laRue=document.getElementById("idRue");
				laRue.setAttribute("value",tabJsonOptions.features[0].properties.street);
				//latitude et longitude
				var laLatitude=document.getElementById("idLatitude");
				laLatitude.setAttribute("value",tabJsonOptions.features[0].geometry.coordinates[1]);
				var laLongitude=document.getElementById("idLongitude");
				laLongitude.setAttribute("value",tabJsonOptions.features[0].geometry.coordinates[0]);
			}
			else
			{
				for(noLigne=0;noLigne<tabJsonOptions.features.length;noLigne++)
				{ 
					// Cree une nouvelle <option>.
					var nouvelleOption = document.createElement('option');
					// on renseigne la value de l'option avec le numéro du produit.
					nouvelleOption.value = tabJsonOptions.features[noLigne].properties.label;
					//on affiche aussi le codePostal et la commune
					nouvelleOption.text=nouvelleOption.value;
					// ajout  de l'<option> en tant qu'enfant de la liste de selection des produits.
					dataListeAdresses.appendChild(nouvelleOption);
					alert('option ajoutee'+tabJsonOptions.features[noLigne].properties.label);
				}
			}
	      } 
	       else 
	       {
		  // An error occured :(
		  alert("Couldn't load datalist options :(");
	       }
	    }
	  };
	  //recup du debut du code postal de la commune
	  var debutAdresse=document.getElementById('idAdresse').value;
	  //formation du texte de la requete
	  var texteRequeteAjax='https://api-adresse.data.gouv.fr/search/?limit=10&q='+debutAdresse;
	  //je l'ouvre
	  request.open('GET', texteRequeteAjax, true);
	  //et l'envoie
	  request.send();
  }//fin du si + de 5 caractères ont été saisi
}


	//auto complément de l'adresse ville et code postal
	$("#idAdresse").autocomplete({
	source: function (request, response) {
		$.ajax({
			url: "https://api-adresse.data.gouv.fr/search/?limit=5",
			data: { q: request.term },
			dataType: "json",
			success: function (data) {
				response($.map(data.features, function (item) {
					return { label: item.properties.label, postcode: item.properties.postcode,city: item.properties.city, value: item.properties.label, street: item.properties.street, name: item.properties.name, latitude: item.geometry.coordinates[1],longitude: item.geometry.coordinates[0]};
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#idCP').val(ui.item.postcode);
		$('#idVille').val(ui.item.city);
		if(ui.item.street)
		$('#idRue').val(ui.item.street);
	    else
		$('#idRue').val(ui.item.name);
	    $("#idLatitude").val(ui.item.latitude);
	    $("#idLongitude").val(ui.item.longitude);
	}
});