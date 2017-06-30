<?php

global $LCONFIG;

$LCONFIG['DATABASE']['HOST'] = 'localhost';
$LCONFIG['DATABASE']['PORT'] = 3306;
$LCONFIG['DATABASE']['USER'] = 'root';
$LCONFIG['DATABASE']['PASS'] = '123456';
$LCONFIG['DATABASE']['NAME'] = 'linkrn';

$LCONFIG['SITE']['DOMAIN'] = 'linkr.local'; // Base domain:`
                                          // "linkr.com.br = right!"
                                          // "bla.linkr.com.br = wrong!"
$LCONFIG['SITE']['WWW'] = 'Linkr/Public/'; # WITHOUT the first /
$LCONFIG['SITE']['STATIC'] = '/Linkr/Public/Static'; //'http://localhost/Link/Static';
$LCONFIG['SITE']['TITLE'] = 'Linkr';
$LCONFIG['SITE']['USERSTATIC'] = 'http://' . $LCONFIG['SITE']['DOMAIN'] . '/UserStatic';

/*
 * Dependencies:
 * MOD GZIP
 * PDO
 * MOD REWRITE
 */
