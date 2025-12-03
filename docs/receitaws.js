/* SETUP DOS IDS DO FORM
 *
 * Insira os ID's CSS de acordo com os campos do seu formulário.
 *  Desenvolvido por DANTE TESTA
 *  */

var cnpj='#cnpj_fornecedor';
var situacao='#form-field-situacao';
var natureza='#form-field-natureza';
var capital='#form-field-capital';

var nome='#form-field-nome';
var fantasia='#nome_fornecedor';
var telefone='#telefone1_fornecedor';
//var telefone2='#telefone2_fornecedor';
var email='#email_fornecedor';

var abertura='#form-field-abertura';
var porte='#form-field-porte';
var atividade='#form-field-atividade';
var cnae='#form-field-cnae';

var cep='#cep_fornecedor';
var rua='#rua_fornecedor';
var numero='#numero_fornecedor';
var complemento='#complemento_fornecedor';
var bairro='#bairro_fornecedor';
var cidade='#cidade_fornecedor';
var uf='#estado_fornecedor';



//-------------------------------------------

/* CODIGO BRUTO */
var $jq = jQuery.noConflict();
$jq(document).ready(function() {

/*function limpa_formulario() {
// Limpa valores do formulário.
$jq(cnpj).val('');
$jq(situacao).val('');
$jq(natureza).val('');
$jq(capital).val('');
$jq(nome).val('');
$jq(fantasia).val('');
$jq(telefone).val('');
$jq(email).val('');
$jq(abertura).val('');
$jq(porte).val('');
$jq(atividade).val('');
$jq(cnae).val('');
$jq(cep).val('');
$jq(rua).val('');
$jq(numero).val('');
$jq(complemento).val('');
$jq(bairro).val('');
$jq(cidade).val('');
$jq(uf).val('');
}*/

//Quando o campo CNPJ perde o foco.
$jq(cnpj).blur(function() {
//Nova variável "CNPJ" somente com dígitos.
var cnpj_consultado = $jq(this).val().replace(/\D/g, '');

//Verifica se campo CNPJ possui valor informado.
if (cnpj_consultado !='') {
//Expressão regular para validar o CNPJ.
var validacnpj = /^[0-9]{14}$/;
//Valida o formato do CNPJ.
if(validacnpj.test(cnpj_consultado)) {
//Preenche os campos com "..." enquanto consulta webservice.
/*$jq(cnpj).val('...');
$jq(situacao).val('...');
$jq(natureza).val('...');
$jq(capital).val('...');
$jq(nome).val('...');
$jq(fantasia).val('...');
$jq(telefone).val('...');
$jq(email).val('...');
$jq(abertura).val('...');
$jq(porte).val('...');
$jq(atividade).val('...');
$jq(cnae).val('...');
$jq(cep).val('...');
$jq(rua).val('...');
$jq(numero).val('...');
$jq(complemento).val('...');
$jq(bairro).val('...');
$jq(cidade).val('...');
$jq(uf).val('...');*/


//Consulta o webservice receitaws.com.br/
$jq.getJSON('https://www.receitaws.com.br/v1/cnpj/'+ cnpj_consultado +'/?callback=?', function(dados) {
if (!('erro' in dados)) {
//Atualiza os campos com os valores da consulta.

$jq(cnpj).val(dados.cnpj).trigger('input').trigger('change');
/*$jq(cnpj).change();*/
$jq(fantasia).val(dados.fantasia).trigger('input').trigger('change');
/*$jq(fantasia).change();*/

// Verifica se há uma barra no número de telefone
        if (dados.telefone.includes('/')) {
            // Divide o número de telefone com base na barra
            var partesTelefone = dados.telefone.split('/');

            // Remove espaços em branco dos números de telefone
            var telefone1 = partesTelefone[0].trim();
            var telefone2 = partesTelefone[1].trim();

            // Preenche os campos de telefone
            $jq(telefone1_fornecedor).val(telefone1).trigger('input').trigger('change');
            $jq(telefone2_fornecedor).val(telefone2).trigger('input').trigger('change');
        } else {
            // Caso não haja uma barra no número de telefone, preenche apenas o campo telefone1_fornecedor
            $jq(telefone1_fornecedor).val(dados.telefone).trigger('input').trigger('change');
        }
// Limita o número de caracteres no campo de telefone para 15
/*var telefoneValue = dados.telefone.substring(0, 15);*/
//$jq(telefone).val(telefoneValue).trigger('input').trigger('change');
/*$jq(telefone).change();*/

$jq(email).val(dados.email).trigger('input').trigger('change');
/*$jq(email).change();*/
$jq(cep).val(dados.cep).trigger('input').trigger('change').trigger('input').trigger('blur');
/*$jq(cep).change();*/
$jq(rua).val(dados.logradouro).trigger('input').trigger('change');
/*$jq(rua).change();*/
$jq(numero).val(dados.numero).trigger('input').trigger('change');
/*$jq(numero).change();*/
$jq(complemento).val(dados.complemento).trigger('input').trigger('change');
/*$jq(complemento).change();*/
$jq(bairro).val(dados.bairro).trigger('input').trigger('change');
/*$jq(bairro).change();*/
$jq(cidade).val(dados.municipio).trigger('input').trigger('change');
/*$jq(cidade).change();*/
$jq(uf).val(dados.uf).trigger('input').trigger('change');
/*$jq(uf).change();*/

} //end if.
else {
//CNPJ pesquisado não foi encontrado.
limpa_formulario();
alert('CNPJ não encontrado.');
}
});
} //end if.
else {
//CNPJ é inválido.
limpa_formulario();
alert('Formato de CNPJ inválido.');
}
} //end if.
else {
//CNPJ sem valor, limpa formulário.
limpa_formulario();
}
});
});
