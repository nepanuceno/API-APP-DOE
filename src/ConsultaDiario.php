<?php

namespace ApiDoe;

use ApiDoe\DiarioOficial;

class ConsultaDiario
{
    private $diario;
    private $quantidadeDeColunas;

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
        // $arrObjDiarios = [];
        $arrObjDiariosAux = [];

        $objDiariosResponse = new \stdClass();

        // $objDiarioStatus->status = true;
        // $arrObjDiarios[] = Array('status' => $objDiarioStatus);
        $objDiariosResponse->status = true;

        foreach($arrDiarios as $diario)
        {
            $uri = $this->getURI($diario[5]);
            $objDiario = new \stdClass();

            $objDiario->id = (int) filter_var($uri, FILTER_SANITIZE_NUMBER_INT);
            $objDiario->edicao = $diario[0];
            $objDiario->data_publicacao = $diario[1];
            $objDiario->paginas = $diario[2];
            $objDiario->tamanho = $diario[3];
            $objDiario->downloads = $diario[4];
            $objDiario->link = $uri;
            $objDiario->imagen = str_replace("download","imagem", $uri);

            $arrObjDiariosAux[] = $objDiario;
        }


        // array_push($arrObjDiarios, Array('diarios' => $arrObjDiariosAux));
        $objDiariosResponse->diarios = $arrObjDiariosAux;
        return json_encode($objDiariosResponse);
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
                    $url = $this->diario->getUrlBase()."doc&tipo-documento={$this->diario->getTipoDocumento()}&numero={$this->diario->getNumero()}";
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
        $this->quantidadeDeColunas = $this->getQuantidadeResultados($content);

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
        $td = $tr[0]->getElementsByTagName('td');

        return $td->length;
    }

    private function chunckArray($match)
    {
        return array_chunk($match[1], $this->quantidadeDeColunas);
    }

    private function getURI($elementURI)
    {
        preg_match_all('/<a href="(.*?)"/s', $elementURI, $match);
        return $match[1][0];
    }
}
