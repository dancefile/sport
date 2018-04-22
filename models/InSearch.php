<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * CoupleSearch represents the model behind the search form about `app\models\Couple`.
 */
class InSearch extends In
{
    public $number;
    public $dancer1;
    public $dancer2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'dancer1', 'dancer2'], 'safe'],
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
        $trenersQuery1 = new Query();
        $trenersQuery1
                ->select ([
                    'GROUP_CONCAT(trener.name, " ", trener.sname SEPARATOR ", ")',
                    ])
                ->from('dancer_trener')
                ->join('LEFT JOIN', 'trener', 'trener.id=dancer_trener.trener_id')
                ;
        $trenersQuery2 = new Query();
        $trenersQuery2
                ->select ([
                    'GROUP_CONCAT(trener.name, " ", trener.sname SEPARATOR ", ")',
                    ])
                ->from('dancer_trener')
                ->join('LEFT JOIN', 'trener', 'trener.id=dancer_trener.trener_id')
                ;
       
        $query = new Query();
        $query
                ->select([
                    'in.id inId',
                    'otd.id otdId',
                    'otd.name otd',
                    'category.id categoryId',
                    'category.name category',
                    'tur.id turId',
                    'tur.name tur',
                    'in.nomer number',
                    'CONCAT(d1.name, " ", d1.sname) dancer1',
                    'CONCAT(d2.name, " ", d2.sname) dancer2',
                    'd1.date age1',
                    'd2.date age2',
                    'd1.clas_id_st classSt1',
                    'd1.clas_id_la classLa1',
                    'd2.clas_id_st classSt2',
                    'd2.clas_id_la classLa2',
                    'club1.name club1',
                    'club2.name club2',
                    'city1.name city1',
                    'city2.name city2',
                    'treners1' => $trenersQuery1->andWhere("dancer_trener.dancer_id = d1.id"),
                    'treners2' => $trenersQuery2->andWhere("dancer_trener.dancer_id = d2.id"),
                    'who'
                    ])
                ->from('in')
                ->join('LEFT JOIN', 'couple', 'couple.id = in.couple_id')
                ->join('LEFT JOIN', 'tur', 'tur.id = in.tur_id')
                ->join('LEFT JOIN', 'category', 'category.id = tur.category_id')
                ->join('LEFT JOIN', 'otd', 'otd.id = category.otd_id')
                ->join('LEFT JOIN', 'dancer d1', 'd1.id = couple.dancer_id_1')
                ->join('LEFT JOIN', 'dancer d2', 'd2.id = couple.dancer_id_2')
                ->join('LEFT JOIN', 'club club1', 'club1.id = d1.club')
                ->join('LEFT JOIN', 'club club2', 'club2.id = d2.club')
                ->join('LEFT JOIN', 'city city1', 'city1.id = club1.city_id')
                ->join('LEFT JOIN', 'city city2', 'city2.id = club2.city_id')
                ->filterWhere(['otd.id' => $this->otd_id])
                ->orderBy('turId, number')
                ;

        // add conditions that should always apply here
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query
            ->andFilterWhere(['like', 'in.nomer', $this->number])
            ->andFilterWhere(['like', 'd1.sname', $this->dancer1])
            ->andFilterWhere(['like', 'd2.sname', $this->dancer2]);    
        
        
        return $dataProvider;
    }
}
