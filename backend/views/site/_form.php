<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Feedback */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Feedback;
use yii\widgets\MaskedInput;

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo $form->field($model, 'customer')->textInput(); ?>  
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <?php echo $form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => '+7(999)999-99-99',
    ]); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <?php echo $form->field($model, 'status')->dropDownList(Feedback::getStatusList());; ?>  
  </div>
</div>

<div class="form-group">
  <?php echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>
