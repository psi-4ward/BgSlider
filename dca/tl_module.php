<?php

/**
 * BgSlider
 *
 * A mootools based fullscreen background slider with fade effect for Contao 3.
 *
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 * @licence LGPL
 */


$GLOBALS['TL_DCA']['tl_module']['palettes']['BgSlider'] = '{title_legend},name,type;{config_legend},BgSlider_slideTime,BgSlider_waitTime,BgSlider_showNav,BgSlider_autoplay,BgSlider_slideAfterLoad,BgSlider_proportional;'
															.'{source_legend},multiSRC,BgSlider_filesHint;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['BgSlider_slideTime'] = array
(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['BgSlider_slideTime'],
	'inputType'	=> 'text',
	'default'   => '1000',
	'eval'		=> array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'		=> "int(9) unsigned NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['BgSlider_waitTime'] = array
(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['BgSlider_waitTime'],
	'inputType'	=> 'text',
	'default'   => '1500',
	'eval'		=> array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'		=> "int(9) unsigned NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['BgSlider_showNav'] = array
(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['BgSlider_showNav'],
	'inputType'	=> 'checkbox',
	'eval'		=> array('tl_class'=>'w50'),
	'sql'		=> "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['BgSlider_autoplay'] = array
(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['BgSlider_autoplay'],
	'inputType'	=> 'checkbox',
	'default'	=> '1',
	'eval'		=> array('tl_class'=>'w50'),
	'sql'		=> "char(1) NOT NULL default '1'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['BgSlider_slideAfterLoad'] = array
(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['BgSlider_slideAfterLoad'],
	'inputType'	=> 'checkbox',
	'default'	=> '1',
	'eval'		=> array('tl_class'=>'w50'),
	'sql'		=> "char(1) NOT NULL default '1'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['BgSlider_proportional'] = array
(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['BgSlider_proportional'],
	'inputType'	=> 'checkbox',
	'default'	=> '1',
	'eval'		=> array('tl_class'=>'w50'),
	'sql'		=> "char(1) NOT NULL default '1'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['BgSlider_filesHint'] = array
(
	'input_field_callback' => array('BgSlider_filesHint','generate')
);

class BgSlider_filesHint
{
	public function generate()
	{
		return '<div style="margin-top:5px">'.$GLOBALS['TL_LANG']['tl_module']['BgSlider_hint'].'</div>';
	}
}