/*
* Ultimate Membership Pro - Gutenberg
*/
"use strict";
var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType,
    blockStyle = {};


registerBlockType( 'indeed-membership-pro/register-form', {
    title                 : 'Registration Form',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-register]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-register]' );
    },
});

registerBlockType( 'indeed-membership-pro/login', {
    title                 : 'Login Form',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-login-form]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-login-form]' );
    },
});

registerBlockType( 'indeed-membership-pro/checkout', {
    title                 : 'Checkout Page',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-checkout-page]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-checkout-page]' );
    },
});

registerBlockType( 'indeed-membership-pro/thankyou', {
    title                 : 'Thank You Page',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-thank-you-page]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-thank-you-page]' );
    },
});

registerBlockType( 'indeed-membership-pro/logout', {
    title                 : 'Logout Button',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-logout-link]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-logout-link]' );
    },
});

registerBlockType( 'indeed-membership-pro/password-reset', {
    title                 : 'Password Recovery',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-pass-reset]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-pass-reset]' );
    },
});

registerBlockType( 'indeed-membership-pro/user-page', {
    title                 : 'Member Portal',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-user-page]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-user-page]' );
    },
});

registerBlockType( 'indeed-membership-pro/subscription-plan', {
    title                 : 'Subscriptions Plan',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-select-level]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-select-level]' );
    },
});

registerBlockType( 'indeed-membership-pro/visitor-inside-user-page', {
    title                 : 'Public Individual Page',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-visitor-inside-user-page]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-visitor-inside-user-page]' );
    },
});

registerBlockType( 'indeed-membership-pro/login-modal', {
    title                 : 'Login Modal Trigger',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-login-popup]Login[/ihc-login-popup]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-login-popup]Login[/ihc-login-popup]' );
    },
});

registerBlockType( 'indeed-membership-pro/register-modal', {
    title                 : 'Registration Modal Trigger',
    icon                  : 'universal-access-alt',
    category              : 'ihc-shortcodes',

    edit: function() {
        return el( 'p', '', '[ihc-register-popup]Register[/ihc-register-popup]' );
    },
    save: function() {
        return el( 'p', '', '[ihc-register-popup]Register[/ihc-register-popup]' );
    },
});
