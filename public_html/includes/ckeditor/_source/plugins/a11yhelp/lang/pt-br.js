﻿/*
 Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.plugins.setLang('a11yhelp', 'pt-br',
    {
        accessibilityHelp:{
            title:'Instruções de Acessibilidade',
            contents:'Conteúdo da Ajuda. Para fechar este diálogo pressione ESC.',
            legend:[
                {
                    name:'Geral',
                    items:[
                        {
                            name:'Barra de Ferramentas do Editor',
                            legend:'Pressione ${toolbarFocus} para navegar para a barra de ferramentas. Mova para o anterior ou próximo grupo de ferramentas com TAB e SHIFT-TAB. Mova para o anterior ou próximo botão com SETA PARA DIREITA or SETA PARA ESQUERDA. Pressione ESPAÇO ou ENTER para ativar o botão da barra de ferramentas.'
                        },

                        {
                            name:'Diálogo do Editor',
                            legend:'Dentro de um diálogo, pressione TAB para navegar para o próximo campo, pressione SHIFT + TAB para mover para o campo anterior, pressione ENTER para enviar o diálogo, pressione ESC para cancelar o diálogo. Para diálogos que tem múltiplas abas, pressione ALT + F10 para navegar para a lista de abas, então mova para a próxima aba com SHIFT + TAB ou SETA PARA ESQUERDA. Pressione ESPAÇO ou ENTER para selecionar a aba.'
                        },

                        {
                            name:'Menu de Contexto do Editor',
                            legend:'Pressione ${contextMenu} ou TECLA DE MENU para abrir o menu de contexto, então mova para a próxima opção com TAB ou SETA PARA BAIXO. Mova para a anterior com SHIFT+TAB ou SETA PARA CIMA. Pressione ESPAÇO ou ENTER para selecionar a opção do menu. Abra o submenu da opção atual com ESPAÇO ou ENTER ou SETA PARA DIREITA. Volte para o menu pai com ESC ou SETA PARA ESQUERDA. Feche o menu de contexto com ESC.'
                        },

                        {
                            name:'Caixa de Lista do Editor',
                            legend:'Dentro de uma caixa de lista, mova para o próximo item com TAB ou SETA PARA BAIXO. Mova para o item anterior com SHIFT + TAB ou SETA PARA CIMA. Pressione ESPAÇO ou ENTER para selecionar uma opção na lista. Pressione ESC para fechar a caixa de lista.'
                        },

                        {
                            name:'Barra de Caminho do Elementos do Editor',
                            legend:'Pressione ${elementsPathFocus} para a barra de caminho dos elementos. Mova para o próximo botão de elemento com TAB ou SETA PARA DIREITA. Mova para o botão anterior com  SHIFT+TAB ou SETA PARA ESQUERDA. Pressione ESPAÇO ou ENTER para selecionar o elemento no editor.'
                        }
                    ]
                },
                {
                    name:'Comandos',
                    items:[
                        {
                            name:' Comando Desfazer',
                            legend:'Pressione ${undo}'
                        },
                        {
                            name:' Comando Refazer',
                            legend:'Pressione ${redo}'
                        },
                        {
                            name:' Comando Negrito',
                            legend:'Pressione ${bold}'
                        },
                        {
                            name:' Comando Itálico',
                            legend:'Pressione ${italic}'
                        },
                        {
                            name:' Comando Sublinhado',
                            legend:'Pressione ${underline}'
                        },
                        {
                            name:' Comando Link',
                            legend:'Pressione ${link}'
                        },
                        {
                            name:' Comando Fechar Barra de Ferramentas',
                            legend:'Pressione ${toolbarCollapse}'
                        },
                        {
                            name:' Ajuda de Acessibilidade',
                            legend:'Pressione ${a11yHelp}'
                        }
                    ]
                }
            ]
        }
    });
