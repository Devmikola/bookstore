<?php

namespace app\controllers;

use app\models\Book;
use app\models\SearchBookForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class BookController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
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

        if($search_form->load(Yii::$app->request->post()) && $search_form->validate())
        {
            $query = Book::find();
            if($search_form->author_id) {
                $query->where(['author_id' => $search_form->author_id]);
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
                        $query->andWhere('date <= :date_before',['date_from' => $search_form->date_before]);
                    }
                }
            }

        } else {
            $query = Book::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', ['model' => $search_form, 'dataProvider' => $dataProvider]);
    }

    public function actionView()
    {
        return $this->render('view');
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
