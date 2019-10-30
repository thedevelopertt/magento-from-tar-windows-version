<?php

namespace TheDeveloper\Banner\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Filesystem;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Psr\Log\LoggerInterface;
use Zend\Db\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface{

    protected $filesystem;
    protected $template;
    protected $logger;

    public function __construct(
        Filesystem $filesystem,
        LoggerInterface $logger
    )
    {
        $this->logger = $logger;
        $this->filesystem = $filesystem;
    }



    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // TODO: Implement install() method.

        $installer = $setup;
        $installer->startSetup();

        if(!$installer->tableExists('mageplaza_bannerslider_banner')){
            $table = $installer->getConnection()
                ->newTable($installer->getTable('mageplaza_bannerslider_banner'))
                ->addColumn(
                    'banner_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true
                    ],
                    'Banner ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => false
                    ],
                    'Banner Name'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    255,
                    [
                        'nullable' => false,
                        'default' => '1'
                    ],
                    'Status'

                )
                ->addColumn(
                    'type',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' =>false,
                        'default' => '0'
                    ],
                    'Banner Type'
                )
                ->addColumn(
                    'content',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Custom html, css'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Banner Image'
                )
                ->addColumn(
                    'url_banner',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Banner Url'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Title'
                )
                ->addColumn(
                    'newtab',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false,
                        'default' => '1'
                    ],
                    'Open tab'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [],
                    'Banner Created At'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    'Banner Updated At'
                );

            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
              $installer->getTable('mageplaza_bannerslider_banner'),
              $setup->getIdxName(
                  $installer->getTable('mageplaza_bannerslider_banner'),
                  [
                      'name','image','url_banner'
                  ],
                  AdapterInterface::INDEX_TYPE_FULLTEXT
              ),
                ['name','image','url_banner'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
    }
}
