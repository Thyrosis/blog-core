<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | The configuration settings array is passed directly to HTMLPurifier.
    |
    | Feel free to add / remove / customize these attributes as you wish.
    |
    | Documentation: http://htmlpurifier.org/live/configdoc/plain.html
    |
    */

    'settings' => [

        /*
        |--------------------------------------------------------------------------
        | Core.Encoding
        |--------------------------------------------------------------------------
        |
        | The encoding to convert input to.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#Core.Encoding
        |
        */

        'Core.Encoding' => 'utf-8',

        /*
        |--------------------------------------------------------------------------
        | Core.SerializerPath
        |--------------------------------------------------------------------------
        |
        | The HTML purifier serializer cache path.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#Cache.SerializerPath
        |
        */

        'Cache.SerializerPath' => storage_path('purify'),

        /*
        |--------------------------------------------------------------------------
        | HTML.Doctype
        |--------------------------------------------------------------------------
        |
        | Doctype to use during filtering.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#HTML.Doctype
        |
        */

        'HTML.Doctype' => 'XHTML 1.0 Strict',

        /*
        |--------------------------------------------------------------------------
        | HTML.Allowed
        |--------------------------------------------------------------------------
        |
        | The allowed HTML Elements with their allowed attributes.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#HTML.Allowed
        |
        */

        // 'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,b,strong,i,em,blockquote,sub,sup,code,a[href|title],ul,ol,li,p[style],br,hr,span,img[style|width|height|alt|src]',
        // Not supported: center,s,u
        // 'HTML.Allowed' => 'a[href|title],b,big,blockquote,br,code,del,div,em,h1,h2,h3,h4,h5,h6,hr,i,img[width|height|alt|src],li,ol,p,pre,small,span,strong,sub,sup,table[summary],td[abbr],th[abbr],tr,ul,*[class|name|style|title]',
        'HTML.Allowed' => 'a,b,big,blockquote,br,code,del,div,em,h1,h2,h3,h4,h5,h6,hr,i,img,li,ol,p,pre,small,span,strong,sub,sup,table,td,th,tr,ul,*[abbr|alt|class|height|href|id|name|src|style|summary|title|width]',

        /*
        |--------------------------------------------------------------------------
        | HTML.ForbiddenElements
        |--------------------------------------------------------------------------
        |
        | The forbidden HTML elements. Elements that are listed in
        | this string will be removed, however their content will remain.
        |
        | For example if 'p' is inside the string, the string: '<p>Test</p>',
        |
        | Will be cleaned to: 'Test'
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#HTML.ForbiddenElements
        |
        */

        'HTML.ForbiddenElements' => '',

        /*
        |--------------------------------------------------------------------------
        | CSS.AllowedProperties
        |--------------------------------------------------------------------------
        |
        | The Allowed CSS properties.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#CSS.AllowedProperties
        |
        */

        'CSS.AllowedProperties' => 'border,background-color,color,float,font,font-size,font-weight,font-style,font-family,height,margin,margin-left,margin-right,margin-top,margin-bottom,padding,padding-left,padding-right,padding-top,padding-bottom,text-decoration,text-align,width',

        /*
        |--------------------------------------------------------------------------
        | AutoFormat.AutoParagraph
        |--------------------------------------------------------------------------
        |
        | The Allowed CSS properties.
        |
        | This directive turns on auto-paragraphing, where double
        | newlines are converted in to paragraphs whenever possible.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#AutoFormat.AutoParagraph
        |
        */

        'AutoFormat.AutoParagraph' => false,

        /*
        |--------------------------------------------------------------------------
        | AutoFormat.RemoveEmpty
        |--------------------------------------------------------------------------
        |
        | When enabled, HTML Purifier will attempt to remove empty
        | elements that contribute no semantic information to the document.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#AutoFormat.RemoveEmpty
        |
        */

        'AutoFormat.RemoveEmpty' => false,
        'HTML.TargetBlank' => true,
        'Attr.EnableID' => true,
    ],

];
