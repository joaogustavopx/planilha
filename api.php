<?php

// Definindo o cabeçalho para retornar dados no formato JSON
header('Content-Type: application/json');

// Função para ler o arquivo .xlsx usando PhpSpreadsheet
function readXlsx($filePath) {
    // Inclui o autoload do Composer para carregar a biblioteca PhpSpreadsheet
    require 'vendor/autoload.php';

    // Usa a biblioteca PhpSpreadsheet para carregar o arquivo
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $data = [];

    // Itera pelas linhas da planilha
    foreach ($sheet->getRowIterator() as $row) {
        $rowData = [];

        // Itera pelas células de cada linha
        foreach ($row->getCellIterator() as $cell) {
            // Adiciona o valor da célula no array
            $rowData[] = $cell->getValue();
        }

        // Adiciona a linha à lista de dados
        $data[] = $rowData;
    }

    return $data;
}

// Função para ler o arquivo .csv
function readCsv($filePath) {
    $data = [];
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}

// Verifica o tipo de arquivo e chama a função apropriada
function getDataFromFile($filePath) {
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

    if ($fileExtension == 'xlsx') {
        return readXlsx($filePath);
    } elseif ($fileExtension == 'csv') {
        return readCsv($filePath);
    } else {
        return null;
    }
}

$filePath = 'dados.xlsx';  

// Chama a função para obter os dados da planilha
$data = getDataFromFile($filePath);

// Retorna os dados como JSON
echo json_encode($data);

?>