<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Редактирование обращения';

$this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обращение №' . $model->id;
?>
<div class="feedback-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>