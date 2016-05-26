<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Vendor;

/**
 * VendorSearch represents the model behind the search form about `backend\models\Vendor`.
 */
class VendorSearch extends Vendor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id'], 'integer'],
            [['vendor_logo', 'vendor_name_en', 'vendor_name_ar', 'vendor_description_en', 'vendor_description_ar', 'vendor_phone1', 'vendor_phone2', 'vendor_youtube_video', 'vendor_social_instagram', 'vendor_social_twitter', 'vendor_location', 'vendor_address_text_en', 'vendor_address_text_ar', 'vendor_account_start_date', 'vendor_account_end_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Vendor::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'vendor_id' => $this->vendor_id,
            'vendor_account_start_date' => $this->vendor_account_start_date,
            'vendor_account_end_date' => $this->vendor_account_end_date,
        ]);

        $query->andFilterWhere(['like', 'vendor_logo', $this->vendor_logo])
            ->andFilterWhere(['like', 'vendor_name_en', $this->vendor_name_en])
            ->andFilterWhere(['like', 'vendor_name_ar', $this->vendor_name_ar])
            ->andFilterWhere(['like', 'vendor_description_en', $this->vendor_description_en])
            ->andFilterWhere(['like', 'vendor_description_ar', $this->vendor_description_ar])
            ->andFilterWhere(['like', 'vendor_phone1', $this->vendor_phone1])
            ->andFilterWhere(['like', 'vendor_phone2', $this->vendor_phone2])
            ->andFilterWhere(['like', 'vendor_youtube_video', $this->vendor_youtube_video])
            ->andFilterWhere(['like', 'vendor_social_instagram', $this->vendor_social_instagram])
            ->andFilterWhere(['like', 'vendor_social_twitter', $this->vendor_social_twitter])
            ->andFilterWhere(['like', 'vendor_location', $this->vendor_location])
            ->andFilterWhere(['like', 'vendor_address_text_en', $this->vendor_address_text_en])
            ->andFilterWhere(['like', 'vendor_address_text_ar', $this->vendor_address_text_ar]);

        return $dataProvider;
    }
}