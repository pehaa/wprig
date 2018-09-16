const CONTACTFORMOBJECTFIELD = document.querySelector( '[name="id:cf7-object"]' );
const objects = [ 'partenariat', 'benevolat', 'projet', 'financement' ];

const niceObject = {
	partenariat: 'Demande de Partenariat',
	benevolat: 'Demande de Bénévolat',
	projet: 'Proposition de Projet',
	financement: 'Contact Financement'
};

if ( CONTACTFORMOBJECTFIELD && -1 !== objects.indexOf( pehaarigContactQuery ) ) {
	const cleanUri = location.protocol + '//' + location.host + location.pathname;
	window.history.replaceState( {}, document.title, cleanUri );
	window.location.hash = 'contact';
	CONTACTFORMOBJECTFIELD.setAttribute( 'value', niceObject[pehaarigContactQuery] );
}
