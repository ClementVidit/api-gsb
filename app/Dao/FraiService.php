<?php

namespace App\Dao;

use App\Exceptions\MonException;
use App\Models\Frai;
use Doctrine\DBAL\Query\QueryException;
use Exception;

class FraiService
{
    public function getFrais($idfrais)
    {
//        $frais = Frai::query()->select('id_frais','anneemois','id_visiteur','nbjustificatifs','datemodification','montantvalide','');
        try {
            $frais = Frai::query()
                ->select()
                ->join('etat','frais.id_etat','=','etat.id_etat')
                ->where('id_frais','=',$idfrais)
                ->get();
            return $frais;
        }catch (Exception $e){
            throw new Exception($e->getMessage(),5);
        }
    }
    public function getListeFrais($id_visiteur){
        try{
            $listefrais = Frai::query()
                ->select()
                ->join('etat','frais.id_etat','=','etat.id_etat')
                ->where('id_visiteur','=',$id_visiteur)
                ->get();
                return $listefrais;
        }catch (Exception $e){
            throw new Exception($e->getMessage(),5);
        }
    }
    public  function saveFrai($frais)
    {
        try{
            $frais->save();
        }catch (Exception $e){
            throw new Exception($e->getMessage(),5);
        }
    }
    public  function deleteFrai($idfrais){
        try{
            $res = Frai::destroy($idfrais);
            return $res;
        }catch (Exception $e){
            throw new Exception($e->getMessage(),5);
        }
    }

}
