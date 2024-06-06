<?php
require_once("../model/relatorio.php");

class ListarRelatorioResumido{

    private $lista;
    private $itensPorPagina = 5; // Número de itens por página

    public function __construct(){
        $this->lista = new Relatorio();
        $this->criarTabela();
    }

    private function criarTabela(){

            $termoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            $camposPesquisa = array('c.status', 'c.nome', 'c.endereco', 'r.it2m', 'r.fman', 'r.vmanut');
            $offset = ($paginaAtual - 1) * $this->itensPorPagina;

            $row = $this->lista->getUltimosEventosCameraPaginado($this->itensPorPagina, $offset, $termoPesquisa, $camposPesquisa);

            echo "</br><form class='form-inline mb-3'>";
            echo "<input type='text' class='form-control mr-2' name='pesquisa' placeholder='Pesquisar' value='".$termoPesquisa."'>";
            echo "</br><button type='submit' class='btn btn-primary'>Pesquisar</button>";
            echo "</form>";

            echo "<table style='table-layout: fixed;' class='table table-bordered w-100'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th><b>Status</b></th>";
            echo "<th><b>Nome Cam</b></th>";
            echo "<th><b>Endereço Cam</b></th>";
            echo "<th><b>Data de Abertura</b></th>";
            echo "<th><b>IT2M</b></th>";
            echo "<th><b>FMAN</b></th>";
            echo "<th><b>VMANUT</b></th>";
            echo "<th><b>Problema</b></th>";
            echo "<th><b>Ação</b></th>";
            echo "<th><b>Data Registro</b></th>";
            echo "<th><b>Detalhes</b></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach ($row as $evento) {
                echo "<tr>";
                echo "<td class='text-truncate text-center align-middle'>";
                    if ($evento['status_da_camera'] == 1) {
                        echo '<span class="badge bg-success">OK</span>';
                    } else {
                        echo '<span class="badge bg-danger">PENDENTE</span>';
                    }
                echo "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['nome_da_camera']."'>" . $evento['nome_da_camera'] . "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['endereco_da_camera']."'>" . $evento['endereco_da_camera'] . "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['data_de_abertura_ultimo_evento']."'>" . $evento['data_de_abertura_ultimo_evento'] . "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['it2m_ultimo_evento']."'>" . $evento['it2m_ultimo_evento'] . "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['fman_ultimo_evento']."'>" . $evento['fman_ultimo_evento'] . "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['vmanut_ultimo_evento']."'>" . $evento['vmanut_ultimo_evento'] . "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['problema_ultimo_evento']."'>" . $evento['problema_ultimo_evento'] . "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['acao_ultimo_evento']."'>" . $evento['acao_ultimo_evento'] . "</td>";
                echo "<td class='text-truncate' data-bs-toggle='tooltip' data-bs-placement='bottom' title='".$evento['data_registro_ultimo_evento']."'>" . $evento['data_registro_ultimo_evento'] . "</td>";
                echo "<td class='text-center align-middle' style='white-space: nowrap;'>
                     <a class='btn btn-warning' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Detalhes' href='../view/detalhesrelatorio.php?id=" . $evento['id_da_camera'] . "'><i class='fas fa-list'></i></a></td>";
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
            echo "<li class='page-item ".($i == $paginaAtual ? 'active' : '')."'><a class='page-link' href='relatorioresumido.php?pagina=".$i.$parametrosPesquisa."'>".$i."</a></li>";
        }

        echo "</ul>";
        echo "</nav>";
    }
}
?>

