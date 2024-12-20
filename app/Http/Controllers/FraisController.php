<?php

namespace App\Http\Controllers;

use App\Dao\FraiService;
use App\Models\Frai;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;

class FraisController extends Controller
{
    function getFrais($id_frais){
        $servicegetFrais = new FraiService();
        $frais =$servicegetFrais->getFrais($id_frais);
        return response()->json($frais);
    }
    function ajout(Request $request){
        $frais = new Frai();
        $frais->id_etat = 2;
        $frais->anneemois = $request->json('anneemois');
        $frais->id_visiteur = $request->json('id_visiteur');
        $frais->nbjustificatifs= $request->json('nbjustificatifs');
        $frais->datemodification= now();
        $service = new FraiService();
        $service->saveFrai($frais);

        $id_frais = $frais->id_frais;

        return response()->json(['message'=>'Insertion réalisée','id_frais'=> $id_frais]);
    }
    function modif(Request $request)
    {
        $frais = new Frai();
        $frais->id_frais = $request->json('id_frais');
        $frais->anneemois = $request->json('anneemois');
        $frais->id_visiteur = $request->json('id_visiteur');
        $frais->nbjustificatifs = $request->json('nbjustificatifs');
        $frais->montantvalide = $request->json('montantvalide');
        $frais->id_etat = $request->json('id_etat');
        $frais->datemodification= now();
        $service = new FraiService();
        $service->saveFrai($frais);

        return response()->json(['message'=>'Modification réalisée','id_frais'=> $frais->id_frais]);
    }
    function suppr(Request $request){
        $idfrais = $request->json('id_frais');
        try {
            $service = new FraiService();

            if($service->deleteFrai($idfrais)){
                return response()->json(['Status'=>'Frais supprimer']);
            }else{
                return response()->json(['Status'=>'Frais non existant']);

            }
        }catch (Exception $exception) {
            return response()->json(['Status' => $exception->getMessage()]);
        }
    }
    function liste($idVisiteur){
        try {
            $service = new FraiService();
            $listeFrais = $service->getListeFrais($idVisiteur);
            return response()->json($listeFrais);
        }catch (Exception $e){
            return response()->json(['Status' => $e->getMessage()]);
        }
    }
}
