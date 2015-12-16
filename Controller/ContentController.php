<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;

/**
 * The content controller is a simple controller that calls a template with
 * the specified content.
 */
class ContentController
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var string
     */
    protected $defaultTemplate;

    /**
     * @var ViewHandlerInterface
     */
    protected $viewHandler;

    /**
     * Instantiate the content controller.
     *
     * @param EngineInterface      $templating      The templating instance to
     *                                              render the template.
     * @param string               $defaultTemplate Default template to use in
     *                                              case none is specified by
     *                                              the request.
     * @param ViewHandlerInterface $viewHandler     Optional view handler
     *                                              instance.
     */
    public function __construct(EngineInterface $templating, $defaultTemplate, ViewHandlerInterface $viewHandler = null)
    {
        $this->templating = $templating;
        $this->defaultTemplate = $defaultTemplate;
        $this->viewHandler = $viewHandler;
    }

    /**
     * Render the provided content.
     *
     * When using the publish workflow, enable the publish_workflow.request_listener
     * of the core bundle to have the contentDocument as well as the route
     * checked for being published.
     * We don't need an explicit check in this method.
     *
     * @param Request $request
     * @param object  $contentDocument
     * @param string  $contentTemplate Symfony path of the template to render
     *                                 the content document. If omitted, the
     *                                 default template is used.
     *
     * @return Response
     */
    public function indexAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        $contentTemplate = $contentTemplate ?: $this->defaultTemplate;

        $contentTemplate = str_replace(
            array('{_format}', '{_locale}'),
            array($request->getRequestFormat(), $request->getLocale()),
            $contentTemplate
        );

        $params = $this->getParams($request, $contentDocument);

        return $this->renderResponse($contentTemplate, $params);
    }

    protected function renderResponse($contentTemplate, $params)
    {
        if ($this->viewHandler) {
            if (1 === count($params)) {
                $templateVar = key($params);
                $params = reset($params);
            }
            $view = $this->getView($params);
            if (isset($templateVar)) {
                $view->setTemplateVar($templateVar);
            }
            $view->setTemplate($contentTemplate);

            return $this->viewHandler->handle($view);
        }

        return $this->templating->renderResponse($contentTemplate, $params);
    }

    /**
     * Prepare the REST View to render the response in the correct format.
     *
     * @param array $params
     *
     * @return View
     */
    protected function getView($params)
    {
        return new View($params);
    }

    /**
     * Determine the parameters for rendering the template.
     *
     * This is mainly meant as a possible extension point in a custom
     * controller.
     *
     * @param Request $request
     * @param object  $contentDocument
     *
     * @return array
     */
    protected function getParams(Request $request, $contentDocument)
    {
        return array(
            'cmfMainContent' => $contentDocument,
        );
    }
}
