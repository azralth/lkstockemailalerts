<?php
/**
 *  Copyright (C) Lk Interactive - All Rights Reserved.
 *
 *  This is proprietary software therefore it cannot be distributed or reselled.
 *  Unauthorized copying of this file, via any medium is strictly prohibited.
 *  Proprietary and confidential.
 *
 * @author    Lk Interactive <contact@lk-interactive.fr>
 * @copyright 2022.
 * @license   Commercial license
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
include_once dirname(__FILE__).'/vendor/autoload.php';

class LkStockEmailAlerts extends Module
{

    public function __construct()
    {
        $this->name = 'lkstockemailalerts';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Lk Interactive';
        $this->need_instance = 0;

        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_,
        ];

        $tabNames = [];
        foreach (Language::getLanguages() as $lang) {
            $tabNames[$lang['locale']] = $this->trans('Stock Email Alerts', [], 'Modules.LkStockEmailAlerts.Admin', $lang['locale']);
        }
        $this->tabs = [
            [
                'route_name' => 'lkstockemailalerts_alerts_index',
                'class_name' => 'AdminAlertsController',
                'visible' => true,
                'name' => $tabNames,
                'parent_class_name' => 'AdminParentThemes',
                'wording' => $this->trans('Alerts list', array(), 'Modules.LkStockEmailAlerts.Admin'),
                'wording_domain' => 'Modules.LkStockEmailAlerts.Admin',
            ],
        ];

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Lk Interactive - stock email alerts', array(), 'Modules.LkStockEmailAlerts.Admin');
        $this->description = $this->trans('List all users who want to be alert if a product is in stock', array(), 'Modules.LkStockEmailAlerts.Admin');
    }

    public function install()
    {
        return parent::install();
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink(
                'AdminAlertsControllerLegacyClass'
            )
        );
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }
}
