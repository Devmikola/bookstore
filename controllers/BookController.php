<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Book;
use app\models\SearchBookForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\web\Response;

class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->uploadImageFile() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        return $this->render('create');
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load(Yii::$app->request->post()) && $model->validate())
            {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->uploadImageFile() && $model->save()) {
                    return ['success'];
                }
            } else {
                return [$this->renderPartial('update', ['model' => $model])];
            }
        }


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->uploadImageFile() && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionIndex()
    {
        $search_form = new SearchBookForm();
        $query = Book::find();

        if($search_form->load(Yii::$app->request->post() ? Yii::$app->request->post() : Yii::$app->session['SearchBookForm'])
            && $search_form->validate())
        {
            if($search_form->author_id) { $query->where(['author_id' => $search_form->author_id]); }
            if($search_form->name) { $query->andWhere('name like :name', ['name' => '%'.$search_form->name.'%']); }
            if($search_form->date_from && $search_form->date_before)
            {
                $query->andWhere('date between :date_from and :date_before',['date_from' => $search_form->date_from,
                    'date_before' => $search_form->date_before]);
            } else {
                if($search_form->date_from)
                {
                    $query->andWhere('date >= :date_from',['date_from' => $search_form->date_from]);
                }
                if($search_form->date_before)
                {
                    $query->andWhere('date <= :date_before',['date_before' => $search_form->date_before]);
                }
            }

            if(Yii::$app->request->post()) { Yii::$app->session['SearchBookForm'] = Yii::$app->request->post(); }
        }

        $query->joinWith(['author']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $dataProvider->sort->attributes['author.fullname'] = [
            'asc' => ['author.firstname' => SORT_ASC, 'author.lastname' => SORT_ASC],
            'desc' => ['author.firstname' => SORT_DESC, 'author.lastname' => SORT_DESC],
        ];

        return $this->render('index', ['model' => $search_form, 'dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        if($model) {
            return Yii::$app->request->isAjax ? $this->renderPartial('view', ['model' => $model]) : $this->render('view', ['model' => $model]);
        } else {
            return $this->redirect('/');
        }
    }

    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
