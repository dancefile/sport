<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Timetable;

/**
 * TimetableSearch represents the model behind the search form of `app\models\Timetable`.
 */
class TimetableSearch extends Timetable
{
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'otd_id', 'tur_number', 'tur_id', 'reg_pairs', 'programm', 'heats_count'], 'integer'],
            [['sortItem', 'time', 'category_name', 'dances'], 'safe'],
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
        $query = Timetable::find();

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
            'time' => $this->time,
            'tur_number' => $this->tur_number,
            'tur_id' => $this->tur_id,
            'reg_pairs' => $this->reg_pairs,
            'programm' => $this->programm,
            'heats_count' => $this->heats_count,
        ]);
        $query->andFilterWhere([
            'otd_id' => $this->otd_id,
        ]);
        

        $query->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'dances', $this->dances]);
        $query->andWhere(['not like', 'reg_pairs', 0]);
        
        $query->orderBy(['sortItem' => SORT_ASC]);

        return $dataProvider;
    }
}
