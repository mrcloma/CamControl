<?php
require_once("../model/evento.php");

class ListarControllerHistorico {

    private $lista;
    private $camera_id;
    private $itensPorPagina = 5; // Número de itens por página

    public function __construct($camera_id) {
        $this->lista = new Evento();
        $this->camera_id = $camera_id;
        $this->criarTabela();
    }

    private function criarTabela() {
        // Obtém a página atual da URL, se não especificada, assume 1
        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

        // Calcula o deslocamento com base na página atual
        $offset = ($paginaAtual - 1) * $this->itensPorPagina;

        // Obtém os dados da página atual do banco de dados
        $row = $this->lista->getEventoPaginado($this->camera_id, $this->itensPorPagina, $offset);
	
        echo "<table class='table w-100'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Evento</th>";
        echo "<th>Inserção</th>";
        echo "<th>IT2M</th>";
        echo "<th>Abertura</th>";
        echo "<th>Fechamento</th>";
        echo "<th>Responsável</th>";
        echo "<th>Ações</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($row as $value) {
            echo "<tr>";
            echo "<td>" . $value['evento'] . "</td>";
            echo "<td>" . $value['data_registro'] . "</td>";
            echo "<td>" . $value['it2m'] . "</td>";
            echo "<td>" . $value['data_abertura'] . "</td>";
            echo "<td>" . $value['data_fechamento'] . "</td>";
            echo "<td>" . $value['responsavel'] . "</td>";
            echo "<td><a class='btn btn-warning'  href='../view/detalheseventos.php?id=" . $value['id'] . "'>Detalhes</a>&nbsp&nbsp<a class='btn btn-danger' href='../controller/ControllerDeletarEvento.php?id=" . $value['id'] . "'>Excluir</a></td>";
            echo "</tr>";
        }

        echo "</tbody></table>";

        // Adicione a lógica para exibir os links da paginação aqui
        $totalPaginas = $this->lista->getTotalPaginasEvento($this->camera_id, $this->itensPorPagina);
        $this->exibirLinksPaginacao($paginaAtual, $totalPaginas);
    }
    private function exibirLinksPaginacao($paginaAtual, $totalPaginas) {
        echo "<nav aria-label='Page navigation'>";
        echo "<ul class='pagination justify-content-center'>";

        for ($i = 1; $i <= $totalPaginas; $i++) {
            // Verifica se há itens para exibir na página $i
            $offset = ($i - 1) * $this->itensPorPagina;
            $itensNaPagina = $this->lista->getEventoPaginado($this->camera_id, $this->itensPorPagina, $offset);
        
            if (!empty($itensNaPagina)) {
                echo "<li class='page-item " . ($i == $paginaAtual ? 'active' : '') . "'><a class='page-link' href='registroseventos.php?id=" . $this->camera_id . "&pagina=" . $i . "'>" . $i . "</a></li>";
            }
        }

        echo "</ul>";
        echo "</nav>";
    }
}
?>

