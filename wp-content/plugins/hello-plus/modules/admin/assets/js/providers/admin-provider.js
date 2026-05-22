import { createContext, useEffect, useState } from 'react';
import apiFetch from '@wordpress/api-fetch';

export const AdminContext = createContext();

export const AdminProvider = ( { children } ) => {
	const [ isLoading, setIsLoading ] = useState( true );
	const [ onboardingSettings, setOnboardingSettings ] = useState( {} );
	const [ elementorKitSettings, setElementorKitSettings ] = useState( {} );
	const [ stepAction, setStepAction ] = useState( '' );
	const [ step, setStep ] = useState( 0 );
	const [ isBlankKit, setIsBlankKit ] = useState( null );
	const { elementorInstalled, elementorActive, wizardCompleted, blankCanvasNonce } = onboardingSettings;
	const { elementorAppConfig } = window;

	useEffect( () => {
		if ( elementorAppConfig ) {
			setElementorKitSettings( elementorAppConfig[ 'kit-library' ] );
		}
	}, [ elementorAppConfig ] );

	useEffect( () => {
		if ( wizardCompleted || isBlankKit ) {
			setStep( 2 );
			return;
		}
		if ( false === elementorInstalled ) {
			setStepAction( 'install-elementor' );
		}
		if ( elementorInstalled && false === elementorActive ) {
			setStepAction( 'activate-elementor' );
		}
		if ( elementorInstalled && elementorActive ) {
			setStepAction( 'install-kit' );
			setStep( 1 );
		}
	}, [ elementorInstalled, elementorActive, wizardCompleted, isBlankKit ] );

	useEffect( () => {
		Promise.all( [
			apiFetch( { path: '/elementor-hello-plus/v1/onboarding-settings' } ),
		] ).then( ( [ onboarding ] ) => {
			setOnboardingSettings( onboarding.settings );
		} ).finally( () => {
			setIsLoading( false );
		} );
	}, [] );

	useEffect( () => {
		if ( null === isBlankKit || ! blankCanvasNonce ) {
			return;
		}

		wp.ajax.post( 'helloplus_set_blank_canvas_option', {
			value: isBlankKit,
			nonce: blankCanvasNonce,
		} );
	}, [ isBlankKit, blankCanvasNonce ] );

	return (
		<AdminContext.Provider value={ {
			onboardingSettings,
			stepAction,
			setStepAction,
			step,
			setStep,
			isLoading,
			elementorKitSettings,
			setIsLoading,
			setIsBlankKit,
			isBlankKit,
		} }>
			{ children }
		</AdminContext.Provider>
	);
};
