<?php

use yii\db\Migration;

/**
 * Handles the creation of table `school_class_users`.
 * Has foreign keys to the tables:
 *
 * - `school_class`
 * - `users`
 */
class m170701_085306_create_junction_table_for_school_class_and_users_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('school_class_users', [
            'school_class_id' => $this->integer(),
            'users_id' => $this->integer(),
            'PRIMARY KEY(school_class_id, users_id)',
        ]);

        // creates index for column `school_class_id`
        $this->createIndex(
            'idx-school_class_users-school_class_id',
            'school_class_users',
            'school_class_id'
        );

        // creates index for column `users_id`
        $this->createIndex(
            'idx-school_class_users-users_id',
            'school_class_users',
            'users_id'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `school_class`
        $this->dropForeignKey(
            'fk-school_class_users-school_class_id',
            'school_class_users'
        );

        // drops index for column `school_class_id`
        $this->dropIndex(
            'idx-school_class_users-school_class_id',
            'school_class_users'
        );

        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-school_class_users-users_id',
            'school_class_users'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            'idx-school_class_users-users_id',
            'school_class_users'
        );

        $this->dropTable('school_class_users');
    }
}
