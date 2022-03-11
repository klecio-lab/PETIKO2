<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function formulario(){
        return view('form');
    }

    // forma de obeter CPF principal
    public static function getAddressByCepViaCep($cep)
    {
    	$cep = strval($cep);
		$CEPinfo = "https://viacep.com.br/ws/" . $cep . "/json/";
        $getCep = file_get_contents($CEPinfo);
        $CepFinal = json_decode($getCep);
        return $CepFinal;
    }

    //Forma extra de obter CPF
    public static function getAddressByCepPostmam($cep)
    {
        $cep = strval($cep);
		$CEPinfo = "https://api.postmon.com.br/v1/cep/" . $cep;
        if(@empty(file_get_contents($CEPinfo))){
            return 404;
        }else{
            $getCep = file_get_contents($CEPinfo);
        }
        $CepFinal = json_decode($getCep);
        return $CepFinal;
    }

    public function SendForm(Request $request){
        $EnderecoCliente = strtoupper($request->all());
        
        // parte de tratamentos de erro
        $enderecoViaCep = HomeController::getAddressByCepViaCep($tudo['cep']);
        if($enderecoViaCep->erro == true){
            $enderecoPostmam = HomeController::getAddressByCepPostmam($tudo['cep']);
            if($enderecoPostmam == 404){
                session()->flash('Erro', 'Seu CEP não Não foi Encontrado!');
                return redirect('/formulario');
            }else{
                dd($enderecoPostmam);
                // if()
            }
        }else{
            if($enderecoViaCep->cep == $EnderecoCliente['cep'] && $enderecoViaCep->longradouro == $EnderecoCliente['rua'] && $enderecoViaCep->bairro == $EnderecoCliente['bairro'] && $enderecoViaCep->localidade == $EnderecoCliente['cidade'] && $enderecoViaCep->uf == $EnderecoCliente['uf']){
            dd($enderecoViaCep);
            }
        }
    
    }
    public function formCep($cep){
        $cep = $cep;
        dd($cep);
    }
}
