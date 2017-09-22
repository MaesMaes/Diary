<?php

use yii\db\Migration;

/**
 * Handles the creation of table `places_list`.
 */
class m170921_103921_create_places_list_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        return true;
        $this->createTable('places_list', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->batchInsert(
            'places_list',
            ['id', 'name'],
            [
                [null, '1б'],
                [null, 'мастерские'],
                [null, 'фитнес'],
                [null, '3А'],
                [null, 'кабинет 2а'],
                [null, 'Кабинет Е-Н'],
                [null, 'кабинет 1А'],
                [null, 'кабинет 1'],
                [null, '0А'],
                [null, 'Информатика'],
                [null, 'кабинет информатика'],
                [null, 'лекторий'],
                [null, 'интерактив'],
                [null, '0 Горс кабинет'],
                [null, 'Кабинет информатики'],
                [null, 'Кабинет 0А'],
                [null, '0 Горс класс'],
                [null, 'Кабинет 0Б'],
                [null, 'Фитнес-зал'],
                [null, '3'],
                [null, 'Фитнесс зал Горс'],
                [null, 'Лекторий 5 а'],
                [null, 'Лекторий 0б'],
                [null, 'Лекторий 0 а'],
                [null, 'Лекторий 1 а'],
                [null, 'Кабинет'],
                [null, 'мастерская'],
                [null, 'кабинет 3А'],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('places_list');
    }
}
