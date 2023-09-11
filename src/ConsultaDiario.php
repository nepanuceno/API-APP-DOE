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

    public function makeObjectDOE()
    {
        $objDiarioStatus = new \stdClass();

        $html = $this->getResponseDOE($this->makeUri()); //Mudar
        $arrDiarios = $this->getHTMLContents($html);
        if (count($arrDiarios) <= 0) {
            $objDiarioStatus->status = false;
            $objDiarioStatus->message = "Não há resultados para esta consulta.";
           
            return json_encode(Array('status' => $objDiarioStatus));
        };
        $arrObjDiarios = [];
        $arrObjDiariosAux = [];

        $objDiarioStatus->status = true;
        $arrObjDiarios[] = Array('status' => $objDiarioStatus);

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

            $arrObjDiariosAux[] = $objDiario;
        }

        array_push($arrObjDiarios, Array('diarios' => $arrObjDiariosAux));

        return json_encode($arrObjDiarios);
    }

    private function makeUri()
    {
        if ($this->diario->getPor() != NULL) {

            switch ($this->diario->getpor()) {
                case 'texto':
                    $url = $this->diario->getUrlBase()."texto&texto={$this->diario->getTexto()}&data-inicial={$this->diario->getDataInicial()}&data-final={$this->diario->getDataFinal()}";
                    return $url;
                    break;
                case 'doc':
                    $url = $this->diario->getUrlBase()."doc&numero={$this->diario->getNumero()}";
                    return $url;
                    break;
                case 'edicao':
                    $url = $this->diario->getUrlBase()."edicao&edicao={$this->diario->getEdicao()}";
                    return $url;
                    break;
            }
        }                
    }
                    
    private function getResponseDOE($url)
    {
        return file_get_contents($url);
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
