const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

const blockStyle = {
	backgroundColor: '#900',
	color: '#fff',
	padding: '20px',
};

registerBlockType( 'flanny/post-list-lip', {
	title:    'Post List Loop',
	icon:     'universal-access-alt',
	category: 'layout',
	edit: ( props ) => {
		return <div style = { blockStyle } > Hello World, step 1(from the editor ).</div>;
	},
	save: ( props ) => {
		return <div style={ blockStyle }>Hello World, step 1 (from the frontend).</div>;
	},
});
