<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use common\grid\EnumColumn;

use common\models\Feedback;

$title = 'Обратная связь';
$this->title = $title;

$this->params['breadcrumbs'][] = 'Обращения';
?>
<div class="feedback-index">

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
        'class' => 'grid-view table-responsive'
    ],
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'id',
            'contentOptions' => ['style' => 'width:100px;'],
        ],
        [
            'attribute' => 'created_at',
            'headerOptions' => [
                'style' => 'width: 180px;',
            ],
            'contentOptions' => [
                'style' => 'width: 180px;',
            ],
            'content' => function ($model, $key, $index, $column) {
                $content = Yii::$app->formatter->asDatetime($model['created_at'], 'php:d.m.Y H:i');
                return $content;
            },
        ],
        'phone',
        'customer',
        [
            'class' => EnumColumn::class,
            'attribute' => 'status',
            'enum' => Feedback::getStatusList(),
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => 'width:65px;'],
        ],
    ],
]); 
?>

</div>