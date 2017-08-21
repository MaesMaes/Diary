<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Albums */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="albums-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <? if (!$model->isNewRecord): ?>
        <div class="row">
            <?php
//            $images = json_decode($model->images);
            if (!empty($images))
                foreach ($images as $img):
                    ?>
                    <div class="img-block">
                        <div class="img-block-img" style="background: url('<?='/uploads/albums/' . $model->id . '/' . $img->url?>'); background-size: cover;"></div>
                        <? if (User::getRoleNameByUserId(Yii::$app->user->identity->id) == User::USER_TYPE_ADMIN): ?>
                            <span class="img-block-active_check" data-image-id="<?= $img->id ?>"><input class="js-activate__image" data-image-id="<?= $img->id ?>" type="checkbox" <? if ($img->active) echo 'checked' ?>/> Активность</span>
                        <? endif; ?>
                        <a class="js-delete__image" data-album-id="<?=$model->id ?>" data-image-id="<?=$img->id ?>" href="#0">Удалить файл</a>
                    </div>
                    <?php
                endforeach;
            ?>
        </div><br>
        <?= \kato\DropZone::widget([
            'options' => [
                'maxFilesize' => '2',
                'url' => '/albums/upload-image?id=' . $model->id,
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
        <p>Перед добавленим фото сохраните фотоальбом</p>
    <? endif; ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function() {
        $('.js-activate__image').on('click', function (e) {
            var imageID = $(this).attr('data-image-id');
            var that = $(this);
            $.ajax({
                url: '/albums/check-active',
                method: 'POST',
                data: {
                    imageID: imageID,
                    status: that.prop('checked')
                }
            });
        });
        $('.js-delete__image').on('click', function (e) {
            e.preventDefault();
            var imageID = $(this).attr('data-image-id');
            var albumID = $(this).attr('data-album-id');
            var that = $(this);
            $.ajax({
                url: '/albums/delete-image',
                method: 'POST',
                data: {
                    imageID: imageID,
                    albumID: albumID
                },
                success: function() {
                    that.parent().fadeOut();
                }
            });
        });
    });
</script>
