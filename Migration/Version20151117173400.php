<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20151117173400 extends AbstractMigration
{

    public function up(Schema $schema)
    {
        $ad = $schema->createTable('plg_dtb_ad');
        $ad->addColumn('ad_id', 'integer', array('notnull' => true, 'autoincrement' => true));
        $ad->addColumn('media_id', 'integer', array('notnull' => true));
        $ad->addColumn('name', 'text', array('notnull' => true, 'default' => ''));
        $ad->addColumn('code', 'string', array('notnull' => true));
        $ad->addColumn('create_date', 'datetime', array('notnull' => true));
        $ad->addColumn('update_date', 'datetime', array('notnull' => true));
        $ad->addColumn('del_flg', 'smallint', array('notnull' => true, 'default' => 0));
        $ad->setPrimaryKey(array('ad_id'));
        $ad->addUniqueIndex(array('code'));
        
        $media = $schema->createTable('plg_dtb_media');
        $media->addColumn('media_id', 'integer', array('notnull' => true, 'autoincrement' => true));
        $media->addColumn('name', 'text', array('notnull' => false));
        $media->addColumn('create_date', 'datetime', array('notnull' => true));
        $media->addColumn('update_date', 'datetime', array('notnull' => true));
        $media->addColumn('del_flg', 'smallint', array('notnull' => true, 'default' => 0));
        $media->setPrimaryKey(array('media_id'));
        
        $access = $schema->createTable('plg_dtb_access');
        $access->addColumn('access_id', 'integer', array('notnull' => true, 'autoincrement' => true));
        $access->addColumn('unique_id', 'string', array('notnull' => true, 'default' => ''));
        $access->addColumn('referrer', 'text', array('notnull' => false));
        $access->addColumn('ad_code', 'string', array('notnull' => false));
        $access->addColumn('ip_address', 'text', array('notnull' => false));
        $access->addColumn('user_agent', 'text', array('notnull' => false));
        $access->addColumn('page', 'text', array('notnull' => false));
        $access->addColumn('history', 'integer', array('notnull' => true, 'default' => 0));
        $access->addColumn('create_date', 'datetime', array('notnull' => true));
        $access->setPrimaryKey(array('access_id'));
        $access->addIndex(array('unique_id'));
        
        $conversion = $schema->createTable('plg_dtb_conversion');
        $conversion->addColumn('conversion_id', 'integer', array('notnull' => true, 'autoincrement' => true));
        $conversion->addColumn('order_id', 'integer', array('notnull' => true));
        $conversion->addColumn('unique_id', 'string', array('notnull' => true));
        $conversion->setPrimaryKey(array('conversion_id'));
        $conversion->addIndex(array('unique_id'));
        
        $order = $schema->getTable('dtb_order');
        
        $ad->addForeignKeyConstraint($media, array('media_id'), array('media_id'));
        $conversion->addForeignKeyConstraint($order, array('order_id'), array('order_id'));
    }

    public function down(Schema $schema)
    {
        $schema->dropTable('plg_dtb_ad');
        $schema->dropTable('plg_dtb_access');
        $schema->dropTable('plg_dtb_conversion');
        $schema->dropTable('plg_dtb_media');
    }
}