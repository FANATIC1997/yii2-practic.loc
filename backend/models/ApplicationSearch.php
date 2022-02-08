<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Application;

/**
 * ApplicationSearch represents the model behind the search form of `backend\models\Application`.
 */
class ApplicationSearch extends Application
{

	public $organization;
	public $user;
	public $manager;
	public $status;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['theme', 'organization', 'user', 'manager', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
		if(Yii::$app->user->can('admin')) {
			$query = Application::find()
				->joinWith(['organization o', 'user u', 'manager m', 'status st'])
				->orderBy('status_id');
		} elseif(Yii::$app->user->can('manager')) {
			$query = Application::find()
				->joinWith(['organization o', 'user u', 'status st'])
				->where(['manager_id' => Yii::$app->user->getId()])
				->orderBy('status_id');
		} else {
			$query = Application::find()
				->joinWith(['organization o', 'user u', 'status st'])
				->where(['user_id' => Yii::$app->user->getId()])
				->orderBy('status_id');
		}

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 50,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$dataProvider->setSort([
			'attributes' => [
				'theme' => [
					'asc'  => ['theme' => SORT_ASC],
					'desc' => ['theme' => SORT_DESC],
				],
				'organization' => [
					'asc'  => ['o.name' => SORT_ASC],
					'desc' => ['o.name' => SORT_DESC],
				],
				'user' => [
					'asc'  => ['u.username' => SORT_ASC],
					'desc' => ['u.username' => SORT_DESC],
				],
				'manager' => [
					'asc'  => ['m.username' => SORT_ASC],
					'desc' => ['m.username' => SORT_DESC],
				],
				'status' => [
					'asc'  => ['status_id' => SORT_ASC],
					'desc' => ['status_id' => SORT_DESC],
				],
			],
		]);

        $query->andFilterWhere(['like', 'theme', $this->theme])
            ->andFilterWhere(['like', 'o.name', $this->organization])
            ->andFilterWhere(['like', 'u.username', $this->user])
            ->andFilterWhere(['like', 'm.username', $this->manager])
            ->andFilterWhere(['like', 'st.name', $this->status]);

        return $dataProvider;
    }
}
