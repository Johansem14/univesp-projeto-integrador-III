<?php
use PHPUnit\Framework\TestCase;

class CadastroInteresseTeste extends TestCase
{
    // Teste se o campo produto não está vazio
    public function testProdutoNaoPodeEstarVazio()
    {
        // Simulando a requisição POST sem o campo produto
        $_POST['produto'] = '';
        $_POST['categoria'] = 'Cadeiras';

        // Iniciar o buffer de saída para capturar o echo
        ob_start();

        $nome = $_POST['produto'];
        $produto = $_POST['categoria'];

        if (empty($nome)) {
            echo "<script>alert('Digite o nome de um produto.');</script>";
        }

        // Capturar a saída gerada
        $output = ob_get_clean();

        // Verificar se a saída está correta
        $this->assertEquals("<script>alert('Digite o nome de um produto.');</script>", $output);
    }

    // Teste se a categoria foi selecionada
    public function testCategoriaDeveSerSelecionada()
    {
        // Simulando a requisição POST com categoria vazia
        $_POST['produto'] = 'Produto Exemplo';
        $_POST['categoria'] = '';

        // Iniciar o buffer de saída para capturar o echo
        ob_start();

        $nome = $_POST['produto'];
        $produto = $_POST['categoria'];

        if ($produto === '') {
            echo "<script>alert('Selecione uma categoria.');</script>";
        }

        // Capturar a saída gerada
        $output = ob_get_clean();

        // Verificar se a saída está correta
        $this->assertEquals("<script>alert('Selecione uma categoria.');</script>", $output);
    }

    // Teste de cadastro válido
    public function testCadastroValido()
    {
        // Simulando a requisição POST com produto e categoria válidos
        $_POST['produto'] = 'Produto Exemplo';
        $_POST['categoria'] = 'Cadeiras';

        // Iniciar o buffer de saída para capturar o echo
        ob_start();

        $nome = $_POST['produto'];
        $produto = $_POST['categoria'];

        if (empty($nome)) {
            echo "<script>alert('Digite o nome de um produto.');</script>";
        } elseif ($produto === '') {
            echo "<script>alert('Selecione uma categoria.');</script>";
        } else {
            echo "<script>alert('Produto Cadastrado com Sucesso.');</script>";
        }

        // Capturar a saída gerada
        $output = ob_get_clean();

        // Verificar se a saída está correta para cadastro válido
        $this->assertEquals("<script>alert('Produto Cadastrado com Sucesso.');</script>", $output);
    }
}