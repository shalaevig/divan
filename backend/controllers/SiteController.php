<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Feedback;
use backend\models\search\FeedbackSearch;

use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Получить модель обращения.
     * 
     * @param int Идентификатор
     * @return Feedback
     * @throws NotFoundHttpException
     */ 
    protected function findModel($id) 
    {
        $query = Feedback::find()->id($id);
        $model = $query->one();
        if (!$model) {
            throw new NotFoundHttpException('Обращение не найдено.');
        }
        return $model;
    }

    /**
     * Вывод обращений.
     *
     * @return string
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->queryParams;
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search($queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Просмотр обращения.
     * 
     * @param integer $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    /**
     * Редактирование обращения.
     *
     * @return string
     */
    public function actionUpdate($id, $backUrl = null)
    {
        $redirectUrl = $backUrl ? $backUrl : ['index'];
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $hasError = false;
            if ($model->validate()) {
                if ($model->save()) {
                    $msg = 'Обращение успешно обновлено.';
                    Yii::$app->getSession()->setFlash('success', $msg);
                    return $this->redirect($redirectUrl);
                } else {
                    $hasError = true;
                }
            } else {
                $hasError = true;
            }

            if ($hasError) {
                $msg = 'Ошибка данных.';
                if ($model->hasErrors()) {
                    $errors = $model->getErrorSummary(false);
                    if ($errors) {
                        $msg = $errors[0];
                    }
                }
                Yii::$app->getSession()->setFlash('danger', $msg);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Удалить обращение.
     *
     * @return string
     */
    public function actionDelete($id, $backUrl = null)
    {
        $redirectUrl = $backUrl ? $backUrl : ['index'];
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect($redirectUrl);
    }

}
