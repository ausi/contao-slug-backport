<?php

namespace Ausi\ContaoSlugBackport;

use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\FaqBundle\ContaoFaqBundle;
use Contao\NewsBundle\ContaoNewsBundle;
use Contao\NewsletterBundle\ContaoNewsletterBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;

class ContaoManagerPlugin implements BundlePluginInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getBundles(ParserInterface $parser)
	{
		return [
			BundleConfig::create(ContaoSlugBackportBundle::class)
				->setLoadAfter([
					ContaoCalendarBundle::class,
					ContaoCoreBundle::class,
					ContaoFaqBundle::class,
					ContaoNewsBundle::class,
					ContaoNewsletterBundle::class,
				]),
		];
	}
}
