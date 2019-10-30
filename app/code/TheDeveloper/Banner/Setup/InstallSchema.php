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

            if(!$installer->tableExists('mageplaza_bannerslider')){
                $table = $installer->getConnection()
                    ->newTable($installer->getTable('mageplaza_bannerslider_slider'))
                    ->addColumn(
                        'slider_id',
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true
                        ],
                        'Slider ID'
                    )
                    ->addColumn('name',Table::TYPE_TEXT,255,['nullable' => 'false'],'Slider Name')
                    ->addColumn('status', Table::TYPE_SMALLINT,null,['nullable' => false,'default' => '1'],'Status')
                    ->addColumn('location',Table::TYPE_TEXT,1000,[],'Location')
                    ->addColumn('store_ids',Table::TYPE_TEXT,255,[])
                    ->addColumn('customer_group_ids',Table::TYPE_TEXT,255)
                    ->addColumn('priority',Table::TYPE_INTEGER,null,[
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                        'Priority')
                    ->addColumn('effect',Table::TYPE_TEXT,255,[],'Animation effect')
                    ->addColumn('autoWidth',Table::TYPE_SMALLINT,null,[],'Auto Width')
                    ->addColumn('autoHeight',Table::TYPE_SMALLINT,null,[],'Auto Height')
                    ->addColumn('design',Table::TYPE_SMALLINT,null,[
                        'nullable' => false,
                        'default' => '0'
                    ],'Design')
                    ->addColumn('loop',Table::TYPE_SMALLINT,null,'Loop Slider')
                    ->addColumn('lazyload',Table::TYPE_SMALLINT,null,'Lazyload Image')
                    ->addColumn('autoplay',Table::TYPE_SMALLINT,null,[],'Autoplay')
                    ->addColumn('autoplayTimeout',Table::TYPE_TEXT,255,[
                        'default' => '5000'
                    ],'Autoplay Timeout')
                    ->addColumn('nav',Table::TYPE_SMALLINT,null,[],'Navigation')
                    ->addColumn('dots',Table::TYPE_SMALLINT,null,[],'Dots')
                    ->addColumn('is_responsive',Table::TYPE_SMALLINT,null,'Responsive')
                    ->addColumn('responsive_items',Table::TYPE_TEXT,null,[],'Max Items Slider')
                    ->addColumn('from_date',Table::TYPE_DATE,null,[
                        'nullable' => true,
                        'default' => null
                    ],'From')
                    ->addColumn('to_date',Table::TYPE_DATE,[
                        'nullable' => true,
                        'default' => null
                    ])
                    ->addColumn('created_at',Table::TYPE_TIMESTAMP,null,[],'Slider Created At')
                    ->addColumn('updated_at',Table::TYPE_TIMESTAMP,null,[],'Slider Updated At')
                    ->setComment('Slider Table');

                $installer->getConnection()->createTable($table);

            }


        }
    }
}
