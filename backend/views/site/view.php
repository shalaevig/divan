<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

$this->title = 'Просмотр обращения';

$this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обращение №' . $model->id;
?>
<div class="feedback-view">

<?php
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'status',
            'captionOptions' => ['width' => '25%'],
        ],
        [
            'attribute' => 'created_at',
            'value' => function($model) {
                return Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i');
            }
        ],
        [
            'attribute' => 'updated_at',
            'value' => function($model) {
                return Yii::$app->formatter->asDatetime($model->updated_at, 'php:d.m.Y H:i');
            }
        ],
        'customer',
        'phone',
        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->getStatusValue();
            }
        ],
    ],
]);
?>    

</div>