<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PreRegistration;

/**
 * PreRegistrationSearch represents the model behind the search form of `app\models\PreRegistration`.
 */
class PreRegistrationSearch extends PreRegistration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['tur_id', 'class', 'dancer1_name', 'dancer1_sname', 'dancer2_name', 'dancer2_sname', 'city', 'club', 'trener_name', 'trener_sname'], 'safe'],
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
        $query = PreRegistration::find();

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

        $query->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'dancer1_name', $this->dancer1_name])
            ->andFilterWhere(['like', 'dancer1_sname', $this->dancer1_sname])
            ->andFilterWhere(['like', 'dancer2_name', $this->dancer2_name])
            ->andFilterWhere(['like', 'dancer2_sname', $this->dancer2_sname])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'club', $this->club])
            ->andFilterWhere(['like', 'trener_name', $this->trener_name])
            ->andFilterWhere(['like', 'trener_sname', $this->trener_sname]);

        return $dataProvider;
    }
}
