<?php
/**
 * @category Agere
 * @package Agere_Export
 * @author Vlad Kozak <vk@agere.com.ua>
 */

class Agere_ExportGold_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        /** @var Agere_ExportGold_Helper_Data $helper */
        $helper = Mage::helper('exportgold/gold');
        $helper->run();
    }
}