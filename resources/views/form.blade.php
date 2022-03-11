<html>
    <head>
    <title>ViaCEP Webservice</title>
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Adicionando Javascript -->
    <script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>
    </head>

    <body>

        {{-- @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif --}}
        
        @if (session('Erro'))
            <div class="alert alert-danger" role="alert">
                {{ session('Erro') }}
            </div>
        @endif

        <center>
        <!-- Inicio do formulario -->
        <form method="post" action="{{ route('SendForm') }}">
            @csrf
                <h1>formulario De Endereço</h1>
            <div class="row container">
                
                <div class="col-md-6 mb-6">
                    <input class="form-control" name="cep" type="number" id="cep" min="0" max="99999999"
                         onblur="pesquisacep(this.value);" placeholder="CEP" required /> 
                </div>

                 <div class="col-md-6 mb-6">
                    <input class="form-control" placeholder="rua" name="rua" type="text" id="rua" required />
                </div>

                <div class="col-md-6 mb-6">
                    <input class="form-control" placeholder="Bairro" name="bairro" type="text" id="bairro"required />
                </div>

                <div class="col-md-6 mb-6">
                    <input class="form-control" placeholder="Cidade" name="cidade" type="text" id="cidade" required />
                </div>

                <div class="col-md-6 mb-6">
                    <input class="form-control" placeholder="Estado" name="uf" type="text" id="uf"required />
                </div>

                {{-- <div class="col-md-6 mb-6">
                    <input class="form-control" placeholder="IBGE" name="ibge" type="text" id="ibge" required />
                </div> --}}
                
            </div>

            <button type="submit" class="btn btn-primary">enviar</button>
            
        </form>
    </center>

    </body>

    </html>