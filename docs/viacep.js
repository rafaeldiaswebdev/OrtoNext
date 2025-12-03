var cep_input='#cep_fornecedor';
var rua='#rua_fornecedor';
var numero='#numero_fornecedor';
var bairro='#bairro_fornecedor';
var cidade='#cidade_fornecedor';
var uf='#estado_fornecedor';
var complemento='#complemento_fornecedor';

var $jq = jQuery.noConflict()

$jq(document).ready(function() {

function limpa_formulário_cep() {

// Limpa valores do formulário de cep.

/*$jq("#form-field-rua").val("");

$jq("#form-field-bairro").val("");

$jq("#form-field-cidade").val("");

$jq("#form-field-uf").val("");*/

}

//Quando o campo cep perde o foco.

$jq(cep_input).blur(function() {

//Nova variável "cep" somente com dígitos.

var cep = $jq(this).val().replace(/\D/g, '');

//Verifica se campo cep possui valor informado.

if (cep != "") {

//Expressão regular para validar o CEP.

var validacep = /^[0-9]{8}$/;

//Valida o formato do CEP.

if(validacep.test(cep)) {

//Preenche os campos com "..." enquanto consulta webservice.

/*$jq("#rua_fornecedor").val("...");

$jq("#bairro_fornecedor").val("...");

$jq("#cidade_fornecedor").val("...");

$jq("#estado_fornecedor").val("...");*/

//Consulta o webservice viacep.com.br/

$jq.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

if (!("erro" in dados)) {

//Atualiza os campos com os valores da consulta.

/*$jq(cep_input).val(dados.cep_input).trigger('input').trigger('change');*/
/*$jq(cep).change();*/
$jq(rua).val(dados.logradouro).trigger('input').trigger('change');
/*$jq(rua).change();*/
$jq(numero).val(dados.gia).trigger('input').trigger('change');
/*$jq(numero).change();*/
$jq(complemento).val(dados.complemento).trigger('input').trigger('change');
/*$jq(complemento).change();*/
$jq(bairro).val(dados.bairro).trigger('input').trigger('change');
/*$jq(bairro).change();*/
$jq(cidade).val(dados.localidade).trigger('input').trigger('change');
/*$jq(cidade).change();*/
$jq(uf).val(dados.uf).trigger('input').trigger('change');

/*$jq("#cep_fornecedor").val(dados.logradouro).trigger('input').trigger('change');

$jq("#rua_fornecedor").val(dados.logradouro).trigger('input').trigger('change');

$jq("#bairro_fornecedor").val(dados.bairro).trigger('input').trigger('change');

$jq("#cidade_fornecedor").val(dados.localidade).trigger('input').trigger('change');

$jq("#estado_fornecedor").val(dados.uf).trigger('input').trigger('change');*/

} //end if.

else {

//CEP pesquisado não foi encontrado.

//limpa_formulário_cep();

alert("CEP não encontrado.");

}

});

} //end if.

else {

//cep é inválido.

//limpa_formulário_cep();

alert("Formato de CEP inválido.");

}

} //end if.

else {

//cep sem valor, limpa formulário.

//limpa_formulário_cep();

}

});

});
