<?php

namespace ApiDoe;

use ApiDoe\DiarioOficial;

class ConsultaDiario
{
    private $diario;
    public function __construct(DiarioOficial $diario)
    {
        $this->diario = $diario;
    }

    private function getResponseDOE($url)
    {
        return file_get_contents($url);
    }

    public function makeObjectDOE()
    {
        $html = $this->getResponseDOE($this->diario->getUrlBase());
        // var_dump($html) or die();
        $arrDiarios = $this->getHTMLContents($html);
        $arrObjDiarios = [];
        
        foreach($arrDiarios as $diario)
        {
            $objDiario = new \stdClass();

            $objDiario->edicao = $diario[0];
            $objDiario->data_publicacao = $diario[1];
            $objDiario->paginas = $diario[2];
            $objDiario->tamanho = $diario[3];
            $objDiario->downloads = $diario[4];
            $objDiario->link = $this->getURI($diario[5]);
            $objDiario->imagen = str_replace("download","imagem", $this->getURI($diario[5]));

            $arrObjDiarios[] = $objDiario;
        }

        return json_encode($arrObjDiarios);
    }

    private function getHTMLContents($content)
    {
        $quantidadeResultados = $this->getQuantidadeResultados($content);
        preg_match_all('/<td>(.*?)<\/td>/s', $content, $match);
        return $this->chunckArray($match);
    }

    private function getQuantidadeResultados($content): int
    {
        $dom = new \DOMDocument;

        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        $tbody = $dom->getElementsByTagName('tbody');
        $tr = $tbody[0]->getElementsByTagName('tr');

        return $tr->length;
    }

    private function chunckArray($match)
    {
        return array_chunk($match[1], 6);
    }

    private function getURI($elementURI)
    {
        preg_match_all('/<a href="(.*?)"/s', $elementURI, $match);
        return $match[1][0];
    }
}
