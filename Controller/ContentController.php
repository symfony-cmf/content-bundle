<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

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
     * Instantiate the content controller.
     *
     * @param EngineInterface $templating the templating instance to render the
     *      template
     * @param string $defaultTemplate default template to use in case none is
     *      specified explicitly
     */
    public function __construct(EngineInterface $templating, $defaultTemplate)
    {
        $this->templating = $templating;
        $this->defaultTemplate = $defaultTemplate;
    }

    /**
     * Render the provided content
     *
     * @param Request $request
     * @param object $contentDocument
     * @param string $contentTemplate symfony path of the template to render the
     *      content document. if omitted uses the defaultTemplate as injected
     *      in constructor
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        if (!$contentDocument) {
            throw new NotFoundHttpException('Content not found: ' . $request->getPathInfo());
        }

        $contentTemplate = $contentTemplate ?: $this->defaultTemplate;

        $contentTemplate = str_replace(
            array('{_format}', '{_locale}'),
            array($request->getRequestFormat(), $request->getLocale()),
            $contentTemplate
        );

        $params = $this->getParams($request, $contentDocument);

        return $this->templating->renderResponse($contentTemplate, $params);
    }

    protected function getParams(Request $request, $contentDocument)
    {
        return array(
            'title' => $contentDocument->getTitle(),
            'path' => $contentDocument->getPath(),
            'page' => $contentDocument,
            'url' => $request->getPathInfo(),
        );
    }
}
