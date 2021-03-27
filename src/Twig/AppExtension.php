<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private const SITE_NAME = "Pinterest";

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
            new TwigFunction('title_url', [$this, 'url_title_generation']),
        ];
    }

    /**
     * 
     */
    public function url_title_generation(?string $url)
    {
        return $url ? $url .' | '.self::SITE_NAME : self::SITE_NAME;
    }

    public function doSomething($value)
    {
        // ...
    }
}
