<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View de Gerenciamento de Portfolioes
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
class Portfolio_Gerencia_View extends View {

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
        $this->traducao->loadTraducao("2060", $this->get_idioma());


        /**
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         */
        $co = base64_encode("Portfolio_Control"); // CONTROLLER
        $ac = base64_encode("Portfolio_Gerencia");
        $ac_apaga = base64_encode("Portfolio_Apaga");
        $ac_ativa = base64_encode("Portfolio_Ativa");
        $ac_desativa = base64_encode("Portfolio_Desativa");
        $ac_altera = base64_encode("Portfolio_Altera_V");
        $ac_altera_img = base64_encode("Portfolio_Altera_Imagem_V");
        $post = $ac;


        /**
         * CONFIGURE OS CAMPOS HIDDEN
         */
        $hidden = Array();


        /**
         * CONFIGURE OS COMPONENTES QUE DEVE CARREGAR
         */
        $componentes = Array("TOOLTIP");


        /**
         * CONFIGURE O NAV
         */
        $pagina = isset($this->post_request['pagina']) ? $this->post_request['pagina'] : 0;
        $pesquisa = isset($this->post_request['pesquisa']) ? $this->post_request['pesquisa'] : "";
        $control_div = "NAO"; // SIM quando � necess�rio esconder alguma div para mostrar modal        
        $retorno_nav = "pagina=$pagina"; // NAO MODIFIQUE ESTA LINHA
        $retorno_nav .= "&ac=$ac"; // ACAO
        $retorno_nav .= "&co=$co"; // CONTROLADOR
        $retorno_nav .= "&pesquisa=$pesquisa"; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO


        /**
         * CONFIGURE O BOX DE INFORMA��ES
         */
        $titulo_infoacao = $this->traducao->get_titulo_formulario01(); // t�tulo do box de informa��es
        $texto_infoacao = $this->traducao->get_titulo_formulario02(); // texto do box de informa��es


        /**
         * CONFIGURE OS FILTROS. ATENCAO !!! � NECESS�RIO EFETUAR CONFIGURA��ES NO CONTROLADOR PARA O FILTRO FUNCIONAR CORRETAMENTE
         */
        $filtros = Array();
        $filtros['pesquisa']["width"] = "100%"; // tamanho do campo
        $filtros['pesquisa']["alinhamento"] = "right";
        $filtros['pesquisa']["texto"] = $this->traducao->get_titulo_formulario06(); // legenda ao lado do campo
        $filtros['pesquisa']["botao"] = $this->traducao->get_titulo_formulario07();


        /**
         * CONFIGURE A PAGINACAO
         */
        $texto_pag = $this->traducao->get_titulo_formulario05(); // texto que aparece ao lado do n�mero de p�ginas
        $retorno_paginacao = "ac=$ac"; // ACAO
        $retorno_paginacao .= "&co=$co"; // CONTROLADOR
        $retorno_paginacao .= "&pesquisa=" . $pesquisa; // INCLUIDO QUANDO O FILTRO PESQUISA EH ADICIONADO


        /**
         * CONFIGURE A LISTA DE ITENS
         */
        $tam_tab = "960"; // tamanho da tabela que lista os itens em %
        $title_tab = $this->traducao->get_titulo_formulario04(); // t�tulo da tabela que lista os itens


        /**
         * CONFIGURE o topo da tabela que mostra a lista de elementos
         */
        $campos = Array();
        $campos[0]["tamanho_celula"] = "15%";
        $campos[0]["texto"] = $this->traducao->get_leg01(); //foto

        $campos[1]["tamanho_celula"] = "35%";
        $campos[1]["texto"] = $this->traducao->get_leg02(); //dados

        $campos[2]["tamanho_celula"] = "13%";
        $campos[2]["texto"] = $this->traducao->get_leg03(); //imagem

        $campos[3]["tamanho_celula"] = "13%";
        $campos[3]["texto"] = $this->traducao->get_leg04(); //alterar

        $campos[4]["tamanho_celula"] = "13%";
        $campos[4]["texto"] = $this->traducao->get_leg05(); //ativar/desativar

        $campos[5]["tamanho_celula"] = "13%";
        $campos[5]["texto"] = $this->traducao->get_leg06(); //apagar


        /**
         * CONFIGURE VALIDA��ES
         */
        $validacao = array();
        
