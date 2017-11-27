<?php

namespace Ausi\ContaoSlugBackport;

use Ausi\ContaoSlugBackport\DependencyInjection\ContaoSlugBackportExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoSlugBackportBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new ContaoSlugBackportExtension();
    }
}
