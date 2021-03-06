'use strict';

module.exports = {
	theme: {
		slug: 'pehaarig',
		name: 'pehaarig',
		author: 'Paulina Hetman aka pehaa'
	},
	dev: {
		browserSync: {
			live: true,
			proxyURL: 'fondation-maintenant.test',
			bypassPort: '8181'
		},
		browserslist: [ // See https://github.com/browserslist/browserslist
			'> 1%',
			'last 2 versions'
		],
		debug: {
			styles: true, // Render verbose CSS for debugging.
			scripts: false // Render verbose JS for debugging.
		}
	},
	export: {
		compress: true
	}
};
