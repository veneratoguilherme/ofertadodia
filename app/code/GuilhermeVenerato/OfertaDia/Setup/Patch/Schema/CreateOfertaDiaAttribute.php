<?php

/**
 * Oferta do dia
 *
 * Extensão para cadastro de ofertas do dia
 *
 * @package GuilhermeVenerato\OfertaDia
 * @author Guilherme Venerato <guilhermevenerato@hotmail.com>
 * Copyright © 2022 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace GuilhermeVenerato\OfertaDia\Setup\Patch\Schema;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\AttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Frontend\Datetime as FrontendDatetime;
use Magento\Framework\Exception\LocalizedException;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\Backend\Datetime as BackendDatetime;

class CreateOfertaDiaAttribute implements DataPatchInterface
{
    public const ATTRIBUTE_CODE = 'oferta_dia';

    public const ATTRIBUTE_LABEL = 'Oferta do dia';

    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private EavSetupFactory $eavSetupFactory;

    /**
     * @var Config
     */
    private Config $eavModelConfig;

    /**
     * CreateOfertaDiaAttribute constructor.
     * @param Config $eavModelConfig
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        Config                   $eavModelConfig,
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavModelConfig = $eavModelConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        if (!$this->isProductAttributeExists()) {

            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
            $eavSetup->addAttribute(Product::ENTITY, self::ATTRIBUTE_CODE, [
                'group' => 'General',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => __(self::ATTRIBUTE_LABEL),
                'input' => 'boolean',
                'class' => '',
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'unique' => false,
                'apply_to' => 'simple,configurable,virtual,bundle,downloadable'
            ]);
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return bool
     */
    private function isProductAttributeExists(): bool
    {
        $attribute = $this->getAttribute();
        return $attribute && $attribute->getId() ? true : false;
    }

    /**
     * @return AttributeInterface|null
     * @throws LocalizedException
     */
    private function getAttribute(): ?AttributeInterface
    {
        return $this->eavModelConfig->getAttribute(Product::ENTITY, self::ATTRIBUTE_CODE);
    }
}
