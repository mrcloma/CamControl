<?php
require_once("../model/relatorio.php");

class ListarControllerRelatorio {

    private $lista;
    private $id;

    public function __construct($id) {
        $this->lista = new Relatorio();
        $this->id = $id;
        $this->criarTabela();
    }


    private function criarTabela(){

        $row = $this->lista->getUltimosEventoDetalhes($this->id);

        echo "<table style='table-layout: fixed;' class='table table-bordered w-100'>";
	echo "<tbody>";

        foreach ($row as $value) {
            echo "<tr>";
            echo "<th><b>Status da câmera: </b></th>";
            echo "<td class='text-truncate text-center align-middle'>";
                    if ($value['status_da_camera'] == 1) {
                        echo '<span class="badge bg-success">OK</span>';
                    } else {
                        echo '<span class="badge bg-danger">PENDENTE</span>';
                    }
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Nome da câmera: </th>";
            echo "<td>" . $value['nome_da_camera'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Endereço da câmera: </th>";
            echo "<td>" . $value['endereco_da_camera'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Data de Abertura: </th>";
            echo "<td>" . $value['data_de_abertura_ultimo_evento'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>IT2M: </th>";
            echo "<td>" . $value['it2m_ultimo_evento'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>FMAN: </th>";
            echo "<td>" . $value['fman_ultimo_evento'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>VMANUT: </th>";
            echo "<td>" . $value['vmanut_ultimo_evento'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Problema: </th>";
            echo "<td>" . $value['problema_ultimo_evento'] . "</td>";
            echo "<tr>";
            echo "</tr>";
            echo "<th>Ação: </th>";
            echo "<td>" . $value['acao_ultimo_evento'] . "</td>";
            echo "</tr>";
            echo "<th>Data Registro: </th>";
            echo "<td>" . $value['data_registro_ultimo_evento'] . "</td>";
	    echo "</tr>";
        }

        echo "</tbody></table>";
    }

}
?>

