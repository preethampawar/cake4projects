<style type="text/css">
    .cke_textarea_inline {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 5px;
        min-height: 50px;
        background: #fff;
        color: #000;
        margin-bottom: 1.5rem;
    }
</style>
<script src="https://cdn.ckeditor.com/4.16.0/standard-all/ckeditor.js"></script>

<script>
    (function() {
        var mathElements = [
            'math',
            'maction',
            'maligngroup',
            'malignmark',
            'menclose',
            'merror',
            'mfenced',
            'mfrac',
            'mglyph',
            'mi',
            'mlabeledtr',
            'mlongdiv',
            'mmultiscripts',
            'mn',
            'mo',
            'mover',
            'mpadded',
            'mphantom',
            'mroot',
            'mrow',
            'ms',
            'mscarries',
            'mscarry',
            'msgroup',
            'msline',
            'mspace',
            'msqrt',
            'msrow',
            'mstack',
            'mstyle',
            'msub',
            'msup',
            'msubsup',
            'mtable',
            'mtd',
            'mtext',
            'mtr',
            'munder',
            'munderover',
            'semantics',
            'annotation',
            'annotation-xml'
        ];

        CKEDITOR.plugins.addExternal('ckeditor_wiris', 'https://ckeditor.com/docs/ckeditor4/4.16.0/examples/assets/plugins/ckeditor_wiris/', 'plugin.js');

        CKEDITOR.inline('name', {
            extraPlugins: 'ckeditor_wiris',
            // For now, MathType is incompatible with CKEditor file upload plugins.
            removePlugins: 'uploadimage,uploadwidget,uploadfile,filetools,filebrowser',
            height: 150,
            // Update the ACF configuration with MathML syntax.
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
        });

        for(i=1; i<5; i++) {

            CKEDITOR.inline('options-'+i+'-name', {
                extraPlugins: 'ckeditor_wiris',
                // For now, MathType is incompatible with CKEditor file upload plugins.
                removePlugins: 'uploadimage,uploadwidget,uploadfile,filetools,filebrowser',
                height: 150,
                // Update the ACF configuration with MathML syntax.
                extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
            });
        }

    }());
</script>
