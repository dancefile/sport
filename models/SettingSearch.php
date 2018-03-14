<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Setings;

/**
 * SettingSearch represents the model behind the search form about `app\models\Setings`.
 */
class SettingSearch extends Setings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['comp_name', 'value', 'comp_date', 'comp_org'], 'safe'],
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
        $query = Setings::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'comp_name', $this->comp_name])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'comp_date', $this->comp_date])
            ->andFilterWhere(['like', 'comp_org', $this->comp_org]);

        return $dataProvider;
    }
}
