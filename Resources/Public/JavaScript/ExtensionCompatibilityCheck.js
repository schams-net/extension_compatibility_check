/*
 * This file is part of the TYPO3 CMS Extension "Extension Compatibility Check"
 * Extension author: Michael Schams - https://schams.net
 *
 * For copyright and license information, please read the LICENSE.txt
 * file distributed with this source code.
 *
 * @package     TYPO3
 * @subpackage  extension_compatibility_check
 * @author      Michael Schams <schams.net>
 * @link        https://schams.net
 */

$(document).ready(function () {
    $("body").keypress(function (event) {
        if (event.which == 32 ) {
            event.preventDefault();
            $('div.Extbase-Utility-Debugger-VarDump').toggleClass('hidden');
        }
    });

    $('button.btn-execute-checks').click(function () {

        $('div.extensionList .icon span.glyphicon').addClass('hidden');
        $('div.extensionList .message').html('');

        $('div.extensionList').each(function (index, element) {
            var extension_key = $(this).attr('data-extension-key');
            var typo3_reference_version = $(this).attr('data-typo3-reference-version');
            var extension_reference_version = $(this).attr('data-extension-reference-version');
            var extension_current_version_dependency = $(this).attr('data-extension-current-version-dependency');

            var response = $.ajax({
                url: TYPO3.settings.ajaxUrls['ExtensionCompatibilityCheck::AjaxDispatch'],
                dataType: 'json',
                async: false,
                data: {
                    'action': 'checkCompatibility',
                    'extension': extension_key,
                    'typo3ReferenceVersion': typo3_reference_version,
                    'extensionReferenceVersion': extension_reference_version,
                    'extensionCurrentVersionDependency': extension_current_version_dependency
                },
                beforeSend: function () {
                    $('div[data-extension-key="' + extension_key + '"] .icon .loading').spin({
                        lines: 11,
                        length: 5,
                        width: 2,
                        radius: 2,
                        speed: 1.6,
                        trail: 40
                    });
                    $('div[data-extension-key="' + extension_key + '"] .message').html('Loading...');
                },
                success: function (data) {
                    var message = '';
                    if (data.message) {
                        message = data.message;
                    } else {
                        message = 'unknown error';
                    }
                    $('div[data-extension-key="' + extension_key + '"] .message').html(message);

                    if (data.result && data.result == 'ok') {
                        $('div[data-extension-key="' + extension_key + '"] .icon .glyphicon-ok-sign').removeClass('hidden');
                    } else if (data.result && data.result == 'update') {
                        $('div[data-extension-key="' + extension_key + '"] .icon .glyphicon-ok-sign').removeClass('hidden');
                        $('div[data-extension-key="' + extension_key + '"] .icon .glyphicon-ok-sign').css({'color': 'orange'});
                    } else {
                        $('div[data-extension-key="' + extension_key + '"] .icon .glyphicon-remove-sign').removeClass('hidden');
                    }
                },
                complete: function (jqXHR, textStatus) {
                    $('div[data-extension-key="' + extension_key + '"] .icon .loading').spin(false).addClass('hidden');
                }
            });
        });
    });

    $('button.btn-getinfo').click(function () {
        $('div.info').toggle();
    });
});

/**
 * Copyright (c) 2011-2014 Felix Gnass
 * Licensed under the MIT license
 * http://spin.js.org/
 */

;(function (factory) {
    if (typeof exports == 'object') {
        factory(require('jquery'), require('spin.min.js'))
    } else if (typeof define == 'function' && define.amd) {
        define(['jquery', 'spin'], factory)
    } else {
        if (!window.Spinner) {
            throw new Error('spin.js not present');
        }
        factory(window.jQuery, window.Spinner)
    }
}(function ($, Spinner) {
    $.fn.spin = function (opts, color) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data()
            if (data.spinner) {
                data.spinner.stop()
                delete data.spinner
            }
            if (opts !== false) {
                opts = $.extend({ color: color || $this.css('color') }, $.fn.spin.presets[opts] || opts)
                data.spinner = new Spinner(opts).spin(this)
            }
        })
    }
    $.fn.spin.presets = {
        tiny: { lines: 8, length: 2, width: 2, radius: 3 },
        small: { lines: 8, length: 4, width: 3, radius: 5 },
        large: { lines: 10, length: 8, width: 4, radius: 8 }
    }
}));
