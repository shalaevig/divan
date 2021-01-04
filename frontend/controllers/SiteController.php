<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\Feedback;

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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Обратная связь.
     *
     * @return mixed
     */
    public function actionFeedback()
    {
        $model = new Feedback();
        $model->status = Feedback::STATUS_MODERATION;
        
        if ($model->load(Yii::$app->request->post())) {
            $hasError = false;
            if ($model->validate()) {
                if ($model->save()) {
                    $msg = 'Обращение успешно создано.';
                    Yii::$app->getSession()->setFlash('success', $msg);
                    return $this->redirect(['index']);
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
        
        return $this->render('feedback', [
            'model' => $model,
        ]);
    }

}
