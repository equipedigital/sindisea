<?php

/**
 * View de Inclus�o de Balancetes
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 11/07/2016
 * @package View
 *
 */
class Balancete_Add_View extends View {

    /**
     * Configura e mostra a View
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return void
     *
     */
    public function showView() {

        /**
         * CONFIGURE O ID DE TRADUCAO DA VIEW
         */
        $this->traducao->loadTraducao("5071", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Balancete_Control"); // CONTROLLER
        $ac = base64_encode("Balancete_Add");
        $ac_v = base64_encode("Balancete_Add_V");
        $post = $ac;


        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();


        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("COUNTER");


        /**
         * CONFIGURE O NAV
         */
        $control_div = "NAO"; // SIM quando � necess�rio esconder alguma div para mostrar modal
        // a linha de retorno � adicionada ao NAV // SEM O IDIOMA (criaNav())
        $retorno_nav = "pagina=" . $this->post_request['pagina']; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac_v"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR


        /**
         * CONFIGURE O BOX DE INFORMA��ES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // t�tulo do box de informa��es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informa��es


        /**
         * CONFIGURE A TABELA
         */
        $tam_tab = "900"; // tamanho da tabela em px ou em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // t�tulo da tabela
        $col[0]['color'] = "#FFFFFF";
        $col[0]['nowrap'] = false;
        $col[0]['width'] = "25%";
        $col[1]['color'] = "#EBEBEB";
        $col[1]['nowrap'] = false;
        $col[1]['width'] = "75%";


        /**
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();

        // completo
        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), false);
        $colunas[1] = $this->form->textfield_FILE("balancete_completo", $this->post_request['completo'], 70);
        $lin[] = $colunas;

        // movimento caixa
//        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), false);
//        $colunas[1] = $this->form->textfield_FILE("balancete_movimento_caixa", $this->post_request['movimento_caixa'], 70);
//        $lin[] = $colunas;

        // resumido
        $colunas[0] = $this->form->texto($this->traducao->get_leg03(), false);
        $colunas[1] = $this->form->textfield_FILE("balancete_resumido", $this->post_request['resumido'], 70);
        $lin[] = $colunas;

        $array_meses = Array("01" => "Janeiro",
            "02" => "Fevereiro",
            "03" => "Mar�o",
            "04" => "Abril",
            "05" => "Maio",
            "06" => "Junho",
            "07" => "Julho",
            "08" => "Agosto",
            "09" => "Setembro",
            "10" => "Outubro",
            "11" => "Novembro",
            "12" => "Dezembro");

        //  m�s
        $colunas[0] = $this->form->texto($this->traducao->get_leg04(), TRUE);
        $colunas[1] = $this->form->select("mes", $this->traducao->get_leg21(), "", $array_meses, TRUE, 'Selecione um m�s', "left", "");
        Array_push($validacao, $this->form->validar('mes', 'value', '==', '"0"', $this->traducao->get_leg31(), Array("mes"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;


        //  ano
        $colunas[0] = $this->form->texto($this->traducao->get_leg05(), true);
        $colunas[1] = $this->form->textfield("ano", "", 20, false, $this->traducao->get_leg24(), null, "left");
        array_push($validacao, $this->form->validar('ano', 'value', '==', '""', $this->traducao->get_leg32(), Array("ano"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $botoes = Array();
        $botoes[0] = $this->form->button("center");

        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Formulario.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->TABELAFORM = $this->criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes, "", $titulo_infoacao, $texto_infoacao);
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal($this->post_request['msg_tp'], $this->post_request['msg']);

        $tpl->show();
    }

}

?>
