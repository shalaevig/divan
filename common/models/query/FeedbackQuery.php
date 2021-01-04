<?php
namespace common\models\query;

use common\models\Feedback;
use yii\db\ActiveQuery;

/**
 * Класс запросов для Feedback.
 */
class FeedbackQuery extends ActiveQuery
{

    /**
     * Добавить условие поиска по id.
     * 
     * @param int $id Идентификатор записи
     * @param string|null $alias Псевдоним таблицы
     * @return $this
     */  
    public function id($id, $alias = null) 
    {
        if ($alias) $_alias = $alias . '.';
        else $_alias = null;
        $this->andWhere([
            $_alias . 'id' => $id, 
        ]);
        return $this;
    }

}
