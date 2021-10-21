<?php

namespace Application\Controller;

use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Application\Service\ParserService;
use Laminas\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction(): ViewModel
    {
        return new ViewModel();
    }

    public function ajaxGetDataAction(): JsonModel
    {
        return (new JsonModel())->setVariable(
            'data',
            (new ParserService())->request() ?? []
        );
    }
}
