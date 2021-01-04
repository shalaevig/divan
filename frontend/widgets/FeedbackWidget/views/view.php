<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

?>

<?php $form = ActiveForm::begin(['id' => 'feedback-form', 'action' => Url::to(['/site/feedback']) ]); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo $form->field($model, 'customer')->textInput(['autofocus' => true]) ?>  
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <?php echo $form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => '+7(999)999-99-99',
    ]); ?>
  </div>
</div>

<div class="form-group">
  <?php echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>
