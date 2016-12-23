<?php

use yii\db\Migration;

class m161223_122046_create_table_photo_image extends Migration
{
    public function up()
    {
        $this->createTable('{{photo_image}}', [
            'id'            => $this->primaryKey(),
            'album_id'      => $this->integer(11)->notNull(),
            'image'         => $this->string(255)->notNull(),
            'title'         => $this->string(50)->defaultValue(NULL),
            'alt'           => $this->string(50)->defaultValue(NULL),
            'description'   => $this->text()->defaultValue(NULL),
            'display_order' => $this->integer()->defaultValue(0),
        ]);

        // создание связи между таблицей фотографий и фотоальбомами
        $this->createIndex('idx_photo_image_album_id', '{{photo_image}}', 'album_id');
        $this->addForeignKey('fk_photo_image_album_id', '{{photo_image}}', 'album_id', '{{photo_album}}', 'id', 'SET NULL', 'SET NULL');

    }

    public function down()
    {
        echo "m161223_122046_create_table_photo_image cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
