<?php
/**
 * @category Agere
 * @package Agere_Export
 * @author Vlad Kozak <vk@agere.com.ua>
 */

class Agere_Export_Model_Attributes extends Mage_Core_Model_Abstract {

    public function getFinalPrice ($product) {
        return Mage::getModel('catalogrule/rule')->calcProductPriceRule($product, $product->getPrice());
    }

    public function getPrice ($product) {
        return number_format($product->getPrice(), 1, ',', '');
    }

    public function getClasp ($product) {
        return $product->getAttributeText('clasp') ? $product->getAttributeText('clasp') : '';
    }

    public function getUrlImage ($product) {
        return $this->getImageUrls($product);
    }

    public function getCreatedAt ($product) {
        return $product->getCreatedAt();
    }

    public function getProductName ($product) {
        return $product->getName();
    }

    public function getImageUrls ($product) {
        if($parentIds = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($product->getId())) {
            $parent = Mage::getModel('catalog/product')->load($parentIds);

            return Mage::getModel('catalog/product_media_config')->getMediaUrl($parent->getImage());
            //return $parent->getImageUrl();
        }
        else {
            return Mage::getModel('catalog/product_media_config')->getMediaUrl($product->getImage());
            //return $product->getImageUrl();
        }
    }
}