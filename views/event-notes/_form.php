<?php

use app\models\SchoolClass;
use app\models\User;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\EventNotes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-notes-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4 hidden">
            <?= $form->field($model, 'pupilID')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'note')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'worked')->dropDownList([0 => 'Нет', 1 => 'Да']) ?>
        </div>
        <div class="col-md-4">
            <div class="form-group field-eventnotes-note">
                <label class="control-label" for="eventnotes-note">Ученик</label><br>
                <button class="btn btn-default js-open-modal__view" data-toggle="modal" data-target="#myModal">
                    <?
                        if (isset($pupils[$model->pupilID])) echo $pupils[$model->pupilID];
                            else echo 'Добавить ученика';
                    ?>
                </button>
                <div class="help-block"></div>
                <div class="js-event__notes-selected__pupil"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Замечания</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="notes-container js-notes__container"></div>
            <div class="buttons-container">
                <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderUsers,
                        'filterModel' => $searchModelUsers,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            ['attribute' => 'lastName'],
                            ['attribute' => 'name'],
                            [
                                'attribute' => 'className',
                                'filter' => ArrayHelper::map(SchoolClass::find()->asArray()->all(), 'name', 'name'),
                            ],
                            [
                                'header' => 'Добавить ученика',
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{add-pupil}',
                                'buttons' => [
                                    'add-pupil' => function ($url,$model,$key) {
                                        return Html::a('Добавить', '#0', ['data-pupil-id' => $model->id, 'class' => 'js-add__pupil__to__notes']);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
            <div class="modal-body">
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.js-open-modal__view').on('click', function(e) {
            e.preventDefault();
        });
        $('body').on('click', '.js-add__pupil__to__notes', function(e) {
            e.preventDefault();
            var tr = $(this).parent().parent();
            var name = tr.find('td').eq(2).text();
            var lastName = tr.find('td').eq(1).text();

            $('.js-open-modal__view').text(lastName + ' ' + name);

            var pupilID = $(this).attr('data-pupil-id');
            $('#eventnotes-pupilid').val(pupilID);
            $('#myModal').modal('hide');
        });
    });
</script>
