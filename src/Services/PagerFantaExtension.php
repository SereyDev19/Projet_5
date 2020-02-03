<?php

namespace App\Services;

use Pagerfanta\View\TwitterBootstrap4View;

class PagerFantaExtension extends \Twig_Extension
{
    /**
     * @return array|\Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('paginate', [$this, 'paginate'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param $paginatedResults
     * @return mixed
     */
    public function paginate($paginatedResults)
    {
        $view = new TwitterBootstrap4View();
        return $view->render($paginatedResults, __DIR__);

    }
}