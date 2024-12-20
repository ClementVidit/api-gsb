<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Visiteur;
use Exception;
use Illuminate\Support\Facades\Auth;

class VisiteurController extends Controller
{
    public function initPasswords(Request $request){
        try {
            $hash = bcrypt($request->json('pwd_visiteur'));
            Visiteur::query()->update(['pwd_visiteur'=>$hash]);
            return response()->json(['status_message'=>'mots de passes réinitialisés']);
        }catch (Exception $e){
            return response()->json(['status_message'=>$e->getMessage()],500);
        }
    }
    public function login(Request $request){
        //Vérifiez is la requête est en JSON
        if($request->isJson()){
            //Validation des données recues, il faut un login et un password
            $request->validate([
                'login'=>'required',
                'password'=>'required',
            ]);
            //Authentification login/password
            $login = $request->json('login');
            $pwd = $request->json('password');
            $credentials= ['login_visiteur'=>$login, 'password'=>$pwd];
            if(!Auth::attempt($credentials)){
                return response()->json(['error'=>'The provided credentials are incorrect.'],401);
            }
            //on crée un token pour le visiteur authentifié
            $visiteur = $request->user();
            $token = $visiteur->createToken('auth_token')->plainTextToken;
            //On retourne un JSON
            return response()->json([
                'visiteur'=>[
                    'id_visiteur'=>$visiteur->id_visiteur,
                    'nom_visiteur'=>$visiteur->nom_visiteur,
                    'prenom_visiteur'=>$visiteur->prenom_visiteur,
                    'type_visiteur'=>$visiteur->type_visiteur,
                ],
                'access_token'=>$token,
                'token_type'=>'bearer'
            ]);
        }
        //Gestion des erreurs si la requête n'est pas en JSON
        return response()->json(['error'=>'Request must be JSON'],415);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message'=>'Successfully logged out']);
    }
    public function unauthorized(){
        return response()->json(['error'=>'Unauthorized access']);
    }
}
