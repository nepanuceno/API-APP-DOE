<?php

namespace ApiDoe;

class DiarioOficial
{
    private $por;
    private $texto;
    private $dataInicial;
    private $dataFinal;
    private $edicao;
    private $tipoDocumento;
    private $numero;
    private $urlBase;

    
    /**
     * Set the value of por
     *
     * @return  self
     */ 
    public function setPor(string|null $por): Object
    {
        $this->por = $por;

        return $this;
    }

    /**
     * Set the value of texto
     *
     * @return  self
     */ 
    public function setTexto(string|null $texto): Object
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Set the value of dataInicial
     *
     * @return  self
     */ 
    public function setDataInicial(string|null $dataInicial): Object
    {
        $this->dataInicial = $dataInicial;

        return $this;
    }

    /**
     * Set the value of dataFinal
     *
     * @return  self
     */ 
    public function setDataFinal(string|null $dataFinal): Object
    {
        $this->dataFinal = $dataFinal;

        return $this;
    }

    /**
     * Set the value of edicao
     *
     * @return  self
     */ 
    public function setEdicao(string|null $edicao): Object
    {
        $this->edicao = $edicao;

        return $this;
    }

    /**
     * Set the value of tipoDocumento
     *
     * @return  self
     */ 
    public function setTipoDocumento(string|null $tipoDocumento): Object
    {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */ 
    public function setNumero(int|null $numero): Object
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Set the value of urlBase
     *
     * @return  self
     */ 
    public function setUrlBase(string $urlBase): Object
    {
        $this->urlBase = $urlBase;

        return $this;
    }

    /**
     * Get the value of por
     */ 
    public function getPor()
    {
        return $this->por;
    }

    /**
     * Get the value of texto
     */ 
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Get the value of dataInicial
     */ 
    public function getDataInicial()
    {
        return $this->dataInicial;
    }

    /**
     * Get the value of dataFinal
     */ 
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * Get the value of edicao
     */ 
    public function getEdicao()
    {
        return $this->edicao;
    }

    /**
     * Get the value of tipoDocumento
     */ 
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    /**
     * Get the value of numero
     */ 
    public function getNumero()
    {
        return $this->numero;
    }

    

    /**
     * Get the value of urlBase
     */ 
    public function getUrlBase()
    {
        return $this->urlBase;
    }
}
