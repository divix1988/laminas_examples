<?php

namespace Application\Controller;

use Laminas\View\Model\ViewModel;

class SitemapController extends AbstractController
{
    private $navigation;
    private $cmsModel;

    public function __construct($navigation, $cmsModel)
    {
        $this->navigation = $navigation;
        $this->cmsModel = $cmsModel;
    }

    public function indexAction()
    {
        $cacheKey = 'sitemap';
        $fileCache = \Laminas\Cache\StorageFactory::factory(array(
            'adapter' => array(
                'name' => 'filesystem',
                'options' => array(
                    'cacheDir' => 'data/cache',
                    'ttl' => 86400 //24h
                )
            ),
            'plugins' => ['Serializer']
        ));
        $navigationContainer = $this->navigation;
        $cachedArticles = $fileCache->getItem($cacheKey);
        $articles = $cachedArticles ? $cachedArticles : $this->cmsModel->getPages();
        $router = $this->getEvent()->getRouter();
        $plainPages = [];

        foreach ($articles as $article) {
            $page = new \Laminas\Navigation\Page\Mvc([
                'route' => 'news',
                'action' => 'show',
                'params' => ['id' => $article['url']],
                'priority' => '1.0'
            ]);
            $page->setRouter($router);
            $navigationContainer->addPage($page);
            $plainPages[] = $article;
        }
        
        //we cannot locally parse results from DB PDO,
        //thus we are passing a regular array
        if (!$cachedArticles) {
            $fileCache->setItem($cacheKey, $plainPages);
        }
        $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'text/xml');
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        
        return $viewModel;
    }
}

