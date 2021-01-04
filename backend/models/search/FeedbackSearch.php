<?php
namespace backend\models\search;

use common\models\Feedback;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Поиск по обращениям.
 */
class FeedbackSearch extends Feedback
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['customer', 'phone'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    /**
     * Поиск по обращениям.
     * 
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $alias1 = 't';
        $_alias1 = $alias1 . '.';
        $query = self::find()->alias($alias1)->asArray();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
            'pagination' => [
                'defaultPageSize' => 1,
            ],
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            $_alias1 . 'id' => $this->id,
            $_alias1 . 'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', $_alias1 . 'customer', $this->customer])
            ->andFilterWhere(['like', $_alias1 . 'phone', $this->phone]);

        return $dataProvider;
    }
    
}
