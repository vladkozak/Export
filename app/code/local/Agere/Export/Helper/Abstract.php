<?php
/**
 * @category Agere
 * @package Agere_Export
 * @author Vlad Kozak <vk@agere.com.ua>
 */
require_once __DIR__ . '/../lib/simplexlsx.class.php';
require_once __DIR__ . '/../lib/xlsxwriter.class.php';

abstract class Agere_Export_Helper_Abstract extends Mage_Core_Helper_Abstract
{
    protected $_settings;

    protected $_pathToFileImport;

    protected $_pathToFileExport;

    protected $_fileInformation = [];

    protected $_productSku = [];

    protected $_fields = [];

    /**
     * Run process reading and writing
     */
    protected function run()
    {
        if ($this->_pathToFileImport) {
            $this->getInformation();
        }
        $this->getAttribute();
        $this->setData();
        $this->write();
    }

    /**
     * Read and set data to $this->_data and
     * set all sku to $this->_sku
     */
    public function getInformation()
    {
        $xlsx = new SimpleXLSX($this->_pathToFileImport);
        $this->_fileInformation = $xlsx->rows();
        foreach ($this->_fileInformation as $key => $value) {
            $this->_productSku[] = $value[$this->_settings['sku']];
        }
    }

    /*This is a new after refactoring of getAttribute*/
    public function getAttribute()
    {
        foreach ($this->_productSku as $sku) {
            if ($product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku)) {
                $model = Mage::getSingleton('exportgold/Attributes');
                foreach (array_keys($this->_settings['fields']) as $field) {
                    if (method_exists($model, $method = 'get' . ucfirst($field))) {
                        $this->_fields[$field][] = $model->{$method}($product) ? $model->{$method}($product) : '';
                    }
                }
            } else {
                foreach (array_keys($this->_settings['fields']) as $field) {
                    $this->_fields[$field][] = '';
                }
            }
        }
    }

    /**
     * Prepare data for writing
     */
    public function setData()
    {
        $i = 0;
        foreach ($this->_fileInformation as $value) {
            if ($i == 0) {
                foreach (array_values($this->_settings['fields']) as $field) {
                    array_push($this->_fileInformation[0], $field);
                }
            } else {
                foreach ($this->_fields as $field => $key) {
                    array_push($this->_fileInformation[$i], $key[$i]);
                }
            }
            $i++;
        }
    }

    public function write()
    {
        $writer = new XLSXWriter();
        $writer->setAuthor('Zarina');
        $writer->writeSheet($this->_fileInformation, 'Лист1');
        $writer->writeToFile($this->_pathToFileExport);
    }
}