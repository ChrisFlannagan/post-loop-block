const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.editor;
const { ServerSideRender, PanelBody, PanelRow, RangeControl, Button } = wp.components;

// import the PLB localized vars
const { blockName, defaultNum, totalPages } = FlannyPostLoopBlock;

registerBlockType(blockName, {
    title:      __('Post List Loop', 'flanny-plb'),
    icon:       'layout',
    category:   'common',
    attributes: {
        numberPosts: {
            type:    'number',
            default: defaultNum,
        },
        page:        {
            type:    'number',
            default: 1,
        },
        totalPages:  {
            type:    'number',
            default: 1,
        }
    },
    edit:       (props) => {
        const {
            className,
            attributes: {
                numberPosts,
                page,
             },
        } = props;

        const onChangeNumber = (data) => {
            props.setAttributes({ numberPosts: data.number, page: 1 });
        };

        let prevBtn;
        if ( props.attributes.page !== 1 ) {
            prevBtn = (
                <Button
                    isLink
                    className={`${className}-btn ${className}-btn-prev`}
                    onClick={() => prevPage()}
                >
                    {__('Prev', 'flanny-plb')}
                </Button>
            );
        }

        let nextBtn;
        if ( totalPages > props.attributes.page ) {
            nextBtn = (
                <Button
                    isLink
                    className={`${className}-btn ${className}-btn-next`}
                    onClick={() => nextPage()}
                >
                    {__('Next', 'flanny-plb')}
                </Button>
            );
        }

        const prevPage = () => {
            if ( props.attributes.page !== 1 ) {
                props.setAttributes({ page: props.attributes.page - 1 });
            }
        };

        const nextPage = () => {
            if ( totalPages > props.attributes.page ) {
                props.setAttributes({ page: props.attributes.page + 1 });
            }
        };

        return (
            <div className={className}>
                {
                    <InspectorControls>
                        <PanelBody title={__('Posts Per Page', 'flanny-plb')}>
                            <PanelRow>
                                <RangeControl
                                    value={props.attributes.numberPosts}
                                    onChange={(number) => onChangeNumber({ number })}
                                    min={1}
                                    max={50}
                                />
                            </PanelRow>
                        </PanelBody>
                    </InspectorControls>
                }
                <ServerSideRender
                    block={blockName}
                    attributes={{
                        numberPosts: props.attributes.numberPosts,
                        page:        props.attributes.page
                    }}
                />
                <div className={`${className}-btn-wrap`}>
                    {prevBtn}{nextBtn}
                </div>
            </div>
        );
    },
    save:       (props) => {
        return null;
    },
});
