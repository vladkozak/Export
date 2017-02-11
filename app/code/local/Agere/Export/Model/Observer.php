<?php
/**
 * @category Agere
 * @package Agere_Export
 * @author Vlad Kozak <vk@agere.com.ua>
 */
class Agere_Export_Model_Observer extends Varien_Event_Observer {

    public function runGold () {
        /** @var Agere_ExportGold_Helper_Data $helper */
        $helper = Mage::helper('exportgold/gold');
        $helper->run();
    }

    public function runZlato () {
        /** @var Agere_ExportGold_Helper_Data $helper */
        $helper = Mage::helper('exportgold/zlato');
        $helper->run();
    }
}