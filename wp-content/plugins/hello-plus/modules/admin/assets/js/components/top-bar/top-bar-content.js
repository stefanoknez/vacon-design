import Stack from '@elementor/ui/Stack';
import BrandElementorIcon from '../../icons/elementor.tsx';
import Typography from '@elementor/ui/Typography';
import XIcon from '@elementor/icons/XIcon';
import { __ } from '@wordpress/i18n';

export const TopBarContent = ( { sx = {}, iconSize = 'medium', onClose, actionButton } ) => {
	return (
		<Stack direction="row" sx={ { alignItems: 'center', minHeight: 50, px: 2, py: 1, backgroundColor: 'background.default', justifyContent: 'space-between', ...sx } }>
			<Stack direction="row" spacing={ 1 } alignItems="center">
				<BrandElementorIcon fontSize={ iconSize } sx={ { color: 'text.primary' } } />
				<Typography variant="subtitle1" sx={ { color: 'text.primary' } }>{ __( 'Hello+', 'hello-plus' ) }</Typography>
			</Stack>
			<Stack direction="row" spacing={ 2 } alignItems="center">
				{ actionButton }
				{ onClose && ( <XIcon onClick={ onClose } sx={ { cursor: 'pointer', color: 'text.primary' } } /> ) }
			</Stack>
		</Stack>
	);
};
