<?php

/**
 * View de Altera��o de dados do Depoimento
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
class Depoimento_Altera_View extends View {

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
        $this->traducao->loadTraducao("4063", $this->get_idioma());


        /**
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Depoimento_Control"); // CONTROLLER
        $ac = base64_encode("Depoimento_Altera");
        $ac_v = base64_encode("Depoimento_Altera_V");
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
         * RECEBE DADOS DO OBJETO
         */
        $dados = $this->objetos->get_all_dados();
        foreach ($dados as $chave => $valor) {
            $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, "ISO-8859-1");
        }

        /**
         * CONFIGURE AS LINHAS, COLUNAS E VALIDACOES DO FORMULARIO
         */
        $lin = Array();
        $colunas = Array();
        $validacao = Array();

        $colunas[0] = $this->form->texto($this->traducao->get_leg01(), TRUE);
        $colunas[1] = $this->form->textfield("nome_depoimento", $dados['nome_depoimento'], 70, TRUE, $this->traducao->get_leg21(), null, "left", "", "");
        Array_push($validacao, $this->form->validar('nome_depoimento', 'value', '==', '""', $this->traducao->get_leg32(), Array("nome_depoimento"), $this->get_tema(), $this->get_idioma()));
        $lin[] = $colunas;

        $colunas[0] = $this->form->texto($this->traducao->get_leg02(), TRUE);
        $colunas[1] = $this->form->textarea("texto_depoimento", $dados['texto_depoimento'], 80, 5, true, 500, true, $this->traducao->get_leg23(), "left");
        Array_push($validacao, $this->form->validar('texto_depoimento', 'value', '==', '""', $this->traducao->get_leg32(), Array("texto_depoimento"), $this->get_tema(), $this->get_idioma()));
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
