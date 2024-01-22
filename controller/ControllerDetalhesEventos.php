<?php
require_once("../model/evento.php");

class ListarControllerHistorico {

    private $lista;
    private $id;

    public function __construct($id) {
        $this->lista = new Evento();
        $this->id = $id;
        $this->criarTabela();
    }

    private function criarTabela() {
        $row = $this->lista->getEventoBD($this->id);
	
        echo "<table class='table w-100'>";
        echo "<tbody>";

        foreach ($row as $value) {
            echo "<tr>";
            echo "<th>Evento: </th>";
            echo "<td>" . $value['evento'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Data de registro: </th>";
            echo "<td>" . $value['data_registro'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>IT2M: </th>";
            echo "<td>" . $value['it2m'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Data de abertura: </th>";
            echo "<td>" . $value['data_abertura'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Data de fechamento: </th>";
            echo "<td>" . $value['data_fechamento'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Responsável: </th>";
            echo "<td>" . $value['responsavel'] . "</td>";
            echo "<tr>";
            echo "</tr>";
            echo "<th>Descrição: </th>";
            echo "<td>" . $value['descricao'] . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    }
}
?>

