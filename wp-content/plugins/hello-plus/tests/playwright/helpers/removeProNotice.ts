export function setupNoticeRemoval() {
	return () => {
		const removeNotices = () => {
			const elements = document.querySelectorAll( '#e-notice-bar' );
			elements.forEach( ( el ) => {
				console.log( '🗑️ CTA Test: Removing notice element: #e-notice-bar' );
				el.remove();
			} );

			if ( elements.length > 0 ) {
				console.log( `🧹 CTA Test: Removed ${ elements.length } notice elements` );
			}
		};

		removeNotices();

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', removeNotices );
		}

		const observer = new MutationObserver( ( mutations ) => {
			let needsRemoving = false;
			mutations.forEach( ( mutation ) => {
				mutation.addedNodes.forEach( ( node ) => {
					if ( 1 === node.nodeType ) {
						const element = node as HTMLElement;
						if ( 'e-notice-bar' === element.id ) {
							needsRemoving = true;
						}
					}
				} );
			} );
			if ( needsRemoving ) {
				setTimeout( removeNotices, 100 );
			}
		} );

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', () => {
				observer.observe( document.body, { childList: true, subtree: true } );
			} );
		} else {
			observer.observe( document.body, { childList: true, subtree: true } );
		}

		console.log( '🔍 CTA Test: Notice removal system initialized for Elementor Pro' );
	};
}
