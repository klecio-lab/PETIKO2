<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedido;

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
        @$getCep = file_get_contents($CEPinfo);
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
        $EnderecoCliente = $request->all();
        
        // parte de tratamentos de erro
        $enderecoViaCep = HomeController::getAddressByCepViaCep(intval($EnderecoCliente['cep']));
        if(@$enderecoViaCep->erro == true){
            $enderecoPostmam = HomeController::getAddressByCepPostmam(intval($EnderecoCliente['cep']));
            if(@$enderecoPostmam == 404){
                session()->flash('Erro', 'Seu CEP não Não foi Encontrado!');
                return redirect('/formulario');
            }else{
                if($enderecoPostmam->cep == $EnderecoCliente['cep'] && $enderecoPostmam->longradouro == $EnderecoCliente['rua'] && $enderecoPostmam->bairro == $EnderecoCliente['bairro'] && $enderecoPostmam->localidade == $EnderecoCliente['cidade'] && $enderecoPostmam->uf == $EnderecoCliente['uf']){
                    $passardados = New pedido;
                    #salvando as variaveis que vão para o bd
                    $passardados->nomeCliente  = $EnderecoCliente['nome'];
                    $passardados->cep = $EnderecoCliente['cep'];
                    $passardados->rua = $EnderecoCliente['rua'];
                    $passardados->complemento = $EnderecoCliente['complemento'];
                    $passardados->bairro = $EnderecoCliente['bairro'];
                    $passardados->cidade = $EnderecoCliente['cidade'];
                    $passardados->uf = $EnderecoCliente['uf'];
                    $passardados->IDpedido = 1;
                    $passardados->save();

                    session()->flash('success', 'Seu pedido foi cadastrado com Sucesso!');
                    return redirect('/formulario');
                }else{
                    session()->flash('perdido', 'Seu endereço não confiz com o CEP!');
                    return redirect('/formulario');
                }
            }
        }else{
            if(strtoupper($enderecoViaCep->logradouro) == strtoupper($EnderecoCliente['rua']) && strtoupper($enderecoViaCep->bairro) == strtoupper($EnderecoCliente['bairro']) && strtoupper($enderecoViaCep->localidade) == strtoupper($EnderecoCliente['cidade']) && strtoupper($enderecoViaCep->uf) == strtoupper($EnderecoCliente['uf'])){
                $passardados = New pedido;

                #salvando as variaveis que vão para o bd
                $passardados->nomeCliente  = $EnderecoCliente['nome'];
                $passardados->cep = $EnderecoCliente['cep'];
                $passardados->rua = $EnderecoCliente['rua'];
                $passardados->complemento = $EnderecoCliente['complemento'];
                $passardados->bairro = $EnderecoCliente['bairro'];
                $passardados->cidade = $EnderecoCliente['cidade'];
                $passardados->uf = $EnderecoCliente['uf'];
                $passardados->IDpedido = 1;
                $passardados->save();

                session()->flash('success', 'Seu pedido foi cadastrado com Sucesso!');
                return redirect('/formulario');

            }
            else{
                $enderecoPostmam = HomeController::getAddressByCepPostmam(intval($EnderecoCliente['cep']));
                dd($enderecoPostmam);
                if(@$enderecoPostmam == 404){
                    session()->flash('Erro', 'Seu CEP não Não foi Encontrado!');
                    return redirect('/formulario');
                }else{
                    if(strtoupper($enderecoPostmam->longradouro) == strtoupper($EnderecoCliente['rua']) && strtoupper($enderecoPostmam->bairro) == strtoupper($EnderecoCliente['bairro']) && strtoupper($enderecoPostmam->cidade) == strtoupper($EnderecoCliente['cidade']) && strtoupper($enderecoPostmam->estado) == strtoupper($EnderecoCliente['uf'])){
                        $passardados = New pedido;

                        #salvando as variaveis que vão para o bd
                        $passardados->nomeCliente  = $EnderecoCliente['nome'];
                        $passardados->cep = $EnderecoCliente['cep'];
                        $passardados->rua = $EnderecoCliente['rua'];
                        $passardados->complemento = $EnderecoCliente['complemento'];
                        $passardados->bairro = $EnderecoCliente['bairro'];
                        $passardados->cidade = $EnderecoCliente['cidade'];
                        $passardados->uf = $EnderecoCliente['uf'];
                        $passardados->IDpedido = 1;
                        $passardados->save();

                        session()->flash('success', 'Seu pedido foi cadastrado com Sucesso!');
                        return redirect('/formulario');
                    }else{
                        session()->flash('perdido', 'Seu endereço não confiz com o CEP!');
                        return redirect('/formulario');
                    }
                }
            }
        }
    
    }
    public function formCep($cep, Request $request){
        $cep = strval($cep);
        
        // parte de tratamentos de erro
        $enderecoViaCep = HomeController::getAddressByCepViaCep($cep);
        if(@$enderecoViaCep->erro == true){
            $enderecoPostmam = HomeController::getAddressByCepPostmam($cep);
            if($enderecoPostmam == 404){
                session()->flash('Erro', 'Seu CEP não Não foi Encontrado!');
                return redirect('/formulario');
            }else{
                $end = $enderecoPostmam;
                return view('form', compact('end'));
            }
        }else{  
                $end = $enderecoViaCep;
                return view('form', compact('end'));
        }
    }
}
