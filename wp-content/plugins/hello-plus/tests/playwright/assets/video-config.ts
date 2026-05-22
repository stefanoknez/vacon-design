import type { TestInfo } from '@playwright/test';
import { resolve } from 'path';

export function getVideoConfig( testInfo: TestInfo ) {
	if ( process.env.CI ) {
		return {
			dir: resolve( process.cwd(), 'test-results' ),
			size: { width: 1920, height: 1080 },
		};
	}
	return undefined;
}

