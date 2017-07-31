<?php

use app\models\Banners;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Banners */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banners-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
<!--        <div class="col-md-4">-->
<!--            --><?//= $form->field($model, 'roleIDs')->dropDownList($roles, ['multiple'=>'multiple']) ?>
<!--        </div>-->
        <div class="col-md-4">
            <?= $form->field($model, 'place')->dropDownList($places) ?>
        </div>
    </div>

    <? if (!$model->isNewRecord): ?>
        <div class="row">
            <?php
                $images = json_decode($model->URLs);
                foreach ($images as $img):
            ?>
                    <div class="img-block">
                        <div class="img-block-img" style="background: url('<?='/tmp/banners/' . $img?>'); background-size: cover;"></div>
                        <a class="js-delete__image" data-modelID="<?=$model->id ?>"  data-imageName="<?=$img ?>" href="#0">Удалить файл</a>
                    </div>
            <?php
                endforeach;
            ?>
        </div><br>
        <?= \kato\DropZone::widget([
            'options' => [
                'maxFilesize' => '2',
                'url' => '/banners/upload-image?id=' . $model->id,
                'method' => 'POST',
                'addRemoveLinks'=>true,
                'dictDefaultMessage' => 'Перетащите файлы чтобы загрузить!',
                'dictRemoveFile' => 'Удалить файл',
            ],
            'clientEvents' => [
                'complete' => "function(file){console.log(file)}",
                'removedfile' => "function(file){
                    alert(file.name + ' is removed');
                    
                }"
            ],
        ]);
        ?>
        <br>
    <? endif; ?>

    <? if ($model->isNewRecord): ?>
        <p>Перед добавленим картинок сохраните баннер</p>
    <? endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function() {
        $('.js-delete__image').on('click', function (e) {
            e.preventDefault();
            var modelID = $(this).attr('data-modelID');
            var imageName = $(this).attr('data-imageName');
            var that = $(this);
            $.ajax({
                url: '/banners/delete-image',
                method: 'POST',
                data: {
                    modelID: modelID,
                    imageName: imageName
                },
                success: function() {
                    that.parent().fadeOut();
                }
            });
        });
    });
</script>
