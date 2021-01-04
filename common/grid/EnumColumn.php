<?php

namespace common\grid;

use Closure;
use yii\base\Model;
use yii\grid\Column;
use yii\grid\DataColumn;
use yii\db\ActiveQueryInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * Class EnumColumn
 * [
 *      'class' => 'common\grid\EnumColumn',
 *      'attribute' => 'role',
 *      'enum' => User::getRoles()
 * ]
 * @package common\components\grid
 */
class EnumColumn extends DataColumn
{
    
    /**
     * @var array List of value => name pairs
     */
    public $enum = [];
    
    /**
     * @var bool
     */
    public $loadFilterDefaultValues = true;

    /**
     * Пустая строка для фильтра.
     * 
     * @var string
     */ 
    public $filterPrompt = 'Все';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->loadFilterDefaultValues && $this->filter === null) {
            $this->filter = $this->enum;
        }
    }

    /**
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return mixed
     */
    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);
        return ArrayHelper::getValue($this->enum, $value, $value);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                $options = array_merge(['prompt' => $this->filterPrompt], $this->filterInputOptions);
                return Html::activeDropDownList($model, $this->attribute, $this->filter, $options) . $error;
            } elseif ($this->format === 'boolean') {
                $options = array_merge(['prompt' => $this->filterPrompt], $this->filterInputOptions);
                return Html::activeDropDownList($model, $this->attribute, [
                    1 => $this->grid->formatter->booleanFormat[1],
                    0 => $this->grid->formatter->booleanFormat[0],
                ], $options) . $error;
            }

            return Html::activeTextInput($model, $this->attribute, $this->filterInputOptions) . $error;
        }

        return Column::renderFilterCellContent();
    }

}
