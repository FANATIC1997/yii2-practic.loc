<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form of `backend\models\User`.
 */
class UserSearch extends User
{
	public $item_name;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['username', 'email', 'item_name'], 'safe'],
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
		$query = User::find()
			->leftJoin('auth_assignment ass', 'user.id = ass.user_id')
			->leftJoin('auth_item ai', 'ass.item_name = ai.name');

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
				'username' => [
					'asc' => ['username' => SORT_ASC],
					'desc' => ['username' => SORT_DESC],
				],
				'email' => [
					'asc' => ['email' => SORT_ASC],
					'desc' => ['email' => SORT_DESC],
				],
				'item_name' => [
					'asc' => ['ai.name' => SORT_ASC],
					'desc' => ['ai.name' => SORT_DESC],
				],
			]
		]);

		// grid filtering conditions
		$query->andFilterWhere(['like', 'username', $this->username])
			->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['like', 'ai.name', $this->item_name]);

		return $dataProvider;
	}
}
