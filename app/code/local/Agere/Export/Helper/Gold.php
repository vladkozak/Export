<?php
/**
 * @category Agere
 * @package Agere_Export
 * @author Vlad Kozak <vk@agere.com.ua>
 */

class Agere_Export_Helper_Gold extends Agere_Export_Helper_Abstract
{
    protected $_settings = array(
        'fields' => [
            'finalPrice'    => 'Акционная цена на сайте',
            'price'         => 'Розничная цена на сайте, грн',
            'clasp'         => 'Вид замка',
            'urlImage'      => 'Cсылка на фото',
            'productName'   => 'Наименование товара',
            'createdAt'     => 'Дата создания',
        ],
        //'fieldsStart' => 'createdAt',
        'sku' => '', // this is value columnId will be init in the method init

    );

    public function __construct () {
        $this->init();
    }

    public function init() {
        Mage::app()->setCurrentStore(Mage::app()->getWebsite(true)->getDefaultGroup()->getDefaultStoreId());
        $this->_pathToFileImport = Mage::getBaseDir() . Mage::getStoreConfig('export/gold_settings/path_to_file_import');
        $this->_pathToFileExport = Mage::getBaseDir() . Mage::getStoreConfig('export/gold_settings/path_to_file_export');
        $this->_settings['sku'] = (Mage::getStoreConfig('export/gold_settings/sku') - 1 );
    }

}