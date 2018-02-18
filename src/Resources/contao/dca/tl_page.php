<?php

if (isset($GLOBALS['TL_DCA']['tl_page']['fields']['alias']['save_callback'])) {
	foreach($GLOBALS['TL_DCA']['tl_page']['fields']['alias']['save_callback'] as $key => $callback) {
		if (is_array($callback) && $callback[0] === 'tl_page' && $callback[1] === 'generateAlias') {
			$GLOBALS['TL_DCA']['tl_page']['fields']['alias']['save_callback'][$key][0] = 'Ausi\ContaoSlugBackport\Callbacks';
			$GLOBALS['TL_DCA']['tl_page']['fields']['alias']['save_callback'][$key][1] = 'pageGenerateAlias';
		}
	}
}

PaletteManipulator::create()
	->addField('validAliasCharacters', 'global_legend', PaletteManipulator::POSITION_APPEND)
	->applyToPalette('root', 'tl_page')
;

$GLOBALS['TL_DCA']['tl_page']['fields']['validAliasCharacters'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_page']['validAliasCharacters'],
	'exclude' => true,
	'inputType' => 'select',
	'options' => array(
		'\pN\p{Ll}' => &$GLOBALS['TL_LANG']['MSC']['validCharacters']['unicodeLowercase'],
		'\pN\pL' => &$GLOBALS['TL_LANG']['MSC']['validCharacters']['unicode'],
		'0-9a-z' => &$GLOBALS['TL_LANG']['MSC']['validCharacters']['asciiLowercase'],
		'0-9a-zA-Z' => &$GLOBALS['TL_LANG']['MSC']['validCharacters']['ascii'],
	),
	'eval' => array('includeBlankOption'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50'),
	'sql' => "varchar(255) NOT NULL default ''"
);
