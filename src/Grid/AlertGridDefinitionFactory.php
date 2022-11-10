<?php
declare(strict_types=1);

namespace LkInteractive\Back\LkStockEmailAlerts\Grid;

use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
//use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
//use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
//use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Type\SimpleGridAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
//use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
//use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ToggleColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AlertGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'stockemailalert';

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
            'Alert',
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
                (new DataColumn('id_customer'))
                ->setName($this->trans(
                    'ID Customer',
                    [],
                    'Modules.Lkstockemailalerts.Admin'
                ))
                ->setOptions([
                    'field' => 'id_customer',
                ])
            )
            ->add(
                (new DataColumn('customer_email'))
                ->setName($this->trans(
                    'Customer email',
                    [],
                    'Modules.Lkstockemailalerts.Admin'
                ))
                ->setOptions([
                    'field' => 'customer_email',
                ])
            );
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
