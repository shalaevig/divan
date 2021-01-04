<?php
namespace frontend\widgets\FeedbackWidget;

use Yii;
use yii\base\Widget;
use common\models\Feedback;

/**
 * Форма обратной связи.
 */ 
class FeedbackWidget extends Widget 
{
    
    /**
     * Вид.
     * 
     * @var string
     */ 
    public $view = 'view';
    
    /**
     * Модель.
     * 
     * @var Feedback
     */ 
    public $model = null;
    
    /**
     * Вывод.
     * 
     * @var string
     */ 
    public function run() 
    {
        $model = $this->model;
        if (!($model instanceof Feedback)) $model = new Feedback(); 
        
        return $this->render($this->view, [
            'model' => $model,
        ]);
    }

}
