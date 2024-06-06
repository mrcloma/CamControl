<?php
require_once("../model/camera.php");

class ListarControllerStatus{

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

        // Campos nos quais deseja realizar a pesquisa
        $camposPesquisa = array('status', 'nome', 'cliente_nome', 'descricao');

        // Calcula o deslocamento com base na página atual
        $offset = ($paginaAtual - 1) * $this->itensPorPagina;

        // Obtém os dados da página atual do banco de dados
        $row = $this->lista->getCameraPaginado($this->itensPorPagina, $offset, $termoPesquisa, $camposPesquisa);

        // Exibe o campo de pesquisa
        echo "</br><form class='form-inline mb-3'>";
        echo "<input type='text' class='form-control mr-2' name='pesquisa' placeholder='Pesquisar' value='".$termoPesquisa."'>";
        echo "</br><button type='submit' class='btn btn-primary'>Pesquisar</button>";
        echo "</form>";

        echo "</br><table style='table-layout: fixed;' class='table table-bordered w-100'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th><b>Status</b></th>";
        echo "<th><b>Nome</b></th>";
        echo "<th>Cliente</th>";
        echo "<th>Descrição</th>";
        echo "<th>Ações</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($row as $value){
            echo "<tr>";
            echo "<td class='text-truncate text-center align-middle'>";
            if ($value['status'] == 1) {
                echo '<span class="badge bg-success">OK</span>';
            } else {
                echo '<span class="badge bg-danger">PENDENTE</span>';
            }
            echo "</td>";
            echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$value['nome']."'>".$value['nome']."</td>";
            echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$value['cliente_nome']."'>".$value['cliente_nome']."</td>";
            echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$value['descricao']."'>".$value['descricao']."</td>";
            echo "<td class='text-truncate text-center align-middle'><a class='btn btn-warning' href='alterarstatus.php?id=".$value['id']."'>Alterar Status</a></td>";
            echo "</tr>";
        }

        echo "</tbody></table>";

        // Adicione a lógica para exibir os links da paginação aqui
        $totalPaginas = $this->lista->getTotalPaginas($this->itensPorPagina, $termoPesquisa, $camposPesquisa);
        $this->exibirLinksPaginacao($paginaAtual, $totalPaginas, $termoPesquisa);
    }

    private function exibirLinksPaginacao($paginaAtual, $totalPaginas, $termoPesquisa){
        echo "<nav aria-label='Page navigation'>";
        echo "<ul class='pagination justify-content-center'>";

        // Adiciona parâmetros de pesquisa à URL
        $parametrosPesquisa = $termoPesquisa ? "&pesquisa=".$termoPesquisa : "";

        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo "<li class='page-item ".($i == $paginaAtual ? 'active' : '')."'><a class='page-link' href='status.php?pagina=".$i.$parametrosPesquisa."'>".$i."</a></li>";
        }

        echo "</ul>";
        echo "</nav>";
    }
}
?>

