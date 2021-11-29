<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\CreateAccountController;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Http;
use App\Client;

class ClientsController extends Controller
{

    public function viewClients() {
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();

        return view('pages.clients.index')->with('states', $states);
    }

    public function getClients(Request $request) {
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();

        $city = isset($request->city) ? $request->city : null;
        $sit = isset($request->sit) ? $request->sit : null;
        $facebook = isset($request->facebook) ? isset($request->facebook) : null;
        $site = isset($request->site) ? isset($request->site) : null;
        $boca = isset($request->boca) ? isset($request->boca) : null;
        $indicacao = isset($request->indicacao) ? isset($request->indicacao) : null;

        $origin = [];

        $query = "SELECT * FROM clients WHERE 1 ";
        if($request->state != null) {
            $query .= "AND client_state = '$request->state'";
        }
        if($request->city != null) {
            $query .= "AND client_city = '$request->city'";
        }
        if($request->name != null) {
            $query .= "AND client_name LIKE '$request->name%'";
        }
        if($request->sit != null) {
            $query .= "AND client_sit = '$request->sit'";
        }
        if($facebook !== null) {
            $query .= "AND client_origin LIKE '%Facebook%'";
        }
        if($site !== null) {
            $query .= "AND client_origin LIKE '%Site%'";
        }
        if($boca !== null) {
            $query .= "AND client_origin LIKE '%Boca%'";
        }
        if($indicacao !== null) {
            $query .= "AND client_origin LIKE '%Indicação%'";
        }

        $clients = DB::select($query);

        return view('pages.clients.index')->with('states', $states)->with('clients', $clients);
    }



    public function newClient() {
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();
        $lastId =  Client::latest('id')->first();

        $nextId = $lastId == null ? 1 : $lastId->id + 1;

        return view('pages.clients.newclient')->with('states', $states)->with('next', $nextId);
    }

    public function saveClient(Request $request) 
    {
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();
        $origin = [];

        if(isset($request->facebook)) {
            array_push($origin, "Facebook");
        }
        if(isset($request->site)) {
            array_push($origin, "Site");
        }
        if(isset($request->indicacao)) {
            array_push($origin, "Indicação");
        }
        if(isset($request->boca)) {
            array_push($origin, "Boca a Boca");
        }


        $insert = false;
        if(!$this->clientExist($request->cnpj)) {
            $insert = Client::insert([
                'client_name'     => $request->name,
                'client_email'    => $request->email,
                'client_cnpj'     => $request->cnpj,
                'client_state'    => $request->state,
                'client_city'     => $request->city,
                'client_phone'    => $request->phone,
                'client_sit'      => "A",
                'client_obs'      => $request->obs,
                'client_origin'   => !empty($origin) ? implode(";", $origin) : ""
            ]);

            $message = $insert ? "Cliente cadastrado com sucesso!" : "Ocorreu um erro ao cadastrar cliente.";
        }
        else {
            $message = "Cliente informado já cadastrado!" ;
        }

        return view('pages.clients.newclient')->with('message', $message)->with('saved', $insert)
                                              ->with('next', "")->with('states', $states);
    }

    public function deleteClient(Request $request) {
        if (!$request->ajax()) {
            return response()->json([
            'status_code' => 400,
            'message' => 'Bad Request'
            ], 400);
        }

        $delete = Client::where("id", $request->id)->delete();
       
        return response()->json([
            'status_code' => 200,
            'success'     => $delete
        ]);
    }

    public function viewUpdateClient($id) {
        
        $client = Client::find($id);

        $registerController = new CreateAccountController();
        $states = $registerController->getStates();

        $cities = $this->getCities($client->client_state);

        return view('pages.clients.updateclient')->with("client", $client)->with("states", $states)->with("cities", $cities);
    }

    public function updateClient(Request $request) {

        $client = Client::find($request->id);
        $registerController = new CreateAccountController();
        $states = $registerController->getStates();
        $cities = $this->getCities($client->client_state);

        $origin = [];

        if(isset($request->facebook)) {
            array_push($origin, "Facebook");
        }
        if(isset($request->site)) {
            array_push($origin, "Site");
        }
        if(isset($request->indicacao)) {
            array_push($origin, "Indicação");
        }
        if(isset($request->boca)) {
            array_push($origin, "Boca a Boca");
        }

        $update = Client::where("id", $request->id)->update([
            'client_name'     => $request->name,
            'client_email'    => $request->email,
            'client_cnpj'     => $request->cnpj,
            'client_state'    => $request->state,
            'client_city'     => $request->city,
            'client_phone'    => $request->phone,
            'client_sit'      => $request->sit,
            'client_obs'      => $request->obs,
            'client_origin'   => !empty($origin) ? implode(";", $origin) : ""
        ]);


        $message = $update ? "Cliente atualizado com sucesso!" : "Ocorreu um erro ao atualizar cliente.";

        return view('pages.clients.updateclient')->with("client", $client)->with("states", $states)
                                                 ->with("cities", $cities)->with("saved", $update)->with("message", $message);
    }

    public function getCities($state)
    {
        $cities = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/$state/municipios");

        return $cities->json();
    }

    private function clientExist($cnpj) {
        $client =  DB::select("SELECT * FROM clients WHERE client_cnpj = '$cnpj'");
        return $client != null;
    }



}
