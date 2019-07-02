/*!
 * bootstrap-fileinput v4.5.2
 * http://plugins.krajee.com/file-input
 *
 * Glyphicon (default) theme configuration for bootstrap-fileinput.
 *
 * Author: Kartik Visweswaran
 * Copyright: 2014 - 2018, Kartik Visweswaran, Krajee.com
 *
 * Licensed under the BSD 3-Clause
 * https://github.com/kartik-v/bootstrap-fileinput/blob/master/LICENSE.md
 */
(function ($) {
    "use strict";

    $.fn.fileinputThemes.gly = {
        fileActionSettings: {
            dragIcon: '<i class="fa fa-arrows-alt"></i>',
            // dragIcon: '<i class="glyphicon glyphicon-move"></i>',
            removeIcon: '<i class="fa fa-times"></i>',
            // removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
            uploadIcon: '<i class="fa fa-upload"></i>',
            // uploadIcon: '<i class="glyphicon glyphicon-upload"></i>',
            zoomIcon: '<i class="fa fa-search-plus"></i>',
            // zoomIcon: '<i class="glyphicon glyphicon-zoom-in"></i>',
            dragIcon: '<i class="fa fa-arrows-alt"></i>',
            // dragIcon: '<i class="glyphicon glyphicon-move"></i>',
            indicatorNew: '<i class="fa fa-plus-circle text-warning"></i>',
            // indicatorNew: '<i class="glyphicon glyphicon-plus-sign text-warning"></i>',
            indicatorSuccess: '<i class="fa fa-check-circle text-success"></i>',
            // indicatorSuccess: '<i class="glyphicon glyphicon-ok-sign text-success"></i>',
            indicatorError: '<i class="fa fa-exclamation-circle text-danger"></i>',
            // indicatorError: '<i class="glyphicon glyphicon-exclamation-sign text-danger"></i>',
            indicatorLoading: '<i class="fa fa-hourglass-half text-muted"></i>'
            // indicatorLoading: '<i class="glyphicon glyphicon-hourglass text-muted"></i>'
        },
        layoutTemplates: {
            fileIcon: '<i class="glyphicon glyphicon-file kv-caption-icon"></i>'
        },
        previewZoomButtonIcons: {
            /* prev: '<i class="glyphicon glyphicon-triangle-left"></i>',
            next: '<i class="glyphicon glyphicon-triangle-right"></i>',
            toggleheader: '<i class="glyphicon glyphicon-resize-vertical"></i>',
            fullscreen: '<i class="glyphicon glyphicon-fullscreen"></i>',
            borderless: '<i class="glyphicon glyphicon-resize-full"></i>',
            close: '<i class="glyphicon glyphicon-remove"></i>'
            */
            prev: '<i class="fa fa-caret-left fa-lg"></i>',
			next: '<i class="fa fa-caret-right fa-lg"></i>',
			toggleheader: '<i class="fas fa-arrows-alt-v"></i>',
			fullscreen: '<i class="fa fa-fw fa-arrows-alt"></i>',
			borderless: '<i class="fas fa-external-link-alt"></i>',
			close: '<i class="fas fa-times"></i>'
        },
        // previewFileIcon: '<i class="glyphicon glyphicon-file"></i>',
        previewFileIcon: '<i class="fa fa-file"></i>',
        // browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>&nbsp;',
        browseIcon: '<i class="fa fa-folder-open"></i>&nbsp;',
        // removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
        removeIcon: '<i class="fa fa-times"></i>',
        // cancelIcon: '<i class="glyphicon glyphicon-ban-circle"></i>',
        cancelIcon: '<i class="fa fa-ban"></i>',
        // uploadIcon: '<i class="glyphicon glyphicon-upload"></i>',
        uploadIcon: '<i class="fa fa-arrow-circle-up"></i>',
        // msgValidationErrorIcon: '<i class="glyphicon glyphicon-exclamation-sign"></i> '
        msgValidationErrorIcon: '<i class="fa fa-fa-exclamation-circle"></i> '
    };
})(window.jQuery);
