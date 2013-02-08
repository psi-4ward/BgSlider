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

 
namespace Psi\BgSlider;

class BgSlider extends \Module
{

	protected $strTemplate = 'mod_BgSlider';


	/**
	 * Generate the BgSlider
	 *
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### BG Slider ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = $this->Environment->script.'?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		$this->multiSRC = deserialize($this->multiSRC);
		// Return if there are no files
		if (!is_array($this->multiSRC) || empty($this->multiSRC))
		{
			return '';
		}

		// Get the file entries from the database
		$this->objFiles = \FilesModel::findMultipleByIds($this->multiSRC);

		if ($this->objFiles === null)
		{
			return '';
		}

		return parent::generate();
	}


	/**
	 * Compile the current element
	 */
	protected function compile()
	{
		$images = array();
		$objFiles = $this->objFiles;

		// Get all images
		while ($objFiles->next())
		{
			// Continue if the files has been processed or does not exist
			if (isset($images[$objFiles->path]) || !file_exists(TL_ROOT . '/' . $objFiles->path))
			{
				continue;
			}

			// Single files
			if ($objFiles->type == 'file')
			{
				$objFile = new \File($objFiles->path);

				if (!$objFile->isGdImage)
				{
					continue;
				}

				// Add the image
				$images[$objFiles->path] = array('path'=>$objFiles->path, 'name'=>$objFile->name, 'height'=>$objFile->height, 'width'=>$objFile->width);
			}

			// Folders
			else
			{
				$objSubfiles = \FilesModel::findByPid($objFiles->id);

				if ($objSubfiles === null)
				{
					continue;
				}

				while ($objSubfiles->next())
				{
					// Skip subfolders
					if ($objSubfiles->type == 'folder')
					{
						continue;
					}

					$objFile = new \File($objSubfiles->path);

					if (!$objFile->isGdImage)
					{
						continue;
					}

					// Add the image
					$images[$objSubfiles->path] = array('path'=>$objSubfiles->path, 'name'=>$objSubfiles->name, 'height'=>$objFile->height, 'width'=>$objFile->width);
				}
			}
		}


		// move the image with the alias to the front
		foreach($images as $img)
		{
			$tmp = array_pop($images);
			array_unshift($images, $tmp);
			if(preg_match("~".preg_quote($GLOBALS['objPage']->alias)."\.[a-z]+$~", $tmp['path']))
			{
				break;
			}
		}

		$this->Template->images = $images;
	}
}