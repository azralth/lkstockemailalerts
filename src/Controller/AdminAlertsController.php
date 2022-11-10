<?php
declare(strict_types=1);

namespace LkInteractive\Back\LkStockEmailAlerts\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use LkInteractive\Back\LkStockEmailAlerts\Grid\AlertsGridDefinitionFactory;
use LkInteractive\Back\LkStockEmailAlerts\Grid\AlertFilters;
use LkInteractive\Back\LkStockEmailAlerts\Grid\AlertsFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Service\Grid\ResponseBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\ModuleActivated;

/**
 * Class AdminAlertsController.
 *
 * @ModuleActivated(moduleName="lkstockemailalerts", redirectRoute="lkstockemailalerts_alerts_index")
 */
class AdminAlertsController extends FrameworkBundleAdminController
{
    /**
     * List alerts
     *
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @param AlertsFilters $filters
     *
     * @return Response
     */
    public function indexAction(AlertsFilters $filters)
    {
        $alertsGridFactory = $this->get('lkinteractive.lkstockemailalerts.grid.factory.alerts');
        $alertsGrid = $alertsGridFactory->getGrid($filters);
        return $this->render(
            '@Modules/lkstockemailalerts/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Email Alerts', 'Modules.Lkstockemailalerts.Admin'),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                'alertsGrid' => $this->presentGrid($alertsGrid),
            ]
        );
    }

    /**
     * Provides filters functionality.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function searchAction(Request $request)
    {
        /** @var ResponseBuilder $responseBuilder */
        $responseBuilder = $this->get('prestashop.bundle.grid.response_builder');
        return $responseBuilder->buildSearchResponse(
            $this->get('lkinteractive.lkstockemailalerts.grid.definition.factory.alerts'),
            $request,
            AlertsGridDefinitionFactory::GRID_ID,
            'lkstockemailalerts_alerts_index'
        );
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons()
    {
        return;
    }

    /**
     * @param Request $request
     * @param int $alertsId
     *
     * @return Response
     */
    public function toggleAction(Request $request, int $alertsId): Response
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $contentBlock = $entityManager
            ->getRepository(Alerts::class)
            ->findOneBy(['id' => $alertsId]);

        if (empty($contentBlock)) {
            return $this->json([
                'status' => false,
                'message' => sprintf('Content block %d doesn\'t exist', $alertsId)
            ]);
        }

        try {
            $contentBlock->setActive(!$contentBlock->isActive());
            $entityManager->flush();
            $response = [
                'status' => true,
                'message' => $this->trans('The status has been successfully updated.', 'Admin.Notifications.Success'),
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'message' => sprintf(
                    'There was an error while updating the status of content block %d: %s',
                    $alertsId,
                    $e->getMessage()
                ),
            ];
        }

        return $this->json($response);
    }

    /**
     * Detail alerts
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @param Request $request
     * @param int $productId
     * @param AlertFilters $filters
     *
     * @return Response
     */
    public function detailAction(Request $request, $productId, AlertFilters $filters)
    {
      $filters->addFilter(['id_product' => $productId]);
      $alertGridFactory = $this->get('lkinteractive.lkstockemailalerts.grid.factory.alert');
      $alertGrid = $alertGridFactory->getGrid($filters);
      return $this->render(
          '@Modules/lkstockemailalerts/views/templates/admin/index.html.twig',
          [
              'enableSidebar' => true,
              'layoutTitle' => $this->trans('Email Alerts', 'Modules.Lkstockemailalerts.Admin'),
              'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
              'alertsGrid' => $this->presentGrid($alertGrid),
          ]
      );
    }
}
