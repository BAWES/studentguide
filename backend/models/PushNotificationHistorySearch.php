<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PushNotificationHistory;

class PushNotificationHistorySearch extends PushNotificationHistory
{
	public function rules()
	{	
		return [
			['id', 'integer'],
			[['message_en', 'message_ar', 'datetime'], 'safe'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = PushNotificationHistory::find();
		$dataProvider 	=	new ActiveDataProvider([
			'query'	=>	$query,
			'sort'	=>	['defaultOrder' => ['datetime' => SORT_DESC]],
		]);

		$this->load($params);
		if(!$this->validate()){
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id'		=>	$this->id,
			'datetime'	=>	$this->datetime,
		]);

		$query->andFilterWhere(['like', 'message_en', $this->message_en])
			->andFilterWhere(['like', 'message_ar', $this->message_ar]);

		return $dataProvider;
	}
}