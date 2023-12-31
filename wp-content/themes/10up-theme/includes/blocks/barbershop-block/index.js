/**
 * Barbershop Booker
 * Handles user booking with available hours
 */

/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import edit from './edit';
import block from './block.json';

/**
 * Register block
 */
registerBlockType(block, {
	edit,
	save: () => <InnerBlocks.Content />,
});
