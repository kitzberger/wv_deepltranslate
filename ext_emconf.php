<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "deepltranslate"
 *
 * Auto generated by Extension Builder 2020-04-18
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'DeepL Translate',
    'description' => 'This extension provides option to translate content element, and TCA record texts to DeepL supported languages.',
    'category' => 'backend',
    'author' => 'web-vision GmbH Team',
    'author_company' => 'web-vision GmbH',
    'author_email' => 'hello@web-vision.de',
    'state' => 'stable',
    'version' => '4.0.2',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-8.2.99',
            'typo3' => '11.5.0-12.4.99',
        ],
        'conflicts' => [
            'recordlist_thumbnail' => '*',
        ],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'WebVision\\WvDeepltranslate\\' => 'Classes',
        ],
    ],
];
