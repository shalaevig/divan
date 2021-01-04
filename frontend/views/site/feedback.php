<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="feedback-index">

<?php echo \frontend\widgets\FeedbackWidget\FeedbackWidget::widget(['model' => $model]); ?>

</div>