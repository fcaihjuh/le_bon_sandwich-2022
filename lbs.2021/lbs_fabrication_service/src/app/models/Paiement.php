<?php
namespace lbs\fab\models;
class Paiement extends \Illuminate\Database\Eloquent\Model{
    protected static $table='paiement';
    protected static $idColumn='commande_id';
    public $timestamps = true;
   
    public function commande(){
        return $this->belongsTo('lbs\command\models\Commande', 'commande_id');
    }

}
?>