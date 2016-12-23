<?php

use yii\db\Migration;

class m161223_122008_create_table_PhotoAlbum extends Migration
{
    public function up()
    {
        // таблица фотоальбомов
        $this->createTable('{{photo_album}}', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string(50)->notNull(),
            'description'   => $this->text()->defaultValue(NULL),
            'display_order' => $this->integer()->defaultValue(0),
            'active'        => $this->smallInteger(1)->defaultValue(0),
        ]);
    }

    public function down()
    {
        echo "m161223_122008_create_table_PhotoAlbum cannot be reverted.\n";

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
