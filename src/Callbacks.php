<?php

namespace Ausi\ContaoSlugBackport;

use Contao\CalendarModel;
use Contao\Config;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\DataContainer;
use Contao\FaqCategoryModel;
use Contao\NewsArchiveModel;
use Contao\NewsletterChannelModel;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;

class Callbacks
{
	public function pageGenerateAlias($varValue, DataContainer $dc)
	{
		// Skip if an explicit alias is set
		if ($varValue) {
			return System::importStatic('tl_page')->generateAlias($varValue, $dc);
		}

		$objPage = PageModel::findWithDetails($dc->activeRecord->id);
		$slugOptions = ['locale' => $objPage->language];

		if ($validAliasCharacters = PageModel::findByPk($objPage->rootId)->validAliasCharacters)
		{
			$slugOptions['validChars'] = $validAliasCharacters;
		}

		$varValue = System::getContainer()
			->get('contao.slug.generator')
			->generate($this->prepareSlug($dc->activeRecord->title), $slugOptions)
		;

		if (Config::get('folderUrl') && $objPage->folderUrl != '')
		{
			$varValue = $objPage->folderUrl . $varValue;
		}

		try {
			$varValue = System::importStatic('tl_page')->generateAlias($varValue, $dc);
		}
		catch(\Exception $e) {
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}

	public function newsGenerateAlias($varValue, DataContainer $dc)
	{
		// Skip if an explicit alias is set
		if ($varValue) {
			return System::importStatic('tl_news')->generateAlias($varValue, $dc);
		}

		$slugOptions = [];

		// Read the slug options from the associated page
		if (
			($objNewsArchive = NewsArchiveModel::findByPk($dc->activeRecord->pid)) !== null
			&& ($objPage = PageModel::findWithDetails($objNewsArchive->jumpTo)) !== null
		) {
			$slugOptions['locale'] = $objPage->language;
			if ($validAliasCharacters = PageModel::findByPk($objPage->rootId)->validAliasCharacters)
			{
				$slugOptions['validChars'] = $validAliasCharacters;
			}
		}

		$varValue = System::getContainer()
			->get('contao.slug.generator')
			->generate($this->prepareSlug($dc->activeRecord->headline), $slugOptions)
		;

		try {
			$varValue = System::importStatic('tl_news')->generateAlias($varValue, $dc);
		}
		catch(\Exception $e) {
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}

	public function calendarGenerateAlias($varValue, DataContainer $dc)
	{
		// Skip if an explicit alias is set
		if ($varValue) {
			return System::importStatic('tl_calendar_events')->generateAlias($varValue, $dc);
		}

		$slugOptions = [];

		// Read the slug options from the associated page
		if (
			($objCalendar = CalendarModel::findByPk($dc->activeRecord->pid)) !== null
			&& ($objPage = PageModel::findWithDetails($objCalendar->jumpTo)) !== null
		) {
			$slugOptions['locale'] = $objPage->language;
			if ($validAliasCharacters = PageModel::findByPk($objPage->rootId)->validAliasCharacters)
			{
				$slugOptions['validChars'] = $validAliasCharacters;
			}
		}

		$varValue = System::getContainer()
			->get('contao.slug.generator')
			->generate($this->prepareSlug($dc->activeRecord->title), $slugOptions)
		;

		try {
			$varValue = System::importStatic('tl_calendar_events')->generateAlias($varValue, $dc);
		}
		catch(\Exception $e) {
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}

	public function faqGenerateAlias($varValue, DataContainer $dc)
	{
		// Skip if an explicit alias is set
		if ($varValue) {
			return System::importStatic('tl_faq')->generateAlias($varValue, $dc);
		}

		$slugOptions = [];

		// Read the slug options from the associated page
		if (
			($objFaqCategory = FaqCategoryModel::findByPk($dc->activeRecord->pid)) !== null
			&& ($objPage = PageModel::findWithDetails($objFaqCategory->jumpTo)) !== null
		) {
			$slugOptions['locale'] = $objPage->language;
			if ($validAliasCharacters = PageModel::findByPk($objPage->rootId)->validAliasCharacters)
			{
				$slugOptions['validChars'] = $validAliasCharacters;
			}
		}

		$varValue = System::getContainer()
			->get('contao.slug.generator')
			->generate($this->prepareSlug($dc->activeRecord->question), $slugOptions)
		;

		try {
			$varValue = System::importStatic('tl_faq')->generateAlias($varValue, $dc);
		}
		catch(\Exception $e) {
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}

	public function newsletterGenerateAlias($varValue, DataContainer $dc)
	{
		// Skip if an explicit alias is set
		if ($varValue) {
			return System::importStatic('tl_newsletter')->generateAlias($varValue, $dc);
		}

		$slugOptions = [];

		// Read the slug options from the associated page
		if (
			($objChannel = NewsletterChannelModel::findByPk($dc->activeRecord->pid)) !== null
			&& ($objPage = PageModel::findWithDetails($objChannel->jumpTo)) !== null
		) {
			$slugOptions['locale'] = $objPage->language;
			if ($validAliasCharacters = PageModel::findByPk($objPage->rootId)->validAliasCharacters)
			{
				$slugOptions['validChars'] = $validAliasCharacters;
			}
		}

		$varValue = System::getContainer()
			->get('contao.slug.generator')
			->generate($this->prepareSlug($dc->activeRecord->subject), $slugOptions)
		;

		try {
			$varValue = System::importStatic('tl_newsletter')->generateAlias($varValue, $dc);
		}
		catch(\Exception $e) {
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}

	public function articleGenerateAlias($varValue, DataContainer $dc)
	{
		// Skip if an explicit alias is set
		if ($varValue) {
			return System::importStatic('tl_article')->generateAlias($varValue, $dc);
		}

		$slugOptions = [];

		// Read the slug options from the associated page
		if (($objPage = PageModel::findWithDetails($dc->activeRecord->pid)) !== null) {
			$slugOptions['locale'] = $objPage->language;
			if ($validAliasCharacters = PageModel::findByPk($objPage->rootId)->validAliasCharacters)
			{
				$slugOptions['validChars'] = $validAliasCharacters;
			}
		}

		$varValue = System::getContainer()
			->get('contao.slug.generator')
			->generate($this->prepareSlug($dc->activeRecord->title), $slugOptions)
		;

		try {
			$varValue = System::importStatic('tl_article')->generateAlias($varValue, $dc);
		}
		catch(\Exception $e) {
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}

	public function formGenerateAlias($varValue, DataContainer $dc)
	{
		// Skip if an explicit alias is set
		if ($varValue) {
			return System::importStatic('tl_form')->generateAlias($varValue, $dc);
		}

		$slugOptions = [];

		// Read the slug options from the associated page
		if (($objPage = PageModel::findWithDetails(Input::post('jumpTo') ?: $dc->activeRecord->jumpTo)) !== null) {
			$slugOptions['locale'] = $objPage->language;
			if ($validAliasCharacters = PageModel::findByPk($objPage->rootId)->validAliasCharacters)
			{
				$slugOptions['validChars'] = $validAliasCharacters;
			}
		}

		$varValue = System::getContainer()
			->get('contao.slug.generator')
			->generate($this->prepareSlug($dc->activeRecord->title), $slugOptions)
		;

		try {
			$varValue = System::importStatic('tl_form')->generateAlias($varValue, $dc);
		}
		catch(\Exception $e) {
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}

	private function prepareSlug($strSlug)
	{
		$strSlug = StringUtil::stripInsertTags($strSlug);
		$strSlug = StringUtil::restoreBasicEntities($strSlug);
		$strSlug = StringUtil::decodeEntities($strSlug);

		return $strSlug;
	}
}