        /**
         * Seleciona os elementos que ser�o mostrados e configura as linhas da tabela
         */
        $linhas = Array();
        $i = 0;
        while ($i < count($this->objetos)) {
            $dados = $this->objetos[$i]->get_all_dados();
            foreach ($dados as $chave => $valor) {
                $dados[$chave] = htmlspecialchars(stripslashes($valor), NULL, "ISO-8859-1");
            }

            /**
             * CONFIGURE o tooltip de INFO
             */
            $inf = Array();
            $infos = $this->criaInfo($inf);


            /**
             * CONFIGURE OS MODAIS.
             */
            $modais = Array();

            $modais[0]['campos'] = Array('ac' => $ac_apaga);
            $modais[0]['acao'] = "apagar";
            $modais[0]['msg'] = $this->traducao->get_leg31();

            $modais[1]['campos'] = Array('ac' => $ac_ativa);
            $modais[1]['acao'] = "ativar";
            $modais[1]['msg'] = $this->traducao->get_leg32();

            $modais[2]['campos'] = Array('ac' => $ac_desativa);
            $modais[2]['acao'] = "desativar";
            $modais[2]['msg'] = $this->traducao->get_leg33();


            /**
             * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
             */
            if ($dados['status_portfolio'] == "A") {
                $ad = "
                    <span class=\"texto_conteudo_tabela\">
                        <a href=\"javascript:certeza_2(" . $dados['id_portfolio'] . ")\">
                            <img src=\"temas/" . $this->get_tema() . "/icones/ativar.png\" width=\"25\" height=\"25\" align=\"middle\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg13() . "
                        </a>
                    </span>";
            } else {
                $ad = "
                    <span class=\"texto_conteudo_tabela\">
                        <a href=\"javascript:certeza_1(" . $dados['id_portfolio'] . ")\">
                            <img src=\"temas/" . $this->get_tema() . "/icones/desativar.png\" width=\"25\" height=\"25\" align=\"middle\"  border=\"0\" hspace=\"2\"><br> " . $this->traducao->get_leg14() . "
                        </a>
                    </span>";
            }


            /**
             * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR V�O ALGUNS TRATAMENTOS.
             */
            $colunas = Array();
            $diretorio = "../sys/arquivos/img_portfolio/";
            $nome = $dados['id_portfolio'] . "." . $dados['ext_img_portfolio'];
            $colunas[0]["alinhamento"] = "center";
            $colunas[0]["texto"] = " <a title=\"" . $dados['nome_portfolio'] . "\"href=\"$diretorio$nome\" rel=\"lightbox[roadtrip]\">
                                        <img src=\"../sys/includes/make_thumb.php?diretorio=../arquivos/img_portfolio/&arquivo=" . $nome . "&tamanho=100\" border=\"0\" >
                                      </a>";

            $colunas[1]["alinhamento"] = "left";
            $colunas[1]["texto"] = "Nome: <font size=\"2\" color=\"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['nome_portfolio'] . "</font><br><br>
                                    Site: <font size=\"1\" color=\"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">" . $dados['site_portfolio'] . "</font>
                                    ";

            $colunas[2]["alinhamento"] = "center";
            $colunas[2]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:submit_campo(" . $dados['id_portfolio'] . ",'$ac_altera');\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/dados.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg11() . "
                                        </a>
                                    </span>";

            $colunas[3]["alinhamento"] = "center";
            $colunas[3]["texto"] = "
                <span class=\"texto_conteudo_tabela\">
                    <a href=\"javascript:submit_campo(" . $dados['id_portfolio'] . ",'$ac_altera_img');\">
                        <img src=\"temas/" . $this->get_tema() . "/icones/icone_imagens.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>
                            " . $this->traducao->get_leg12() . "
                    </a>
                </span>";

            $colunas[4]["alinhamento"] = "center";
            $colunas[4]["texto"] = $ad; // leg 13 e leg 14

            $colunas[5]["alinhamento"] = "center";
            $colunas[5]["texto"] = "<span class=\"texto_conteudo_tabela\">
                                        <a href=\"javascript:certeza_0(" . $dados['id_portfolio'] . ")\">
                                            <img src=\"temas/" . $this->get_tema() . "/icones/apagar.png\" width=\"25\" height=\"25\" align=\"center\" border=\"0\" hspace=\"2\"><br>" . $this->traducao->get_leg15() . "
                                        </a>
                                    </span>";
            $linhas[$i] = $colunas;

            $i++;
        }


        /**
         * CONFIGURE O ARQUIVO DE TEMPLATE.
         */
        $tpl = new Template("../Templates/Gerencia.html");

        $tpl->CABECALHO = $this->criaCabecalho();
        $tpl->META = $this->criaMetaTags();
        $tpl->CSS = $this->criaCss();
        $tpl->JS = $this->criaJs();
        $tpl->JAVASCRIPT = $this->criaJavascript();
        $tpl->VALIDACAO = $this->criaValidacoes($validacao, $this->form->get_resetcampos(), $post, $this->form->get_ajax());
        $tpl->TITLE = $this->criaTitulo();
        $tpl->COMPONENTES = $this->criaComponentes($componentes);
        $tpl->MODAIS = $this->criaModalLista($modais);
        $tpl->NAV = $this->criaNav($retorno_nav, $control_div);
        $tpl->MENU = $this->criaMenu();
        $tpl->HIDDENS = $this->criaHiddens($hidden);
        $tpl->FILTROS = $this->criaFiltros($filtros);
        $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);
        $pagin = $this->criaPaginacao($this->post_request['pagina'], $this->get_pag_views(), $this->getTotal_reg(), $retorno_paginacao, $texto_pag);
        $tpl->PAGINACAO = $pagin['nav_pesquisa'];
        $tpl->RODAPE = $this->criaRodape();
        $tpl->MODALCOMP = $this->criaModal(isset($this->post_request['msg_tp']) ? $this->post_request['msg_tp'] : "", isset($this->post_request['msg']) ? $this->post_request['msg'] : "");

        $tpl->show();
    }

}

?>
