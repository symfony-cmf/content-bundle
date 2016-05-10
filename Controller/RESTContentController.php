<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Cmf\Bundle\ContentBundle\Model\Collection;
use Symfony\Cmf\Bundle\ContentBundle\Model\ManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use FOS\RestBundle\View\ViewHandlerInterface;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class RESTContentController extends ContentController
{
    /**
     * @var ManagerInterface
     */
    private $manager;

    public function __construct(
        EngineInterface $templating,
        $defaultTemplate,
        ManagerInterface $manager,
        ViewHandlerInterface $viewHandler = null
    ) {
        parent::__construct($templating, $defaultTemplate, $viewHandler);

        $this->manager = $manager;
    }

    /**
     * The GET action should behave as the normal ContentController::indexAction().
     *
     * @param Request $request
     * @param object  $contentDocument
     * @param string  $contentTemplate Symfony path of the template to render
     *                                 the content document. If omitted, the
     *                                 default template is used.
     *
     * @return Response
     */
    public function getAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        return parent::indexAction($request, $contentDocument, $contentTemplate);
    }

    /**
     * A PUT request updates a given contentDocument.
     *
     * @param Request $request
     * @param object  $contentDocument
     * @param string  $contentTemplate Symfony path of the template to render
     *                                 the content document. If omitted, the
     *                                 default template is used.
     *
     * @return Response
     */
    public function putAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        return new Response('', Response::HTTP_OK);
    }

    /**
     * The contentDocument should be of type Collection to add a new child in it.
     *
     * @param Request $request
     * @param object  $contentDocument
     * @param string  $contentTemplate Symfony path of the template to render
     *                                 the content document. If omitted, the
     *                                 default template is used.
     *
     * @return Response
     */
    public function postAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        if (!$contentDocument instanceof Collection) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * Deletes a contentDocument and redirects (by redirect or link hint) to the parent
     * Collection.
     *
     * @param Request $request
     * @param object  $contentDocument
     * @param string  $contentTemplate Symfony path of the template to render
     *                                 the content document. If omitted, the
     *                                 default template is used.
     *
     * @return Response
     */
    public function deleteAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * You can update special fields of a given contentDocument by using the PATCH request.
     *
     * @param Request $request
     * @param object  $contentDocument
     * @param string  $contentTemplate Symfony path of the template to render
     *                                 the content document. If omitted, the
     *                                 default template is used.
     *
     * @return Response
     */
    public function patchAction(Request $request, $contentDocument, $contentTemplate = null)
    {
        return new Response('', Response::HTTP_OK);
    }
}
