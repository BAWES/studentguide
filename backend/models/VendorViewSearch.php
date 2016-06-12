<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VendorView;

/**
 * VendorSearch represents the model behind the search form about `backend\models\Vendor`.
 */
class VendorViewSearch extends VendorView
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id', 'number_of_views'], 'integer'],
            [['view_date'], 'safe'],
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
        $query = VendorView::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'         =>  $query,
            'sort'      =>  ['defaultOrder' => ['view_date' => SORT_DESC, 'number_of_views' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'vendor_id'         => $this->vendor_id,
            'view_date'         => $this->view_date,
            
        ]);

        $query->andFilterWhere(['>=', 'number_of_views', $this->number_of_views]);
        return $dataProvider;
    }
}