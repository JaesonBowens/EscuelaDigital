var navegar = function () {
	var elemento = document.getElementById('slide-menu').getElementsByTagName('li');
	var pos = 0;
	for (var i=0; i<elemento.length; i++) {
		if (elemento[i].className == "selected") {
			elemento[i].className = "noselected";
			pos = i;
		}
	}
	/** Pulsar Anterior **/
	if (this.id == "prev" && pos > 0) {
		elemento[pos-1].className = "selected";
	} else if (this.id == "prev") {
		elemento[elemento.length-1].className = "selected";
	} 
	
	/** Pulsar Siguiente **/
	if (this.id == "next" && pos < elemento.length-1) {
		elemento[pos+1].className = "selected";		
	} else if (this.id == "next") {
		elemento[0].className = "selected";
	}
	return false;
};

var desplazar = function () {
	var nav = document.querySelectorAll(".boton-slide");
	for (var i=0; i<nav.length; i++) {
		nav[i].onclick = navegar; 
	}
};

window.onload = function (){
	new desplazar();
};