const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const blockStyle = {
	backgroundColor: '#900',
	color: '#fff',
	padding: '20px',
};

registerBlockType( 'flanny/post-list-loop', {
	title:    'Post List Loop',
	icon:     'dashicons-update-alt',
	category: 'common',
	edit: ( props ) => {
		return <div style = { blockStyle } > Hello World, step 1(from the editor ).</div>;
	},
	save: ( props ) => {
		return <div style={ blockStyle }>Hello World, step 1 (from the frontend).</div>;
	},
});
