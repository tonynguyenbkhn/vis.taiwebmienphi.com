/*
* Ultimate Membership Pro - Gutenberg Locker
* updated @version 13.4
*/
"use strict";
(function(wp) {
const { registerBlockType } = wp.blocks;
const { InnerBlocks, InspectorControls } = wp.blockEditor || wp.editor;
const { SelectControl } = wp.components;
const { __ } = wp.i18n;
const { createElement, useState, useEffect } = wp.element;

registerBlockType('iump/locker', {
    title: __('Content Locker Shortcode'),
    icon: 'universal-access-alt',
    category: 'common',
    attributes: {
        lockerType: {
            type: 'string',
            default: '',
        },
        lockerTarget: {
            type: 'string',
            default: '',
        },
        template: {
            type: 'string',
            default: '',
        },
    },

    edit: (props) => {
        const { attributes, setAttributes } = props;
        const [templateOptions, setTemplateOptions] = useState([]);
        const [lockerTypeOptions, setLockerTypeOptions] = useState([]);
        const [lockerTargetOptions, setLockerTargetOptions] = useState([]);

        // set default options
        useEffect(() => {
          if ( typeof window.iump_locker_options != 'object' ){
            let lockerOptions = JSON.parse( window.iump_locker_options );
            setLockerTypeOptions( lockerOptions.lockerType );
            setLockerTargetOptions( lockerOptions.lockerTarget );
            setTemplateOptions( lockerOptions.templates );
          }

        }, []);

        return createElement('div', { className: 'iump-locker', style: { border: '1px dashed #999', padding: '10px' } }, [
            // block settings
            createElement(
                InspectorControls,
                {},
                createElement(SelectControl, {
                    label: __('Type'),
                    value: attributes.lockerType,
                    options: lockerTypeOptions.length > 0 ? lockerTypeOptions : [{label: 'Loading...', value: ''}],
                    onChange: (value) => setAttributes({ lockerType: value }),
                })
            ),
            createElement(
                InspectorControls,
                {},
                createElement(SelectControl, {
                    label: __('Target'),
                    value: attributes.lockerTarget,
                    options: lockerTargetOptions.length > 0 ? lockerTargetOptions : [{label: 'Loading...', value: ''}],
                    onChange: (value) => setAttributes({ lockerTarget: value }),
                    multiple  : true,
                })
            ),
            createElement(
                InspectorControls,
                {},
                createElement(SelectControl, {
                    label: __('Template'),
                    value: attributes.template,
                    options: templateOptions.length > 0 ? templateOptions : [{label: 'Loading...', value: ''}],
                    onChange: (value) => setAttributes({ template: value }),
                })
            ),
            createElement(InnerBlocks)
        ]);
    },

    save: () => {
        // save just InnerBlocks.
        return createElement(InnerBlocks.Content);
    }
});
})(window.wp);
