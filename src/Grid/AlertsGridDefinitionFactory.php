<?php
declare(strict_types=1);

namespace LkInteractive\Back\LkStockEmailAlerts\Grid;

use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
//use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Type\SimpleGridAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
//use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ToggleColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AlertsGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'stockemailalerts';

    /**
     * {@inheritdoc}
     */
    protected function getId()
    {
        return self::GRID_ID;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return $this->trans(
            'Alerts',
            [],
            'Modules.Lkstockemailalerts.Admin'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add(
                (new DataColumn('id_product'))
                ->setName($this->trans(
                    'ID Product',
                    [],
                    'Modules.Lkstockemailalerts.Admin'
                ))
                ->setOptions([
                    'field' => 'id_product',
                ])
            )
            ->add(
                (new DataColumn('name'))
                ->setName($this->trans(
                    'Name',
                    [],
                    'Modules.Lkstockemailalerts.Admin'
                ))
                ->setOptions([
                    'field' => 'name',
                ])
            )
            ->add(
                (new DataColumn('nb_alerts'))
                    ->setName($this->trans(
                        'Number of alerts',
                        [],
                        'Modules.Lkstockemailalerts.Admin'
                    ))
                    ->setOptions([
                        'field' => 'nb_alerts',
                    ])
            )
            ->add((new ActionColumn('actions'))
                ->setName($this->trans(
                    'Actions',
                    [],
                    'Admin.Global'
                ))
                ->setOptions([
                    'actions' => (new RowActionCollection())
                        ->add((new LinkRowAction('detail'))
                            ->setName($this->trans(
                                'Detail',
                                [],
                                'Admin.Actions'
                            ))
                            ->setIcon('edit')
                            ->setOptions([
                                'route' => 'lkstockemailalerts_alerts_detail',
                                'route_param_name' => 'productId',
                                'route_param_field' => 'id_product',
                                'clickable_row' => true,
                            ]))
                ]));
    }

    /**
     * {@inheritdoc}
     */
    protected function getFilters()
    {
        return (new FilterCollection())
            ->add((new Filter('id_product', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                    'attr' => [
                        'placeholder' => $this->trans(
                            'ID Product',
                            [],
                            'Admin.Global'
                        ),
                    ],
                ])
                ->setAssociatedColumn('id_product'))
            ->add((new Filter('name', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                    'attr' => [
                        'placeholder' => $this->trans(
                            'name',
                            [],
                            'Modules.Lkstockemailalerts.Admin'
                        ),
                    ],
                ])
                ->setAssociatedColumn('name'))
            ->add((new Filter('actions', SearchAndResetType::class))
                ->setTypeOptions([
                    'reset_route' => 'admin_common_reset_search_by_filter_id'
                    ,
                    'reset_route_params' => [
                        'filterId' => self::GRID_ID,
                    ],
                    'redirect_route' => 'lkstockemailalerts_alerts_index',
                ])
                ->setAssociatedColumn('actions'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getGridActions()
    {
        return (new GridActionCollection())
            ->add((new SimpleGridAction('common_refresh_list'))
                ->setName($this->trans(
                    'Refresh list',
                    [],
                    'Admin.Advparameters.Feature'
                ))
                ->setIcon('refresh'))
            ->add((new SimpleGridAction('common_show_query'))
                ->setName($this->trans(
                    'Show SQL query',
                    [],
                    'Admin.Actions'
                ))
                ->setIcon('code'))
            ->add((new SimpleGridAction('common_export_sql_manager'))
                ->setName($this->trans(
                    'Export to SQL Manager',
                    [],
                    'Admin.Actions'
                ))
                ->setIcon('storage'));
    }
}
