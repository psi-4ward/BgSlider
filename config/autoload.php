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


// Register the namespace
ClassLoader::addNamespace('Psi');

// Register the classes
ClassLoader::addClasses(array
(
	'Psi\BgSlider\BgSlider' 	=> 'system/modules/BgSlider/BgSlider.php',
));

// Register the templates
TemplateLoader::addFiles(array
(
	'mod_BgSlider' 					=> 'system/modules/BgSlider/templates',
));
