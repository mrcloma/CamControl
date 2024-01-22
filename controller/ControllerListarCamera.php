<?php
require_once("../model/camera.php");

class ListarControllerCamera{

    private $lista;
    private $itensPorPagina = 5; // Número de itens por página

    public function __construct(){
        $this->lista = new Camera();
        $this->criarTabela();
    }

    private function criarTabela(){
        // Verifica se foi realizada uma pesquisa
        $termoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

        // Obtém a página atual da URL, se não especificada, assume 1
        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

	$camposPesquisa = array('nome', 'cliente_nome', 'endereco', 'descricao');

        // Calcula o deslocamento com base na página atual
        $offset = ($paginaAtual - 1) * $this->itensPorPagina;

        // Obtém os dados da página atual do banco de dados
        //$row = $this->lista->getCameraPaginado($this->itensPorPagina, $offset, $termoPesquisa);
	$row = $this->lista->getCameraPaginado($this->itensPorPagina, $offset, $termoPesquisa, $camposPesquisa);

        // Exibe o campo de pesquisa
        echo "</br><form class='form-inline mb-3'>";
        echo "<input type='text' class='form-control mr-2' name='pesquisa' placeholder='Pesquisar' value='".$termoPesquisa."'>";
        echo "</br><button type='submit' class='btn btn-primary'>Pesquisar</button>";
        echo "</form>";


	echo "<table class='table w-100'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th><b>Nome</b></th>";
	echo "<th><b>Cliente</b></th>";
	echo "<th><b>Endereço</b></th>";
	echo "<th>Descrição</th>";
	echo "<th>Ações</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	
	foreach ($row as $value){
	    echo "<tr>";
	    echo "<td>".$value['nome']."</td>";
	    echo "<td>".$value['cliente_nome']."</td>";
	    echo "<td>".$value['endereco']."</td>";
	    echo "<td>".$value['descricao']."</td>";
	    echo "<td><a class='btn btn-warning' href='editarcamera.php?id=".$value['id']."'>Editar</a>&nbsp&nbsp<a class='btn btn-danger' href='../controller/ControllerDeletarCamera.php?id=".$value['id']."'>Excluir</a></td>";
	    echo "</tr>";
	}
	
	echo "</tbody></table>";

        // Adicione a lógica para exibir os links da paginação aqui
        $totalPaginas = $this->lista->getTotalPaginas($this->itensPorPagina, $termoPesquisa);
        $this->exibirLinksPaginacao($paginaAtual, $totalPaginas, $termoPesquisa);
    }

    private function exibirLinksPaginacao($paginaAtual, $totalPaginas, $termoPesquisa){
        echo "<nav aria-label='Page navigation'>";
        echo "<ul class='pagination justify-content-center'>";

        // Adiciona parâmetros de pesquisa à URL
        $parametrosPesquisa = $termoPesquisa ? "&pesquisa=".$termoPesquisa : "";

        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo "<li class='page-item ".($i == $paginaAtual ? 'active' : '')."'><a class='page-link' href='camera.php?pagina=".$i.$parametrosPesquisa."'>".$i."</a></li>";
        }

        echo "</ul>";
        echo "</nav>";
    }
}
?>

