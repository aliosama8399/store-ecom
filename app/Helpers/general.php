<?php

define('PAGENATE',10);

function getFolder()
{
    return app()->getLocale() === 'ar' ? 'css-rtl' : 'css';
}

