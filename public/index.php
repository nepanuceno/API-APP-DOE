<?php
    header('Content-Type: application/json; charset=utf-8');    
    function getResponseDOE($url)
    {
        $a = file_get_contents($url);
        return $a;
    }

    function getQuantidadeResultados($content): int
    {
        $dom = new DOMDocument;

        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        $tbody = $dom->getElementsByTagName('tbody');
        $tr = $tbody[0]->getElementsByTagName('tr');

        return $tr->length;
    }

    function getURI($elementURI)
    {
        preg_match_all('/<a href="(.*?)"/s', $elementURI, $match);
        return $match[1][0];
    }


    function getElementHTML($content, $elementName)
    {
        $quantidadeResultados = getQuantidadeResultados($content);
        preg_match_all('/<td>(.*?)<\/td>/s', $content, $match);
        $arrDiarios = array_chunk($match[1], 6);
        $arrObjDiarios = [];
        
        foreach($arrDiarios as $diario)
        {
            $objDiario = new stdClass();

            $objDiario->edicao = $diario[0];
            $objDiario->data_publicacao = $diario[1];
            $objDiario->paginas = $diario[2];
            $objDiario->tamanho = $diario[3];
            $objDiario->downloads = $diario[4];
            $objDiario->link = getURI($diario[5]);
            $objDiario->imagen = str_replace("download","imagem", getURI($diario[5]));

            $arrObjDiarios[] = $objDiario;
        }

        echo json_encode($arrObjDiarios);
    }

    $por = filter_input(INPUT_POST, 'por');
    $texto = filter_input(INPUT_POST, 'texto');
    $dataInicial = filter_input(INPUT_POST, 'data-inicial');
    $dataFinal = filter_input(INPUT_POST, 'data-final');
    $edicao = filter_input(INPUT_POST, 'edicao');
    $tipoDocumento = filter_input(INPUT_POST, 'tipo-documento');
    $texnumeroto = filter_input(INPUT_POST, 'numero');

    $dataInicial="2023-01-01";
    $dataFinal="2023-09-11";

    $url = ("https://diariooficial.to.gov.br/busca?por=texto&texto=1079476&data-inicial=$dataInicial&data-final=$dataFinal");

    $response = getResponseDOE($url);
    getElementHTML($response, 'table');