<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dancer;

/**
 * DancerSearch represents the model behind the search form about `app\models\Dancer`.
 */
class DancerSearch extends Dancer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'clas_id_st', 'clas_id_la', 'gender', 'club'], 'integer'],
            [['name', 'sname', 'date', 'booknumber'], 'safe'],
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
        $query = Dancer::find();

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
            'date' => $this->date,
            'clas_id_st' => $this->clas_id_st,
            'clas_id_la' => $this->clas_id_la,
            'gender' => $this->gender,
            'club' => $this->club,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sname', $this->sname])
            ->andFilterWhere(['like', 'booknumber', $this->booknumber]);

        return $dataProvider;
    }
}
