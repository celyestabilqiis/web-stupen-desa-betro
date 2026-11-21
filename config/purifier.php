<?php

return [
    'encoding' => 'UTF-8',
    'finalize' => true,
    'ignoreNonStrings' => false,
    'cachePath' => storage_path('app/purifier'),
    'cacheFileMode' => 0755,
    'settings' => [
        'default' => [
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,p[style],br,span[style],strong,b,em,i,u,s,a[href|title|target|rel],ul,ol,li,blockquote,hr,img[src|alt|width|height|style|class],table[style|class],thead,tbody,tr,th[style|colspan|rowspan],td[style|colspan|rowspan],div[style|class],pre,code,sub,sup',
            'CSS.AllowedProperties' => 'font-size,font-weight,font-style,font-family,text-decoration,color,background-color,text-align,padding-left,margin-left,width,height,max-width,border,border-collapse,border-color,border-width,border-style,float',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty' => true,
            'HTML.SafeIframe' => false,
            'Attr.AllowedClasses' => null,
        ],
        'test' => [
            'Attr.EnableID' => 'true',
        ],
    ],
];
