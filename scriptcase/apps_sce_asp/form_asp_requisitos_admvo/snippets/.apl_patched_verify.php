<?php
//
class form_asp_requisitos_admvo_apl
{
   var $has_where_params = false;
   var $NM_is_redirected = false;
   var $NM_non_ajax_info = false;
   var $formatado = false;
   var $use_100perc_fields = false;
   var $classes_100perc_fields = array();
   var $close_modal_after_insert = false;
   var $NM_ajax_flag    = false;
   var $NM_ajax_opcao   = '';
   var $NM_ajax_retorno = '';
   var $NM_ajax_info    = array('result'            => '',
                                'param'             => array(),
                                'autoComp'          => '',
                                'rsSize'            => '',
                                'msgDisplay'        => '',
                                'errList'           => array(),
                                'fldList'           => array(),
                                'varList'           => array(),
                                'focus'             => '',
                                'navStatus'         => array(),
                                'navSummary'        => array(),
                                'navPage'           => array(),
                                'redir'             => array(),
                                'blockDisplay'      => array(),
                                'fieldDisplay'      => array(),
                                'fieldLabel'        => array(),
                                'readOnly'          => array(),
                                'btnVars'           => array(),
                                'ajaxAlert'         => array(),
                                'ajaxMessage'       => array(),
                                'ajaxJavascript'    => array(),
                                'buttonDisplay'     => array(),
                                'buttonDisplayVert' => array(),
                                'calendarReload'    => false,
                                'quickSearchRes'    => false,
                                'displayMsg'        => false,
                                'displayMsgTxt'     => '',
                                'dyn_search'        => array(),
                                'empty_filter'      => '',
                                'event_field'       => '',
                                'fieldsWithErrors'  => array(),
                               );
   var $NM_ajax_force_values = false;
   var $captcha_code;
   var $captcha_sent;
   var $Nav_permite_ava     = true;
   var $Nav_permite_ret     = true;
   var $Apl_com_erro        = false;
   var $app_is_initializing = false;
   var $Ini;
   var $Erro;
   var $Db;
   var $id_asp_req_;
   var $id_asp_fk_;
   var $login_fk_;
   var $id_lisreq_fk_;
   var $num_req_;
   var $archivo_;
   var $notas_aspirante_;
   var $cc_correcto_;
   var $cc_carta_;
   var $prefijo_requisito_;
   var $notas_revisor_;
   var $fecha_revision_;
   var $fecha_revision__hora;
   var $notas_internas_;
   var $notas_internas__hora;
   var $id_carga_req_;
   var $usu_carga_req_;
   var $ip_revision_;
   var $login_insert_;
   var $fecha_alta_;
   var $fecha_alta__hora;
   var $ip_alta_;
   var $login_last_;
   var $fecha_ult_act_;
   var $fecha_ult_act__hora;
   var $ip_last_;
   var $nm_data;
   var $nmgp_opcao;
   var $nmgp_opc_ant;
   var $sc_evento;
   var $nmgp_clone;
   var $nmgp_return_img = array();
   var $nmgp_dados_form = array();
   var $nmgp_dados_select = array();
   var $nm_location;
   var $nm_flag_iframe;
   var $nm_flag_saida_novo;
   var $nmgp_botoes = array();
   var $nmgp_url_saida;
   var $nmgp_form_show;
   var $nmgp_form_empty;
   var $nmgp_cmp_readonly = array();
   var $nmgp_cmp_hidden   = array();
   var $Field_no_validate  = array();
   var $sc_teve_incl = false;
   var $sc_teve_excl = false;
   var $sc_teve_alt  = false;
   var $sc_after_all_insert = false;
   var $sc_after_all_update = false;
   var $sc_after_all_delete = false;
   var $sc_max_reg = 15; 
   var $sc_max_reg_incl = 10; 
   var $form_vert_form_asp_requisitos_admvo = array();
   var $form_paginacao = 'parcial';
   var $lig_edit_lookup      = false;
   var $lig_edit_lookup_call = false;
   var $lig_edit_lookup_cb   = '';
   var $lig_edit_lookup_row  = '';
   var $is_calendar_app = false;
   var $Embutida_call  = false;
   var $Embutida_ronly = false;
   var $Embutida_proc  = false;
   var $Embutida_form  = true;
   var $Grid_editavel  = false;
   var $url_webhelp = '';
   var $nm_todas_criticas;
   var $Campos_Mens_erro;
   var $nm_new_label = array();
   var $record_insert_ok = false;
   var $record_delete_ok = false;
//
//----- 
   function ini_controle()
   {
        global $nm_url_saida, $teste_validade, $script_case_init, 
               $GLOBALS, $Campos_Crit, $Campos_Falta, $Campos_Erros, $sc_seq_vert, $sc_check_incl, 
               $glo_senha_protect, $nm_apl_dependente, $nm_form_submit, $sc_check_excl, $nm_opc_form_php, $nm_call_php, $nm_opc_lookup;


      if ($this->NM_ajax_flag)
      {
          if (isset($this->NM_ajax_info['param']['archivo_']))
          {
              $this->archivo_ = $this->NM_ajax_info['param']['archivo_'];
          }
          if (isset($this->NM_ajax_info['param']['cc_correcto_']))
          {
              $this->cc_correcto_ = $this->NM_ajax_info['param']['cc_correcto_'];
          }
          if (isset($this->NM_ajax_info['param']['csrf_token']))
          {
              $this->csrf_token = $this->NM_ajax_info['param']['csrf_token'];
          }
          if (isset($this->NM_ajax_info['param']['id_asp_req_']))
          {
              $this->id_asp_req_ = $this->NM_ajax_info['param']['id_asp_req_'];
          }
          if (isset($this->NM_ajax_info['param']['nm_form_submit']))
          {
              $this->nm_form_submit = $this->NM_ajax_info['param']['nm_form_submit'];
          }
          if (isset($this->NM_ajax_info['param']['nmgp_ancora']))
          {
              $this->nmgp_ancora = $this->NM_ajax_info['param']['nmgp_ancora'];
          }
          if (isset($this->NM_ajax_info['param']['nmgp_arg_dyn_search']))
          {
              $this->nmgp_arg_dyn_search = $this->NM_ajax_info['param']['nmgp_arg_dyn_search'];
          }
          if (isset($this->NM_ajax_info['param']['nmgp_num_form']))
          {
              $this->nmgp_num_form = $this->NM_ajax_info['param']['nmgp_num_form'];
          }
          if (isset($this->NM_ajax_info['param']['nmgp_opcao']))
          {
              $this->nmgp_opcao = $this->NM_ajax_info['param']['nmgp_opcao'];
          }
          if (isset($this->NM_ajax_info['param']['nmgp_ordem']))
          {
              $this->nmgp_ordem = $this->NM_ajax_info['param']['nmgp_ordem'];
          }
          if (isset($this->NM_ajax_info['param']['nmgp_parms']))
          {
              $this->nmgp_parms = $this->NM_ajax_info['param']['nmgp_parms'];
          }
          if (isset($this->NM_ajax_info['param']['nmgp_refresh_row']))
          {
              $this->nmgp_refresh_row = $this->NM_ajax_info['param']['nmgp_refresh_row'];
          }
          if (isset($this->NM_ajax_info['param']['nmgp_url_saida']))
          {
              $this->nmgp_url_saida = $this->NM_ajax_info['param']['nmgp_url_saida'];
          }
          if (isset($this->NM_ajax_info['param']['notas_aspirante_']))
          {
              $this->notas_aspirante_ = $this->NM_ajax_info['param']['notas_aspirante_'];
          }
          if (isset($this->NM_ajax_info['param']['notas_revisor_']))
          {
              $this->notas_revisor_ = $this->NM_ajax_info['param']['notas_revisor_'];
          }
          if (isset($this->NM_ajax_info['param']['num_req_']))
          {
              $this->num_req_ = $this->NM_ajax_info['param']['num_req_'];
          }
          if (isset($this->NM_ajax_info['param']['sc_clone']))
          {
              $this->sc_clone = $this->NM_ajax_info['param']['sc_clone'];
          }
          if (isset($this->NM_ajax_info['param']['sc_seq_clone']))
          {
              $this->sc_seq_clone = $this->NM_ajax_info['param']['sc_seq_clone'];
          }
          if (isset($this->NM_ajax_info['param']['sc_seq_vert']))
          {
              $this->sc_seq_vert = $this->NM_ajax_info['param']['sc_seq_vert'];
          }
          if (isset($this->NM_ajax_info['param']['script_case_init']))
          {
              $this->script_case_init = $this->NM_ajax_info['param']['script_case_init'];
          }
          if (isset($this->nmgp_refresh_fields))
          {
              $this->nmgp_refresh_fields = explode('_#fld#_', $this->nmgp_refresh_fields);
              $this->nmgp_opcao          = 'recarga';
          }
          if (!isset($this->nmgp_refresh_row))
          {
              $this->nmgp_refresh_row = '';
          }
      }

      $this->scSajaxReservedWords = array('rs', 'rst', 'rsrnd', 'rsargs');
      $this->sc_conv_var = array();
      $this->sc_conv_var['id_asp_req'] = "id_asp_req_";
      $this->sc_conv_var['id_asp_fk'] = "id_asp_fk_";
      $this->sc_conv_var['login_fk'] = "login_fk_";
      $this->sc_conv_var['id_lisreq_fk'] = "id_lisreq_fk_";
      $this->sc_conv_var['num_req'] = "num_req_";
      $this->sc_conv_var['archivo'] = "archivo_";
      $this->sc_conv_var['notas_aspirante'] = "notas_aspirante_";
      $this->sc_conv_var['cc_correcto'] = "cc_correcto_";
      $this->sc_conv_var['cc_carta'] = "cc_carta_";
      $this->sc_conv_var['prefijo_requisito'] = "prefijo_requisito_";
      $this->sc_conv_var['notas_revisor'] = "notas_revisor_";
      $this->sc_conv_var['fecha_revision'] = "fecha_revision_";
      $this->sc_conv_var['notas_internas'] = "notas_internas_";
      $this->sc_conv_var['id_carga_req'] = "id_carga_req_";
      $this->sc_conv_var['usu_carga_req'] = "usu_carga_req_";
      $this->sc_conv_var['ip_revision'] = "ip_revision_";
      $this->sc_conv_var['login_insert'] = "login_insert_";
      $this->sc_conv_var['fecha_alta'] = "fecha_alta_";
      $this->sc_conv_var['ip_alta'] = "ip_alta_";
      $this->sc_conv_var['login_last'] = "login_last_";
      $this->sc_conv_var['fecha_ult_act'] = "fecha_ult_act_";
      $this->sc_conv_var['ip_last'] = "ip_last_";
      if (!empty($_FILES))
      {
          foreach ($_FILES as $nmgp_campo => $nmgp_valores)
          {
               if (!in_array(strtolower($nmgp_campo), $this->scSajaxReservedWords)) {
                   if (isset($this->sc_conv_var[$nmgp_campo]))
                   {
                       $nmgp_campo = $this->sc_conv_var[$nmgp_campo];
                   }
                   elseif (isset($this->sc_conv_var[strtolower($nmgp_campo)]))
                   {
                       $nmgp_campo = $this->sc_conv_var[strtolower($nmgp_campo)];
                   }
               }
               $tmp_scfile_name     = $nmgp_campo . "_scfile_name";
               $tmp_scfile_type     = $nmgp_campo . "_scfile_type";
               $this->$nmgp_campo = is_array($nmgp_valores['tmp_name']) ? $nmgp_valores['tmp_name'][0] : $nmgp_valores['tmp_name'];
               $this->$tmp_scfile_type   = is_array($nmgp_valores['type'])     ? $nmgp_valores['type'][0]     : $nmgp_valores['type'];
               $this->$tmp_scfile_name   = is_array($nmgp_valores['name'])     ? $nmgp_valores['name'][0]     : $nmgp_valores['name'];
          }
      }
      $Sc_lig_md5 = false;
      if (!empty($_POST))
      {
          foreach ($_POST as $nmgp_var => $nmgp_val)
          {
               if (substr($nmgp_var, 0, 11) == "SC_glo_par_")
               {
                   $nmgp_var = substr($nmgp_var, 11);
                   $nmgp_val = $_SESSION[$nmgp_val];
               }
              if ($nmgp_var == "nmgp_parms" && substr($nmgp_val, 0, 8) == "@SC_par@")
              {
                  $SC_Ind_Val = explode("@SC_par@", $nmgp_val);
                  if (count($SC_Ind_Val) == 4 && isset($_SESSION['sc_session'][$SC_Ind_Val[1]][$SC_Ind_Val[2]]['Lig_Md5'][$SC_Ind_Val[3]]))
                  {
                      $nmgp_val = $_SESSION['sc_session'][$SC_Ind_Val[1]][$SC_Ind_Val[2]]['Lig_Md5'][$SC_Ind_Val[3]];
                      $Sc_lig_md5 = true;
                  }
                  else
                  {
                      $_SESSION['sc_session']['SC_parm_violation'] = true;
                  }
              }
               if (!in_array(strtolower($nmgp_var), $this->scSajaxReservedWords)) {
                   if (isset($this->sc_conv_var[$nmgp_var]))
                   {
                       $nmgp_var = $this->sc_conv_var[$nmgp_var];
                   }
                   elseif (isset($this->sc_conv_var[strtolower($nmgp_var)]))
                   {
                       $nmgp_var = $this->sc_conv_var[strtolower($nmgp_var)];
                   }
               }
               $nmgp_val = NM_decode_input($nmgp_val);
               $this->$nmgp_var = $nmgp_val;
          }
      }
      if (!empty($_GET))
      {
          foreach ($_GET as $nmgp_var => $nmgp_val)
          {
               if (substr($nmgp_var, 0, 11) == "SC_glo_par_")
               {
                   $nmgp_var = substr($nmgp_var, 11);
                   $nmgp_val = $_SESSION[$nmgp_val];
               }
              if ($nmgp_var == "nmgp_parms" && substr($nmgp_val, 0, 8) == "@SC_par@")
              {
                  $SC_Ind_Val = explode("@SC_par@", $nmgp_val);
                  if (count($SC_Ind_Val) == 4 && isset($_SESSION['sc_session'][$SC_Ind_Val[1]][$SC_Ind_Val[2]]['Lig_Md5'][$SC_Ind_Val[3]]))
                  {
                      $nmgp_val = $_SESSION['sc_session'][$SC_Ind_Val[1]][$SC_Ind_Val[2]]['Lig_Md5'][$SC_Ind_Val[3]];
                      $Sc_lig_md5 = true;
                  }
                  else
                  {
                       $_SESSION['sc_session']['SC_parm_violation'] = true;
                  }
              }
               if (!in_array(strtolower($nmgp_var), $this->scSajaxReservedWords)) {
                   if (isset($this->sc_conv_var[$nmgp_var]))
                   {
                       $nmgp_var = $this->sc_conv_var[$nmgp_var];
                   }
                   elseif (isset($this->sc_conv_var[strtolower($nmgp_var)]))
                   {
                       $nmgp_var = $this->sc_conv_var[strtolower($nmgp_var)];
                   }
               }
               $nmgp_val = NM_decode_input($nmgp_val);
               $this->$nmgp_var = $nmgp_val;
          }
      }
      if (isset($SC_lig_apl_orig) && !$Sc_lig_md5 && (!isset($nmgp_parms) || ($nmgp_parms != "SC_null" && substr($nmgp_parms, 0, 8) != "OrScLink")))
      {
          $_SESSION['sc_session']['SC_parm_violation'] = true;
      }
      if (isset($nmgp_parms) && $nmgp_parms == "SC_null")
      {
          $nmgp_parms = "";
      }
      if (isset($this->generacion) && isset($this->NM_contr_var_session) && $this->NM_contr_var_session == "Yes") 
      {
          $_SESSION['generacion'] = $this->generacion;
      }
      if (isset($this->cont_file) && isset($this->NM_contr_var_session) && $this->NM_contr_var_session == "Yes") 
      {
          $_SESSION['cont_file'] = $this->cont_file;
      }
      if (isset($_POST["generacion"]) && isset($this->generacion)) 
      {
          $_SESSION['generacion'] = $this->generacion;
      }
      if (isset($_POST["cont_file"]) && isset($this->cont_file)) 
      {
          $_SESSION['cont_file'] = $this->cont_file;
      }
      if (isset($_GET["generacion"]) && isset($this->generacion)) 
      {
          $_SESSION['generacion'] = $this->generacion;
      }
      if (isset($_GET["cont_file"]) && isset($this->cont_file)) 
      {
          $_SESSION['cont_file'] = $this->cont_file;
      }
      if (isset($this->Refresh_aba_menu)) {
          $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['Refresh_aba_menu'] = $this->Refresh_aba_menu;
      }
      if (isset($this->nmgp_opcao) && $this->nmgp_opcao == "reload_novo") {
          $_POST['nmgp_opcao'] = "novo";
          $this->nmgp_opcao    = "novo";
          $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['opcao']   = "novo";
          $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['opc_ant'] = "inicio";
      }
      if (isset($_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['embutida_parms']))
      { 
          $this->nmgp_parms = $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['embutida_parms'];
          unset($_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['embutida_parms']);
      } 
      if (isset($this->nmgp_parms) && !empty($this->nmgp_parms)) 
      { 
          if (isset($_SESSION['nm_aba_bg_color'])) 
          { 
              unset($_SESSION['nm_aba_bg_color']);
          }   
          $this->NM_where_filter = "";
          $tem_where_parms       = false;
          $nmgp_parms = str_replace("@aspass@", "'", $this->nmgp_parms);
          $nmgp_parms = str_replace("*scout", "?@?", $nmgp_parms);
          $nmgp_parms = str_replace("*scin", "?#?", $nmgp_parms);
          $todox = str_replace("?#?@?@?", "?#?@ ?@?", $nmgp_parms);
          $todo  = explode("?@?", $todox);
          $ix = 0;
          while (!empty($todo[$ix]))
          {
             $cadapar = explode("?#?", $todo[$ix]);
             if (1 < sizeof($cadapar))
             {
                if (substr($cadapar[0], 0, 11) == "SC_glo_par_")
                {
                    $cadapar[0] = substr($cadapar[0], 11);
                    $cadapar[1] = $_SESSION[$cadapar[1]];
                }
                 if (isset($this->sc_conv_var[$cadapar[0]]))
                 {
                     $cadapar[0] = $this->sc_conv_var[$cadapar[0]];
                 }
                 elseif (isset($this->sc_conv_var[strtolower($cadapar[0])]))
                 {
                     $cadapar[0] = $this->sc_conv_var[strtolower($cadapar[0])];
                 }
                 nm_limpa_str_form_asp_requisitos_admvo($cadapar[1]);
                 if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
                 $Tmp_par = $cadapar[0];
                 $this->$Tmp_par = $cadapar[1];
                 if ($cadapar[0] == "id_asp_req_")
                 {
                     $this->NM_where_filter .= (empty($this->NM_where_filter)) ? "(" : " and ";
                     $this->NM_where_filter .= "id_asp_req = " . $this->id_asp_req_;
                     $this->has_where_params = true;
                     $tem_where_parms        = true;
                 }
                 elseif ($cadapar[0] == "NM_where_filter")
                 {
                     $this->has_where_params = false;
                     $tem_where_parms        = false;
                 }
             }
             $ix++;
          }
          if (isset($this->generacion)) 
          {
              $_SESSION['generacion'] = $this->generacion;
          }
          if (isset($this->cont_file)) 
          {
              $_SESSION['cont_file'] = $this->cont_file;
          }
          if ($tem_where_parms)
          {
              $this->NM_where_filter .= ")";
          }
          elseif (empty($this->NM_where_filter))
          {
              unset($this->NM_where_filter);
          }
          if (isset($this->NM_where_filter_form))
          {
              $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['where_filter_form'] = $this->NM_where_filter_form;
              unset($_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['total']);
          }
          if (isset($this->sc_redir_atualiz))
          {
              $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['sc_redir_atualiz'] = $this->sc_redir_atualiz;
          }
          if (isset($this->sc_redir_insert))
          {
              $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['sc_redir_insert'] = $this->sc_redir_insert;
              unset($_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['opc_ant']);
          }
          if (isset($this->generacion)) 
          {
              $_SESSION['generacion'] = $this->generacion;
          }
          if (isset($this->cont_file)) 
          {
              $_SESSION['cont_file'] = $this->cont_file;
          }
      } 
      elseif (isset($script_case_init) && !empty($script_case_init) && isset($_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['parms']))
      {
          if ((!isset($this->nmgp_opcao) || ($this->nmgp_opcao != "incluir" && $this->nmgp_opcao != "alterar" && $this->nmgp_opcao != "excluir" && $this->nmgp_opcao != "novo" && $this->nmgp_opcao != "recarga" && $this->nmgp_opcao != "muda_form")) && (!isset($this->NM_ajax_opcao) || $this->NM_ajax_opcao == ""))
          {
              $todox = str_replace("?#?@?@?", "?#?@ ?@?", $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['parms']);
              $todo  = explode("?@?", $todox);
              $ix = 0;
              while (!empty($todo[$ix]))
              {
                 $cadapar = explode("?#?", $todo[$ix]);
                 if (substr($cadapar[0], 0, 11) == "SC_glo_par_")
                 {
                     $cadapar[0] = substr($cadapar[0], 11);
                     $cadapar[1] = $_SESSION[$cadapar[1]];
                 }
                 if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
                 $Tmp_par = $cadapar[0];
                 $this->$Tmp_par = $cadapar[1];
                 $ix++;
              }
          }
      } 

      if (isset($this->nm_run_menu) && $this->nm_run_menu == 1)
      { 
          $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['nm_run_menu'] = 1;
      } 
      if (!$this->NM_ajax_flag && 'autocomp_' == substr($this->NM_ajax_opcao, 0, 9))
      {
          $this->NM_ajax_flag = true;
      }

      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      if (isset($this->nm_evt_ret_edit) && '' != $this->nm_evt_ret_edit)
      {
          $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['lig_edit_lookup']     = true;
          $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['lig_edit_lookup_cb']  = $this->nm_evt_ret_edit;
          $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['lig_edit_lookup_row'] = isset($this->nm_evt_ret_row) ? $this->nm_evt_ret_row : '';
      }
      if (isset($_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['lig_edit_lookup']) && $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['lig_edit_lookup'])
      {
          $this->lig_edit_lookup     = true;
          $this->lig_edit_lookup_cb  = $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['lig_edit_lookup_cb'];
          $this->lig_edit_lookup_row = $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['lig_edit_lookup_row'];
      }
      if (!$this->Ini)
      { 
          $this->Ini = new form_asp_requisitos_admvo_ini(); 
          $this->Ini->init();
          $this->nm_data = new nm_data("es");
          $this->app_is_initializing = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['initialize'];
      } 
      else 
      { 
         $this->nm_data = new nm_data("es");
      } 
      $_SESSION['sc_session'][$script_case_init]['form_asp_requisitos_admvo']['upload_field_info'] = array();

      unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['masterValue']);
      $this->Change_Menu = false;
      $run_iframe = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe']) && ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "F" || $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "R")) ? true : false;
      if (!$run_iframe && isset($_SESSION['scriptcase']['menu_atual']) && !$_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_call'] && (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_outra_jan']) || !$_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_outra_jan']))
      {
          $this->sc_init_menu = "x";
          if (isset($_SESSION['scriptcase'][$_SESSION['scriptcase']['menu_atual']]['sc_init']['form_asp_requisitos_admvo']))
          {
              $this->sc_init_menu = $_SESSION['scriptcase'][$_SESSION['scriptcase']['menu_atual']]['sc_init']['form_asp_requisitos_admvo'];
          }
          elseif (isset($_SESSION['scriptcase']['menu_apls'][$_SESSION['scriptcase']['menu_atual']]))
          {
              foreach ($_SESSION['scriptcase']['menu_apls'][$_SESSION['scriptcase']['menu_atual']] as $init => $resto)
              {
                  if ($this->Ini->sc_page == $init)
                  {
                      $this->sc_init_menu = $init;
                      break;
                  }
              }
          }
          if ($this->Ini->sc_page == $this->sc_init_menu && !isset($_SESSION['scriptcase']['menu_apls'][$_SESSION['scriptcase']['menu_atual']][$this->sc_init_menu]['form_asp_requisitos_admvo']))
          {
               $_SESSION['scriptcase']['menu_apls'][$_SESSION['scriptcase']['menu_atual']][$this->sc_init_menu]['form_asp_requisitos_admvo']['link'] = $this->Ini->sc_protocolo . $this->Ini->server . $this->Ini->path_link . "" . SC_dir_app_name('form_asp_requisitos_admvo') . "/";
               $_SESSION['scriptcase']['menu_apls'][$_SESSION['scriptcase']['menu_atual']][$this->sc_init_menu]['form_asp_requisitos_admvo']['label'] = "" . $this->Ini->Nm_lang['lang_othr_frmu_title'] . " " . $this->Ini->Nm_lang['lang_tbl_asp_requisitos'] . "";
               $this->Change_Menu = true;
          }
          elseif ($this->Ini->sc_page == $this->sc_init_menu)
          {
              $achou = false;
              foreach ($_SESSION['scriptcase']['menu_apls'][$_SESSION['scriptcase']['menu_atual']][$this->sc_init_menu] as $apl => $parms)
              {
                  if ($apl == "form_asp_requisitos_admvo")
                  {
                      $achou = true;
                  }
                  elseif ($achou)
                  {
                      unset($_SESSION['scriptcase']['menu_apls'][$_SESSION['scriptcase']['menu_atual']][$this->sc_init_menu][$apl]);
                      $this->Change_Menu = true;
                  }
              }
          }
      }
      if (!function_exists("nmButtonOutput"))
      {
          include_once($this->Ini->path_lib_php . "nm_gp_config_btn.php");
      }
      include("../_lib/css/" . $this->Ini->str_schema_all . "_form.php");
      $this->Ini->Str_btn_form    = trim($str_button);
      include($this->Ini->path_btn . $this->Ini->Str_btn_form . '/' . $this->Ini->Str_btn_form . $_SESSION['scriptcase']['reg_conf']['css_dir'] . '.php');
      $_SESSION['scriptcase']['css_form_help'] = '../_lib/css/' . $this->Ini->str_schema_all . "_form.css";
      $_SESSION['scriptcase']['css_form_help_dir'] = '../_lib/css/' . $this->Ini->str_schema_all . "_form" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css";
      $this->Db = $this->Ini->Db; 
      $this->nm_new_label['num_req_'] = '' . $this->Ini->Nm_lang['lang_asp_requisitos_fld_num_req'] . '';
      $this->nm_new_label['archivo_'] = '' . $this->Ini->Nm_lang['lang_asp_requisitos_fld_archivo'] . '';
      $this->nm_new_label['cc_correcto_'] = '' . $this->Ini->Nm_lang['lang_asp_requisitos_fld_cc_correcto'] . '';
      $this->nm_new_label['notas_revisor_'] = '' . $this->Ini->Nm_lang['lang_asp_requisitos_fld_notas_revisor'] . '';

      $this->Ini->str_google_fonts = isset($str_google_fonts)?$str_google_fonts:'';
      $this->Ini->Img_sep_form    = "/" . trim($str_toolbar_separator);
      $this->Ini->Color_bg_ajax   = !isset($str_ajax_bg)         || "" == trim($str_ajax_bg)         ? "#000" : $str_ajax_bg;
      $this->Ini->Border_c_ajax   = !isset($str_ajax_border_c)   || "" == trim($str_ajax_border_c)   ? ""     : $str_ajax_border_c;
      $this->Ini->Border_s_ajax   = !isset($str_ajax_border_s)   || "" == trim($str_ajax_border_s)   ? ""     : $str_ajax_border_s;
      $this->Ini->Border_w_ajax   = !isset($str_ajax_border_w)   || "" == trim($str_ajax_border_w)   ? ""     : $str_ajax_border_w;
      $this->Ini->Block_img_exp   = !isset($str_block_exp)       || "" == trim($str_block_exp)       ? ""     : $str_block_exp;
      $this->Ini->Block_img_col   = !isset($str_block_col)       || "" == trim($str_block_col)       ? ""     : $str_block_col;
      $this->Ini->Msg_ico_title   = !isset($str_msg_ico_title)   || "" == trim($str_msg_ico_title)   ? ""     : $str_msg_ico_title;
      $this->Ini->Msg_ico_body    = !isset($str_msg_ico_body)    || "" == trim($str_msg_ico_body)    ? ""     : $str_msg_ico_body;
      $this->Ini->Err_ico_title   = !isset($str_err_ico_title)   || "" == trim($str_err_ico_title)   ? ""     : $str_err_ico_title;
      $this->Ini->Err_ico_body    = !isset($str_err_ico_body)    || "" == trim($str_err_ico_body)    ? ""     : $str_err_ico_body;
      $this->Ini->Cal_ico_back    = !isset($str_cal_ico_back)    || "" == trim($str_cal_ico_back)    ? ""     : $str_cal_ico_back;
      $this->Ini->Cal_ico_for     = !isset($str_cal_ico_for)     || "" == trim($str_cal_ico_for)     ? ""     : $str_cal_ico_for;
      $this->Ini->Cal_ico_close   = !isset($str_cal_ico_close)   || "" == trim($str_cal_ico_close)   ? ""     : $str_cal_ico_close;
      $this->Ini->Tab_space       = !isset($str_tab_space)       || "" == trim($str_tab_space)       ? ""     : $str_tab_space;
      $this->Ini->Bubble_tail     = !isset($str_bubble_tail)     || "" == trim($str_bubble_tail)     ? ""     : $str_bubble_tail;
      $this->Ini->Label_sort_pos  = !isset($str_label_sort_pos)  || "" == trim($str_label_sort_pos)  ? ""     : $str_label_sort_pos;
      $this->Ini->Label_sort      = !isset($str_label_sort)      || "" == trim($str_label_sort)      ? ""     : $str_label_sort;
      $this->Ini->Label_sort_asc  = !isset($str_label_sort_asc)  || "" == trim($str_label_sort_asc)  ? ""     : $str_label_sort_asc;
      $this->Ini->Label_sort_desc = !isset($str_label_sort_desc) || "" == trim($str_label_sort_desc) ? ""     : $str_label_sort_desc;
      $this->Ini->Img_status_ok       = !isset($str_img_status_ok_mult)  || "" == trim($str_img_status_ok_mult)   ? ""     : $str_img_status_ok_mult;
      $this->Ini->Img_status_err      = !isset($str_img_status_err_mult) || "" == trim($str_img_status_err_mult)  ? ""     : $str_img_status_err_mult;
      $this->Ini->Css_status          = "scFormInputErrorMult";
      $this->Ini->Css_status_pwd_box  = "scFormInputErrorMultPwdBox";
      $this->Ini->Css_status_pwd_text = "scFormInputErrorMultPwdText";
      $this->Ini->Error_icon_span      = !isset($str_error_icon_span)  || "" == trim($str_error_icon_span)  ? false  : "message" == $str_error_icon_span;
      $this->Ini->Img_qs_search        = !isset($img_qs_search)        || "" == trim($img_qs_search)        ? "scriptcase__NM__qs_lupa.png"  : $img_qs_search;
      $this->Ini->Img_qs_clean         = !isset($img_qs_clean)         || "" == trim($img_qs_clean)         ? "scriptcase__NM__qs_close.png" : $img_qs_clean;
      $this->Ini->Str_qs_image_padding = !isset($str_qs_image_padding) || "" == trim($str_qs_image_padding) ? "0"                            : $str_qs_image_padding;
      $this->Ini->App_div_tree_img_col = trim($app_div_str_tree_col);
      $this->Ini->App_div_tree_img_exp = trim($app_div_str_tree_exp);
      $this->Ini->form_table_width     = isset($str_form_table_width) && '' != trim($str_form_table_width) ? $str_form_table_width : '';
      $this->Ini->Bubble_tail          = trim($str_bubble_tail);

        $this->classes_100perc_fields['table'] = '';
        $this->classes_100perc_fields['input'] = '';
        $this->classes_100perc_fields['span_input'] = '';
        $this->classes_100perc_fields['span_select'] = '';
        $this->classes_100perc_fields['style_category'] = '';
        $this->classes_100perc_fields['keep_field_size'] = true;



      $_SESSION['scriptcase']['error_icon']['form_asp_requisitos_admvo']  = "<img src=\"" . $this->Ini->path_icones . "/scriptcase__NM__btn__NM__scriptcase9_Rhino__NM__nm_scriptcase9_Rhino_error.png\" style=\"border-width: 0px\" align=\"top\">&nbsp;";
      $_SESSION['scriptcase']['error_close']['form_asp_requisitos_admvo'] = "<td>" . nmButtonOutput($this->arr_buttons, "berrm_clse", "document.getElementById('id_error_display_fixed').style.display = 'none'; document.getElementById('id_error_message_fixed').innerHTML = ''; return false", "document.getElementById('id_error_display_fixed').style.display = 'none'; document.getElementById('id_error_message_fixed').innerHTML = ''; return false", "", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", '', '', '', '', '', '', '', '', "") . "</td>";

      $this->Embutida_proc = isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_proc']) ? $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_proc'] : $this->Embutida_proc;
      $this->Embutida_form = isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_form']) ? $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_form'] : $this->Embutida_form;
      $this->Embutida_call = isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_call']) ? $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_call'] : $this->Embutida_call;

      $this->form_3versions_single = false;

       $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['table_refresh'] = false;

      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit']) && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit'])
      {
          $this->Grid_editavel = ('on' == $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit']) ? true : false;
      }
      if (isset($this->Grid_editavel) && $this->Grid_editavel)
      {
          $this->Embutida_form  = true;
          $this->Embutida_ronly = true;
      }
      $this->Embutida_multi = false;
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_multi']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_multi'])
      {
          $this->Grid_editavel  = false;
          $this->Embutida_form  = false;
          $this->Embutida_ronly = false;
          $this->Embutida_multi = true;
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_tp_pag']) && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_tp_pag'])
      {
          $this->form_paginacao = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_tp_pag'];
      }

      if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_form']) || '' == $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_form'])
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_form'] = $this->Embutida_form;
      }
      if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit']) || '' == $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit'])
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit'] = $this->Grid_editavel ? 'on' : 'off';
      }
      if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit']) || '' == $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit'])
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_grid_edit'] = $this->Embutida_call;
      }

      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      $this->nmgp_url_saida  = $nm_url_saida;
      $this->nmgp_form_show  = "on";
      $this->nmgp_form_empty = false;
      $this->Ini->sc_Include($this->Ini->path_lib_php . "/nm_valida.php", "C", "NM_Valida") ; 
      $teste_validade = new NM_Valida ;

      $this->loadFieldConfig();

      if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['first_time'])
      {
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['insert']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['new']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['update']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['delete']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['first']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['back']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['forward']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['last']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['qsearch']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['dynsearch']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['summary']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['navpage']);
          unset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['goto']);
      }
      $this->NM_cancel_return_new = (isset($this->NM_cancel_return_new) && $this->NM_cancel_return_new == 1) ? "1" : "";
      $this->NM_cancel_insert_new = ((isset($this->NM_cancel_insert_new) && $this->NM_cancel_insert_new == 1) || $this->NM_cancel_return_new == 1) ? "document.F5.action='" . $nm_url_saida . "';" : "";
      if (isset($this->NM_btn_insert) && '' != $this->NM_btn_insert && (!isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['insert']) || '' == $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['insert']))
      {
          if ('N' == $this->NM_btn_insert)
          {
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['insert'] = 'off';
          }
          else
          {
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['insert'] = 'on';
          }
      }
      if (isset($this->NM_btn_new) && 'N' == $this->NM_btn_new)
      {
          $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['new'] = 'off';
      }
      if (isset($this->NM_btn_update) && '' != $this->NM_btn_update && (!isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['update']) || '' == $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['update']))
      {
          if ('N' == $this->NM_btn_update)
          {
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['update'] = 'off';
          }
          else
          {
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['update'] = 'on';
          }
      }
      if (isset($this->NM_btn_delete) && '' != $this->NM_btn_delete && (!isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['delete']) || '' == $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['delete']))
      {
          if ('N' == $this->NM_btn_delete)
          {
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['delete'] = 'off';
          }
          else
          {
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['delete'] = 'on';
          }
      }
      if (isset($this->NM_btn_navega) && '' != $this->NM_btn_navega)
      {
          if ('N' == $this->NM_btn_navega)
          {
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['first']     = 'off';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['back']      = 'off';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['forward']   = 'off';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['last']      = 'off';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['qsearch']   = 'off';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['dynsearch'] = 'off';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['summary']   = 'off';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['navpage']   = 'off';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['goto']      = 'off';
              $this->Nav_permite_ava = false;
              $this->Nav_permite_ret = false;
          }
          else
          {
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['first']     = 'on';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['back']      = 'on';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['forward']   = 'on';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['last']      = 'on';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['qsearch']   = 'on';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['dynsearch'] = 'on';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['summary']   = 'on';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['navpage']   = 'on';
              $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['goto']      = 'on';
          }
      }

      $this->nmgp_botoes['cancel'] = "on";
      $this->nmgp_botoes['exit'] = "on";
      $this->nmgp_botoes['new']  = "off";
      $this->nmgp_botoes['copy'] = "off";
      $this->nmgp_botoes['insert'] = "off";
      $this->nmgp_botoes['update'] = "on";
      $this->nmgp_botoes['delete'] = "off";
      if ('total' == $this->form_paginacao)
      {
          $this->nmgp_botoes['first']   = "off";
          $this->nmgp_botoes['back']    = "off";
          $this->nmgp_botoes['forward'] = "off";
          $this->nmgp_botoes['last']    = "off";
          $this->nmgp_botoes['navpage'] = "off";
          $this->nmgp_botoes['goto']    = "off";
          $this->nmgp_botoes['qtline']  = "off";
          $this->nmgp_botoes['summary'] = "on";
      }
      else
      {
      $this->nmgp_botoes['first'] = "on";
      $this->nmgp_botoes['back'] = "on";
      $this->nmgp_botoes['forward'] = "on";
      $this->nmgp_botoes['last'] = "on";
      $this->nmgp_botoes['summary'] = "on";
      $this->nmgp_botoes['navpage'] = "on";
      $this->nmgp_botoes['goto'] = "on";
      $this->nmgp_botoes['qtline'] = "on";
      $this->nmgp_botoes['reload'] = "off";
      }
      if (isset($this->NM_btn_cancel) && 'N' == $this->NM_btn_cancel)
      {
          $this->nmgp_botoes['cancel'] = "off";
      }
      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_orig'] = "";
      if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_pesq']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_pesq'] = "";
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_pesq_filtro'] = "";
      }
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_pesq_filtro'];
      if ($this->NM_ajax_flag && 'event_' == substr($this->NM_ajax_opcao, 0, 6)) {
          $this->nmgp_botoes = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['buttonStatus'];
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['iframe_filtro']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['iframe_filtro'] == "S")
      {
          $this->nmgp_botoes['exit'] = "off";
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['btn_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['btn_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['btn_display'] as $NM_cada_btn => $NM_cada_opc)
          {
              $this->nmgp_botoes[$NM_cada_btn] = $NM_cada_opc;
          }
      }

      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['insert']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['insert'] != '')
      {
          $this->nmgp_botoes['new']    = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['insert'];
          $this->nmgp_botoes['insert'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['insert'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['new']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['new'] != '')
      {
          $this->nmgp_botoes['new']    = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['new'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['update']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['update'] != '')
      {
          $this->nmgp_botoes['update'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['update'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['delete']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['delete'] != '')
      {
          $this->nmgp_botoes['delete'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['delete'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['first']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['first'] != '')
      {
          $this->nmgp_botoes['first'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['first'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['back']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['back'] != '')
      {
          $this->nmgp_botoes['back'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['back'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['forward']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['forward'] != '')
      {
          $this->nmgp_botoes['forward'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['forward'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['last']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['last'] != '')
      {
          $this->nmgp_botoes['last'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['last'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['qsearch']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['qsearch'] != '')
      {
          $this->nmgp_botoes['qsearch'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['qsearch'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['dynsearch']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['dynsearch'] != '')
      {
          $this->nmgp_botoes['dynsearch'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['dynsearch'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['summary']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['summary'] != '')
      {
          $this->nmgp_botoes['summary'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['summary'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['navpage']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['navpage'] != '')
      {
          $this->nmgp_botoes['navpage'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['navpage'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['goto']) && $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['goto'] != '')
      {
          $this->nmgp_botoes['goto'] = $_SESSION['scriptcase']['sc_apl_conf_lig']['form_asp_requisitos_admvo']['goto'];
      }

      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_insert']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_insert'] != '')
      {
          $this->nmgp_botoes['new']    = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_insert'];
          $this->nmgp_botoes['insert'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_insert'];
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_update']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_update'] != '')
      {
          $this->nmgp_botoes['update'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_update'];
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_delete']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_delete'] != '')
      {
          $this->nmgp_botoes['delete'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_delete'];
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_btn_nav']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_btn_nav'] != '')
      {
          $this->nmgp_botoes['first']   = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_btn_nav'];
          $this->nmgp_botoes['back']    = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_btn_nav'];
          $this->nmgp_botoes['forward'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_btn_nav'];
          $this->nmgp_botoes['last']    = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_btn_nav'];
      }

      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['under_dashboard'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['maximized']) {
          $tmpDashboardApp = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['dashboard_app'];
          if (isset($_SESSION['scriptcase']['dashboard_toolbar'][$tmpDashboardApp]['form_asp_requisitos_admvo'])) {
              $tmpDashboardButtons = $_SESSION['scriptcase']['dashboard_toolbar'][$tmpDashboardApp]['form_asp_requisitos_admvo'];

              $this->nmgp_botoes['update']     = $tmpDashboardButtons['form_update']    ? 'on' : 'off';
              $this->nmgp_botoes['new']        = $tmpDashboardButtons['form_insert']    ? 'on' : 'off';
              $this->nmgp_botoes['insert']     = $tmpDashboardButtons['form_insert']    ? 'on' : 'off';
              $this->nmgp_botoes['delete']     = $tmpDashboardButtons['form_delete']    ? 'on' : 'off';
              $this->nmgp_botoes['copy']       = $tmpDashboardButtons['form_copy']      ? 'on' : 'off';
              $this->nmgp_botoes['first']      = $tmpDashboardButtons['form_navigate']  ? 'on' : 'off';
              $this->nmgp_botoes['back']       = $tmpDashboardButtons['form_navigate']  ? 'on' : 'off';
              $this->nmgp_botoes['last']       = $tmpDashboardButtons['form_navigate']  ? 'on' : 'off';
              $this->nmgp_botoes['forward']    = $tmpDashboardButtons['form_navigate']  ? 'on' : 'off';
              $this->nmgp_botoes['navpage']    = $tmpDashboardButtons['form_navpage']   ? 'on' : 'off';
              $this->nmgp_botoes['goto']       = $tmpDashboardButtons['form_goto']      ? 'on' : 'off';
              $this->nmgp_botoes['qtline']     = $tmpDashboardButtons['form_lineqty']   ? 'on' : 'off';
              $this->nmgp_botoes['summary']    = $tmpDashboardButtons['form_summary']   ? 'on' : 'off';
              $this->nmgp_botoes['qsearch']    = $tmpDashboardButtons['form_qsearch']   ? 'on' : 'off';
              $this->nmgp_botoes['dynsearch']  = $tmpDashboardButtons['form_dynsearch'] ? 'on' : 'off';
              $this->nmgp_botoes['reload']     = $tmpDashboardButtons['form_reload']    ? 'on' : 'off';
          }
      }

      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['insert']) && $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['insert'] != '')
      {
          $this->nmgp_botoes['new']    = $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['insert'];
          $this->nmgp_botoes['insert'] = $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['insert'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['update']) && $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['update'] != '')
      {
          $this->nmgp_botoes['update'] = $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['update'];
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['delete']) && $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['delete'] != '')
      {
          $this->nmgp_botoes['delete'] = $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['delete'];
      }

      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['field_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['field_display'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->nmgp_cmp_hidden[$NM_cada_field . "_"] = $NM_cada_opc;
              $this->NM_ajax_info['fieldDisplay'][$NM_cada_field . "_"] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['field_readonly']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['field_readonly']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['field_readonly'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->nmgp_cmp_readonly[$NM_cada_field . "_"] = "on";
              $this->NM_ajax_info['readOnly'][$NM_cada_field . "_"] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['exit']) && $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['exit'] != '')
      {
          $_SESSION['scriptcase']['sc_url_saida'][$this->Ini->sc_page]       = $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['exit'];
          $_SESSION['scriptcase']['sc_force_url_saida'][$this->Ini->sc_page] = true;
      }
      $glo_senha_protect = (isset($_SESSION['scriptcase']['glo_senha_protect'])) ? $_SESSION['scriptcase']['glo_senha_protect'] : "S";
      $this->aba_iframe = false;
      if (isset($_SESSION['scriptcase']['sc_aba_iframe']))
      {
          foreach ($_SESSION['scriptcase']['sc_aba_iframe'] as $aba => $apls_aba)
          {
              if (in_array("form_asp_requisitos_admvo", $apls_aba))
              {
                  $this->aba_iframe = true;
                  break;
              }
          }
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['iframe_menu'] && (!isset($_SESSION['scriptcase']['menu_mobile']) || empty($_SESSION['scriptcase']['menu_mobile'])))
      {
          $this->aba_iframe = true;
      }
      $this->Ini->sc_Include($this->Ini->path_lib_php . "/nm_gp_limpa.php", "F", "nm_limpa_valor") ; 
      $this->Ini->sc_Include($this->Ini->path_libs . "/nm_gc.php", "F", "nm_gc") ; 
      $_SESSION['scriptcase']['sc_tab_meses']['int'] = array(
                                      $this->Ini->Nm_lang['lang_mnth_janu'],
                                      $this->Ini->Nm_lang['lang_mnth_febr'],
                                      $this->Ini->Nm_lang['lang_mnth_marc'],
                                      $this->Ini->Nm_lang['lang_mnth_apri'],
                                      $this->Ini->Nm_lang['lang_mnth_mayy'],
                                      $this->Ini->Nm_lang['lang_mnth_june'],
                                      $this->Ini->Nm_lang['lang_mnth_july'],
                                      $this->Ini->Nm_lang['lang_mnth_augu'],
                                      $this->Ini->Nm_lang['lang_mnth_sept'],
                                      $this->Ini->Nm_lang['lang_mnth_octo'],
                                      $this->Ini->Nm_lang['lang_mnth_nove'],
                                      $this->Ini->Nm_lang['lang_mnth_dece']);
      $_SESSION['scriptcase']['sc_tab_meses']['abr'] = array(
                                      $this->Ini->Nm_lang['lang_shrt_mnth_janu'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_febr'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_marc'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_apri'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_mayy'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_june'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_july'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_augu'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_sept'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_octo'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_nove'],
                                      $this->Ini->Nm_lang['lang_shrt_mnth_dece']);
      $_SESSION['scriptcase']['sc_tab_dias']['int'] = array(
                                      $this->Ini->Nm_lang['lang_days_sund'],
                                      $this->Ini->Nm_lang['lang_days_mond'],
                                      $this->Ini->Nm_lang['lang_days_tued'],
                                      $this->Ini->Nm_lang['lang_days_wend'],
                                      $this->Ini->Nm_lang['lang_days_thud'],
                                      $this->Ini->Nm_lang['lang_days_frid'],
                                      $this->Ini->Nm_lang['lang_days_satd']);
      $_SESSION['scriptcase']['sc_tab_dias']['abr'] = array(
                                      $this->Ini->Nm_lang['lang_shrt_days_sund'],
                                      $this->Ini->Nm_lang['lang_shrt_days_mond'],
                                      $this->Ini->Nm_lang['lang_shrt_days_tued'],
                                      $this->Ini->Nm_lang['lang_shrt_days_wend'],
                                      $this->Ini->Nm_lang['lang_shrt_days_thud'],
                                      $this->Ini->Nm_lang['lang_shrt_days_frid'],
                                      $this->Ini->Nm_lang['lang_shrt_days_satd']);
      nm_gc($this->Ini->path_libs);
      $this->Ini->Gd_missing  = true;
      if(function_exists("getProdVersion"))
      {
         $_SESSION['scriptcase']['sc_prod_Version'] = str_replace(".", "", getProdVersion($this->Ini->path_libs));
         if(function_exists("gd_info"))
         {
            $this->Ini->Gd_missing = false;
         }
      }
      $this->Ini->sc_Include($this->Ini->path_lib_php . "/nm_trata_img.php", "C", "nm_trata_img") ; 

      if (is_file($this->Ini->path_aplicacao . 'form_asp_requisitos_admvo_help.txt'))
      {
          $arr_link_webhelp = file($this->Ini->path_aplicacao . 'form_asp_requisitos_admvo_help.txt');
          if ($arr_link_webhelp)
          {
              foreach ($arr_link_webhelp as $str_link_webhelp)
              {
                  $str_link_webhelp = trim($str_link_webhelp);
                  if ('form:' == substr($str_link_webhelp, 0, 5))
                  {
                      $arr_link_parts = explode(':', $str_link_webhelp);
                      if ('' != $arr_link_parts[1] && is_file($this->Ini->root . $this->Ini->path_help . $arr_link_parts[1]))
                      {
                          $this->url_webhelp = $this->Ini->path_help . $arr_link_parts[1];
                      }
                  }
              }
          }
      }

      if (is_dir($this->Ini->path_aplicacao . 'img'))
      {
          $Res_dir_img = @opendir($this->Ini->path_aplicacao . 'img');
          if ($Res_dir_img)
          {
              while (FALSE !== ($Str_arquivo = @readdir($Res_dir_img))) 
              {
                 if (@is_file($this->Ini->path_aplicacao . 'img/' . $Str_arquivo) && '.' != $Str_arquivo && '..' != $this->Ini->path_aplicacao . 'img/' . $Str_arquivo)
                 {
                     @unlink($this->Ini->path_aplicacao . 'img/' . $Str_arquivo);
                 }
              }
          }
          @closedir($Res_dir_img);
          rmdir($this->Ini->path_aplicacao . 'img');
      }

      if ($this->Embutida_proc)
      { 
          require_once($this->Ini->path_embutida . 'form_asp_requisitos_admvo/form_asp_requisitos_admvo_erro.class.php');
      }
      else
      { 
          require_once($this->Ini->path_aplicacao . "form_asp_requisitos_admvo_erro.class.php"); 
      }
      $this->Erro      = new form_asp_requisitos_admvo_erro();
      $this->Erro->Ini = $this->Ini;
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_max_reg']) && strtolower($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_max_reg']) == "all")
      {
          $this->form_paginacao = "total";
      }
      $this->proc_fast_search = false;
      if ((!isset($nm_opc_lookup) || $nm_opc_lookup != "lookup") && (!isset($nm_opc_php) || $nm_opc_php != "formphp"))
      { 
         if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opcao']))
         { 
             if ($this->id_asp_req_ != "")   
             { 
                 $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opcao'] = "igual" ;  
             }   
         }   
      } 
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opcao']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opcao']) && empty($this->nmgp_refresh_fields))
      {
          $this->nmgp_opcao = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opcao'];  
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opcao'] = "" ;  
          if ($this->nmgp_opcao == "edit_novo")  
          {
             $this->nmgp_opcao = "novo";
             $this->nm_flag_saida_novo = "S";
          }
      } 
      $this->nm_Start_new = false;
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['start']) && $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['start'] == 'new')
      {
          $this->nmgp_opcao = "novo";
          $this->nm_Start_new = true;
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opcao'] = "novo";
          unset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['start']);
      }
      if ($this->nmgp_opcao == "igual")  
      {
          $this->nmgp_opc_ant = $this->nmgp_opcao;
      } 
      else
      {
          $this->nmgp_opc_ant = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opc_ant'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opc_ant'] : "";
      } 
      if ($this->nmgp_opcao == "recarga" || $this->nmgp_opcao == "muda_form")  
      {
          $this->nmgp_botoes = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['botoes'];
          $this->Nav_permite_ret = 0 != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['inicio'];
          $this->Nav_permite_ava = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'] != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['final'];
      }
      else
      {
      }
      $this->nm_flag_iframe = false;
      if ($this->nmgp_opcao == "edit_novo")  
      {
          $this->nmgp_opcao = "novo";
          $this->nm_flag_saida_novo = "S";
      }
//
      $this->NM_case_insensitive = false;
      $this->sc_evento = $this->nmgp_opcao;
      if (!isset($this->NM_ajax_flag) || ('validate_' != substr($this->NM_ajax_opcao, 0, 9) && 'add_new_line' != $this->NM_ajax_opcao && 'autocomp_' != substr($this->NM_ajax_opcao, 0, 9)))
      {
      $_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'on';
if (isset($this->NM_ajax_flag) && $this->NM_ajax_flag)
{
    $original_archivo_ = $this->archivo_;
}
if (!isset($this->sc_temp_cont_file)) {$this->sc_temp_cont_file = (isset($_SESSION['cont_file'])) ? $_SESSION['cont_file'] : "";}
if (!isset($this->sc_temp_generacion)) {$this->sc_temp_generacion = (isset($_SESSION['generacion'])) ? $_SESSION['generacion'] : "";}
  if (isset($_SESSION['scriptcase']['form_asp_requisitos_admvo']['visor_expediente_url'])) {
    unset($_SESSION['scriptcase']['form_asp_requisitos_admvo']['visor_expediente_url']);
}

$gen='SELECT generacion 
                   FROM sce.convocatorias_posg 
                   WHERE cc_activa=1 
                   AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))
                   LIMIT 1';
 
      $nm_select = $gen; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs0 = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->rs0[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs0 = false;
          $this->rs0_erro = $this->Db->ErrorMsg();
      } 

$generacion = $this->rs0[0][0];	
 if (isset($generacion)) {$this->sc_temp_generacion = $generacion;}
;

$cont_file=$this->archivo_ ;
 if (isset($cont_file)) {$this->sc_temp_cont_file = $cont_file;}
;
if (isset($this->sc_temp_generacion)) { $_SESSION['generacion'] = $this->sc_temp_generacion;}
if (isset($this->sc_temp_cont_file)) { $_SESSION['cont_file'] = $this->sc_temp_cont_file;}
if (isset($this->NM_ajax_flag) && $this->NM_ajax_flag)
{
    if (($original_archivo_ != $this->archivo_ || (isset($bFlagRead_archivo_) && $bFlagRead_archivo_))&& isset($this->nmgp_refresh_row))
    {
        $this->NM_ajax_info['fldList']['archivo_' . $this->nmgp_refresh_row]['type']    = 'text';
        $this->NM_ajax_info['fldList']['archivo_' . $this->nmgp_refresh_row]['valList'] = array($this->archivo_);
        $this->NM_ajax_changed['archivo_'] = true;
    }
}
$_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'off'; 
      }
            if ('ajax_check_file' == $this->nmgp_opcao ){
                 ob_start(); 
                 global $bol_api_prod; 
                 $bol_api_prod = true; 
                 if (isset($_SESSION['scriptcase']['form_asp_requisitos_admvo']['glo_nm_conexao']) && !empty($_SESSION['scriptcase']['form_asp_requisitos_admvo']['glo_nm_conexao'])) 
                 { 
                     $bol_api_prod = false;
                 } 
                 include_once("../_lib/lib/php/nm_api.php"); 
            switch( $_POST['rsargs'] ){
               default:
                   echo 0;exit;
               break;
               }

            $out1_img_cache = $_SESSION['scriptcase']['form_asp_requisitos_admvo']['glo_nm_path_imag_temp'] . $file_name;
            $orig_img = $_SESSION['scriptcase']['form_asp_requisitos_admvo']['glo_nm_path_imag_temp']. '/sc_'.md5(date('YmdHis').basename($_POST['AjaxCheckImg'])).'.gif';
            copy($__file_download, $_SERVER['DOCUMENT_ROOT'].$orig_img);
            echo $orig_img . '_@@NM@@_';            copy($__file_download, $_SERVER['DOCUMENT_ROOT'].$out1_img_cache);
            $sc_obj_img = new nm_trata_img($_SERVER['DOCUMENT_ROOT'].$out1_img_cache, true);

            if(!empty($img_width) && !empty($img_height)){
                $sc_obj_img->setWidth($img_width);
                $sc_obj_img->setHeight($img_height);
            }
                $sc_obj_img->setManterAspecto(true);
            $sc_obj_img->createImg($_SERVER['DOCUMENT_ROOT'].$out1_img_cache);
            echo $out1_img_cache;
               exit;
            }
      if (isset($nm_opc_lookup) && $nm_opc_lookup == "lookup")
      { 
          if ($GLOBALS['F'] == "num_req_")
          { 
              $nm_parms   = substr($GLOBALS['P0'], 1, strlen($GLOBALS['P0']) - 2);
              $array_vars = explode(",", $nm_parms);
              $this->num_req_ = $array_vars[0];
              $num_req_       = $this->num_req_;
              nm_limpa_numero($num_req_, $this->field_config['num_req_']['symbol_grp']); 
              $this->num_req_       = $num_req_;
              $this->lookup_num_req_($conteudo);
              $conteudo = str_replace("&", "&amp;", $conteudo); 
              $conteudo = str_replace("\/" , "\/", $conteudo); 
              echo "<!DOCTYPE html><html><head></head>";
              echo " <body onload=\"p=document.layers?parentLayer:window.parent;p.jsrsLoaded('" . $GLOBALS['C'] . "');\">";
              echo "  jsrsPayload:";
              echo "  <br>";
              echo "  <form name=\"jsrs_Form\"><textarea name=\"jsrs_Payload\">";
              echo "$conteudo";
              echo " </textarea></form></body></html>";
          } 
          $this->NM_close_db(); 
          exit;
      } 
   }

   function loadFieldConfig()
   {
      $this->field_config = array();
      //-- cc_correcto_
      $this->field_config['cc_correcto_']               = array();
      $this->field_config['cc_correcto_']['symbol_grp'] = $_SESSION['scriptcase']['reg_conf']['grup_num'];
      $this->field_config['cc_correcto_']['symbol_fmt'] = $_SESSION['scriptcase']['reg_conf']['num_group_digit'];
      $this->field_config['cc_correcto_']['symbol_dec'] = '';
      $this->field_config['cc_correcto_']['symbol_neg'] = $_SESSION['scriptcase']['reg_conf']['simb_neg'];
      $this->field_config['cc_correcto_']['format_neg'] = $_SESSION['scriptcase']['reg_conf']['neg_num'];
      //-- num_req_
      $this->field_config['num_req_']               = array();
      $this->field_config['num_req_']['symbol_grp'] = $_SESSION['scriptcase']['reg_conf']['grup_num'];
      $this->field_config['num_req_']['symbol_fmt'] = $_SESSION['scriptcase']['reg_conf']['num_group_digit'];
      $this->field_config['num_req_']['symbol_dec'] = '';
      $this->field_config['num_req_']['symbol_neg'] = $_SESSION['scriptcase']['reg_conf']['simb_neg'];
      $this->field_config['num_req_']['format_neg'] = $_SESSION['scriptcase']['reg_conf']['neg_num'];
      //-- id_asp_req_
      $this->field_config['id_asp_req_']               = array();
      $this->field_config['id_asp_req_']['symbol_grp'] = $_SESSION['scriptcase']['reg_conf']['grup_num'];
      $this->field_config['id_asp_req_']['symbol_fmt'] = $_SESSION['scriptcase']['reg_conf']['num_group_digit'];
      $this->field_config['id_asp_req_']['symbol_dec'] = '';
      $this->field_config['id_asp_req_']['symbol_neg'] = $_SESSION['scriptcase']['reg_conf']['simb_neg'];
      $this->field_config['id_asp_req_']['format_neg'] = $_SESSION['scriptcase']['reg_conf']['neg_num'];
      //-- id_asp_fk_
      $this->field_config['id_asp_fk_']               = array();
      $this->field_config['id_asp_fk_']['symbol_grp'] = $_SESSION['scriptcase']['reg_conf']['grup_num'];
      $this->field_config['id_asp_fk_']['symbol_fmt'] = $_SESSION['scriptcase']['reg_conf']['num_group_digit'];
      $this->field_config['id_asp_fk_']['symbol_dec'] = '';
      $this->field_config['id_asp_fk_']['symbol_neg'] = $_SESSION['scriptcase']['reg_conf']['simb_neg'];
      $this->field_config['id_asp_fk_']['format_neg'] = $_SESSION['scriptcase']['reg_conf']['neg_num'];
      //-- id_lisreq_fk_
      $this->field_config['id_lisreq_fk_']               = array();
      $this->field_config['id_lisreq_fk_']['symbol_grp'] = $_SESSION['scriptcase']['reg_conf']['grup_num'];
      $this->field_config['id_lisreq_fk_']['symbol_fmt'] = $_SESSION['scriptcase']['reg_conf']['num_group_digit'];
      $this->field_config['id_lisreq_fk_']['symbol_dec'] = '';
      $this->field_config['id_lisreq_fk_']['symbol_neg'] = $_SESSION['scriptcase']['reg_conf']['simb_neg'];
      $this->field_config['id_lisreq_fk_']['format_neg'] = $_SESSION['scriptcase']['reg_conf']['neg_num'];
      //-- cc_carta_
      $this->field_config['cc_carta_']               = array();
      $this->field_config['cc_carta_']['symbol_grp'] = $_SESSION['scriptcase']['reg_conf']['grup_num'];
      $this->field_config['cc_carta_']['symbol_fmt'] = $_SESSION['scriptcase']['reg_conf']['num_group_digit'];
      $this->field_config['cc_carta_']['symbol_dec'] = '';
      $this->field_config['cc_carta_']['symbol_neg'] = $_SESSION['scriptcase']['reg_conf']['simb_neg'];
      $this->field_config['cc_carta_']['format_neg'] = $_SESSION['scriptcase']['reg_conf']['neg_num'];
      //-- fecha_revision_
      $this->field_config['fecha_revision_']                 = array();
      $this->field_config['fecha_revision_']['date_format']  = $_SESSION['scriptcase']['reg_conf']['date_format'] . ';' . $_SESSION['scriptcase']['reg_conf']['time_format'];
      $this->field_config['fecha_revision_']['date_sep']     = $_SESSION['scriptcase']['reg_conf']['date_sep'];
      $this->field_config['fecha_revision_']['time_sep']     = $_SESSION['scriptcase']['reg_conf']['time_sep'];
      $this->field_config['fecha_revision_']['date_display'] = "ddmmaaaa;hhiiss";
      $this->new_date_format('DH', 'fecha_revision_');
      //-- notas_internas_
      $this->field_config['notas_internas_']                 = array();
      $this->field_config['notas_internas_']['date_format']  = $_SESSION['scriptcase']['reg_conf']['date_format'] . ';' . $_SESSION['scriptcase']['reg_conf']['time_format'];
      $this->field_config['notas_internas_']['date_sep']     = $_SESSION['scriptcase']['reg_conf']['date_sep'];
      $this->field_config['notas_internas_']['time_sep']     = $_SESSION['scriptcase']['reg_conf']['time_sep'];
      $this->field_config['notas_internas_']['date_display'] = "ddmmaaaa;hhiiss";
      $this->new_date_format('DH', 'notas_internas_');
      //-- id_carga_req_
      $this->field_config['id_carga_req_']               = array();
      $this->field_config['id_carga_req_']['symbol_grp'] = $_SESSION['scriptcase']['reg_conf']['grup_num'];
      $this->field_config['id_carga_req_']['symbol_fmt'] = $_SESSION['scriptcase']['reg_conf']['num_group_digit'];
      $this->field_config['id_carga_req_']['symbol_dec'] = '';
      $this->field_config['id_carga_req_']['symbol_neg'] = $_SESSION['scriptcase']['reg_conf']['simb_neg'];
      $this->field_config['id_carga_req_']['format_neg'] = $_SESSION['scriptcase']['reg_conf']['neg_num'];
      //-- fecha_alta_
      $this->field_config['fecha_alta_']                 = array();
      $this->field_config['fecha_alta_']['date_format']  = $_SESSION['scriptcase']['reg_conf']['date_format'] . ';' . $_SESSION['scriptcase']['reg_conf']['time_format'];
      $this->field_config['fecha_alta_']['date_sep']     = $_SESSION['scriptcase']['reg_conf']['date_sep'];
      $this->field_config['fecha_alta_']['time_sep']     = $_SESSION['scriptcase']['reg_conf']['time_sep'];
      $this->field_config['fecha_alta_']['date_display'] = "ddmmaaaa;hhiiss";
      $this->new_date_format('DH', 'fecha_alta_');
      //-- fecha_ult_act_
      $this->field_config['fecha_ult_act_']                 = array();
      $this->field_config['fecha_ult_act_']['date_format']  = $_SESSION['scriptcase']['reg_conf']['date_format'] . ';' . $_SESSION['scriptcase']['reg_conf']['time_format'];
      $this->field_config['fecha_ult_act_']['date_sep']     = $_SESSION['scriptcase']['reg_conf']['date_sep'];
      $this->field_config['fecha_ult_act_']['time_sep']     = $_SESSION['scriptcase']['reg_conf']['time_sep'];
      $this->field_config['fecha_ult_act_']['date_display'] = "ddmmaaaa;hhiiss";
      $this->new_date_format('DH', 'fecha_ult_act_');
   }

   function controle()
   {
        global $nm_url_saida, $teste_validade, 
               $GLOBALS, $Campos_Crit, $Campos_Falta, $Campos_Erros, $sc_seq_vert, $sc_check_incl, 
               $glo_senha_protect, $nm_apl_dependente, $nm_form_submit, $sc_check_excl, $nm_opc_form_php, $nm_call_php, $nm_opc_lookup;


      $this->ini_controle();
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['Gera_log_access'])
      {
          $this->NM_gera_log_insert("Scriptcase", "access");
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['Gera_log_access'] = false;
      }
      if ($this->nmgp_opcao == "change_qtd_line")
      {
          $this->NM_btn_navega = "N";
          if (strtolower($this->nmgp_max_line) == "all")
          {
              $this->nmgp_opcao = "inicio";
              $this->form_paginacao = "total";
          }
          else
          {
              $this->nmgp_opcao = "igual";
              $this->form_paginacao = "parcial";
          }
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_max_reg'] = $this->nmgp_max_line;
      }
      if ('' != $_SESSION['scriptcase']['change_regional_old'])
      {
          $_SESSION['scriptcase']['str_conf_reg'] = $_SESSION['scriptcase']['change_regional_old'];
          $this->Ini->regionalDefault($_SESSION['scriptcase']['str_conf_reg']);
          $this->loadFieldConfig();
          $this->nm_tira_formatacao();

          $_SESSION['scriptcase']['str_conf_reg'] = $_SESSION['scriptcase']['change_regional_new'];
          $this->Ini->regionalDefault($_SESSION['scriptcase']['str_conf_reg']);
          $this->loadFieldConfig();
          $guarda_formatado = $this->formatado;
          $this->nm_formatar_campos();
          $this->formatado = $guarda_formatado;

          $_SESSION['scriptcase']['change_regional_old'] = '';
          $_SESSION['scriptcase']['change_regional_new'] = '';
      }

      $Campos_Crit       = "";
      $Campos_erro       = "";
      $Campos_Falta      = array();
      $Campos_Erros      = array();
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          =  substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->Field_no_validate = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['Field_no_validate'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['Field_no_validate'] : array();
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opc_edit'] = true;  
      $this->SC_log_arr_vert = array();
      $sc_contr_vert = (isset($GLOBALS["sc_contr_vert"])) ? $GLOBALS["sc_contr_vert"] : "";
      $sc_seq_vert   = 1; 
      $sc_opc_salva  = $this->nmgp_opcao; 
      $sc_todas_Crit = "";
      $sc_check_excl = array(); 
      $sc_check_incl = array(); 
      if (isset($GLOBALS["sc_check_vert"]) && is_array($GLOBALS["sc_check_vert"])) 
      { 
          if ($this->nmgp_opcao == "incluir" || ($this->nmgp_opcao == "recarga" && $this->nmgp_opc_ant == "novo"))
          {
              $sc_check_incl = $GLOBALS["sc_check_vert"]; 
          }
          elseif ($this->nmgp_opcao == "alterar" || $this->nmgp_opcao == "excluir" || $this->nmgp_opcao == "recarga")
          {
              $sc_check_excl = $GLOBALS["sc_check_vert"]; 
          }
      } 
      elseif ($this->nmgp_opcao == 'incluir' && isset($_POST['upload_file_row']) && '' != $_POST['upload_file_row'])
      {
          $sc_check_incl = array($_POST['upload_file_row']);
      }
      if (empty($this->nmgp_opcao)) 
      { 
          $this->nmgp_opcao = "inicio";
      } 
      if ($this->NM_ajax_flag && 'add_new_line' == $this->NM_ajax_opcao)
      {
         $this->nmgp_opcao = "novo";
         $this->nm_select_banco();
         $this->nm_gera_html();
         $this->NM_ajax_info['newline'] = NM_utf8_urldecode($this->New_Line);
         $this->NM_close_db();
         form_asp_requisitos_admvo_pack_ajax_response();
         exit;
      }
      if ($this->NM_ajax_flag && 'backup_line' == $this->NM_ajax_opcao)
      {
         $this->nmgp_opcao = "igual";
         $this->nm_tira_formatacao();
         $this->nm_select_banco();
         $this->ajax_return_values();
         $this->NM_close_db();
         form_asp_requisitos_admvo_pack_ajax_response();
         exit;
      }
      if ($this->NM_ajax_flag && 'submit_form' == $this->NM_ajax_opcao)
      {
         if (isset($this->num_req_)) { $this->nm_limpa_alfa($this->num_req_); }
         if (isset($this->archivo_)) { $this->nm_limpa_alfa($this->archivo_); }
         if (isset($this->notas_aspirante_)) { $this->nm_limpa_alfa($this->notas_aspirante_); }
         if (isset($this->cc_correcto_)) { $this->nm_limpa_alfa($this->cc_correcto_); }
         if (isset($this->notas_revisor_)) { $this->nm_limpa_alfa($this->notas_revisor_); }
         if (isset($this->Sc_num_lin_alt) && $this->Sc_num_lin_alt > 0) 
         {
             $sc_seq_vert = $this->Sc_num_lin_alt;
         }
         if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert]))
         {
             $this->nmgp_dados_form = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert];
             $this->id_asp_req_ = $this->nmgp_dados_form['id_asp_req_']; 
             $this->id_asp_fk_ = $this->nmgp_dados_form['id_asp_fk_']; 
             $this->login_fk_ = $this->nmgp_dados_form['login_fk_']; 
             $this->id_lisreq_fk_ = $this->nmgp_dados_form['id_lisreq_fk_']; 
             if ($this->nmgp_opcao == "incluir"){$this->num_req_ = $this->nmgp_dados_form['num_req_'];} 
             $this->cc_carta_ = $this->nmgp_dados_form['cc_carta_']; 
             $this->prefijo_requisito_ = $this->nmgp_dados_form['prefijo_requisito_']; 
             $this->fecha_revision_ = $this->nmgp_dados_form['fecha_revision_']; 
             $this->notas_internas_ = $this->nmgp_dados_form['notas_internas_']; 
             $this->id_carga_req_ = $this->nmgp_dados_form['id_carga_req_']; 
             $this->usu_carga_req_ = $this->nmgp_dados_form['usu_carga_req_']; 
             $this->ip_revision_ = $this->nmgp_dados_form['ip_revision_']; 
             $this->login_insert_ = $this->nmgp_dados_form['login_insert_']; 
             $this->fecha_alta_ = $this->nmgp_dados_form['fecha_alta_']; 
             $this->ip_alta_ = $this->nmgp_dados_form['ip_alta_']; 
             $this->login_last_ = $this->nmgp_dados_form['login_last_']; 
             $this->fecha_ult_act_ = $this->nmgp_dados_form['fecha_ult_act_']; 
             $this->ip_last_ = $this->nmgp_dados_form['ip_last_']; 
         }
         if ($this->nmgp_opcao == "incluir") {
             $this->num_req_ = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert]['num_req_'];
      if ('' !== $this->num_req_ || (!empty($format_fields) && isset($format_fields['num_req_'])))
      {
          nmgp_Form_Num_Val($this->num_req_, $this->field_config['num_req_']['symbol_grp'], $this->field_config['num_req_']['symbol_dec'], "0", "S", $this->field_config['num_req_']['format_neg'], "", "", "-", $this->field_config['num_req_']['symbol_fmt']) ; 
      }
         }
         if ($this->nmgp_opcao == "alterar" || $this->nmgp_opcao == "excluir") {
             $this->num_req_ = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert]['num_req_'];
      if ('' !== $this->num_req_ || (!empty($format_fields) && isset($format_fields['num_req_'])))
      {
          nmgp_Form_Num_Val($this->num_req_, $this->field_config['num_req_']['symbol_grp'], $this->field_config['num_req_']['symbol_dec'], "0", "S", $this->field_config['num_req_']['format_neg'], "", "", "-", $this->field_config['num_req_']['symbol_fmt']) ; 
      }
         }
         $this->controle_form_vert();
         if ($Campos_Crit != "" || !empty($Campos_Falta) || $this->Campos_Mens_erro != "")
         {
             $this->NM_rollback_db();
              if ($this->NM_ajax_flag)
              {
                  if (!isset($this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo']) || !is_array($this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo']))
                  {
                      $this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo'] = array();
                  }
                  if ($Campos_Crit != "")
                  {
                      $this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo'][] = $Campos_Crit;
                  }
                  if (!empty($Campos_Falta))
                  {
                      $this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo'][] = $this->Formata_Campos_Falta($Campos_Falta);
                  }
                  if ($this->Campos_Mens_erro != "")
                  {
                      $this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo'][] = $this->Campos_Mens_erro;
                  }
                  $this->NM_gera_nav_page(); 
                  $this->NM_ajax_info['navPage'] = $this->SC_nav_page; 
              }
         }
         else
         {
             if ($this->SC_log_atv)
             {
                 $this->SC_log_arr_vert[] = $this->SC_log_arr;
                 $this->SC_log_atv = false;
             }
             $this->NM_commit_db();
         }
         if ($this->nmgp_opcao != "recarga" && $this->nmgp_opcao != "muda_form" && !$this->Apl_com_erro)
         {
             $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['recarga'] = $this->nmgp_opcao;
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_insert']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_insert'] == "ok")
          {
              if ($this->sc_teve_incl && empty($sc_todas_Crit))
              {
                  $this->NM_close_db(); 
                  $this->nmgp_redireciona(2); 
              }
          }
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_atualiz']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_atualiz'] == "ok")
          {
              if ($this->sc_teve_alt && empty($sc_todas_Crit))
              {
                  $this->NM_close_db(); 
                  $this->nmgp_redireciona(2); 
              }
              if ($this->sc_teve_excl && empty($sc_todas_Crit))
              {
                  $this->NM_close_db(); 
                  $this->nmgp_redireciona(2); 
              }
          }
         }
         $this->NM_close_db();
                if ('alterar' == $this->NM_ajax_info['param']['nmgp_opcao'] && 'ERROR' != $this->NM_ajax_info['result']) {
                        $this->NM_ajax_info['msgDisplay'] = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_ajax_frmu']);
                }
                if ('incluir' == $this->NM_ajax_info['param']['nmgp_opcao'] && 'ERROR' != $this->NM_ajax_info['result']) {
                        $this->NM_ajax_info['msgDisplay'] = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_ajax_frmi']);
                }
                if ('excluir' == $this->NM_ajax_info['param']['nmgp_opcao'] && 'ERROR' != $this->NM_ajax_info['result']) {
                        $this->NM_ajax_info['msgDisplay'] = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_ajax_frmd']);
                }         form_asp_requisitos_admvo_pack_ajax_response();
         exit;
      }
      if ($this->NM_ajax_flag && 'validate_' == substr($this->NM_ajax_opcao, 0, 9))
      {
         $Campos_Crit  = "";
         $Campos_Falta = array();
         $Campos_Erros = array();
          if ('validate_cc_correcto_' == $this->NM_ajax_opcao)
          {
              $this->Valida_campos($Campos_Crit, $Campos_Falta, $Campos_Erros, 'cc_correcto_');
          }
          if ('validate_notas_revisor_' == $this->NM_ajax_opcao)
          {
              $this->Valida_campos($Campos_Crit, $Campos_Falta, $Campos_Erros, 'notas_revisor_');
          }
          if ('validate_num_req_' == $this->NM_ajax_opcao)
          {
              $this->Valida_campos($Campos_Crit, $Campos_Falta, $Campos_Erros, 'num_req_');
          }
          if ('validate_archivo_' == $this->NM_ajax_opcao)
          {
              $this->Valida_campos($Campos_Crit, $Campos_Falta, $Campos_Erros, 'archivo_');
          }
          if ('validate_notas_aspirante_' == $this->NM_ajax_opcao)
          {
              $this->Valida_campos($Campos_Crit, $Campos_Falta, $Campos_Erros, 'notas_aspirante_');
          }
          form_asp_requisitos_admvo_pack_ajax_response();
          exit;
      }
      while ($sc_contr_vert > $sc_seq_vert) 
      { 
         $Campos_Crit  = "";
         $Campos_Falta = array();
         $Campos_Erros = array();
         if ($this->nmgp_opcao == "recarga" && !isset($GLOBALS["num_req_" . $sc_seq_vert]))
         { 
             $GLOBALS["num_req_" . $sc_seq_vert] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['num_req_'];
         } 
         $this->cc_correcto_ = $GLOBALS["cc_correcto_" . $sc_seq_vert]; 
         $this->notas_revisor_ = $GLOBALS["notas_revisor_" . $sc_seq_vert]; 
         $this->num_req_ = $GLOBALS["num_req_" . $sc_seq_vert]; 
         $this->archivo_ = $GLOBALS["archivo_" . $sc_seq_vert]; 
         $this->notas_aspirante_ = $GLOBALS["notas_aspirante_" . $sc_seq_vert]; 
         if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert]))
         {
             $this->nmgp_dados_form = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert];
             $this->id_asp_req_ = $this->nmgp_dados_form['id_asp_req_']; 
             $this->id_asp_fk_ = $this->nmgp_dados_form['id_asp_fk_']; 
             $this->login_fk_ = $this->nmgp_dados_form['login_fk_']; 
             $this->id_lisreq_fk_ = $this->nmgp_dados_form['id_lisreq_fk_']; 
             if ($this->nmgp_opcao == "incluir"){$this->num_req_ = $this->nmgp_dados_form['num_req_'];} 
             $this->cc_carta_ = $this->nmgp_dados_form['cc_carta_']; 
             $this->prefijo_requisito_ = $this->nmgp_dados_form['prefijo_requisito_']; 
             $this->fecha_revision_ = $this->nmgp_dados_form['fecha_revision_']; 
             $this->notas_internas_ = $this->nmgp_dados_form['notas_internas_']; 
             $this->id_carga_req_ = $this->nmgp_dados_form['id_carga_req_']; 
             $this->usu_carga_req_ = $this->nmgp_dados_form['usu_carga_req_']; 
             $this->ip_revision_ = $this->nmgp_dados_form['ip_revision_']; 
             $this->login_insert_ = $this->nmgp_dados_form['login_insert_']; 
             $this->fecha_alta_ = $this->nmgp_dados_form['fecha_alta_']; 
             $this->ip_alta_ = $this->nmgp_dados_form['ip_alta_']; 
             $this->login_last_ = $this->nmgp_dados_form['login_last_']; 
             $this->fecha_ult_act_ = $this->nmgp_dados_form['fecha_ult_act_']; 
             $this->ip_last_ = $this->nmgp_dados_form['ip_last_']; 
         }
         if (isset($this->num_req_)) { $this->nm_limpa_alfa($this->num_req_); }
         if (isset($this->archivo_)) { $this->nm_limpa_alfa($this->archivo_); }
         if (isset($this->notas_aspirante_)) { $this->nm_limpa_alfa($this->notas_aspirante_); }
         if (isset($this->cc_correcto_)) { $this->nm_limpa_alfa($this->cc_correcto_); }
         if (isset($this->notas_revisor_)) { $this->nm_limpa_alfa($this->notas_revisor_); }
         if ($this->nmgp_opcao == "incluir") {
             $this->num_req_ = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert]['num_req_'];
      if ('' !== $this->num_req_ || (!empty($format_fields) && isset($format_fields['num_req_'])))
      {
          nmgp_Form_Num_Val($this->num_req_, $this->field_config['num_req_']['symbol_grp'], $this->field_config['num_req_']['symbol_dec'], "0", "S", $this->field_config['num_req_']['format_neg'], "", "", "-", $this->field_config['num_req_']['symbol_fmt']) ; 
      }
         }
         if ($this->nmgp_opcao == "alterar" || $this->nmgp_opcao == "excluir") {
             $this->num_req_ = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert]['num_req_'];
      if ('' !== $this->num_req_ || (!empty($format_fields) && isset($format_fields['num_req_'])))
      {
          nmgp_Form_Num_Val($this->num_req_, $this->field_config['num_req_']['symbol_grp'], $this->field_config['num_req_']['symbol_dec'], "0", "S", $this->field_config['num_req_']['format_neg'], "", "", "-", $this->field_config['num_req_']['symbol_fmt']) ; 
      }
         }
         if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'])) 
         {
            $this->nmgp_dados_form = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert];
         }
         if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'])) 
         {
            $this->nmgp_dados_select = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert];
         }
         if ($this->nmgp_opcao != "recarga" && in_array($sc_seq_vert, $sc_check_excl))
         {
             $this->nmgp_opcao = "excluir";
         }
         if ($this->nmgp_opcao == "incluir" && !in_array($sc_seq_vert, $sc_check_incl))
         { }
         else
         {
             if ($this->nmgp_opcao != "incluir" && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['num_req_']) && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_disabled'][$sc_seq_vert]['num_req_']))
             { 
                 $this->num_req_ = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['num_req_'];
      if ('' !== $this->num_req_ || (!empty($format_fields) && isset($format_fields['num_req_'])))
      {
          nmgp_Form_Num_Val($this->num_req_, $this->field_config['num_req_']['symbol_grp'], $this->field_config['num_req_']['symbol_dec'], "0", "S", $this->field_config['num_req_']['format_neg'], "", "", "-", $this->field_config['num_req_']['symbol_fmt']) ; 
      }
             } 
             $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_disabled'] = array();
             $this->controle_form_vert(); 
             $this->nmgp_opcao = $sc_opc_salva; 
             if ($this->nmgp_opcao != "recarga"  && $this->nmgp_opcao != "muda_form" && ($Campos_Crit != "" || !empty($Campos_Falta) || $this->Campos_Mens_erro != ""))
             {
                 $sc_todas_Crit .= (!empty($sc_todas_Crit)) ? "<br>" : ""; 
                 $sc_todas_Crit .= "<B>" . $this->Ini->Nm_lang['lang_errm_line'] . $sc_seq_vert . "</B>: "; 
                 $sc_todas_Crit .= $this->Formata_Erros($Campos_Crit, $Campos_Falta, $Campos_Erros);
                 $this->Campos_Mens_erro = ""; 
             }
             elseif ($this->SC_log_atv)
             {
                 $this->SC_log_arr_vert[] = $this->SC_log_arr;
                 $this->SC_log_atv = false;
             }
             if ($this->nmgp_opcao != "recarga") 
             {
                $this->nm_guardar_campos();
                $this->nm_formatar_campos();
             }
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['cc_correcto_'] =  $this->cc_correcto_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_revisor_'] =  $this->notas_revisor_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['num_req_'] =  $this->num_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['archivo_'] =  $this->archivo_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_aspirante_'] =  $this->notas_aspirante_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_asp_req_'] =  $this->id_asp_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_asp_fk_'] =  $this->id_asp_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_fk_'] =  $this->login_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_lisreq_fk_'] =  $this->id_lisreq_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['cc_carta_'] =  $this->cc_carta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['prefijo_requisito_'] =  $this->prefijo_requisito_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_revision_'] =  $this->fecha_revision_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_revision__hora'] =  $this->fecha_revision__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_internas_'] =  $this->notas_internas_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_internas__hora'] =  $this->notas_internas__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_carga_req_'] =  $this->id_carga_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['usu_carga_req_'] =  $this->usu_carga_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_revision_'] =  $this->ip_revision_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_insert_'] =  $this->login_insert_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_alta_'] =  $this->fecha_alta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_alta__hora'] =  $this->fecha_alta__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_alta_'] =  $this->ip_alta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_last_'] =  $this->login_last_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_ult_act_'] =  $this->fecha_ult_act_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_ult_act__hora'] =  $this->fecha_ult_act__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_last_'] =  $this->ip_last_; 
         }
         $sc_seq_vert++; 
      } 
      $Save_option = $this->nmgp_opcao; 
      if (!empty($sc_todas_Crit)) 
      { 
          $this->Erro->mensagem(__FILE__, __LINE__, "critica", $sc_todas_Crit); 
          if ($this->nmgp_opcao == "incluir")
          { 
              $this->nmgp_opcao = "novo"; 
          }
      } 
      elseif ($this->nmgp_opcao == "incluir")
      { 
          $this->nmgp_opcao = "novo"; 
      }
      if ($this->nmgp_opcao == 'incluir' && isset($_POST['upload_file_row']) && '' != $_POST['upload_file_row'])
      {
          $this->nmgp_opcao = 'igual';
      }
      if ($this->nmgp_opcao != "recarga" && $this->nmgp_opcao != "muda_form") 
      { 
          if ($this->sc_teve_incl) 
          { 
              $this->sc_after_all_insert = true;
          }
          if ($this->sc_teve_alt) 
          { 
              $this->sc_after_all_update = true;
          }
          if ($this->sc_teve_excl) 
          { 
              $this->sc_after_all_delete = true;
          }
          if (empty($sc_todas_Crit)) 
          { 
              $this->NM_commit_db(); 
              $this->nm_select_banco();
              $sc_check_excl = array(); 
          } 
          else
          { 
              $this->NM_rollback_db(); 
          } 
      } 
      if ($this->nmgp_opcao == "recarga") 
      { 
          $this->NM_gera_nav_page(); 
      } 
      if ($this->NM_ajax_flag && ('navigate_form' == $this->NM_ajax_opcao || !empty($this->nmgp_refresh_fields)))
      {
          $this->ajax_return_values();
          $this->ajax_add_parameters();
          $this->NM_close_db();
          form_asp_requisitos_admvo_pack_ajax_response();
          exit;
      }
      if ($this->NM_ajax_flag && 'table_refresh' == $this->NM_ajax_opcao)
      {
          $this->nm_gera_html();
          $this->NM_ajax_info['tableRefresh'] = NM_charset_to_utf8($this->Table_refresh . $this->New_Line) . '</table>';
          $this->NM_ajax_info['navStatus']['ret'] = $this->Nav_permite_ret ? 'S' : 'N';
          $this->NM_ajax_info['navStatus']['ava'] = $this->Nav_permite_ava ? 'S' : 'N';
          $this->NM_ajax_info['rsSize'] = sizeof($this->form_vert_form_asp_requisitos_admvo);
          $this->NM_ajax_info['fldList']['id_asp_req_']['keyVal'] = sc_htmlentities($this->nmgp_dados_form['id_asp_req_']);
          $this->NM_close_db();
          form_asp_requisitos_admvo_pack_ajax_response();
          exit;
      }
      if ($this->nmgp_opcao != "recarga" && $this->nmgp_opcao != "muda_form" && !$this->Apl_com_erro)
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['recarga'] = $this->nmgp_opcao;
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_insert']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_insert'] == "ok")
          {
              if ($this->sc_teve_incl && empty($sc_todas_Crit))
              {
                  $this->NM_close_db(); 
                  $this->nmgp_redireciona(2); 
              }
          }
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_atualiz']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_atualiz'] == "ok")
          {
              if ($this->sc_teve_alt && empty($sc_todas_Crit))
              {
                  $this->NM_close_db(); 
                  $this->nmgp_redireciona(2); 
              }
              if ($this->sc_teve_excl && empty($sc_todas_Crit))
              {
                  $this->NM_close_db(); 
                  $this->nmgp_redireciona(2); 
              }
          }
      }
      $this->nm_todas_criticas = $sc_todas_Crit;
      $this->nm_gera_html();
      $this->NM_close_db(); 
      if ($this->Change_Menu)
      {
          $apl_menu  = $_SESSION['scriptcase']['menu_atual'];
          $Arr_rastro = array();
          if (isset($_SESSION['scriptcase']['menu_apls'][$apl_menu][$this->sc_init_menu]) && count($_SESSION['scriptcase']['menu_apls'][$apl_menu][$this->sc_init_menu]) > 1)
          {
              foreach ($_SESSION['scriptcase']['menu_apls'][$apl_menu][$this->sc_init_menu] as $menu => $apls)
              {
                 $Arr_rastro[] = "'<a href=\"" . $apls['link'] . "?script_case_init=" . $this->sc_init_menu . "\" target=\"#NMIframe#\">" . $apls['label'] . "</a>'";
              }
              $ult_apl = count($Arr_rastro) - 1;
              unset($Arr_rastro[$ult_apl]);
              $rastro = implode(",", $Arr_rastro);
?>
  <script type="text/javascript">
     link_atual = new Array (<?php echo $rastro ?>);
     if (parent.writeFastMenu)
     {
         parent.writeFastMenu(link_atual);
     }
  </script>
<?php
          }
          else
          {
?>
  <script type="text/javascript">
     if (parent.clearFastMenu)
     {
        parent.clearFastMenu();
     }
  </script>
<?php
          }
      }
   }
   function controle_form_vert()
   {
     global $nm_opc_lookup,$Campos_Crit, $Campos_Falta, $Campos_Erros, 
            $glo_senha_protect, $nm_apl_dependente, $nm_form_submit;

//
//-----> 
//
      if (isset($this->sc_inline_call) && 'Y' == $this->sc_inline_call)
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['inline_form_seq'] = $this->sc_seq_row;
          $this->nm_tira_formatacao();
      }
      if ($this->nmgp_opcao == "recarga" || $this->nmgp_opcao == "recarga_mobile" || $this->nmgp_opcao == "muda_form") 
      {
          if (isset($this->num_req_))
          { 
              $SV_num_req_ = $this->num_req_;
          } 
          $this->nm_tira_formatacao();
          if (isset($SV_num_req_) && $this->nmgp_opcao != "recarga")
          { 
              $this->num_req_ = $SV_num_req_;
          } 
          $nm_sc_sv_opcao = $this->nmgp_opcao; 
          $this->nmgp_opcao = "nada"; 
          $this->nm_acessa_banco();
          if ($this->NM_ajax_flag)
          {
              $this->ajax_return_values();
              form_asp_requisitos_admvo_pack_ajax_response();
              exit;
          }
          $this->nm_formatar_campos();
          $this->nmgp_opcao = $nm_sc_sv_opcao; 
          return; 
      }
      if ($this->nmgp_opcao == "incluir" || $this->nmgp_opcao == "alterar" || $this->nmgp_opcao == "excluir") 
      {
          $this->Valida_campos($Campos_Crit, $Campos_Falta, $Campos_Erros) ; 
          $_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'off';
          if ($Campos_Crit != "") 
          {
              $Campos_Crit = $this->Ini->Nm_lang['lang_errm_flds'] . ' ' . $Campos_Crit ; 
          }
          if ($Campos_Crit != "" || !empty($Campos_Falta) || $this->Campos_Mens_erro != "")
          {
              $this->nmgp_opc_ant = $this->nmgp_opcao ; 
              if ($this->nmgp_opcao == "incluir" && $nm_apl_dependente == 1) 
              { 
                  $this->nm_flag_saida_novo = "S";; 
              }
              if ($this->nmgp_opcao == "incluir") 
              { 
                  $GLOBALS["erro_incl"] = 1; 
              }
              $this->nmgp_opcao = "nada" ; 
          }
      }
      elseif (isset($nm_form_submit) && 1 == $nm_form_submit && $this->nmgp_opcao != "menu_link" && $this->nmgp_opcao != "recarga_mobile")
      {
      }
//
      if ($this->nmgp_opcao != "nada")
      {
          $this->nm_acessa_banco();
      }
      else
      {
           if ($this->nmgp_opc_ant == "incluir") 
           { 
               $this->nm_proc_onload(false);
           }
           else
           { 
              $this->nm_guardar_campos();
           }
      }
   }
  function html_export_print($nm_arquivo_html, $nmgp_password)
  {
      $Html_password = "";
          $Arq_base  = $this->Ini->root . $this->Ini->path_imag_temp . $nm_arquivo_html;
          $Parm_pass = ($Html_password != "") ? " -p" : "";
          $Zip_name = "sc_prt_" . date("YmdHis") . "_" . rand(0, 1000) . "form_asp_requisitos_admvo.zip";
          $Arq_htm = $this->Ini->path_imag_temp . "/" . $Zip_name;
          $Arq_zip = $this->Ini->root . $Arq_htm;
          $Zip_f     = (FALSE !== strpos($Arq_zip, ' ')) ? " \"" . $Arq_zip . "\"" :  $Arq_zip;
          $Arq_input = (FALSE !== strpos($Arq_base, ' ')) ? " \"" . $Arq_base . "\"" :  $Arq_base;
           if (is_file($Arq_zip)) {
               unlink($Arq_zip);
           }
           $str_zip = "";
           if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
           {
               chdir($this->Ini->path_third . "/zip/windows");
               $str_zip = "zip.exe " . strtoupper($Parm_pass) . " -j " . $Html_password . " " . $Zip_f . " " . $Arq_input;
           }
           elseif (FALSE !== strpos(strtolower(php_uname()), 'linux')) 
           {
                if (FALSE !== strpos(strtolower(php_uname()), 'i686')) 
                {
                    chdir($this->Ini->path_third . "/zip/linux-i386/bin");
                }
                else
                {
                    chdir($this->Ini->path_third . "/zip/linux-amd64/bin");
                }
               $str_zip = "./7za " . $Parm_pass . $Html_password . " a " . $Zip_f . " " . $Arq_input;
           }
           elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
           {
               chdir($this->Ini->path_third . "/zip/mac/bin");
               $str_zip = "./7za " . $Parm_pass . $Html_password . " a " . $Zip_f . " " . $Arq_input;
           }
           if (!empty($str_zip)) {
               exec($str_zip);
           }
           // ----- ZIP log
           $fp = @fopen(trim(str_replace(array(".zip",'"'), array(".log",""), $Zip_f)), 'w');
           if ($fp)
           {
               @fwrite($fp, $str_zip . "\r\n\r\n");
               @fclose($fp);
           }
           foreach ($this->Ini->Img_export_zip as $cada_img_zip)
           {
               $str_zip      = "";
              $cada_img_zip = '"' . $cada_img_zip . '"';
               if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
               {
                   $str_zip = "zip.exe " . strtoupper($Parm_pass) . " -j -u " . $Html_password . " " . $Zip_f . " " . $cada_img_zip;
               }
               elseif (FALSE !== strpos(strtolower(php_uname()), 'linux')) 
               {
                   $str_zip = "./7za " . $Parm_pass . $Html_password . " a " . $Zip_f . " " . $cada_img_zip;
               }
               elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
               {
                   $str_zip = "./7za " . $Parm_pass . $Html_password . " a " . $Zip_f . " " . $cada_img_zip;
               }
               if (!empty($str_zip)) {
                   exec($str_zip);
               }
               // ----- ZIP log
               $fp = @fopen(trim(str_replace(array(".zip",'"'), array(".log",""), $Zip_f)), 'a');
               if ($fp)
               {
                   @fwrite($fp, $str_zip . "\r\n\r\n");
                   @fclose($fp);
               }
           }
           if (is_file($Arq_zip)) {
               unlink($Arq_base);
           } 
          $path_doc_md5 = md5($Arq_htm);
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo'][$path_doc_md5][0] = $Arq_htm;
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo'][$path_doc_md5][1] = $Zip_name;
?><!DOCTYPE html>
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo strip_tags("" . $this->Ini->Nm_lang['lang_othr_frmu_title'] . " " . $this->Ini->Nm_lang['lang_tbl_asp_requisitos'] . "") ?></TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
 <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
 <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
 <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
 <META http-equiv="Pragma" content="no-cache"/>
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $this->Ini->Str_btn_form . '/' . $this->Ini->Str_btn_form ?>.css" /> 
  <link rel="stylesheet" type="text/css" href="<?php echo $this->Ini->path_prod; ?>/third/font-awesome/6/css/all.min.css" /> 
  <link rel="shortcut icon" href="../_lib/img/grp__NM__ico__NM__grp__NM__ico__NM__favicon_posgrado.ico">
</HEAD>
<BODY class="scExportPage">
<table style="border-collapse: collapse; border-width: 0; height: 100%; width: 100%"><tr><td style="padding: 0; text-align: center; vertical-align: top">
 <table class="scExportTable" align="center">
  <tr>
   <td class="scExportTitle" style="height: 25px">PRINT</td>
  </tr>
  <tr>
   <td class="scExportLine" style="width: 100%">
    <table style="border-collapse: collapse; border-width: 0; width: 100%"><tr><td class="scExportLineFont" style="padding: 3px 0 0 0" id="idMessage">
    <?php echo $this->Ini->Nm_lang['lang_othr_file_msge'] ?>
    </td><td class="scExportLineFont" style="text-align:right; padding: 3px 0 0 0">
   <?php echo nmButtonOutput($this->arr_buttons, "bexportview", "document.Fview.submit()", "document.Fview.submit()", "idBtnView", "", "", "", "absmiddle", "", "0", $this->Ini->path_botoes, "", "", "", "", "", '', '', '', '', '', '', '', '', "");?>

   <?php echo nmButtonOutput($this->arr_buttons, "bdownload", "document.Fdown.submit()", "document.Fdown.submit()", "idBtnDown", "", "", "", "absmiddle", "", "0", $this->Ini->path_botoes, "", "", "", "", "", '', '', '', '', '', '', '', '', "");?>

   <?php echo nmButtonOutput($this->arr_buttons, "bvoltar", "document.F0.submit()", "document.F0.submit()", "idBtnBack", "", "", "", "absmiddle", "", "0", $this->Ini->path_botoes, "", "", "", "", "", '', '', '', '', '', '', '', '', "");?>

    </td></tr></table>
   </td>
  </tr>
 </table>
</td></tr></table>
<form name="Fview" method="get" action="<?php echo  $this->form_encode_input($Arq_htm) ?>" target="_self" style="display: none"> 
</form>
<form name="Fdown" method="get" action="form_asp_requisitos_admvo_download.php" target="_self" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo $this->form_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nm_tit_doc" value="form_asp_requisitos_admvo"> 
<input type="hidden" name="nm_name_doc" value="<?php echo $path_doc_md5 ?>"> 
</form>
<form name="F0" method=post action="./" target="_self" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo $this->form_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nmgp_opcao" value="<?php echo $this->nmgp_opcao ?>"> 
</form> 
         </BODY>
         </HTML>
<?php
          exit;
  }
//
//--------------------------------------------------------------------------------------
   function NM_has_trans()
   {
       return !in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access);
   }
//
//--------------------------------------------------------------------------------------
   function NM_commit_db()
   {
       if ($this->Ini->sc_tem_trans_banco && !$this->Embutida_proc)
       { 
           $this->Db->CommitTrans(); 
           $this->Ini->sc_tem_trans_banco = false;
       } 
       foreach ($this->SC_log_arr_vert as $this->SC_log_arr)
       {
           $this->NM_gera_log_output();
       }
   }
//
//--------------------------------------------------------------------------------------
   function NM_rollback_db()
   {
       if ($this->Ini->sc_tem_trans_banco && !$this->Embutida_proc)
       { 
           $this->Db->RollbackTrans(); 
           $this->Ini->sc_tem_trans_banco = false;
       } 
   }
//
//--------------------------------------------------------------------------------------
   function NM_gera_log_insert($orig="Scriptcase", $evento="", $texto="")
   {
       $delim  = "'";
       $delim1 = "'";
       if (in_array(strtolower($_SESSION['scriptcase']['glo_tpbanco']), $this->Ini->nm_bases_access))
       { 
           $delim  = "#";
           $delim1 = "#";
       } 
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['SC_sep_date']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['SC_sep_date']))
       {
           $delim  = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['SC_sep_date'];
           $delim1 = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['SC_sep_date1'];
       }
       $dt  = $delim . date('Y-m-d H:i:s') . $delim1;
       $usr = isset($_SESSION['usr_login']) ? $_SESSION['usr_login'] : "";
       if (strtolower($_SESSION['scriptcase']['glo_tpbanco']) == 'pdo_sqlsrv' || strtolower($_SESSION['scriptcase']['glo_tpbanco']) == 'pdo_dblib')
       { 
           $dt  = $delim . date('Ymd H:i:s') . $delim1;
       } 
       if (in_array(strtolower($_SESSION['scriptcase']['glo_tpbanco']), $this->Ini->nm_bases_access))
       { 
           $dt  = $delim . date('Y-m-d H:i:s') . $delim1;
       } 
       if (in_array(strtolower($_SESSION['scriptcase']['glo_tpbanco']), $this->Ini->nm_bases_informix))
       { 
           $dt  = "EXTEND(" . $dt . ", YEAR TO FRACTION)";
       } 
       if (in_array(strtolower($_SESSION['scriptcase']['glo_tpbanco']), $this->Ini->nm_bases_access))
       { 
           $comando = "INSERT INTO sc_log (inserted_date, username, application, creator, ip_user, `action`, description) VALUES ($dt, " . $this->Db->qstr($usr) . ", 'form_asp_requisitos_admvo', '$orig', '" . $_SERVER['REMOTE_ADDR'] . "', '$evento', " . $this->Db->qstr($texto) . ")"; 
       } 
       elseif (in_array(strtolower($_SESSION['scriptcase']['glo_tpbanco']), $this->Ini->nm_bases_sqlite))
       { 
           $comando = "INSERT INTO sc_log (id, inserted_date, username, application, creator, ip_user, action, description) VALUES (NULL, $dt, " . $this->Db->qstr($usr) . ", 'form_asp_requisitos_admvo', '$orig', '" . $_SERVER['REMOTE_ADDR'] . "', '$evento', " . $this->Db->qstr($texto) . ")"; 
       } 
       else
       { 
           $comando = "INSERT INTO sc_log (inserted_date, username, application, creator, ip_user, action, description) VALUES ($dt, " . $this->Db->qstr($usr) . ", 'form_asp_requisitos_admvo', '$orig', '" . $_SERVER['REMOTE_ADDR'] . "', '$evento', " . $this->Db->qstr($texto) . ")"; 
       } 
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $comando; 
       $rlog = $this->Db->Execute($comando); 
       if ($rlog === false)  
       { 
           $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_inst'], $this->Db->ErrorMsg()); 
           if ($this->NM_ajax_flag)
           {
               form_asp_requisitos_admvo_pack_ajax_response();
               exit; 
           }
       }
   }
//
//--------------------------------------------------------------------------------------
   function NM_close_db()
   {
       if ($this->Db && !$this->Embutida_proc)
       { 
           $this->Db->Close(); 
           $this->Ini->nm_db_conn_sce_desde_asp_temp->Close(); 
       } 
   }
//
//--------------------------------------------------------------------------------------
   function lookup_num_req_(&$conteudo)
   {
      global  $num_req_;
      $guarda_formatado = $this->formatado;
      $this->nm_tira_formatacao();
      if (in_array(strtolower($this->Ini->nm_con_conn_sce_desde_asp_temp['tpbanco']), $this->Ini->nm_bases_ibase))
      { 
          $GLOBALS["NM_ERRO_IBASE"] = 1;  
      } 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      {
          $nm_comando = "SELECT ' - ' + leyenda  FROM convocatorias_posg INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK WHERE cc_activa=1    AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))   AND list_req_gral.num_requisito= $this->num_req_";
      }
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      {
          $nm_comando = "SELECT concat(' - ', leyenda)  FROM convocatorias_posg INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK WHERE cc_activa=1    AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))   AND list_req_gral.num_requisito= $this->num_req_";
      }
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
      {
          $nm_comando = "SELECT ' - '&leyenda  FROM convocatorias_posg INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK WHERE cc_activa=1    AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))   AND list_req_gral.num_requisito= $this->num_req_";
      }
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres))
      {
          $nm_comando = "SELECT ' - '||leyenda  FROM convocatorias_posg INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK WHERE cc_activa=1    AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))   AND list_req_gral.num_requisito= $this->num_req_";
      }
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      {
          $nm_comando = "SELECT ' - ' + leyenda  FROM convocatorias_posg INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK WHERE cc_activa=1    AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))   AND list_req_gral.num_requisito= $this->num_req_";
      }
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_db2))
      {
          $nm_comando = "SELECT ' - '||leyenda  FROM convocatorias_posg INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK WHERE cc_activa=1    AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))   AND list_req_gral.num_requisito= $this->num_req_";
      }
      else
      {
          $nm_comando = "SELECT ' - '||leyenda  FROM convocatorias_posg INNER JOIN sce.list_req_gral ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK WHERE cc_activa=1    AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))   AND list_req_gral.num_requisito= $this->num_req_";
      }
      if ($this->num_req_ == "")
      { 
          $conteudo = ""; 
          $this->nm_formatar_campos();
          return; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rs = $this->Ini->nm_db_conn_sce_desde_asp_temp->Execute($nm_comando)) 
      {
          $conteudo = (isset($rs->fields[0])) ? $rs->fields[0] : ""; 
          $rs->Close() ; 
      } 
      elseif ($GLOBALS["NM_ERRO_IBASE"] != 1)  
      {  
          $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Ini->nm_db_conn_sce_desde_asp_temp->ErrorMsg()); 
          exit; 
      } 
      $GLOBALS["NM_ERRO_IBASE"] = 0; 
      foreach ($this->Before_unformat as $Cmp => $Val)
      {
          $this->$Cmp = $Val;
          $this->formatado = $guarda_formatado;
      }
   }
//
//--------------------------------------------------------------------------------------
   function Formata_Erros($Campos_Crit, $Campos_Falta, $Campos_Erros, $mode = 3) 
   {
       switch ($mode)
       {
           case 1:
               $campos_erro = array();
               if (!empty($Campos_Crit))
               {
                   $campos_erro[] = $Campos_Crit;
               }
               if (!empty($Campos_Falta))
               {
                   $campos_erro[] = $this->Formata_Campos_Falta($Campos_Falta);
               }
               if (!empty($this->Campos_Mens_erro))
               {
                   $campos_erro[] = $this->Campos_Mens_erro;
               }
               return implode('<br />', $campos_erro);
               break;

           case 2:
               $campos_erro = array();
               if (!empty($Campos_Crit))
               {
                   $campos_erro[] = $Campos_Crit;
               }
               if (!empty($Campos_Falta))
               {
                   $campos_erro[] = $this->Formata_Campos_Falta($Campos_Falta, true);
               }
               if (!empty($this->Campos_Mens_erro))
               {
                   $campos_erro[] = $this->Campos_Mens_erro;
               }
               return implode('<br />', $campos_erro);
               break;

           case 3:
               $campos_erro = array();
               if (!empty($Campos_Erros))
               {
                   $campos_erro[] = $this->Formata_Campos_Erros($Campos_Erros);
               }
               if (!empty($this->Campos_Mens_erro))
               {
                   $campos_mens_erro = str_replace(array('<br />', '<br>', '<BR />'), array('<BR>', '<BR>', '<BR>'), $this->Campos_Mens_erro);
                   $campos_mens_erro = explode('<BR>', $campos_mens_erro);
                   foreach ($campos_mens_erro as $msg_erro)
                   {
                       if ('' != $msg_erro && !in_array($msg_erro, $campos_erro))
                       {
                           $campos_erro[] = $msg_erro;
                       }
                   }
               }
               return implode('<br />', $campos_erro);
               break;

           case 4:
               $campos_erro = array();
               if (!empty($Campos_Erros))
               {
                   $campos_erro[] = $this->Formata_Campos_Erros_SweetAlert($Campos_Erros);
               }
               if (!empty($this->Campos_Mens_erro))
               {
                   $campos_mens_erro = str_replace(array('<br />', '<br>', '<BR />'), array('<BR>', '<BR>', '<BR>'), $this->Campos_Mens_erro);
                   $campos_mens_erro = explode('<BR>', $campos_mens_erro);
                   foreach ($campos_mens_erro as $msg_erro)
                   {
                       if ('' != $msg_erro && !in_array($msg_erro, $campos_erro))
                       {
                           $campos_erro[] = $msg_erro;
                       }
                   }
               }
               return implode('<br />', $campos_erro);
               break;
       }
   }

   function Formata_Campos_Falta($Campos_Falta, $table = false) 
   {
       $Campos_Falta = array_unique($Campos_Falta);

       if (!$table)
       {
           return $this->Ini->Nm_lang['lang_errm_reqd'] . ' ' . implode('; ', $Campos_Falta);
       }

       $aCols  = array();
       $iTotal = sizeof($Campos_Falta);
       $iCols  = 6 > $iTotal ? 1 : (11 > $iTotal ? 2 : (16 > $iTotal ? 3 : 4));
       $iItems = ceil($iTotal / $iCols);
       $iNowC  = 0;
       $iNowI  = 0;

       foreach ($Campos_Falta as $campo)
       {
           $aCols[$iNowC][] = $campo;
           if ($iItems == ++$iNowI)
           {
               $iNowC++;
               $iNowI = 0;
           }
       }

       $sError  = '<table style="border-collapse: collapse; border-width: 0px">';
       $sError .= '<tr>';
       $sError .= '<td class="scFormErrorMessageFont" style="padding: 0; vertical-align: top; white-space: nowrap">' . $this->Ini->Nm_lang['lang_errm_reqd'] . '</td>';
       foreach ($aCols as $aCol)
       {
           $sError .= '<td class="scFormErrorMessageFont" style="padding: 0 6px; vertical-align: top; white-space: nowrap">' . implode('<br />', $aCol) . '</td>';
       }
       $sError .= '</tr>';
       $sError .= '</table>';

       return $sError;
   }

   function Formata_Campos_Crit($Campos_Crit, $table = false) 
   {
       $Campos_Crit = array_unique($Campos_Crit);

       if (!$table)
       {
           return $this->Ini->Nm_lang['lang_errm_flds'] . ' ' . implode('; ', $Campos_Crit);
       }

       $aCols  = array();
       $iTotal = sizeof($Campos_Crit);
       $iCols  = 6 > $iTotal ? 1 : (11 > $iTotal ? 2 : (16 > $iTotal ? 3 : 4));
       $iItems = ceil($iTotal / $iCols);
       $iNowC  = 0;
       $iNowI  = 0;

       foreach ($Campos_Crit as $campo)
       {
           $aCols[$iNowC][] = $campo;
           if ($iItems == ++$iNowI)
           {
               $iNowC++;
               $iNowI = 0;
           }
       }

       $sError  = '<table style="border-collapse: collapse; border-width: 0px">';
       $sError .= '<tr>';
       $sError .= '<td class="scFormErrorMessageFont" style="padding: 0; vertical-align: top; white-space: nowrap">' . $this->Ini->Nm_lang['lang_errm_flds'] . '</td>';
       foreach ($aCols as $aCol)
       {
           $sError .= '<td class="scFormErrorMessageFont" style="padding: 0 6px; vertical-align: top; white-space: nowrap">' . implode('<br />', $aCol) . '</td>';
       }
       $sError .= '</tr>';
       $sError .= '</table>';

       return $sError;
   }

   function Formata_Campos_Erros($Campos_Erros) 
   {
       $sError  = '<table style="border-collapse: collapse; border-width: 0px">';

       foreach ($Campos_Erros as $campo => $erros)
       {
           $sError .= '<tr>';
           $sError .= '<td class="scFormErrorMessageFont" style="padding: 0; vertical-align: top; white-space: nowrap">' . $this->Recupera_Nome_Campo($campo) . ':</td>';
           $sError .= '<td class="scFormErrorMessageFont" style="padding: 0 6px; vertical-align: top; white-space: nowrap">' . implode('<br />', array_unique($erros)) . '</td>';
           $sError .= '</tr>';
       }

       $sError .= '</table>';

       return $sError;
   }

   function Formata_Campos_Erros_SweetAlert($Campos_Erros) 
   {
       $sError  = '';

       foreach ($Campos_Erros as $campo => $erros)
       {
           $sError .= $this->Recupera_Nome_Campo($campo) . ': ' . implode('<br />', array_unique($erros)) . '<br />';
       }

       return $sError;
   }

   function Recupera_Nome_Campo($campo) 
   {
       switch($campo)
       {
           case 'cc_correcto_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_cc_correcto'] . "";
               break;
           case 'notas_revisor_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_notas_revisor'] . "";
               break;
           case 'num_req_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_num_req'] . "";
               break;
           case 'archivo_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_archivo'] . "";
               break;
           case 'notas_aspirante_':
               return "Notas del aspirante";
               break;
           case 'id_asp_req_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_id_asp_req'] . "";
               break;
           case 'id_asp_fk_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_id_asp_FK'] . "";
               break;
           case 'login_fk_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_login_FK'] . "";
               break;
           case 'id_lisreq_fk_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_id_lisreq_FK'] . "";
               break;
           case 'cc_carta_':
               return "Cc Carta";
               break;
           case 'prefijo_requisito_':
               return "Prefijo Requisito";
               break;
           case 'fecha_revision_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_fecha_revision'] . "";
               break;
           case 'notas_internas_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_notas_internas'] . "";
               break;
           case 'id_carga_req_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_id_carga_req'] . "";
               break;
           case 'usu_carga_req_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_usu_carga_req'] . "";
               break;
           case 'ip_revision_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_ip_revision'] . "";
               break;
           case 'login_insert_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_login_insert'] . "";
               break;
           case 'fecha_alta_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_fecha_alta'] . "";
               break;
           case 'ip_alta_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_ip_alta'] . "";
               break;
           case 'login_last_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_login_last'] . "";
               break;
           case 'fecha_ult_act_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_fecha_ult_act'] . "";
               break;
           case 'ip_last_':
               return "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_ip_last'] . "";
               break;
       }

       return $campo;
   }

   function dateDefaultFormat()
   {
       if (isset($this->Ini->Nm_conf_reg[$this->Ini->str_conf_reg]['data_format']))
       {
           $sDate = str_replace('yyyy', 'Y', $this->Ini->Nm_conf_reg[$this->Ini->str_conf_reg]['data_format']);
           $sDate = str_replace('mm',   'm', $sDate);
           $sDate = str_replace('dd',   'd', $sDate);
           return substr(chunk_split($sDate, 1, $this->Ini->Nm_conf_reg[$this->Ini->str_conf_reg]['data_sep']), 0, -1);
       }
       elseif ('en_us' == $this->Ini->str_lang)
       {
           return 'm/d/Y';
       }
       else
       {
           return 'd/m/Y';
       }
   } // dateDefaultFormat

//
//--------------------------------------------------------------------------------------
   function Valida_campos(&$Campos_Crit, &$Campos_Falta, &$Campos_Erros, $filtro = '') 
   {
     global $nm_browser, $teste_validade;
     if (is_array($filtro) && empty($filtro)) {
         $filtro = '';
     }
//---------------------------------------------------------
     $this->sc_force_zero = array();

     if (!is_array($filtro) && '' == $filtro && isset($this->nm_form_submit) && '1' == $this->nm_form_submit && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['csrf_token']) && $this->scCsrfGetToken() != $this->csrf_token)
     {
          $this->Campos_Mens_erro .= (empty($this->Campos_Mens_erro)) ? "" : "<br />";
          $this->Campos_Mens_erro .= "CSRF: " . $this->Ini->Nm_lang['lang_errm_ajax_csrf'];
          if ($this->NM_ajax_flag)
          {
              if (!isset($this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo']) || !is_array($this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo']))
              {
                  $this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo'] = array();
              }
              $this->NM_ajax_info['errList']['geral_form_asp_requisitos_admvo'][] = "CSRF: " . $this->Ini->Nm_lang['lang_errm_ajax_csrf'];
          }
     }
      if ((!is_array($filtro) && ('' == $filtro || 'cc_correcto_' == $filtro)) || (is_array($filtro) && in_array('cc_correcto_', $filtro)))
        $this->ValidateField_cc_correcto_($Campos_Crit, $Campos_Falta, $Campos_Erros);
      if ((!is_array($filtro) && ('' == $filtro || 'notas_revisor_' == $filtro)) || (is_array($filtro) && in_array('notas_revisor_', $filtro)))
        $this->ValidateField_notas_revisor_($Campos_Crit, $Campos_Falta, $Campos_Erros);
      if ((!is_array($filtro) && ('' == $filtro || 'num_req_' == $filtro)) || (is_array($filtro) && in_array('num_req_', $filtro)))
        $this->ValidateField_num_req_($Campos_Crit, $Campos_Falta, $Campos_Erros);
      if ((!is_array($filtro) && ('' == $filtro || 'archivo_' == $filtro)) || (is_array($filtro) && in_array('archivo_', $filtro)))
        $this->ValidateField_archivo_($Campos_Crit, $Campos_Falta, $Campos_Erros);
      if ((!is_array($filtro) && ('' == $filtro || 'notas_aspirante_' == $filtro)) || (is_array($filtro) && in_array('notas_aspirante_', $filtro)))
        $this->ValidateField_notas_aspirante_($Campos_Crit, $Campos_Falta, $Campos_Erros);
      if (!empty($Campos_Crit) || !empty($Campos_Falta) || !empty($this->Campos_Mens_erro))
      {
          if (!empty($this->sc_force_zero))
          {
              foreach ($this->sc_force_zero as $i_force_zero => $sc_force_zero_field)
              {
                  eval('$this->' . $sc_force_zero_field . ' = "";');
                  unset($this->sc_force_zero[$i_force_zero]);
              }
          }
      }
   }

    function ValidateField_cc_correcto_(&$Campos_Crit, &$Campos_Falta, &$Campos_Erros)
    {
        global $teste_validade;
        $hasError = false;
      if (isset($this->Field_no_validate['cc_correcto_'])) {
          nm_limpa_numero($this->cc_correcto_, $this->field_config['cc_correcto_']['symbol_grp']) ; 
          return;
      }
      if ($this->cc_correcto_ === "" || is_null($this->cc_correcto_))  
      { 
          $this->cc_correcto_ = 0;
          $this->sc_force_zero[] = 'cc_correcto_';
      } 
      nm_limpa_numero($this->cc_correcto_, $this->field_config['cc_correcto_']['symbol_grp']) ; 
      if ($this->nmgp_opcao != "excluir") 
      { 
          if ($this->cc_correcto_ != '')  
          { 
              $iTestSize = 11;
              if (strlen($this->cc_correcto_) > $iTestSize)  
              { 
                  $hasError = true;
                  $Campos_Crit .= "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_cc_correcto'] . ": " . $this->Ini->Nm_lang['lang_errm_size']; 
                  if (!isset($Campos_Erros['cc_correcto_']))
                  {
                      $Campos_Erros['cc_correcto_'] = array();
                  }
                  $Campos_Erros['cc_correcto_'][] = $this->Ini->Nm_lang['lang_errm_size'];
                  if (!isset($this->NM_ajax_info['errList']['cc_correcto_']) || !is_array($this->NM_ajax_info['errList']['cc_correcto_']))
                  {
                      $this->NM_ajax_info['errList']['cc_correcto_'] = array();
                  }
                  $this->NM_ajax_info['errList']['cc_correcto_'][] = $this->Ini->Nm_lang['lang_errm_size'];
              } 
              if ($teste_validade->Valor($this->cc_correcto_, 11, 0, 0, 0, "N") == false)  
              { 
                  $hasError = true;
                  $Campos_Crit .= "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_cc_correcto'] . "; " ; 
                  if (!isset($Campos_Erros['cc_correcto_']))
                  {
                      $Campos_Erros['cc_correcto_'] = array();
                  }
                  $Campos_Erros['cc_correcto_'][] = "" . $this->Ini->Nm_lang['lang_errm_ajax_data'] . "";
                  if (!isset($this->NM_ajax_info['errList']['cc_correcto_']) || !is_array($this->NM_ajax_info['errList']['cc_correcto_']))
                  {
                      $this->NM_ajax_info['errList']['cc_correcto_'] = array();
                  }
                  $this->NM_ajax_info['errList']['cc_correcto_'][] = "" . $this->Ini->Nm_lang['lang_errm_ajax_data'] . "";
              } 
          } 
      } 
        if ($hasError) {
            global $sc_seq_vert;
            $fieldName = 'cc_correcto_';
            if (isset($sc_seq_vert) && '' != $sc_seq_vert) {
                $fieldName .= $sc_seq_vert;
            }
            $this->NM_ajax_info['fieldsWithErrors'][] = $fieldName;
        }
    } // ValidateField_cc_correcto_

    function ValidateField_notas_revisor_(&$Campos_Crit, &$Campos_Falta, &$Campos_Erros)
    {
        global $teste_validade;
        $hasError = false;
      if (isset($this->Field_no_validate['notas_revisor_'])) {
          return;
      }
      if ($this->nmgp_opcao != "excluir") 
      { 
          if (NM_utf8_strlen($this->notas_revisor_) > 255) 
          { 
              $hasError = true;
              $Campos_Crit .= "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_notas_revisor'] . " " . $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr']; 
              if (!isset($Campos_Erros['notas_revisor_']))
              {
                  $Campos_Erros['notas_revisor_'] = array();
              }
              $Campos_Erros['notas_revisor_'][] = $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr'];
              if (!isset($this->NM_ajax_info['errList']['notas_revisor_']) || !is_array($this->NM_ajax_info['errList']['notas_revisor_']))
              {
                  $this->NM_ajax_info['errList']['notas_revisor_'] = array();
              }
              $this->NM_ajax_info['errList']['notas_revisor_'][] = $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr'];
          } 
      } 
        if ($hasError) {
            global $sc_seq_vert;
            $fieldName = 'notas_revisor_';
            if (isset($sc_seq_vert) && '' != $sc_seq_vert) {
                $fieldName .= $sc_seq_vert;
            }
            $this->NM_ajax_info['fieldsWithErrors'][] = $fieldName;
        }
    } // ValidateField_notas_revisor_

    function ValidateField_num_req_(&$Campos_Crit, &$Campos_Falta, &$Campos_Erros)
    {
        global $teste_validade;
        $hasError = false;
      if (isset($this->Field_no_validate['num_req_'])) {
          nm_limpa_numero($this->num_req_, $this->field_config['num_req_']['symbol_grp']) ; 
          return;
      }
      if ($this->num_req_ === "" || is_null($this->num_req_))  
      { 
          $this->num_req_ = 0;
          $this->sc_force_zero[] = 'num_req_';
      } 
      nm_limpa_numero($this->num_req_, $this->field_config['num_req_']['symbol_grp']) ; 
      if ($this->nmgp_opcao != "excluir") 
      { 
          if ($this->num_req_ != '')  
          { 
              $iTestSize = 2;
              if (strlen($this->num_req_) > $iTestSize)  
              { 
                  $hasError = true;
                  $Campos_Crit .= "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_num_req'] . ": " . $this->Ini->Nm_lang['lang_errm_size']; 
                  if (!isset($Campos_Erros['num_req_']))
                  {
                      $Campos_Erros['num_req_'] = array();
                  }
                  $Campos_Erros['num_req_'][] = $this->Ini->Nm_lang['lang_errm_size'];
                  if (!isset($this->NM_ajax_info['errList']['num_req_']) || !is_array($this->NM_ajax_info['errList']['num_req_']))
                  {
                      $this->NM_ajax_info['errList']['num_req_'] = array();
                  }
                  $this->NM_ajax_info['errList']['num_req_'][] = $this->Ini->Nm_lang['lang_errm_size'];
              } 
              if ($teste_validade->Valor($this->num_req_, 2, 0, 0, 0, "N") == false)  
              { 
                  $hasError = true;
                  $Campos_Crit .= "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_num_req'] . "; " ; 
                  if (!isset($Campos_Erros['num_req_']))
                  {
                      $Campos_Erros['num_req_'] = array();
                  }
                  $Campos_Erros['num_req_'][] = "" . $this->Ini->Nm_lang['lang_errm_ajax_data'] . "";
                  if (!isset($this->NM_ajax_info['errList']['num_req_']) || !is_array($this->NM_ajax_info['errList']['num_req_']))
                  {
                      $this->NM_ajax_info['errList']['num_req_'] = array();
                  }
                  $this->NM_ajax_info['errList']['num_req_'][] = "" . $this->Ini->Nm_lang['lang_errm_ajax_data'] . "";
              } 
          } 
      } 
        if ($hasError) {
            global $sc_seq_vert;
            $fieldName = 'num_req_';
            if (isset($sc_seq_vert) && '' != $sc_seq_vert) {
                $fieldName .= $sc_seq_vert;
            }
            $this->NM_ajax_info['fieldsWithErrors'][] = $fieldName;
        }
    } // ValidateField_num_req_

    function ValidateField_archivo_(&$Campos_Crit, &$Campos_Falta, &$Campos_Erros)
    {
        global $teste_validade;
        $hasError = false;
      if (isset($this->Field_no_validate['archivo_'])) {
          return;
      }
      if ($this->nmgp_opcao != "excluir") 
      { 
          if (NM_utf8_strlen($this->archivo_) > 255) 
          { 
              $hasError = true;
              $Campos_Crit .= "" . $this->Ini->Nm_lang['lang_asp_requisitos_fld_archivo'] . " " . $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr']; 
              if (!isset($Campos_Erros['archivo_']))
              {
                  $Campos_Erros['archivo_'] = array();
              }
              $Campos_Erros['archivo_'][] = $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr'];
              if (!isset($this->NM_ajax_info['errList']['archivo_']) || !is_array($this->NM_ajax_info['errList']['archivo_']))
              {
                  $this->NM_ajax_info['errList']['archivo_'] = array();
              }
              $this->NM_ajax_info['errList']['archivo_'][] = $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr'];
          } 
      } 
        if ($hasError) {
            global $sc_seq_vert;
            $fieldName = 'archivo_';
            if (isset($sc_seq_vert) && '' != $sc_seq_vert) {
                $fieldName .= $sc_seq_vert;
            }
            $this->NM_ajax_info['fieldsWithErrors'][] = $fieldName;
        }
    } // ValidateField_archivo_

    function ValidateField_notas_aspirante_(&$Campos_Crit, &$Campos_Falta, &$Campos_Erros)
    {
        global $teste_validade;
        $hasError = false;
      if (isset($this->Field_no_validate['notas_aspirante_'])) {
          return;
      }
      if ($this->nmgp_opcao != "excluir") 
      { 
          if (NM_utf8_strlen($this->notas_aspirante_) > 255) 
          { 
              $hasError = true;
              $Campos_Crit .= "Notas del aspirante " . $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr']; 
              if (!isset($Campos_Erros['notas_aspirante_']))
              {
                  $Campos_Erros['notas_aspirante_'] = array();
              }
              $Campos_Erros['notas_aspirante_'][] = $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr'];
              if (!isset($this->NM_ajax_info['errList']['notas_aspirante_']) || !is_array($this->NM_ajax_info['errList']['notas_aspirante_']))
              {
                  $this->NM_ajax_info['errList']['notas_aspirante_'] = array();
              }
              $this->NM_ajax_info['errList']['notas_aspirante_'][] = $this->Ini->Nm_lang['lang_errm_mxch'] . " 255 " . $this->Ini->Nm_lang['lang_errm_nchr'];
          } 
      } 
        if ($hasError) {
            global $sc_seq_vert;
            $fieldName = 'notas_aspirante_';
            if (isset($sc_seq_vert) && '' != $sc_seq_vert) {
                $fieldName .= $sc_seq_vert;
            }
            $this->NM_ajax_info['fieldsWithErrors'][] = $fieldName;
        }
    } // ValidateField_notas_aspirante_

    function removeDuplicateDttmError($aErrDate, &$aErrTime)
    {
        if (empty($aErrDate) || empty($aErrTime))
        {
            return;
        }

        foreach ($aErrDate as $sErrDate)
        {
            foreach ($aErrTime as $iErrTime => $sErrTime)
            {
                if ($sErrDate == $sErrTime)
                {
                    unset($aErrTime[$iErrTime]);
                }
            }
        }
    } // removeDuplicateDttmError

   function nm_guardar_campos()
   {
    global
           $sc_seq_vert;
    $this->nmgp_dados_form['cc_correcto_'] = $this->cc_correcto_;
    $this->nmgp_dados_form['notas_revisor_'] = $this->notas_revisor_;
    $this->nmgp_dados_form['num_req_'] = $this->num_req_;
    $this->nmgp_dados_form['archivo_'] = $this->archivo_;
    $this->nmgp_dados_form['notas_aspirante_'] = $this->notas_aspirante_;
    $this->nmgp_dados_form['id_asp_req_'] = $this->id_asp_req_;
    $this->nmgp_dados_form['id_asp_fk_'] = $this->id_asp_fk_;
    $this->nmgp_dados_form['login_fk_'] = $this->login_fk_;
    $this->nmgp_dados_form['id_lisreq_fk_'] = $this->id_lisreq_fk_;
    $this->nmgp_dados_form['cc_carta_'] = $this->cc_carta_;
    $this->nmgp_dados_form['prefijo_requisito_'] = $this->prefijo_requisito_;
    $this->nmgp_dados_form['fecha_revision_'] = $this->fecha_revision_;
    $this->nmgp_dados_form['notas_internas_'] = $this->notas_internas_;
    $this->nmgp_dados_form['id_carga_req_'] = $this->id_carga_req_;
    $this->nmgp_dados_form['usu_carga_req_'] = $this->usu_carga_req_;
    $this->nmgp_dados_form['ip_revision_'] = $this->ip_revision_;
    $this->nmgp_dados_form['login_insert_'] = $this->login_insert_;
    $this->nmgp_dados_form['fecha_alta_'] = $this->fecha_alta_;
    $this->nmgp_dados_form['ip_alta_'] = $this->ip_alta_;
    $this->nmgp_dados_form['login_last_'] = $this->login_last_;
    $this->nmgp_dados_form['fecha_ult_act_'] = $this->fecha_ult_act_;
    $this->nmgp_dados_form['ip_last_'] = $this->ip_last_;
    $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_form'][$sc_seq_vert] = $this->nmgp_dados_form;
   }
   function nm_tira_formatacao()
   {
      global $nm_form_submit;
         $this->Before_unformat = array();
         $this->formatado = false;
      $this->Before_unformat['cc_correcto_'] = $this->cc_correcto_;
      nm_limpa_numero($this->cc_correcto_, $this->field_config['cc_correcto_']['symbol_grp']) ; 
      $this->Before_unformat['num_req_'] = $this->num_req_;
      nm_limpa_numero($this->num_req_, $this->field_config['num_req_']['symbol_grp']) ; 
      $this->Before_unformat['id_asp_req_'] = $this->id_asp_req_;
      nm_limpa_numero($this->id_asp_req_, $this->field_config['id_asp_req_']['symbol_grp']) ; 
      $this->Before_unformat['id_asp_fk_'] = $this->id_asp_fk_;
      nm_limpa_numero($this->id_asp_fk_, $this->field_config['id_asp_fk_']['symbol_grp']) ; 
      $this->Before_unformat['id_lisreq_fk_'] = $this->id_lisreq_fk_;
      nm_limpa_numero($this->id_lisreq_fk_, $this->field_config['id_lisreq_fk_']['symbol_grp']) ; 
      $this->Before_unformat['cc_carta_'] = $this->cc_carta_;
      nm_limpa_numero($this->cc_carta_, $this->field_config['cc_carta_']['symbol_grp']) ; 
      $this->Before_unformat['fecha_revision_'] = $this->fecha_revision_;
      $this->Before_unformat['fecha_revision__hora'] = $this->fecha_revision__hora;
      nm_limpa_data($this->fecha_revision_, $this->field_config['fecha_revision_']['date_sep']) ; 
      nm_limpa_hora($this->fecha_revision__hora, $this->field_config['fecha_revision_']['time_sep']) ; 
      $this->Before_unformat['notas_internas_'] = $this->notas_internas_;
      $this->Before_unformat['notas_internas__hora'] = $this->notas_internas__hora;
      nm_limpa_data($this->notas_internas_, $this->field_config['notas_internas_']['date_sep']) ; 
      nm_limpa_hora($this->notas_internas__hora, $this->field_config['notas_internas_']['time_sep']) ; 
      $this->Before_unformat['id_carga_req_'] = $this->id_carga_req_;
      nm_limpa_numero($this->id_carga_req_, $this->field_config['id_carga_req_']['symbol_grp']) ; 
      $this->Before_unformat['fecha_alta_'] = $this->fecha_alta_;
      $this->Before_unformat['fecha_alta__hora'] = $this->fecha_alta__hora;
      nm_limpa_data($this->fecha_alta_, $this->field_config['fecha_alta_']['date_sep']) ; 
      nm_limpa_hora($this->fecha_alta__hora, $this->field_config['fecha_alta_']['time_sep']) ; 
      $this->Before_unformat['fecha_ult_act_'] = $this->fecha_ult_act_;
      $this->Before_unformat['fecha_ult_act__hora'] = $this->fecha_ult_act__hora;
      nm_limpa_data($this->fecha_ult_act_, $this->field_config['fecha_ult_act_']['date_sep']) ; 
      nm_limpa_hora($this->fecha_ult_act__hora, $this->field_config['fecha_ult_act_']['time_sep']) ; 
   }
   function sc_add_currency(&$value, $symbol, $pos)
   {
       if ('' == $value)
       {
           return;
       }
       $value = (1 == $pos || 3 == $pos) ? $symbol . ' ' . $value : $value . ' ' . $symbol;
   }
   function sc_remove_currency(&$value, $symbol_dec, $symbol_tho, $symbol_mon)
   {
       $value = preg_replace('~&#x0*([0-9a-f]+);~i', '', $value);
       $sNew  = str_replace($symbol_mon, '', $value);
       if ($sNew != $value)
       {
           $value = str_replace(' ', '', $sNew);
           return;
       }
       $aTest = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', $symbol_dec, $symbol_tho);
       $sNew  = '';
       for ($i = 0; $i < strlen($value); $i++)
       {
           if ($this->sc_test_currency_char($value[$i], $aTest))
           {
               $sNew .= $value[$i];
           }
       }
       $value = $sNew;
   }
   function sc_test_currency_char($char, $test)
   {
       $found = false;
       foreach ($test as $test_char)
       {
           if ($char === $test_char)
           {
               $found = true;
           }
       }
       return $found;
   }
   function nm_clear_val($Nome_Campo)
   {
      if ($Nome_Campo == "cc_correcto_")
      {
          nm_limpa_numero($this->cc_correcto_, $this->field_config['cc_correcto_']['symbol_grp']) ; 
      }
      if ($Nome_Campo == "num_req_")
      {
          nm_limpa_numero($this->num_req_, $this->field_config['num_req_']['symbol_grp']) ; 
      }
      if ($Nome_Campo == "id_asp_req_")
      {
          nm_limpa_numero($this->id_asp_req_, $this->field_config['id_asp_req_']['symbol_grp']) ; 
      }
      if ($Nome_Campo == "id_asp_fk_")
      {
          nm_limpa_numero($this->id_asp_fk_, $this->field_config['id_asp_fk_']['symbol_grp']) ; 
      }
      if ($Nome_Campo == "id_lisreq_fk_")
      {
          nm_limpa_numero($this->id_lisreq_fk_, $this->field_config['id_lisreq_fk_']['symbol_grp']) ; 
      }
      if ($Nome_Campo == "cc_carta_")
      {
          nm_limpa_numero($this->cc_carta_, $this->field_config['cc_carta_']['symbol_grp']) ; 
      }
      if ($Nome_Campo == "id_carga_req_")
      {
          nm_limpa_numero($this->id_carga_req_, $this->field_config['id_carga_req_']['symbol_grp']) ; 
      }
   }
   function nm_formatar_campos($format_fields = array())
   {
      global $nm_form_submit;
      if ('' !== $this->cc_correcto_ || (!empty($format_fields) && isset($format_fields['cc_correcto_'])))
      {
          nmgp_Form_Num_Val($this->cc_correcto_, $this->field_config['cc_correcto_']['symbol_grp'], $this->field_config['cc_correcto_']['symbol_dec'], "0", "S", $this->field_config['cc_correcto_']['format_neg'], "", "", "-", $this->field_config['cc_correcto_']['symbol_fmt']) ; 
      }
      if ('' !== $this->num_req_ || (!empty($format_fields) && isset($format_fields['num_req_'])))
      {
          nmgp_Form_Num_Val($this->num_req_, $this->field_config['num_req_']['symbol_grp'], $this->field_config['num_req_']['symbol_dec'], "0", "S", $this->field_config['num_req_']['format_neg'], "", "", "-", $this->field_config['num_req_']['symbol_fmt']) ; 
      }
   }
   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";

      if (false !== strpos($nm_mask, '9') || false !== strpos($nm_mask, 'a') || false !== strpos($nm_mask, '*'))
      {
          $new_campo = '';
          $a_mask_ord  = array();
          $i_mask_size = -1;

          foreach (explode(';', $nm_mask) as $str_mask)
          {
              $a_mask_ord[ $this->nm_conta_mask_chars($str_mask) ] = $str_mask;
          }
          ksort($a_mask_ord);

          foreach ($a_mask_ord as $i_size => $s_mask)
          {
              if (-1 == $i_mask_size)
              {
                  $i_mask_size = $i_size;
              }
              elseif (strlen($nm_campo) >= $i_size && strlen($nm_campo) > $i_mask_size)
              {
                  $i_mask_size = $i_size;
              }
          }
          $nm_mask = $a_mask_ord[$i_mask_size];

          for ($i = 0; $i < strlen($nm_mask); $i++)
          {
              $test_mask = substr($nm_mask, $i, 1);
              
              if ('9' == $test_mask || 'a' == $test_mask || '*' == $test_mask)
              {
                  $new_campo .= substr($nm_campo, 0, 1);
                  $nm_campo   = substr($nm_campo, 1);
              }
              else
              {
                  $new_campo .= $test_mask;
              }
          }

                  $nm_campo = $new_campo;

          return;
      }

      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($cont1 < $cont2 && $tam_campo <= $cont2 && $tam_campo > $cont1)
              {
                  $trab_mask = $ver_duas[1];
              }
              elseif ($cont1 > $cont2 && $tam_campo <= $cont2)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $trab_saida;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $trab_saida;
   } 
   function nm_conta_mask_chars($sMask)
   {
       $iLength = 0;

       for ($i = 0; $i < strlen($sMask); $i++)
       {
           if (in_array($sMask[$i], array('9', 'a', '*')))
           {
               $iLength++;
           }
       }

       return $iLength;
   }
   function nm_tira_mask(&$nm_campo, $nm_mask, $nm_chars = '')
   { 
      $mask_dados = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $tam_mask   = strlen($nm_mask);
      $trab_saida = "";

      if (false !== strpos($nm_mask, '9') || false !== strpos($nm_mask, 'a') || false !== strpos($nm_mask, '*'))
      {
          $raw_campo = $this->sc_clear_mask($nm_campo, $nm_chars);
          $raw_mask  = $this->sc_clear_mask($nm_mask, $nm_chars);
          $new_campo = '';

          $test_mask = substr($raw_mask, 0, 1);
          $raw_mask  = substr($raw_mask, 1);

          while ('' != $raw_campo)
          {
              $test_val  = substr($raw_campo, 0, 1);
              $raw_campo = substr($raw_campo, 1);
              $ord       = ord($test_val);
              $found     = false;

              switch ($test_mask)
              {
                  case '9':
                      if (48 <= $ord && 57 >= $ord)
                      {
                          $new_campo .= $test_val;
                          $found      = true;
                      }
                      break;

                  case 'a':
                      if ((65 <= $ord && 90 >= $ord) || (97 <= $ord && 122 >= $ord))
                      {
                          $new_campo .= $test_val;
                          $found      = true;
                      }
                      break;

                  case '*':
                      if ((48 <= $ord && 57 >= $ord) || (65 <= $ord && 90 >= $ord) || (97 <= $ord && 122 >= $ord))
                      {
                          $new_campo .= $test_val;
                          $found      = true;
                      }
                      break;
              }

              if ($found)
              {
                  $test_mask = substr($raw_mask, 0, 1);
                  $raw_mask  = substr($raw_mask, 1);
              }
          }

          $nm_campo = $new_campo;

          return;
      }

      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          for ($x=0; $x < strlen($mask_dados); $x++)
          {
              if (is_numeric(substr($mask_dados, $x, 1)))
              {
                  $trab_saida .= substr($mask_dados, $x, 1);
              }
          }
          $nm_campo = $trab_saida;
          return;
      }
      if ($tam_mask > $tam_campo)
      {
         $mask_desfaz = "";
         for ($mask_ind = 0; $tam_mask > $tam_campo; $mask_ind++)
         {
              $mask_char = substr($trab_mask, $mask_ind, 1);
              if ($mask_char == "z")
              {
                  $tam_mask--;
              }
              else
              {
                  $mask_desfaz .= $mask_char;
              }
              if ($mask_ind == $tam_campo)
              {
                  $tam_mask = $tam_campo;
              }
         }
         $trab_mask = $mask_desfaz . substr($trab_mask, $mask_ind);
      }
      $mask_saida = "";
      for ($mask_ind = strlen($trab_mask); $mask_ind > 0; $mask_ind--)
      {
          $mask_char = substr($trab_mask, $mask_ind - 1, 1);
          if ($mask_char == "x" || $mask_char == "z")
          {
              if ($tam_campo > 0)
              {
                  $mask_saida = substr($mask_dados, $tam_campo - 1, 1) . $mask_saida;
              }
          }
          else
          {
              if ($mask_char != substr($mask_dados, $tam_campo - 1, 1) && $tam_campo > 0)
              {
                  $mask_saida = substr($mask_dados, $tam_campo - 1, 1) . $mask_saida;
                  $mask_ind--;
              }
          }
          $tam_campo--;
      }
      if ($tam_campo > 0)
      {
         $mask_saida = substr($mask_dados, 0, $tam_campo) . $mask_saida;
      }
      $nm_campo = $mask_saida;
   }

   function sc_clear_mask($value, $chars)
   {
       $new = '';

       for ($i = 0; $i < strlen($value); $i++)
       {
           if (false === strpos($chars, $value[$i]))
           {
               $new .= $value[$i];
           }
       }

       return $new;
   }
//
   function nm_limpa_alfa(&$str)
   {
   }
   function nm_conv_data_db($dt_in, $form_in, $form_out, $replaces = array())
   {
       $dt_out = $dt_in;
       if (strtoupper($form_in) == "DB_FORMAT") {
           if ($dt_out == "null" || $dt_out == "")
           {
               $dt_out = "";
               return $dt_out;
           }
           $form_in = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "DB_FORMAT") {
           if (empty($dt_out))
           {
               $dt_out = "null";
               return $dt_out;
           }
           $form_out = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "SC_FORMAT_REGION") {
           $this->nm_data->SetaData($dt_in, strtoupper($form_in));
           $prep_out  = (strpos(strtolower($form_in), "dd") !== false) ? "dd" : "";
           $prep_out .= (strpos(strtolower($form_in), "mm") !== false) ? "mm" : "";
           $prep_out .= (strpos(strtolower($form_in), "aa") !== false) ? "aaaa" : "";
           $prep_out .= (strpos(strtolower($form_in), "yy") !== false) ? "aaaa" : "";
           return $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", $prep_out));
       }
       else {
           nm_conv_form_data($dt_out, $form_in, $form_out, $replaces);
           return $dt_out;
       }
   }

   function returnWhere($aCond, $sOp = 'AND')
   {
       $aWhere = array();
       foreach ($aCond as $sCond)
       {
           $this->handleWhereCond($sCond);
           if ('' != $sCond)
           {
               $aWhere[] = $sCond;
           }
       }
       if (empty($aWhere))
       {
           return '';
       }
       else
       {
           return ' WHERE (' . implode(') ' . $sOp . ' (', $aWhere) . ')';
       }
   } // returnWhere

   function handleWhereCond(&$sCond)
   {
       $sCond = trim($sCond);
       if ('where' == strtolower(substr($sCond, 0, 5)))
       {
           $sCond = trim(substr($sCond, 5));
       }
   } // handleWhereCond

   function ajax_return_values()
   {
          $this->ajax_return_values_all_vert();
          if ('navigate_form' == $this->NM_ajax_opcao)
          {
              $this->NM_ajax_info['clearUpload']      = 'S';
              $this->NM_ajax_info['navStatus']['ret'] = $this->Nav_permite_ret ? 'S' : 'N';
              $this->NM_ajax_info['navStatus']['ava'] = $this->Nav_permite_ava ? 'S' : 'N';
              $this->NM_ajax_info['fldList']['id_asp_req_']['keyVal'] = form_asp_requisitos_admvo_pack_protect_string($this->nmgp_dados_form['id_asp_req_']);
          }
   } // ajax_return_values
   function ajax_return_values_all_vert()
   {
          if (isset($this->nmgp_refresh_fields) && isset($this->nmgp_refresh_row) && '' != $this->nmgp_refresh_row)
          {
              $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row] = $this->NM_ajax_info['param'];
              if ((isset($this->Embutida_ronly) && $this->Embutida_ronly) || $this->NM_ajax_force_values)
              {
                  if (isset($this->NM_ajax_changed['cc_correcto_']) && $this->NM_ajax_changed['cc_correcto_'])
                  {
                      $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row]['cc_correcto_'] = $this->cc_correcto_;
                  }
                  if (isset($this->NM_ajax_changed['notas_revisor_']) && $this->NM_ajax_changed['notas_revisor_'])
                  {
                      $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row]['notas_revisor_'] = $this->notas_revisor_;
                  }
                  if (isset($this->NM_ajax_changed['num_req_']) && $this->NM_ajax_changed['num_req_'])
                  {
                      $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row]['num_req_'] = $this->num_req_;
                  }
                  if (isset($this->NM_ajax_changed['archivo_']) && $this->NM_ajax_changed['archivo_'])
                  {
                      $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row]['archivo_'] = $this->archivo_;
                  }
                  if (isset($this->NM_ajax_changed['notas_aspirante_']) && $this->NM_ajax_changed['notas_aspirante_'])
                  {
                      $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row]['notas_aspirante_'] = $this->notas_aspirante_;
                  }
              }
          }
          if (isset($this->nmgp_refresh_row) && '' != $this->nmgp_refresh_row)
          {
              $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row]['notas_revisor_'] = $this->notas_revisor_;
              $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row]['archivo_'] = $this->archivo_;
              $this->form_vert_form_asp_requisitos_admvo[$this->nmgp_refresh_row]['notas_aspirante_'] = $this->notas_aspirante_;
          }
          $this->NM_ajax_info['rsSize']            = sizeof($this->form_vert_form_asp_requisitos_admvo);
          $this->NM_ajax_info['buttonDisplayVert'] = array();
          foreach($this->form_vert_form_asp_requisitos_admvo as $sc_seq_vert => $aRecData)
          {
              $this->loadRecordState($sc_seq_vert);
              if ('navigate_form' == $this->NM_ajax_opcao) {
                  $this->NM_ajax_info['buttonDisplayVert'][] = array(
                      'seq'      => $sc_seq_vert,
                      'gridView' => false,
                      'delete'   => $this->nmgp_botoes['delete'],
                      'update'   => $this->nmgp_botoes['update'],
                  );
              }
              if ('navigate_form' == $this->NM_ajax_opcao || 'backup_line' == $this->NM_ajax_opcao || (isset($this->nmgp_refresh_fields) && in_array("cc_correcto_", $this->nmgp_refresh_fields)))
              {
                  $sTmpValue = NM_charset_to_utf8($aRecData['cc_correcto_']);
                  $aLookup = array();
          $aLookupOrig = $aLookup;
                  $this->NM_ajax_info['fldList']['cc_correcto_' . $sc_seq_vert] = array(
                       'row'    => $sc_seq_vert,
                       'type'    => 'text',
                       'valList' => array($sTmpValue),
                       );
              }
              if ('navigate_form' == $this->NM_ajax_opcao || 'backup_line' == $this->NM_ajax_opcao || (isset($this->nmgp_refresh_fields) && in_array("notas_revisor_", $this->nmgp_refresh_fields)))
              {
                  $sTmpValue = NM_charset_to_utf8($aRecData['notas_revisor_']);
                  $aLookup = array();
          $aLookupOrig = $aLookup;
                  $this->NM_ajax_info['fldList']['notas_revisor_' . $sc_seq_vert] = array(
                       'row'    => $sc_seq_vert,
                       'type'    => 'text',
                       'valList' => array($sTmpValue),
                       );
              }
              if ('navigate_form' == $this->NM_ajax_opcao || 'backup_line' == $this->NM_ajax_opcao || (isset($this->nmgp_refresh_fields) && in_array("num_req_", $this->nmgp_refresh_fields)))
              {
                  $sTmpValue = NM_charset_to_utf8($aRecData['num_req_']);
                  $aLookup = array();
          $aLookupOrig = $aLookup;
                  $this->NM_ajax_info['fldList']['num_req_' . $sc_seq_vert] = array(
                       'row'    => $sc_seq_vert,
                       'type'    => 'text',
                       'valList' => array($sTmpValue),
                       );
              $this->num_req_ = $aRecData['num_req_'];
              $orig_num_req_ = $this->num_req_;
              $num_req_      = $this->num_req_;
              nm_limpa_numero($num_req_, $this->field_config['num_req_']['symbol_grp']); 
              $this->num_req_ = $num_req_;
              $this->lookup_num_req_($conteudo);
              $this->num_req_ = $orig_num_req_;
              $this->NM_ajax_info['fldList']['num_req_' . $sc_seq_vert]['lookupCons'] = form_asp_requisitos_admvo_pack_protect_string($conteudo);
              }
              if ('navigate_form' == $this->NM_ajax_opcao || 'backup_line' == $this->NM_ajax_opcao || (isset($this->nmgp_refresh_fields) && in_array("archivo_", $this->nmgp_refresh_fields)))
              {
                  $sTmpValue = NM_charset_to_utf8($aRecData['archivo_']);
                  $aLookup = array();
          $aLookupOrig = $aLookup;
                  $this->NM_ajax_info['fldList']['archivo_' . $sc_seq_vert] = array(
                       'row'    => $sc_seq_vert,
                       'type'    => 'text',
                       'valList' => array($this->form_encode_input($sTmpValue)),
                       );
              }
              if ('navigate_form' == $this->NM_ajax_opcao || 'backup_line' == $this->NM_ajax_opcao || (isset($this->nmgp_refresh_fields) && in_array("notas_aspirante_", $this->nmgp_refresh_fields)))
              {
                  $sTmpValue = NM_charset_to_utf8($aRecData['notas_aspirante_']);
                  $aLookup = array();
          $aLookupOrig = $aLookup;
                  $this->NM_ajax_info['fldList']['notas_aspirante_' . $sc_seq_vert] = array(
                       'row'    => $sc_seq_vert,
                       'type'    => 'text',
                       'valList' => array($sTmpValue),
                       );
              }
          }
   }

    function fetchUniqueUploadName($originalName, $uploadDir, $fieldName)
    {
        $originalName = trim($originalName);
        if ('' == $originalName)
        {
            return $originalName;
        }
        if (!@is_dir($uploadDir))
        {
            return $originalName;
        }
        if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['upload_dir'][$fieldName]))
        {
            $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['upload_dir'][$fieldName] = array();
            $resDir = @opendir($uploadDir);
            if (!$resDir)
            {
                return $originalName;
            }
            while (false !== ($fileName = @readdir($resDir)))
            {
                if (@is_file($uploadDir . $fileName))
                {
                    $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['upload_dir'][$fieldName][] = $fileName;
                }
            }
            @closedir($resDir);
        }
        if (!in_array($originalName, $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['upload_dir'][$fieldName]))
        {
            $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['upload_dir'][$fieldName][] = $originalName;
            return $originalName;
        }
        else
        {
            $newName = $this->fetchFileNextName($originalName, $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['upload_dir'][$fieldName]);
            $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['upload_dir'][$fieldName][] = $newName;
            $this->Upload_refresh_fields[] = $fieldName;
            return $newName;
        }
    } // fetchUniqueUploadName

    function fetchFileNextName($uniqueName, $uniqueList)
    {
        $aPathinfo     = pathinfo($uniqueName);
        $fileExtension = $aPathinfo['extension'];
        $fileName      = $aPathinfo['filename'];
        $foundName     = false;
        $nameIt        = 1;
        if ('' != $fileExtension)
        {
            $fileExtension = '.' . $fileExtension;
        }
        while (!$foundName)
        {
            $testName = $fileName . '(' . $nameIt . ')' . $fileExtension;
            if (in_array($testName, $uniqueList))
            {
                $nameIt++;
            }
            else
            {
                $foundName = true;
                return $testName;
            }
        }
    } // fetchFileNextName

   function ajax_add_parameters()
   {
       $this->NM_ajax_info['summary_line'] = $this->getSummaryLine();
   } // ajax_add_parameters
  function nm_proc_onload_record($sc_seq_vert=0)
  {
          if (!$this->NM_ajax_flag || !isset($this->nmgp_refresh_fields)) {
          $_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'on';
  static $visor_url_guardada = false;
if ($visor_url_guardada) {
    return;
}

$visor_path = '/opt/lampp/htdocs/visor-requisitos-admvo';
if (!is_dir($visor_path) || !is_file($visor_path . '/lib/token.php') || !is_file($visor_path . '/config.php')) {
    error_log('form_asp_requisitos_admvo onLoadRecord visor: ruta inválida ' . $visor_path);
    return;
}

$id_asp = intval($this->id_asp_fk_ );
if ($id_asp <= 0) {
    return;
}

require_once $visor_path . '/config.php';
require_once $visor_path . '/lib/token.php';

try {
    $token = generateDownloadToken($id_asp, 'adm-visor-req');
} catch (Throwable $e) {
    error_log('form_asp_requisitos_admvo onLoadRecord visor: ' . $e->getMessage());
    return;
}

$base = defined('VISOR_PUBLIC_BASE_URL')
    ? trim((string) VISOR_PUBLIC_BASE_URL)
    : 'https://posgrados.inecol.mx/visor-requisitos-admvo/';
$base = preg_replace('#/(index|viewer|serve)\.php.*$#i', '', $base);
$base = rtrim($base, '/');
$visor_url = $base . '/index.php?type=adm-visor-req&id=' . $id_asp . '&token=' . rawurlencode($token);

$_SESSION['scriptcase']['form_asp_requisitos_admvo']['visor_expediente_url'] = $visor_url;
$visor_url_guardada = true;
$_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'off'; 
          }
  }
  function nm_proc_onload($bFormat = true)
  {
      $Ctrl_Proc_Onload = true;
      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['Field_no_validate'] = array();
      if (!$this->NM_ajax_flag || !isset($this->nmgp_refresh_fields)) {
      $_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'on';
$_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'off'; 
      }
      if (empty($this->fecha_revision_))
      {
          $this->fecha_revision__hora = $this->fecha_revision_;
      }
      if (empty($this->notas_internas_))
      {
          $this->notas_internas__hora = $this->notas_internas_;
      }
      if (empty($this->fecha_alta_))
      {
          $this->fecha_alta__hora = $this->fecha_alta_;
      }
      if (empty($this->fecha_ult_act_))
      {
          $this->fecha_ult_act__hora = $this->fecha_ult_act_;
      }
      if (!isset($Ctrl_Format) || !$Ctrl_Format) {
          $this->nm_guardar_campos();
          if ($bFormat) $this->nm_formatar_campos();
      }
  }
//
//----------------------------------------------------
//-----> 
//----------------------------------------------------
//----------- 


   function temRegistros($sWhere)
   {
       if ('' == $sWhere)
       {
           return false;
       }
       $nmgp_sel_count = 'SELECT COUNT(*) AS countTest FROM ' . $this->Ini->nm_tabela . ' WHERE ' . $sWhere;
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_sel_count; 
       $rsc = $this->Db->Execute($nmgp_sel_count); 
       if ($rsc === false && !$rsc->EOF)
       {
           $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg());
           exit; 
       }
       $iTotal = $rsc->fields[0];
       $rsc->Close();
       return 0 < $iTotal;
   } // temRegistros

   function deletaRegistros($sWhere)
   {
       if ('' == $sWhere)
       {
           return false;
       }
       $nmgp_sel_count = 'DELETE FROM ' . $this->Ini->nm_tabela . ' WHERE ' . $sWhere;
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_sel_count; 
       $rsc = $this->Db->Execute($nmgp_sel_count); 
       $bResult = $rsc;
       $rsc->Close();
       return $bResult == true;
   } // deletaRegistros
    function handleDbErrorMessage(&$dbErrorMessage, $dbErrorCode)
    {
        if (1267 == $dbErrorCode) {
            $dbErrorMessage = $this->Ini->Nm_lang['lang_errm_db_invalid_collation'];
        }
    }

   function restore_zeros_null()
   {
      if (!empty($this->sc_force_zero))
      {
          foreach ($this->sc_force_zero as $i_force_zero => $sc_force_zero_field)
          {
              eval('if ($this->' . $sc_force_zero_field . ' == 0) {$this->' . $sc_force_zero_field . ' = "";}');
          }
      }
      $this->sc_force_zero = array();
      if (!empty($this->NM_val_null))
      {
          foreach ($this->NM_val_null as $i_val_null => $sc_val_null_field)
          {
              eval('$this->' . $sc_val_null_field . ' = "";');
          }
      }
      $this->NM_val_null = array();
   }

   function nm_acessa_banco() 
   { 
      global $sc_seq_vert,  $nm_form_submit, $teste_validade, $sc_where;
 
      $this->NM_val_null = array();
      $NM_val_form = array();
      $this->sc_erro_insert = "";
      $this->sc_erro_update = "";
      $this->sc_erro_delete = "";
      $this->SC_log_atv = false;
      if ("alterar" == $this->nmgp_opcao || "excluir" == $this->nmgp_opcao)
      {
          $this->NM_gera_log_key($this->nmgp_opcao);
      }
      if ("alterar" == $this->nmgp_opcao || "excluir" == $this->nmgp_opcao)
      {
          $this->NM_gera_log_old($sc_seq_vert);
      }
      $this->restore_zeros_null();
      if ($this->nmgp_opcao == "alterar")
      {
          $this->nmgp_dados_select = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert];
          if ($this->nmgp_dados_select['cc_correcto_'] == $this->cc_correcto_ &&
              $this->nmgp_dados_select['notas_revisor_'] == $this->notas_revisor_ &&
              $this->nmgp_dados_select['num_req_'] == $this->num_req_ &&
              $this->nmgp_dados_select['archivo_'] == $this->archivo_ &&
              $this->nmgp_dados_select['notas_aspirante_'] == $this->notas_aspirante_)
          { }
          else
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['cc_correcto_'] = $this->cc_correcto_;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['notas_revisor_'] = $this->notas_revisor_;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['num_req_'] = $this->num_req_;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['archivo_'] = $this->archivo_;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['notas_aspirante_'] = $this->notas_aspirante_;
          }
      }
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $salva_opcao = $this->nmgp_opcao; 
      if ($this->sc_evento != "novo" && $this->sc_evento != "incluir") 
      { 
          $this->sc_evento = ""; 
      } 
      if ((!isset($this->Ini->nm_bases_access) || !in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access)) && !$this->Ini->sc_tem_trans_banco && in_array($this->nmgp_opcao, array('excluir', 'incluir', 'alterar')))
      { 
          $this->Ini->sc_tem_trans_banco = $this->Db->BeginTrans(); 
      } 
      if ('incluir' == $this->nmgp_opcao && empty($this->login_insert_)) {$this->login_insert_ = "" . $_SESSION['usr_login'] . ""; $this->NM_val_null[] = "login_insert_";}  
      if ('incluir' == $this->nmgp_opcao) { $this->ip_alta_ = $_SERVER['REMOTE_ADDR']; } 
      if (('alterar' == $this->nmgp_opcao || 'igual' == $this->nmgp_opcao) && empty($this->login_last_)){$this->login_last_ = "" . $_SESSION['usr_login'] . ""; $this->NM_val_null[] = "login_last_";}  
      if ('alterar' == $this->nmgp_opcao || 'igual' == $this->nmgp_opcao) { $this->ip_last_ = $_SERVER['REMOTE_ADDR']; } 
      $NM_val_form['cc_correcto_'] = $this->cc_correcto_;
      $NM_val_form['notas_revisor_'] = $this->notas_revisor_;
      $NM_val_form['num_req_'] = $this->num_req_;
      $NM_val_form['archivo_'] = $this->archivo_;
      $NM_val_form['notas_aspirante_'] = $this->notas_aspirante_;
      $NM_val_form['id_asp_req_'] = $this->id_asp_req_;
      $NM_val_form['id_asp_fk_'] = $this->id_asp_fk_;
      $NM_val_form['login_fk_'] = $this->login_fk_;
      $NM_val_form['id_lisreq_fk_'] = $this->id_lisreq_fk_;
      $NM_val_form['cc_carta_'] = $this->cc_carta_;
      $NM_val_form['prefijo_requisito_'] = $this->prefijo_requisito_;
      $NM_val_form['fecha_revision_'] = $this->fecha_revision_;
      $NM_val_form['notas_internas_'] = $this->notas_internas_;
      $NM_val_form['id_carga_req_'] = $this->id_carga_req_;
      $NM_val_form['usu_carga_req_'] = $this->usu_carga_req_;
      $NM_val_form['ip_revision_'] = $this->ip_revision_;
      $NM_val_form['login_insert_'] = $this->login_insert_;
      $NM_val_form['fecha_alta_'] = $this->fecha_alta_;
      $NM_val_form['ip_alta_'] = $this->ip_alta_;
      $NM_val_form['login_last_'] = $this->login_last_;
      $NM_val_form['fecha_ult_act_'] = $this->fecha_ult_act_;
      $NM_val_form['ip_last_'] = $this->ip_last_;
      if ($this->id_asp_req_ === "" || is_null($this->id_asp_req_))  
      { 
          $this->id_asp_req_ = 0;
      } 
      if ($this->id_asp_fk_ === "" || is_null($this->id_asp_fk_))  
      { 
          $this->id_asp_fk_ = 0;
          $this->sc_force_zero[] = 'id_asp_fk_';
      } 
      if ($this->id_lisreq_fk_ === "" || is_null($this->id_lisreq_fk_))  
      { 
          $this->id_lisreq_fk_ = 0;
          $this->sc_force_zero[] = 'id_lisreq_fk_';
      } 
      if ($this->num_req_ === "" || is_null($this->num_req_))  
      { 
          $this->num_req_ = 0;
          $this->sc_force_zero[] = 'num_req_';
      } 
      if ($this->cc_correcto_ === "" || is_null($this->cc_correcto_))  
      { 
          $this->cc_correcto_ = 0;
          $this->sc_force_zero[] = 'cc_correcto_';
      } 
      if ($this->cc_carta_ === "" || is_null($this->cc_carta_))  
      { 
          $this->cc_carta_ = 0;
          $this->sc_force_zero[] = 'cc_carta_';
      } 
      if ($this->id_carga_req_ === "" || is_null($this->id_carga_req_))  
      { 
          $this->id_carga_req_ = 0;
          $this->sc_force_zero[] = 'id_carga_req_';
      } 
      $nm_bases_lob_geral = array_merge($this->Ini->nm_bases_oracle, $this->Ini->nm_bases_ibase, $this->Ini->nm_bases_informix, $this->Ini->nm_bases_mysql, $this->Ini->nm_bases_access, $this->Ini->nm_bases_sqlite, $this->Ini->nm_bases_db2, array('pdo_sqlsrv'));
      if ($this->nmgp_opcao == "alterar" || $this->nmgp_opcao == "incluir") 
      {
          $this->login_fk__before_qstr = $this->login_fk_;
          $this->login_fk_ = substr($this->Db->qstr($this->login_fk_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->login_fk_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->login_fk_);
          }
          if ($this->login_fk_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->login_fk_ = "null"; 
              $this->NM_val_null[] = "login_fk_";
          } 
          $this->archivo__before_qstr = $this->archivo_;
          $this->archivo_ = substr($this->Db->qstr($this->archivo_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->archivo_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->archivo_);
          }
          if ($this->archivo_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->archivo_ = "null"; 
              $this->NM_val_null[] = "archivo_";
          } 
          $this->notas_aspirante__before_qstr = $this->notas_aspirante_;
          $this->notas_aspirante_ = substr($this->Db->qstr($this->notas_aspirante_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->notas_aspirante_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->notas_aspirante_);
          }
          if ($this->notas_aspirante_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->notas_aspirante_ = "null"; 
              $this->NM_val_null[] = "notas_aspirante_";
          } 
          $this->prefijo_requisito__before_qstr = $this->prefijo_requisito_;
          $this->prefijo_requisito_ = substr($this->Db->qstr($this->prefijo_requisito_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->prefijo_requisito_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->prefijo_requisito_);
          }
          if ($this->prefijo_requisito_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->prefijo_requisito_ = "null"; 
              $this->NM_val_null[] = "prefijo_requisito_";
          } 
          $this->notas_revisor__before_qstr = $this->notas_revisor_;
          $this->notas_revisor_ = substr($this->Db->qstr($this->notas_revisor_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->notas_revisor_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->notas_revisor_);
          }
          if ($this->notas_revisor_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->notas_revisor_ = "null"; 
              $this->NM_val_null[] = "notas_revisor_";
          } 
          if ($this->fecha_revision_ == "")  
          { 
              $this->fecha_revision_ = "null"; 
              $this->NM_val_null[] = "fecha_revision_";
          } 
          $this->notas_internas__before_qstr = $this->notas_internas_;
          $this->notas_internas_ = substr($this->Db->qstr($this->notas_internas_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->notas_internas_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->notas_internas_);
          }
          if ($this->notas_internas_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->notas_internas_ = "null"; 
              $this->NM_val_null[] = "notas_internas_";
          } 
          $this->usu_carga_req__before_qstr = $this->usu_carga_req_;
          $this->usu_carga_req_ = substr($this->Db->qstr($this->usu_carga_req_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->usu_carga_req_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->usu_carga_req_);
          }
          if ($this->usu_carga_req_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->usu_carga_req_ = "null"; 
              $this->NM_val_null[] = "usu_carga_req_";
          } 
          $this->ip_revision__before_qstr = $this->ip_revision_;
          $this->ip_revision_ = substr($this->Db->qstr($this->ip_revision_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->ip_revision_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->ip_revision_);
          }
          if ($this->ip_revision_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->ip_revision_ = "null"; 
              $this->NM_val_null[] = "ip_revision_";
          } 
          $this->login_insert__before_qstr = $this->login_insert_;
          $this->login_insert_ = substr($this->Db->qstr($this->login_insert_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->login_insert_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->login_insert_);
          }
          if ($this->login_insert_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->login_insert_ = "null"; 
              $this->NM_val_null[] = "login_insert_";
          } 
          if ($this->fecha_alta_ == "")  
          { 
              $this->fecha_alta_ = "null"; 
              $this->NM_val_null[] = "fecha_alta_";
          } 
          $this->ip_alta__before_qstr = $this->ip_alta_;
          $this->ip_alta_ = substr($this->Db->qstr($this->ip_alta_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->ip_alta_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->ip_alta_);
          }
          if ($this->ip_alta_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->ip_alta_ = "null"; 
              $this->NM_val_null[] = "ip_alta_";
          } 
          $this->login_last__before_qstr = $this->login_last_;
          $this->login_last_ = substr($this->Db->qstr($this->login_last_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->login_last_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->login_last_);
          }
          if ($this->login_last_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->login_last_ = "null"; 
              $this->NM_val_null[] = "login_last_";
          } 
          if ($this->fecha_ult_act_ == "")  
          { 
              $this->fecha_ult_act_ = "null"; 
              $this->NM_val_null[] = "fecha_ult_act_";
          } 
          $this->ip_last__before_qstr = $this->ip_last_;
          $this->ip_last_ = substr($this->Db->qstr($this->ip_last_), 1, -1); 
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
          {
              $this->ip_last_ = str_replace(array("\\r\\n", "\\n", "\r\n"), array("\r\n", "\n", "\n"), $this->ip_last_);
          }
          if ($this->ip_last_ == "" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))  
          { 
              $this->ip_last_ = "null"; 
              $this->NM_val_null[] = "ip_last_";
          } 
      }
      if ($this->nmgp_opcao == "alterar") 
      {
          $SC_fields_update = array(); 
          if (($this->Embutida_form || $this->Embutida_multi) && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key']))
          {
              foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key'] as $sFKName => $sFKValue)
              {
                   if (isset($this->sc_conv_var[$sFKName]))
                   {
                       $sFKName = $this->sc_conv_var[$sFKName];
                   }
                  eval("\$this->" . $sFKName . " = \"" . $sFKValue . "\";");
              }
          }
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ ";
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ ";
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ ";
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ ";
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          else  
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ ";
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          if ($rs1 === false)  
          { 
              $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
              if ($this->NM_ajax_flag)
              {
                 form_asp_requisitos_admvo_pack_ajax_response();
              }
              exit; 
          }  
          $bUpdateOk = true;
          $tmp_result = (int) $rs1->fields[0]; 
          if ($tmp_result != 1) 
          { 
              $this->Campos_Mens_erro = $this->Ini->Nm_lang['lang_errm_nfnd']; 
              $this->nmgp_opcao = "nada"; 
              $bUpdateOk = false;
              $this->sc_evento = 'update';
          } 
          $aUpdateOk = array();
          $bUpdateOk = $bUpdateOk && empty($aUpdateOk);
          if ($bUpdateOk)
          { 
              $rs1->Close(); 
              $aDoNotUpdate = array();
              $this->fecha_ult_act_ =  date('Y') . "-" . date('m')  . "-" . date('d') . " " . date('H') . ":" . date('i') . ":" . date('s');
              $this->fecha_ult_act__hora =  date('H') . ":" . date('i') . ":" . date('s');
              $NM_val_form['fecha_ult_act_'] = $this->fecha_ult_act_;
              $this->NM_ajax_changed['fecha_ult_act_'] = true;
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
              { 
                  $comando = "UPDATE " . $this->Ini->nm_tabela . " SET ";  
                  $SC_fields_update[] = "num_req = $this->num_req_, archivo = '$this->archivo_', notas_aspirante = '$this->notas_aspirante_', cc_correcto = $this->cc_correcto_, notas_revisor = '$this->notas_revisor_'"; 
              } 
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
              { 
                  $comando = "UPDATE " . $this->Ini->nm_tabela . " SET ";  
                  $SC_fields_update[] = "num_req = $this->num_req_, archivo = '$this->archivo_', notas_aspirante = '$this->notas_aspirante_', cc_correcto = $this->cc_correcto_, notas_revisor = '$this->notas_revisor_'"; 
              } 
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
              { 
                  $comando = "UPDATE " . $this->Ini->nm_tabela . " SET ";  
                  $SC_fields_update[] = "num_req = $this->num_req_, archivo = '$this->archivo_', notas_aspirante = '$this->notas_aspirante_', cc_correcto = $this->cc_correcto_, notas_revisor = '$this->notas_revisor_'"; 
              } 
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              { 
                  $comando = "UPDATE " . $this->Ini->nm_tabela . " SET ";  
                  $SC_fields_update[] = "num_req = $this->num_req_, archivo = '$this->archivo_', notas_aspirante = '$this->notas_aspirante_', cc_correcto = $this->cc_correcto_, notas_revisor = '$this->notas_revisor_'"; 
              } 
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
              { 
                  $comando = "UPDATE " . $this->Ini->nm_tabela . " SET ";  
                  $SC_fields_update[] = "num_req = $this->num_req_, archivo = '$this->archivo_', notas_aspirante = '$this->notas_aspirante_', cc_correcto = $this->cc_correcto_, notas_revisor = '$this->notas_revisor_'"; 
              } 
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_ibase))
              { 
                  $comando = "UPDATE " . $this->Ini->nm_tabela . " SET ";  
                  $SC_fields_update[] = "num_req = $this->num_req_, archivo = '$this->archivo_', notas_aspirante = '$this->notas_aspirante_', cc_correcto = $this->cc_correcto_, notas_revisor = '$this->notas_revisor_'"; 
              } 
              else 
              { 
                  $comando = "UPDATE " . $this->Ini->nm_tabela . " SET ";  
                  $SC_fields_update[] = "num_req = $this->num_req_, archivo = '$this->archivo_', notas_aspirante = '$this->notas_aspirante_', cc_correcto = $this->cc_correcto_, notas_revisor = '$this->notas_revisor_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['id_asp_fk_']) && $NM_val_form['id_asp_fk_'] == "null"  && $this->nmgp_dados_select['id_asp_fk_'] == "") ? "null" : $this->nmgp_dados_select['id_asp_fk_'];
              if (isset($NM_val_form['id_asp_fk_']) && $NM_val_form['id_asp_fk_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "id_asp_FK = $this->id_asp_fk_"; 
              } 
              $Prep_Tst = (isset($NM_val_form['login_fk_']) && $NM_val_form['login_fk_'] == "null"  && $this->nmgp_dados_select['login_fk_'] == "") ? "null" : $this->nmgp_dados_select['login_fk_'];
              if (isset($NM_val_form['login_fk_']) && $NM_val_form['login_fk_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "login_FK = '$this->login_fk_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['id_lisreq_fk_']) && $NM_val_form['id_lisreq_fk_'] == "null"  && $this->nmgp_dados_select['id_lisreq_fk_'] == "") ? "null" : $this->nmgp_dados_select['id_lisreq_fk_'];
              if (isset($NM_val_form['id_lisreq_fk_']) && $NM_val_form['id_lisreq_fk_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "id_lisreq_FK = $this->id_lisreq_fk_"; 
              } 
              $Prep_Tst = (isset($NM_val_form['cc_carta_']) && $NM_val_form['cc_carta_'] == "null"  && $this->nmgp_dados_select['cc_carta_'] == "") ? "null" : $this->nmgp_dados_select['cc_carta_'];
              if (isset($NM_val_form['cc_carta_']) && $NM_val_form['cc_carta_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "cc_carta = $this->cc_carta_"; 
              } 
              $Prep_Tst = (isset($NM_val_form['prefijo_requisito_']) && $NM_val_form['prefijo_requisito_'] == "null"  && $this->nmgp_dados_select['prefijo_requisito_'] == "") ? "null" : $this->nmgp_dados_select['prefijo_requisito_'];
              if (isset($NM_val_form['prefijo_requisito_']) && $NM_val_form['prefijo_requisito_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "prefijo_requisito = '$this->prefijo_requisito_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['fecha_revision_']) && $NM_val_form['fecha_revision_'] == "null"  && $this->nmgp_dados_select['fecha_revision_'] == "") ? "null" : $this->nmgp_dados_select['fecha_revision_'];
              if (isset($NM_val_form['fecha_revision_']) && $NM_val_form['fecha_revision_'] != $Prep_Tst) 
              { 
                  if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
                  { 
                      $SC_fields_update[] = "fecha_revision = #$this->fecha_revision_#"; 
                  } 
                  elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
                  { 
                      $SC_fields_update[] = "fecha_revision = EXTEND('" . $this->fecha_revision_ . "', YEAR TO FRACTION)"; 
                  } 
                  else
                  { 
                      $SC_fields_update[] = "fecha_revision = " . $this->Ini->date_delim . $this->fecha_revision_ . $this->Ini->date_delim1 . ""; 
                  } 
              } 
              $Prep_Tst = (isset($NM_val_form['notas_internas_']) && $NM_val_form['notas_internas_'] == "null"  && $this->nmgp_dados_select['notas_internas_'] == "") ? "null" : $this->nmgp_dados_select['notas_internas_'];
              if (isset($NM_val_form['notas_internas_']) && $NM_val_form['notas_internas_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "notas_internas = '$this->notas_internas_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['id_carga_req_']) && $NM_val_form['id_carga_req_'] == "null"  && $this->nmgp_dados_select['id_carga_req_'] == "") ? "null" : $this->nmgp_dados_select['id_carga_req_'];
              if (isset($NM_val_form['id_carga_req_']) && $NM_val_form['id_carga_req_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "id_carga_req = $this->id_carga_req_"; 
              } 
              $Prep_Tst = (isset($NM_val_form['usu_carga_req_']) && $NM_val_form['usu_carga_req_'] == "null"  && $this->nmgp_dados_select['usu_carga_req_'] == "") ? "null" : $this->nmgp_dados_select['usu_carga_req_'];
              if (isset($NM_val_form['usu_carga_req_']) && $NM_val_form['usu_carga_req_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "usu_carga_req = '$this->usu_carga_req_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['ip_revision_']) && $NM_val_form['ip_revision_'] == "null"  && $this->nmgp_dados_select['ip_revision_'] == "") ? "null" : $this->nmgp_dados_select['ip_revision_'];
              if (isset($NM_val_form['ip_revision_']) && $NM_val_form['ip_revision_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "ip_revision = '$this->ip_revision_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['login_insert_']) && $NM_val_form['login_insert_'] == "null"  && $this->nmgp_dados_select['login_insert_'] == "") ? "null" : $this->nmgp_dados_select['login_insert_'];
              if (isset($NM_val_form['login_insert_']) && $NM_val_form['login_insert_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "login_insert = '$this->login_insert_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['fecha_alta_']) && $NM_val_form['fecha_alta_'] == "null"  && $this->nmgp_dados_select['fecha_alta_'] == "") ? "null" : $this->nmgp_dados_select['fecha_alta_'];
              if (isset($NM_val_form['fecha_alta_']) && $NM_val_form['fecha_alta_'] != $Prep_Tst) 
              { 
                  if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
                  { 
                      $SC_fields_update[] = "fecha_alta = #$this->fecha_alta_#"; 
                  } 
                  elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
                  { 
                      $SC_fields_update[] = "fecha_alta = EXTEND('" . $this->fecha_alta_ . "', YEAR TO FRACTION)"; 
                  } 
                  else
                  { 
                      $SC_fields_update[] = "fecha_alta = " . $this->Ini->date_delim . $this->fecha_alta_ . $this->Ini->date_delim1 . ""; 
                  } 
              } 
              $Prep_Tst = (isset($NM_val_form['ip_alta_']) && $NM_val_form['ip_alta_'] == "null"  && $this->nmgp_dados_select['ip_alta_'] == "") ? "null" : $this->nmgp_dados_select['ip_alta_'];
              if (isset($NM_val_form['ip_alta_']) && $NM_val_form['ip_alta_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "ip_alta = '$this->ip_alta_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['login_last_']) && $NM_val_form['login_last_'] == "null"  && $this->nmgp_dados_select['login_last_'] == "") ? "null" : $this->nmgp_dados_select['login_last_'];
              if (isset($NM_val_form['login_last_']) && $NM_val_form['login_last_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "login_last = '$this->login_last_'"; 
              } 
              $Prep_Tst = (isset($NM_val_form['fecha_ult_act_']) && $NM_val_form['fecha_ult_act_'] == "null"  && $this->nmgp_dados_select['fecha_ult_act_'] == "") ? "null" : $this->nmgp_dados_select['fecha_ult_act_'];
              if (isset($NM_val_form['fecha_ult_act_']) && $NM_val_form['fecha_ult_act_'] != $Prep_Tst) 
              { 
                  if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
                  { 
                      $SC_fields_update[] = "fecha_ult_act = #$this->fecha_ult_act_#"; 
                  } 
                  elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
                  { 
                      $SC_fields_update[] = "fecha_ult_act = EXTEND('" . $this->fecha_ult_act_ . "', YEAR TO FRACTION)"; 
                  } 
                  else
                  { 
                      $SC_fields_update[] = "fecha_ult_act = " . $this->Ini->date_delim . $this->fecha_ult_act_ . $this->Ini->date_delim1 . ""; 
                  } 
              } 
              $Prep_Tst = (isset($NM_val_form['ip_last_']) && $NM_val_form['ip_last_'] == "null"  && $this->nmgp_dados_select['ip_last_'] == "") ? "null" : $this->nmgp_dados_select['ip_last_'];
              if (isset($NM_val_form['ip_last_']) && $NM_val_form['ip_last_'] != $Prep_Tst) 
              { 
                  $SC_fields_update[] = "ip_last = '$this->ip_last_'"; 
              } 
              $comando .= implode(",", $SC_fields_update);  
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
              {
                  $comando .= " WHERE id_asp_req = $this->id_asp_req_ ";  
              }  
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
              {
                  $comando .= " WHERE id_asp_req = $this->id_asp_req_ ";  
              }  
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
              {
                  $comando .= " WHERE id_asp_req = $this->id_asp_req_ ";  
              }  
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              {
                  $comando .= " WHERE id_asp_req = $this->id_asp_req_ ";  
              }  
              else  
              {
                  $comando .= " WHERE id_asp_req = $this->id_asp_req_ ";  
              }  
              $comando = str_replace("N'null'", "null", $comando) ; 
              $comando = str_replace("'null'", "null", $comando) ; 
              $comando = str_replace("#null#", "null", $comando) ; 
              $comando = str_replace($this->Ini->date_delim . "null" . $this->Ini->date_delim1, "null", $comando) ; 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              {
                $comando = str_replace("EXTEND('', YEAR TO FRACTION)", "null", $comando) ; 
                $comando = str_replace("EXTEND(null, YEAR TO FRACTION)", "null", $comando) ; 
                $comando = str_replace("EXTEND('', YEAR TO DAY)", "null", $comando) ; 
                $comando = str_replace("EXTEND(null, YEAR TO DAY)", "null", $comando) ; 
              }  
              $useUpdateProcedure = false;
              if (!empty($SC_fields_update) || $useUpdateProcedure)
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = $comando; 
                  $rs = $this->Db->Execute($comando);  
                  if ($rs === false) 
                  { 
                      if (FALSE === strpos(strtoupper($this->Db->ErrorMsg()), "MAIL SENT") && FALSE === strpos(strtoupper($this->Db->ErrorMsg()), "WARNING"))
                      {
                          $dbErrorMessage = $this->Db->ErrorMsg();
                          $dbErrorCode = $this->Db->ErrorNo();
                          $this->handleDbErrorMessage($dbErrorMessage, $dbErrorCode);
                          $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_updt'], $dbErrorMessage, true);
                          if (isset($_SESSION['scriptcase']['erro_handler']) && $_SESSION['scriptcase']['erro_handler']) 
                          { 
                              $this->sc_erro_update = $dbErrorMessage;
                              $this->NM_rollback_db(); 
                              if ($this->NM_ajax_flag)
                              {
                                  form_asp_requisitos_admvo_pack_ajax_response();
                              }
                              exit;  
                          }   
                      }   
                  }   
              }   
              $this->login_fk_ = $this->login_fk__before_qstr;
              $this->archivo_ = $this->archivo__before_qstr;
              $this->notas_aspirante_ = $this->notas_aspirante__before_qstr;
              $this->prefijo_requisito_ = $this->prefijo_requisito__before_qstr;
              $this->notas_revisor_ = $this->notas_revisor__before_qstr;
              $this->notas_internas_ = $this->notas_internas__before_qstr;
              $this->usu_carga_req_ = $this->usu_carga_req__before_qstr;
              $this->ip_revision_ = $this->ip_revision__before_qstr;
              $this->login_insert_ = $this->login_insert__before_qstr;
              $this->ip_alta_ = $this->ip_alta__before_qstr;
              $this->login_last_ = $this->login_last__before_qstr;
              $this->ip_last_ = $this->ip_last__before_qstr;
              if (in_array(strtolower($this->Ini->nm_tpbanco), $nm_bases_lob_geral))
              { 
              }   
              $this->sc_evento = "update"; 
              $this->nmgp_opcao = "igual"; 
              $this->nm_flag_iframe = true;
              if ($this->lig_edit_lookup)
              {
                  $this->lig_edit_lookup_call = true;
              }
              $this->NM_gera_log_new();
              $this->NM_gera_log_compress();
              $this->NM_gera_nav_page(); 
              $this->NM_ajax_info['navPage'] = $this->SC_nav_page; 

              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['db_changed'] = true;
              if ($this->NM_ajax_flag) {
                  $this->NM_ajax_info['clearUpload'] = 'S';
              }

              $this->sc_teve_alt = true; 
              if     (isset($NM_val_form) && isset($NM_val_form['num_req_'])) { $this->num_req_ = $NM_val_form['num_req_']; }
              elseif (isset($this->num_req_)) { $this->nm_limpa_alfa($this->num_req_); }
              if     (isset($NM_val_form) && isset($NM_val_form['archivo_'])) { $this->archivo_ = $NM_val_form['archivo_']; }
              elseif (isset($this->archivo_)) { $this->nm_limpa_alfa($this->archivo_); }
              if     (isset($NM_val_form) && isset($NM_val_form['notas_aspirante_'])) { $this->notas_aspirante_ = $NM_val_form['notas_aspirante_']; }
              elseif (isset($this->notas_aspirante_)) { $this->nm_limpa_alfa($this->notas_aspirante_); }
              if     (isset($NM_val_form) && isset($NM_val_form['cc_correcto_'])) { $this->cc_correcto_ = $NM_val_form['cc_correcto_']; }
              elseif (isset($this->cc_correcto_)) { $this->nm_limpa_alfa($this->cc_correcto_); }
              if     (isset($NM_val_form) && isset($NM_val_form['notas_revisor_'])) { $this->notas_revisor_ = $NM_val_form['notas_revisor_']; }
              elseif (isset($this->notas_revisor_)) { $this->nm_limpa_alfa($this->notas_revisor_); }
              $this->nm_proc_onload_record($this->nmgp_refresh_row);

              $this->nm_formatar_campos();
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
              {
              }

              $aOldRefresh               = $this->nmgp_refresh_fields;
              $this->nmgp_refresh_fields = array_diff(array('cc_correcto_', 'notas_revisor_', 'num_req_', 'archivo_', 'notas_aspirante_'), $aDoNotUpdate);
              $this->ajax_return_values();
              $this->nmgp_refresh_fields = $aOldRefresh;

              if (isset($this->Embutida_ronly) && $this->Embutida_ronly)
              {

                  $this->NM_ajax_info['readOnly']['cc_correcto_' . $this->nmgp_refresh_row] = 'on';

                  $this->NM_ajax_info['readOnly']['notas_revisor_' . $this->nmgp_refresh_row] = 'on';

                  $this->NM_ajax_info['readOnly']['num_req_' . $this->nmgp_refresh_row] = 'on';

                  $this->NM_ajax_info['readOnly']['archivo_' . $this->nmgp_refresh_row] = 'on';

                  $this->NM_ajax_info['readOnly']['notas_aspirante_' . $this->nmgp_refresh_row] = 'on';


                  $this->NM_ajax_info['closeLine'] = $this->nmgp_refresh_row;
              }

              $this->nm_tira_formatacao();
          }  
      }  
      if ($this->nmgp_opcao == "incluir") 
      { 
          $NM_cmp_auto = "";
          $NM_seq_auto = "";
          if (($this->Embutida_form || $this->Embutida_multi) && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key']))
          {
              foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key'] as $sFKName => $sFKValue)
              {
                   if (isset($this->sc_conv_var[$sFKName]))
                   {
                       $sFKName = $this->sc_conv_var[$sFKName];
                   }
                  eval("\$this->" . $sFKName . " = \"" . $sFKValue . "\";");
              }
          }
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sqlite))
          { 
              $NM_seq_auto = "NULL, ";
              $NM_cmp_auto = "id_asp_req, ";
          } 
          $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select max(id_asp_req) from " . $this->Ini->nm_tabela; 
          $comando = "select max(id_asp_req) from " . $this->Ini->nm_tabela; 
          $rs = $this->Db->Execute($comando); 
          if ($rs === false && !$rs->EOF)  
          { 
              $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_inst'], $this->Db->ErrorMsg()); 
              $this->NM_rollback_db(); 
              if ($this->NM_ajax_flag)
              {
                  form_asp_requisitos_admvo_pack_ajax_response();
              }
              exit; 
          }  
          $this->id_asp_req__before_qstr = $this->id_asp_req_ = $rs->fields[0] + 1;
          $rs->Close(); 
              $this->fecha_alta_ =  date('Y') . "-" . date('m')  . "-" . date('d') . " " . date('H') . ":" . date('i') . ":" . date('s');
              $this->fecha_alta__hora =  date('H') . ":" . date('i') . ":" . date('s');
          $bInsertOk = true;
          $aInsertOk = array(); 
          $bInsertOk = $bInsertOk && empty($aInsertOk);
          if ($bInsertOk)
          { 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
              { 
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES ($this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', #$this->fecha_revision_#, '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', #$this->fecha_alta_#, '$this->ip_alta_', '$this->login_last_', #$this->fecha_ult_act_#, '$this->ip_last_')"; 
              }
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
              { 
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (" . $NM_cmp_auto . "id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES (" . $NM_seq_auto . "$this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', " . $this->Ini->date_delim . $this->fecha_revision_ . $this->Ini->date_delim1 . ", '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', " . $this->Ini->date_delim . $this->fecha_alta_ . $this->Ini->date_delim1 . ", '$this->ip_alta_', '$this->login_last_', " . $this->Ini->date_delim . $this->fecha_ult_act_ . $this->Ini->date_delim1 . ", '$this->ip_last_')"; 
              }
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
              { 
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (" . $NM_cmp_auto . "id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES (" . $NM_seq_auto . "$this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', " . $this->Ini->date_delim . $this->fecha_revision_ . $this->Ini->date_delim1 . ", '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', " . $this->Ini->date_delim . $this->fecha_alta_ . $this->Ini->date_delim1 . ", '$this->ip_alta_', '$this->login_last_', " . $this->Ini->date_delim . $this->fecha_ult_act_ . $this->Ini->date_delim1 . ", '$this->ip_last_')"; 
              }
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
              {
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (" . $NM_cmp_auto . "id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES (" . $NM_seq_auto . "$this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', " . $this->Ini->date_delim . $this->fecha_revision_ . $this->Ini->date_delim1 . ", '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', " . $this->Ini->date_delim . $this->fecha_alta_ . $this->Ini->date_delim1 . ", '$this->ip_alta_', '$this->login_last_', " . $this->Ini->date_delim . $this->fecha_ult_act_ . $this->Ini->date_delim1 . ", '$this->ip_last_')"; 
              }
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              {
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (" . $NM_cmp_auto . "id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES (" . $NM_seq_auto . "$this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', EXTEND('$this->fecha_revision_', YEAR TO FRACTION), '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', EXTEND('$this->fecha_alta_', YEAR TO FRACTION), '$this->ip_alta_', '$this->login_last_', EXTEND('$this->fecha_ult_act_', YEAR TO FRACTION), '$this->ip_last_')"; 
              }
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
              {
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (" . $NM_cmp_auto . "id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES (" . $NM_seq_auto . "$this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', " . $this->Ini->date_delim . $this->fecha_revision_ . $this->Ini->date_delim1 . ", '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', " . $this->Ini->date_delim . $this->fecha_alta_ . $this->Ini->date_delim1 . ", '$this->ip_alta_', '$this->login_last_', " . $this->Ini->date_delim . $this->fecha_ult_act_ . $this->Ini->date_delim1 . ", '$this->ip_last_')"; 
              }
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sqlite))
              {
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (" . $NM_cmp_auto . "id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES (" . $NM_seq_auto . "$this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', " . $this->Ini->date_delim . $this->fecha_revision_ . $this->Ini->date_delim1 . ", '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', " . $this->Ini->date_delim . $this->fecha_alta_ . $this->Ini->date_delim1 . ", '$this->ip_alta_', '$this->login_last_', " . $this->Ini->date_delim . $this->fecha_ult_act_ . $this->Ini->date_delim1 . ", '$this->ip_last_')"; 
              }
              elseif ($this->Ini->nm_tpbanco == 'pdo_ibm')
              {
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (" . $NM_cmp_auto . "id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES (" . $NM_seq_auto . "$this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', " . $this->Ini->date_delim . $this->fecha_revision_ . $this->Ini->date_delim1 . ", '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', " . $this->Ini->date_delim . $this->fecha_alta_ . $this->Ini->date_delim1 . ", '$this->ip_alta_', '$this->login_last_', " . $this->Ini->date_delim . $this->fecha_ult_act_ . $this->Ini->date_delim1 . ", '$this->ip_last_')"; 
              }
              else
              {
                  $comando = "INSERT INTO " . $this->Ini->nm_tabela . " (" . $NM_cmp_auto . "id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last) VALUES (" . $NM_seq_auto . "$this->id_asp_fk_, '$this->login_fk_', $this->id_lisreq_fk_, $this->num_req_, '$this->archivo_', '$this->notas_aspirante_', $this->cc_correcto_, $this->cc_carta_, '$this->prefijo_requisito_', '$this->notas_revisor_', " . $this->Ini->date_delim . $this->fecha_revision_ . $this->Ini->date_delim1 . ", '$this->notas_internas_', $this->id_carga_req_, '$this->usu_carga_req_', '$this->ip_revision_', '$this->login_insert_', " . $this->Ini->date_delim . $this->fecha_alta_ . $this->Ini->date_delim1 . ", '$this->ip_alta_', '$this->login_last_', " . $this->Ini->date_delim . $this->fecha_ult_act_ . $this->Ini->date_delim1 . ", '$this->ip_last_')"; 
              }
              $comando = str_replace("N'null'", "null", $comando) ; 
              $comando = str_replace("'null'", "null", $comando) ; 
              $comando = str_replace("#null#", "null", $comando) ; 
              $comando = str_replace($this->Ini->date_delim . "null" . $this->Ini->date_delim1, "null", $comando) ; 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              {
                $comando = str_replace("EXTEND('', YEAR TO FRACTION)", "null", $comando) ; 
                $comando = str_replace("EXTEND(null, YEAR TO FRACTION)", "null", $comando) ; 
                $comando = str_replace("EXTEND('', YEAR TO DAY)", "null", $comando) ; 
                $comando = str_replace("EXTEND(null, YEAR TO DAY)", "null", $comando) ; 
              }  
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = $comando; 
              $rs = $this->Db->Execute($comando); 
              if ($rs === false)  
              { 
                  if (FALSE === strpos(strtoupper($this->Db->ErrorMsg()), "MAIL SENT") && FALSE === strpos(strtoupper($this->Db->ErrorMsg()), "WARNING"))
                  {
                      $dbErrorMessage = $this->Db->ErrorMsg();
                      $dbErrorCode = $this->Db->ErrorNo();
                      $this->handleDbErrorMessage($dbErrorMessage, $dbErrorCode);
                      $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_inst'], $dbErrorMessage, true);
                      if (isset($_SESSION['scriptcase']['erro_handler']) && $_SESSION['scriptcase']['erro_handler'])
                      { 
                          $this->sc_erro_insert = $dbErrorMessage;
                          $this->nmgp_opcao     = 'refresh_insert';
                          $this->NM_rollback_db(); 
                          if ($this->NM_ajax_flag)
                          {
                              form_asp_requisitos_admvo_pack_ajax_response();
                              exit; 
                          }
                      }  
                  }  
              }  
              if ('refresh_insert' != $this->nmgp_opcao)
              {
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql) || in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access) || in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase)) 
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select @@identity"; 
                  $rsy = $this->Db->Execute($_SESSION['scriptcase']['sc_sql_ult_comando']); 
                  if ($rsy === false && !$rsy->EOF)  
                  { 
                      $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
                      $this->NM_rollback_db(); 
                      if ($this->NM_ajax_flag)
                      {
                          form_asp_requisitos_admvo_pack_ajax_response();
                      }
                      exit; 
                  } 
                  $this->id_asp_req_ =  $rsy->fields[0];
                 $rsy->Close(); 
              } 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
              { 
                  {
                      $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select last_insert_id()"; 
                  }
                  $rsy = $this->Db->Execute($_SESSION['scriptcase']['sc_sql_ult_comando']); 
                  if ($rsy === false && !$rsy->EOF)  
                  { 
                      $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
                      exit; 
                  } 
                  $this->id_asp_req_ = $rsy->fields[0];
                  $rsy->Close(); 
              } 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "SELECT dbinfo('sqlca.sqlerrd1') FROM " . $this->Ini->nm_tabela; 
                  $rsy = $this->Db->Execute($_SESSION['scriptcase']['sc_sql_ult_comando']); 
                  if ($rsy === false && !$rsy->EOF)  
                  { 
                      $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
                      exit; 
                  } 
                  $this->id_asp_req_ = $rsy->fields[0];
                  $rsy->Close(); 
              } 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select .currval from dual"; 
                  $rsy = $this->Db->Execute($_SESSION['scriptcase']['sc_sql_ult_comando']); 
                  if ($rsy === false && !$rsy->EOF)  
                  { 
                      $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
                      exit; 
                  } 
                  $this->id_asp_req_ = $rsy->fields[0];
                  $rsy->Close(); 
              } 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_db2))
              { 
                  $str_tabela = "SYSIBM.SYSDUMMY1"; 
                  if($this->Ini->nm_con_use_schema == "N") 
                  { 
                          $str_tabela = "SYSDUMMY1"; 
                  } 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "SELECT IDENTITY_VAL_LOCAL() FROM " . $str_tabela; 
                  $rsy = $this->Db->Execute($_SESSION['scriptcase']['sc_sql_ult_comando']); 
                  if ($rsy === false && !$rsy->EOF)  
                  { 
                      $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
                      exit; 
                  } 
                  $this->id_asp_req_ = $rsy->fields[0];
                  $rsy->Close(); 
              } 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres))
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select CURRVAL('')"; 
                  $rsy = $this->Db->Execute($_SESSION['scriptcase']['sc_sql_ult_comando']); 
                  if ($rsy === false && !$rsy->EOF)  
                  { 
                      $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
                      exit; 
                  } 
                  $this->id_asp_req_ = $rsy->fields[0];
                  $rsy->Close(); 
              } 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sqlite))
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select last_insert_rowid()"; 
                  $rsy = $this->Db->Execute($_SESSION['scriptcase']['sc_sql_ult_comando']); 
                  if ($rsy === false && !$rsy->EOF)  
                  { 
                      $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
                      exit; 
                  } 
                  $this->id_asp_req_ = $rsy->fields[0];
                  $rsy->Close(); 
              } 
              $this->login_fk_ = $this->login_fk__before_qstr;
              $this->archivo_ = $this->archivo__before_qstr;
              $this->notas_aspirante_ = $this->notas_aspirante__before_qstr;
              $this->prefijo_requisito_ = $this->prefijo_requisito__before_qstr;
              $this->notas_revisor_ = $this->notas_revisor__before_qstr;
              $this->notas_internas_ = $this->notas_internas__before_qstr;
              $this->usu_carga_req_ = $this->usu_carga_req__before_qstr;
              $this->ip_revision_ = $this->ip_revision__before_qstr;
              $this->login_insert_ = $this->login_insert__before_qstr;
              $this->ip_alta_ = $this->ip_alta__before_qstr;
              $this->login_last_ = $this->login_last__before_qstr;
              $this->ip_last_ = $this->ip_last__before_qstr;
              }

              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['db_changed'] = true;

              $this->sc_evento = "insert"; 
              $this->login_fk_ = $this->login_fk__before_qstr;
              $this->archivo_ = $this->archivo__before_qstr;
              $this->notas_aspirante_ = $this->notas_aspirante__before_qstr;
              $this->prefijo_requisito_ = $this->prefijo_requisito__before_qstr;
              $this->notas_revisor_ = $this->notas_revisor__before_qstr;
              $this->notas_internas_ = $this->notas_internas__before_qstr;
              $this->usu_carga_req_ = $this->usu_carga_req__before_qstr;
              $this->ip_revision_ = $this->ip_revision__before_qstr;
              $this->login_insert_ = $this->login_insert__before_qstr;
              $this->ip_alta_ = $this->ip_alta__before_qstr;
              $this->login_last_ = $this->login_last__before_qstr;
              $this->ip_last_ = $this->ip_last__before_qstr;
              $this->NM_gera_log_key("incluir");
              $this->NM_gera_log_new();
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total']++; 
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_qtd']++; 
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_I_E']++; 
              $this->NM_ajax_info['navSummary']['reg_ini'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] + 1; 
              $this->NM_ajax_info['navSummary']['reg_qtd'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_qtd']; 
              $this->NM_ajax_info['navSummary']['reg_tot'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'] + 1; 
              $this->NM_gera_nav_page(); 
              $this->NM_ajax_info['navPage'] = $this->SC_nav_page; 
              $this->sc_teve_incl = true; 
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['cc_correcto_'] = $this->cc_correcto_;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['notas_revisor_'] = $this->notas_revisor_;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['num_req_'] = $this->num_req_;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['archivo_'] = $this->archivo_;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert]['notas_aspirante_'] = $this->notas_aspirante_;
              $this->restore_zeros_null();
              if (isset($this->num_req_)) { $this->nm_limpa_alfa($this->num_req_); }
              if (isset($this->archivo_)) { $this->nm_limpa_alfa($this->archivo_); }
              if (isset($this->notas_aspirante_)) { $this->nm_limpa_alfa($this->notas_aspirante_); }
              if (isset($this->cc_correcto_)) { $this->nm_limpa_alfa($this->cc_correcto_); }
              if (isset($this->notas_revisor_)) { $this->nm_limpa_alfa($this->notas_revisor_); }
              if (isset($this->Embutida_form) && $this->Embutida_form)
              {
                  $this->nm_guardar_campos();
                  $this->nm_proc_onload_record($this->nmgp_refresh_row);
                  $this->nm_formatar_campos();

                  $this->NM_ajax_info['fldList']['cc_correcto_' . $this->nmgp_refresh_row]['type']    = 'text';
                  $this->NM_ajax_info['fldList']['cc_correcto_' . $this->nmgp_refresh_row]['valList'] = array($this->form_encode_input(NM_charset_to_utf8($this->cc_correcto_)));
                  $this->NM_ajax_info['fldList']['cc_correcto_' . $this->nmgp_refresh_row]['labList'] = array($this->form_encode_input(NM_charset_to_utf8($tmpLabel_cc_correcto_)));

                  if ((isset($this->Embutida_form) && $this->Embutida_form) && (!isset($this->Embutida_ronly) || !$this->Embutida_ronly))
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['cc_correcto_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['cc_correcto_' . $this->nmgp_refresh_row] = "off";
                      }
                  }
                  elseif (isset($this->Embutida_ronly) && $this->Embutida_ronly)
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['cc_correcto_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['cc_correcto_' . $this->nmgp_refresh_row] = "on";
                      }
                  }

                  $this->notas_revisor_    = str_replace(array('\r\n', '\n\r', '\n', '\r'), array("\r\n", "\n\r", "\n", "\r"), $this->notas_revisor_);
                  $tmpLabel_notas_revisor_ = nl2br($this->notas_revisor_);
                  $this->NM_ajax_info['fldList']['notas_revisor_' . $this->nmgp_refresh_row]['type']    = 'text';
                  $this->NM_ajax_info['fldList']['notas_revisor_' . $this->nmgp_refresh_row]['valList'] = array($this->form_encode_input(NM_charset_to_utf8($this->notas_revisor_)));
                  $this->NM_ajax_info['fldList']['notas_revisor_' . $this->nmgp_refresh_row]['labList'] = array($this->form_encode_input(NM_charset_to_utf8($tmpLabel_notas_revisor_)));

                  if ((isset($this->Embutida_form) && $this->Embutida_form) && (!isset($this->Embutida_ronly) || !$this->Embutida_ronly))
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['notas_revisor_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['notas_revisor_' . $this->nmgp_refresh_row] = "off";
                      }
                  }
                  elseif (isset($this->Embutida_ronly) && $this->Embutida_ronly)
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['notas_revisor_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['notas_revisor_' . $this->nmgp_refresh_row] = "on";
                      }
                  }

                  $orig_num_req_ = $this->num_req_;
                  $num_req_      = $this->num_req_;
              nm_limpa_numero($num_req_, $this->field_config['num_req_']['symbol_grp']); 
                  $this->num_req_ = $num_req_;
                  $this->lookup_num_req_($conteudo);
                  $this->num_req_ = $orig_num_req_;
                  $this->NM_ajax_info['fldList']['num_req_' . $this->nmgp_refresh_row]['lookupCons'] = form_asp_requisitos_admvo_pack_protect_string($conteudo);
                  $this->NM_ajax_info['fldList']['num_req_' . $this->nmgp_refresh_row]['type']    = 'text';
                  $this->NM_ajax_info['fldList']['num_req_' . $this->nmgp_refresh_row]['valList'] = array($this->form_encode_input(NM_charset_to_utf8($this->num_req_)));
                  $this->NM_ajax_info['fldList']['num_req_' . $this->nmgp_refresh_row]['labList'] = array($this->form_encode_input(NM_charset_to_utf8($tmpLabel_num_req_)));

                  if ((isset($this->Embutida_form) && $this->Embutida_form) && (!isset($this->Embutida_ronly) || !$this->Embutida_ronly))
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['num_req_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['num_req_' . $this->nmgp_refresh_row] = "off";
                      }
                  }
                  elseif (isset($this->Embutida_ronly) && $this->Embutida_ronly)
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['num_req_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['num_req_' . $this->nmgp_refresh_row] = "on";
                      }
                  }

                  $this->NM_ajax_info['fldList']['archivo_' . $this->nmgp_refresh_row]['type']    = 'text';
                  $this->NM_ajax_info['fldList']['archivo_' . $this->nmgp_refresh_row]['valList'] = array($this->form_encode_input(NM_charset_to_utf8($this->archivo_)));
                  $this->NM_ajax_info['fldList']['archivo_' . $this->nmgp_refresh_row]['labList'] = array($this->form_encode_input(NM_charset_to_utf8($tmpLabel_archivo_)));

                  if ((isset($this->Embutida_form) && $this->Embutida_form) && (!isset($this->Embutida_ronly) || !$this->Embutida_ronly))
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['archivo_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['archivo_' . $this->nmgp_refresh_row] = "off";
                      }
                  }
                  elseif (isset($this->Embutida_ronly) && $this->Embutida_ronly)
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['archivo_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['archivo_' . $this->nmgp_refresh_row] = "on";
                      }
                  }

                  $this->NM_ajax_info['fldList']['notas_aspirante_' . $this->nmgp_refresh_row]['type']    = 'text';
                  $this->NM_ajax_info['fldList']['notas_aspirante_' . $this->nmgp_refresh_row]['valList'] = array($this->form_encode_input(NM_charset_to_utf8($this->notas_aspirante_)));
                  $this->NM_ajax_info['fldList']['notas_aspirante_' . $this->nmgp_refresh_row]['labList'] = array($this->form_encode_input(NM_charset_to_utf8($tmpLabel_notas_aspirante_)));

                  if ((isset($this->Embutida_form) && $this->Embutida_form) && (!isset($this->Embutida_ronly) || !$this->Embutida_ronly))
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['notas_aspirante_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['notas_aspirante_' . $this->nmgp_refresh_row] = "off";
                      }
                  }
                  elseif (isset($this->Embutida_ronly) && $this->Embutida_ronly)
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['notas_aspirante_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['notas_aspirante_' . $this->nmgp_refresh_row] = "on";
                      }
                  }

                  $tmpLabel_id_asp_req_ = $this->id_asp_req_;
                  $this->NM_ajax_info['fldList']['id_asp_req_' . $this->nmgp_refresh_row]['type']    = 'label';
                  $this->NM_ajax_info['fldList']['id_asp_req_' . $this->nmgp_refresh_row]['valList'] = array($this->form_encode_input(NM_charset_to_utf8($this->id_asp_req_)));
                  $this->NM_ajax_info['fldList']['id_asp_req_' . $this->nmgp_refresh_row]['labList'] = array($this->form_encode_input(NM_charset_to_utf8($tmpLabel_id_asp_req_)));

                  if ((isset($this->Embutida_form) && $this->Embutida_form) && (!isset($this->Embutida_ronly) || !$this->Embutida_ronly))
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['id_asp_req_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['id_asp_req_' . $this->nmgp_refresh_row] = "on";
                      }
                  }
                  elseif (isset($this->Embutida_ronly) && $this->Embutida_ronly)
                  {
                      if (!isset($this->NM_ajax_info['readOnly']['id_asp_req_' . $this->nmgp_refresh_row]))
                      {
                          $this->NM_ajax_info['readOnly']['id_asp_req_' . $this->nmgp_refresh_row] = "on";
                      }
                  }


                  $this->nm_tira_formatacao();

                  $this->NM_ajax_info['closeLine'] = $this->nmgp_refresh_row;
              }
              if ('refresh_insert' != $this->nmgp_opcao && (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_insert']) || $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_redir_insert'] != "S"))
              {
              $this->nmgp_opcao = "novo"; 
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "F" || $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "R")
              { 
                   $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['return_edit'] = "new";
              } 
              }
              $this->nm_flag_iframe = true;
          } 
          if ($this->lig_edit_lookup)
          {
              $this->lig_edit_lookup_call = true;
          }
      } 
      if ($this->nmgp_opcao == "excluir") 
      { 
          $this->id_asp_req_ = substr($this->Db->qstr($this->id_asp_req_), 1, -1); 

          $bDelecaoOk = true;
          $sMsgErro   = '';

          if ($bDelecaoOk)
          {

          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_"; 
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_"; 
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_"; 
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_"; 
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          else  
          {
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = "select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_"; 
              $rs1 = $this->Db->Execute("select count(*) AS countTest from " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
          }  
          if ($rs1 === false)  
          { 
              $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
              exit; 
          }  
          if ($rs1 === false)  
          { 
              $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dbas'], $this->Db->ErrorMsg()); 
              exit; 
          }  
          $tmp_result = (int) $rs1->fields[0]; 
          if ($tmp_result != 1) 
          { 
              $this->Campos_Mens_erro = $this->Ini->Nm_lang['lang_errm_dele_nfnd']; 
              $this->nmgp_opcao = "nada"; 
              $this->sc_evento = 'delete';
          } 
          else 
          { 
              $rs1->Close(); 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
              {
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "; 
                  $rs = $this->Db->Execute("DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
              }  
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
              {
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "; 
                  $rs = $this->Db->Execute("DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
              }  
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
              {
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "; 
                  $rs = $this->Db->Execute("DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
              }  
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              {
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "; 
                  $rs = $this->Db->Execute("DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
              }  
              else  
              {
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "; 
                  $rs = $this->Db->Execute("DELETE FROM " . $this->Ini->nm_tabela . " where id_asp_req = $this->id_asp_req_ "); 
              }  
              if ($rs === false) 
              { 
                  $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dele'], $this->Db->ErrorMsg(), true); 
                  if (isset($_SESSION['scriptcase']['erro_handler']) && $_SESSION['scriptcase']['erro_handler']) 
                  { 
                      $this->sc_erro_delete = $this->Db->ErrorMsg();  
                      $this->NM_rollback_db(); 
                      if ($this->NM_ajax_flag)
                      {
                          form_asp_requisitos_admvo_pack_ajax_response();
                          exit; 
                      }
                  } 
              } 
              $this->sc_evento = "delete"; 
              $this->nm_proc_onload_record($sc_seq_vert);
              $this->nmgp_opcao = "avanca"; 
              $this->nm_flag_iframe = true;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start']--; 
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] < 0)
              {
                  $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = 0; 
              }

              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['db_changed'] = true;

              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_qtd']--; 
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total']--; 
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_I_E']--; 
              $this->NM_ajax_info['navSummary']['reg_ini'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] + 1; 
              $this->NM_ajax_info['navSummary']['reg_qtd'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_qtd']; 
              $this->NM_ajax_info['navSummary']['reg_tot'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'] + 1; 
              $this->NM_gera_nav_page(); 
              $this->NM_ajax_info['navPage'] = $this->SC_nav_page; 
              $this->sc_teve_excl = true; 
              if ($this->lig_edit_lookup)
              {
                  $this->lig_edit_lookup_call = true;
              }
          }

          }
          else
          {
              $this->sc_evento = "delete"; 
              $this->nmgp_opcao = "igual"; 
              $this->Erro->mensagem(__FILE__, __LINE__, "critica", $sMsgErro); 
          }

      }  
      $this->restore_zeros_null();
    if ("update" == $this->sc_evento && $this->nmgp_opcao != "nada") {
        $_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'on';
if (isset($this->NM_ajax_flag) && $this->NM_ajax_flag)
{
    $original_archivo_ = $this->archivo_;
    $original_num_req_ = $this->num_req_;
}
  $this->chg_filename($this->archivo_ );
if (isset($this->NM_ajax_flag) && $this->NM_ajax_flag)
{
    if (($original_archivo_ != $this->archivo_ || (isset($bFlagRead_archivo_) && $bFlagRead_archivo_))&& isset($this->nmgp_refresh_row))
    {
        $this->NM_ajax_info['fldList']['archivo_' . $this->nmgp_refresh_row]['type']    = 'text';
        $this->NM_ajax_info['fldList']['archivo_' . $this->nmgp_refresh_row]['valList'] = array($this->archivo_);
        $this->NM_ajax_changed['archivo_'] = true;
    }
    if (($original_num_req_ != $this->num_req_ || (isset($bFlagRead_num_req_) && $bFlagRead_num_req_))&& isset($this->nmgp_refresh_row))
    {
        $this->NM_ajax_info['fldList']['num_req_' . $this->nmgp_refresh_row]['type']    = 'text';
        $this->NM_ajax_info['fldList']['num_req_' . $this->nmgp_refresh_row]['valList'] = array($this->num_req_);
        $this->NM_ajax_changed['num_req_'] = true;
    }
}
$_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'off'; 
    }
      if (!empty($this->Campos_Mens_erro)) 
      {
          return;
      }
      if ($salva_opcao == "incluir" && $GLOBALS["erro_incl"] != 1) 
      { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['parms'] = "id_asp_req_?#?$this->id_asp_req_?@?"; 
      }
      if ($this->sc_evento != "insert" && $this->sc_evento != "update" && $this->sc_evento != "delete")
      { 
          $this->id_asp_req_ = null === $this->id_asp_req_ ? null : substr($this->Db->qstr($this->id_asp_req_), 1, -1); 
      } 
   }
//---------- 
   function nm_select_banco() 
   { 
      global $nm_form_submit, $sc_seq_vert, $sc_check_incl, $teste_validade, $sc_where;
 
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['rows']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['rows']))
      {
          $this->sc_max_reg = $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['rows'];
      } 
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['rows_ins']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['rows_ins']))
      {
          $this->sc_max_reg_incl = $_SESSION['scriptcase']['sc_apl_conf']['form_asp_requisitos_admvo']['rows_ins'];
      } 
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_qtd_reg']) && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_qtd_reg'])
      {
          $this->sc_max_reg = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_qtd_reg'];
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_max_reg']) && ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_max_reg'] > 0 || strtolower($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_max_reg']) == "all"))
      {
          $this->sc_max_reg = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_max_reg'];
      } 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $GLOBALS["NM_ERRO_IBASE"] = 0;  
      $this->form_vert_form_asp_requisitos_admvo = array();
      if ($this->nmgp_opcao != "novo") 
      { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['parms'] = ""; 
      } 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_ibase))
      { 
          $GLOBALS["NM_ERRO_IBASE"] = 1;  
      } 
      if ($this->sc_teve_excl)
      {
          $this->nmgp_opcao = "avanca";
          if ($this->sc_max_reg != 'all') {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] -= $this->sc_max_reg;
          } 
      }
      if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start']) || empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = 0;
      }
      if (isset($this->NM_where_filter))
      {
          $this->NM_where_filter = str_replace("@percent@", "%", $this->NM_where_filter);
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter'] = trim($this->NM_where_filter);
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total']))
          {
              unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total']);
          }
      }
      $sc_where_filter = '';
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter_form']) && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter_form'])
      {
          $sc_where_filter = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter_form'];
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter']) && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter'] && $sc_where_filter != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter'])
      {
          if (empty($sc_where_filter))
          {
              $sc_where_filter = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter'];
          }
          else
          {
              $sc_where_filter .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter'] . ")";
          }
      }
      $sc_where = "";
      if ('' != $sc_where_filter)
      {
          $sc_where = (isset($sc_where) && '' != $sc_where) ? $sc_where . ' and (' . $sc_where_filter . ')' : ' where ' . $sc_where_filter;
      }
      if (((isset($this->NM_ajax_opcao) && 'backup_line' == $this->NM_ajax_opcao) || (isset($this->NM_btn_navega) && 'N' == $this->NM_btn_navega)) && !$this->has_where_params && 'novo' != $this->nmgp_opcao)
      {
          $aNewWhereCond = array();
          if (null != $this->id_asp_req_)
          {
              $aNewWhereCond[] = "id_asp_req = " . $this->id_asp_req_;
          }
          if (!$this->NM_ajax_flag)
          {
              $this->NM_btn_navega = "S";
          }
          elseif (!empty($aNewWhereCond))
          {
              if ('' == $sc_where)
              {
                  $sc_where = " where (";
              }
              else
              {
                  $sc_where .= " and (";
              }
              $sc_where .= implode(" and ", $aNewWhereCond) . ")";
          }
      }
      if ('total' != $this->form_paginacao)
      {
          if ($this->app_is_initializing || $this->sc_teve_excl || $this->sc_teve_incl || (isset($_POST['master_nav']) && 'on' == $_POST['master_nav']) || !isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total']))
          {
              $nmgp_select = "SELECT count(*) AS countTest from " . $this->Ini->nm_tabela . $sc_where;
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
              $rt = $this->Db->Execute($nmgp_select);
              if ($rt === false && !$rt->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
              {
                  $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
                  exit;
              }
              $qt_geral_reg_form_asp_requisitos_admvo = isset($rt->fields[0]) ? $rt->fields[0] - 1 : 0;
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'] = $qt_geral_reg_form_asp_requisitos_admvo;
              $rt->Close();
          }
      if ((isset($_POST['master_nav']) && 'on' == $_POST['master_nav']) || !isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total']))
      { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_I_E'] = 0; 
          if (!$this->sc_teve_excl && !$this->sc_teve_incl) 
          { 
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = 0; 
          } 
          if ($this->nmgp_opcao == "igual" && isset($this->NM_btn_navega) && 'S' == $this->NM_btn_navega && !empty($this->id_asp_req_))
          {
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
              {
                  $Key_Where = "id_asp_req < $this->id_asp_req_ "; 
              }  
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
              {
                  $Key_Where = "id_asp_req < $this->id_asp_req_ "; 
              }
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
              {
                  $Key_Where = "id_asp_req < $this->id_asp_req_ "; 
              }
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              {
                  $Key_Where = "id_asp_req < $this->id_asp_req_ "; 
              }
              else  
              {
                  $Key_Where = "id_asp_req < $this->id_asp_req_ "; 
              }
              $Where_Start = (empty($sc_where)) ? " where " . $Key_Where :  $sc_where . " and (" . $Key_Where . ")";
              $nmgp_select = "SELECT count(*) AS countTest from " . $this->Ini->nm_tabela . $Where_Start; 
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
              $rt = $this->Db->Execute($nmgp_select) ; 
              if ($rt === false && !$rt->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1) 
              { 
                  $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
                  exit ; 
              }  
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = $rt->fields[0];
              $rt->Close(); 
          }
      } 
      else 
      { 
          $qt_geral_reg_form_asp_requisitos_admvo = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'];
      } 
      if ($this->nmgp_opcao == "inicio" || $this->nmgp_opcao == "ordem") 
      { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = 0; 
      } 
      if ($this->nmgp_opcao == "navpage" && ($this->nmgp_ordem - 1) <= $qt_geral_reg_form_asp_requisitos_admvo) 
      { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = $this->nmgp_ordem - 1; 
      } 
      if ($this->nmgp_opcao == "avanca")  
      { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] += ($this->sc_max_reg + $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_I_E']); 
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] > $qt_geral_reg_form_asp_requisitos_admvo)
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = $qt_geral_reg_form_asp_requisitos_admvo - $this->sc_max_reg; 
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] < 0)
              {
                  $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = 0; 
              }
          }
      } 
      if ($this->nmgp_opcao == "retorna") 
      { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] -= $this->sc_max_reg; 
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] < 0)
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = 0; 
          }
      } 
      if ($this->nmgp_opcao == "final") 
      { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = ($qt_geral_reg_form_asp_requisitos_admvo + 1) - $this->sc_max_reg; 
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] < 0)
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] = 0; 
          }
      } 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_I_E'] = 0; 
      }
      $Cmps_ord_def = array();
      $sc_order_by  = "";
      $sc_order_by = "id_asp_req";
      $sc_order_by = str_replace("order by ", "", $sc_order_by);
      $sc_order_by = str_replace("ORDER BY ", "", trim($sc_order_by));
      if (!empty($sc_order_by))
      {
          $sc_order_by = " order by $sc_order_by "; 
      }
      if ($this->nmgp_opcao == "ordem" && in_array($this->nmgp_ordem, $Cmps_ord_def)) 
      { 
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_cmp'] != $this->nmgp_ordem)
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_cmp'] = $this->nmgp_ordem; 
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' asc'; 
              switch ($this->nmgp_ordem) {
                  case "cc_correcto":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "num_req":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "id_asp_req":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "id_asp_FK":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "id_lisreq_FK":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "cc_carta":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "fecha_revision":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "notas_internas":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "id_carga_req":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "fecha_alta":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  case "fecha_ult_act":
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc';
                      break;
                  default:
                      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' asc';
                      break;
              }
          }
          elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] == ' asc')
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' desc'; 
          }
          else
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] = ' asc'; 
          }
      } 
      if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_cmp'])) 
      { 
          $sc_order_by = " order by " . $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_cmp'] . $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord']; 
      } 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
          $nmgp_select = "SELECT id_asp_req, id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, str_replace (convert(char(10),fecha_revision,102), '.', '-') + ' ' + convert(char(8),fecha_revision,20), notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, str_replace (convert(char(10),fecha_alta,102), '.', '-') + ' ' + convert(char(8),fecha_alta,20), ip_alta, login_last, str_replace (convert(char(10),fecha_ult_act,102), '.', '-') + ' ' + convert(char(8),fecha_ult_act,20), ip_last from " . $this->Ini->nm_tabela . $sc_where . $sc_order_by; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nmgp_select = "SELECT id_asp_req, id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, convert(char(23),fecha_revision,121), notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, convert(char(23),fecha_alta,121), ip_alta, login_last, convert(char(23),fecha_ult_act,121), ip_last from " . $this->Ini->nm_tabela . $sc_where . $sc_order_by; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
          $nmgp_select = "SELECT id_asp_req, id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last from " . $this->Ini->nm_tabela . $sc_where . $sc_order_by; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
      { 
          $nmgp_select = "SELECT id_asp_req, id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, EXTEND(fecha_revision, YEAR TO FRACTION), notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, EXTEND(fecha_alta, YEAR TO FRACTION), ip_alta, login_last, EXTEND(fecha_ult_act, YEAR TO FRACTION), ip_last from " . $this->Ini->nm_tabela . $sc_where . $sc_order_by; 
      } 
      else 
      { 
          $nmgp_select = "SELECT id_asp_req, id_asp_FK, login_FK, id_lisreq_FK, num_req, archivo, notas_aspirante, cc_correcto, cc_carta, prefijo_requisito, notas_revisor, fecha_revision, notas_internas, id_carga_req, usu_carga_req, ip_revision, login_insert, fecha_alta, ip_alta, login_last, fecha_ult_act, ip_last from " . $this->Ini->nm_tabela . $sc_where . $sc_order_by; 
      } 
      if ($this->nmgp_opcao != "novo") 
      { 
      if (isset($this->NM_ajax_opcao) && 'backup_line' == $this->NM_ajax_opcao)
      {
          $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
          $rs = $this->Db->Execute($nmgp_select) ;
      }
      elseif ('total' == $this->form_paginacao)
      {
          $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
          $rs = $this->Db->Execute($nmgp_select) ; 
      }
      else
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "F" || $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "R")
          { 
              $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
              $rs = $this->Db->Execute($nmgp_select) ; 
          } 
          else 
          { 
              if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql) || in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres) || in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle) || in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_ibase) || in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_db2))
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "SelectLimit($nmgp_select, $this->sc_max_reg, " . $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] . ")" ; 
                  $rs = $this->Db->SelectLimit($nmgp_select, $this->sc_max_reg, $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start']) ; 
              } 
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "SelectLimit($nmgp_select, $this->sc_max_reg, " . $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] . ")" ; 
                  $rs = $this->Db->SelectLimit($nmgp_select, $this->sc_max_reg, $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start']) ; 
              } 
              elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = "SelectLimit($nmgp_select, $this->sc_max_reg, " . $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] . ")" ; 
                  $rs = $this->Db->SelectLimit($nmgp_select, $this->sc_max_reg, $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start']) ; 
              } 
              else  
              { 
                  $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
                  $rs = $this->Db->Execute($nmgp_select) ; 
                  if (!$rs === false && !$rs->EOF) 
                  { 
                      $rs->Move($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start']) ;  
                  } 
              } 
          } 
      }
          if ($rs === false && !$rs->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1) 
          { 
              $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
              exit ; 
          }  
          if ($rs === false && $GLOBALS["NM_ERRO_IBASE"] == 1) 
          { 
              $GLOBALS["NM_ERRO_IBASE"] = 0; 
              $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_nfnd_extr'], $this->Db->ErrorMsg()); 
              exit ; 
          }  
          if ($rs->EOF && $this->nmgp_botoes['new'] != "on")
          {
              $this->nmgp_form_empty = true;
          }
          if ($rs->EOF)
          {
              $sc_seq_vert = 0; 
              if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter']))
              {
                  $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['empty_filter'] = true;
              }
          }
          else
          {
              $sc_seq_vert = 1; 
          }
          if ('total' == $this->form_paginacao)
          {
              $bPagTest = true;
              $this->sc_max_reg = 0;
          }
          else
          {
              $bPagTest = $sc_seq_vert <= $this->sc_max_reg;
          }
          if (!$rs->EOF && (!$this->NM_ajax_flag || !isset($this->nmgp_refresh_fields))) {
              $this->nm_proc_onload(false);
          }
          $this->summary_record_count = 0;
          while (!$rs->EOF && $bPagTest)
          { 
              $this->summary_record_count++;
              if ('total' == $this->form_paginacao)
              {
                  $this->sc_max_reg++;
              }
              if (isset($this->NM_ajax_opcao) && 'backup_line' == $this->NM_ajax_opcao)
              {
                  $guard_seq_vert = $sc_seq_vert;
                  $sc_seq_vert    = $this->nmgp_refresh_row;
              }
              if ('total' != $this->form_paginacao)
              {
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "F" || $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "R")
              { 
                  $this->sc_max_reg++;
              } 
              }
              $this->id_asp_req_ = $rs->fields[0] ; 
              $this->nmgp_dados_select['id_asp_req_'] = $this->id_asp_req_;
              $this->id_asp_fk_ = $rs->fields[1] ; 
              $this->nmgp_dados_select['id_asp_fk_'] = $this->id_asp_fk_;
              $this->login_fk_ = $rs->fields[2] ; 
              $this->nmgp_dados_select['login_fk_'] = $this->login_fk_;
              $this->id_lisreq_fk_ = $rs->fields[3] ; 
              $this->nmgp_dados_select['id_lisreq_fk_'] = $this->id_lisreq_fk_;
              $this->num_req_ = $rs->fields[4] ; 
              $this->nmgp_dados_select['num_req_'] = $this->num_req_;
              $this->archivo_ = $rs->fields[5] ; 
              $this->nmgp_dados_select['archivo_'] = $this->archivo_;
              $this->notas_aspirante_ = $rs->fields[6] ; 
              $this->nmgp_dados_select['notas_aspirante_'] = $this->notas_aspirante_;
              $this->cc_correcto_ = $rs->fields[7] ; 
              $this->nmgp_dados_select['cc_correcto_'] = $this->cc_correcto_;
              $this->cc_carta_ = $rs->fields[8] ; 
              $this->nmgp_dados_select['cc_carta_'] = $this->cc_carta_;
              $this->prefijo_requisito_ = $rs->fields[9] ; 
              $this->nmgp_dados_select['prefijo_requisito_'] = $this->prefijo_requisito_;
              $this->notas_revisor_ = $rs->fields[10] ; 
              $this->nmgp_dados_select['notas_revisor_'] = $this->notas_revisor_;
              $this->fecha_revision_ = $rs->fields[11] ; 
              if (substr($this->fecha_revision_, 10, 1) == "-") 
              { 
                 $this->fecha_revision_ = substr($this->fecha_revision_, 0, 10) . " " . substr($this->fecha_revision_, 11);
              } 
              if (substr($this->fecha_revision_, 13, 1) == ".") 
              { 
                 $this->fecha_revision_ = substr($this->fecha_revision_, 0, 13) . ":" . substr($this->fecha_revision_, 14, 2) . ":" . substr($this->fecha_revision_, 17);
              } 
              $this->nmgp_dados_select['fecha_revision_'] = $this->fecha_revision_;
              $this->notas_internas_ = $rs->fields[12] ; 
              $this->nmgp_dados_select['notas_internas_'] = $this->notas_internas_;
              $this->id_carga_req_ = $rs->fields[13] ; 
              $this->nmgp_dados_select['id_carga_req_'] = $this->id_carga_req_;
              $this->usu_carga_req_ = $rs->fields[14] ; 
              $this->nmgp_dados_select['usu_carga_req_'] = $this->usu_carga_req_;
              $this->ip_revision_ = $rs->fields[15] ; 
              $this->nmgp_dados_select['ip_revision_'] = $this->ip_revision_;
              $this->login_insert_ = $rs->fields[16] ; 
              $this->nmgp_dados_select['login_insert_'] = $this->login_insert_;
              $this->fecha_alta_ = $rs->fields[17] ; 
              if (substr($this->fecha_alta_, 10, 1) == "-") 
              { 
                 $this->fecha_alta_ = substr($this->fecha_alta_, 0, 10) . " " . substr($this->fecha_alta_, 11);
              } 
              if (substr($this->fecha_alta_, 13, 1) == ".") 
              { 
                 $this->fecha_alta_ = substr($this->fecha_alta_, 0, 13) . ":" . substr($this->fecha_alta_, 14, 2) . ":" . substr($this->fecha_alta_, 17);
              } 
              $this->nmgp_dados_select['fecha_alta_'] = $this->fecha_alta_;
              $this->ip_alta_ = $rs->fields[18] ; 
              $this->nmgp_dados_select['ip_alta_'] = $this->ip_alta_;
              $this->login_last_ = $rs->fields[19] ; 
              $this->nmgp_dados_select['login_last_'] = $this->login_last_;
              $this->fecha_ult_act_ = $rs->fields[20] ; 
              if (substr($this->fecha_ult_act_, 10, 1) == "-") 
              { 
                 $this->fecha_ult_act_ = substr($this->fecha_ult_act_, 0, 10) . " " . substr($this->fecha_ult_act_, 11);
              } 
              if (substr($this->fecha_ult_act_, 13, 1) == ".") 
              { 
                 $this->fecha_ult_act_ = substr($this->fecha_ult_act_, 0, 13) . ":" . substr($this->fecha_ult_act_, 14, 2) . ":" . substr($this->fecha_ult_act_, 17);
              } 
              $this->nmgp_dados_select['fecha_ult_act_'] = $this->fecha_ult_act_;
              $this->ip_last_ = $rs->fields[21] ; 
              $this->nmgp_dados_select['ip_last_'] = $this->ip_last_;
              $GLOBALS["NM_ERRO_IBASE"] = 0; 
              $this->id_asp_req_ = (string)$this->id_asp_req_; 
              $this->id_asp_fk_ = (string)$this->id_asp_fk_; 
              $this->id_lisreq_fk_ = (string)$this->id_lisreq_fk_; 
              $this->num_req_ = (string)$this->num_req_; 
              $this->cc_correcto_ = (string)$this->cc_correcto_; 
              $this->cc_carta_ = (string)$this->cc_carta_; 
              $this->id_carga_req_ = (string)$this->id_carga_req_; 
              if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['parms'])) 
              { 
                  $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['parms'] = "id_asp_req_?#?$this->id_asp_req_?@?";
              } 
              $this->nm_proc_onload_record($sc_seq_vert);
              $this->storeRecordState($sc_seq_vert);
//
//-- 
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert] = $this->nmgp_dados_select;
              $this->nm_guardar_campos();
              $this->nm_formatar_campos();
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['cc_correcto_'] =  $this->cc_correcto_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_revisor_'] =  $this->notas_revisor_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['num_req_'] =  $this->num_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['archivo_'] =  $this->archivo_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_aspirante_'] =  $this->notas_aspirante_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_asp_req_'] =  $this->id_asp_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_asp_fk_'] =  $this->id_asp_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_fk_'] =  $this->login_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_lisreq_fk_'] =  $this->id_lisreq_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['cc_carta_'] =  $this->cc_carta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['prefijo_requisito_'] =  $this->prefijo_requisito_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_revision_'] =  $this->fecha_revision_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_revision__hora'] =  $this->fecha_revision__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_internas_'] =  $this->notas_internas_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_internas__hora'] =  $this->notas_internas__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_carga_req_'] =  $this->id_carga_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['usu_carga_req_'] =  $this->usu_carga_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_revision_'] =  $this->ip_revision_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_insert_'] =  $this->login_insert_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_alta_'] =  $this->fecha_alta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_alta__hora'] =  $this->fecha_alta__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_alta_'] =  $this->ip_alta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_last_'] =  $this->login_last_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_ult_act_'] =  $this->fecha_ult_act_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_ult_act__hora'] =  $this->fecha_ult_act__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_last_'] =  $this->ip_last_; 
              $sc_seq_vert++; 
              $rs->MoveNext() ; 
              if (isset($this->NM_ajax_opcao) && 'backup_line' == $this->NM_ajax_opcao)
              {
                  $sc_seq_vert = $guard_seq_vert;
              }
              if ('total' != $this->form_paginacao)
              {
                  $bPagTest = $sc_seq_vert <= $this->sc_max_reg;
              }
          } 
          ksort ($this->form_vert_form_asp_requisitos_admvo); 
          $rs->Close(); 
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_qtd'] = $sc_seq_vert + $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] - 1;
          if ('total' == $this->form_paginacao)
          {
              $this->NM_ajax_info['navSummary']['reg_ini'] = 1; 
              $this->NM_ajax_info['navSummary']['reg_qtd'] = $this->sc_max_reg; 
              $this->NM_ajax_info['navSummary']['reg_tot'] = $this->sc_max_reg; 
          }
          else
          {
              $this->NM_ajax_info['navSummary']['reg_ini'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] + 1; 
              $this->NM_ajax_info['navSummary']['reg_qtd'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_qtd']; 
              $this->NM_ajax_info['navSummary']['reg_tot'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'] + 1; 
          }
          if ($this->form_paginacao == "total")
          {
              $this->SC_nav_page = "";
          }
          else
          {
              $this->NM_gera_nav_page(); 
          }
          $this->NM_ajax_info['navPage'] = $this->SC_nav_page; 
          if (!$this->NM_ajax_flag || 'backup_line' != $this->NM_ajax_opcao)
          {
              $this->Nav_permite_ret = 0 != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'];
              $this->Nav_permite_ava = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] < (($qt_geral_reg_form_asp_requisitos_admvo + 1) - $this->sc_max_reg);
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opcao'] = '';
          }
      } 
      if ($this->nmgp_opcao == "novo") 
      { 
          $sc_seq_vert = 1; 
          $sc_check_incl = array(); 
          if ($this->NM_ajax_flag && 'add_new_line' == $this->NM_ajax_opcao) 
          { 
              $sc_seq_vert = $this->sc_seq_vert; 
              $this->sc_evento = "novo"; 
              $this->sc_max_reg_incl = $this->sc_seq_vert; 
          } 
          elseif (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_multi']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_multi']) 
          { 
          } 
          else 
          { 
              $this->sc_max_reg_incl = 0; 
          } 
          while ($sc_seq_vert <= $this->sc_max_reg_incl) 
          { 
              $this->num_req_ = "";  
              $this->archivo_ = "";  
              $this->notas_aspirante_ = "";  
              $this->cc_correcto_ = "";  
              $this->notas_revisor_ = "";  
              $this->nm_proc_onload_record($sc_seq_vert);
              if (($this->Embutida_form || $this->Embutida_multi) && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key']))
              {
                  foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['foreign_key'] as $sFKName => $sFKValue)
                  {
                      if (isset($this->sc_conv_var[$sFKName]))
                      {
                          $sFKName = $this->sc_conv_var[$sFKName];
                      }
                      eval("\$this->" . $sFKName . " = \"" . $sFKValue . "\";");
                  }
              }
              $this->nm_guardar_campos();
              $this->nm_formatar_campos();
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['cc_correcto_'] =  $this->cc_correcto_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_revisor_'] =  $this->notas_revisor_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['num_req_'] =  $this->num_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['archivo_'] =  $this->archivo_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_aspirante_'] =  $this->notas_aspirante_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_asp_req_'] =  $this->id_asp_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_asp_fk_'] =  $this->id_asp_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_fk_'] =  $this->login_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_lisreq_fk_'] =  $this->id_lisreq_fk_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['cc_carta_'] =  $this->cc_carta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['prefijo_requisito_'] =  $this->prefijo_requisito_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_revision_'] =  $this->fecha_revision_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_revision__hora'] =  $this->fecha_revision__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_internas_'] =  $this->notas_internas_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['notas_internas__hora'] =  $this->notas_internas__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['id_carga_req_'] =  $this->id_carga_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['usu_carga_req_'] =  $this->usu_carga_req_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_revision_'] =  $this->ip_revision_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_insert_'] =  $this->login_insert_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_alta_'] =  $this->fecha_alta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_alta__hora'] =  $this->fecha_alta__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_alta_'] =  $this->ip_alta_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['login_last_'] =  $this->login_last_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_ult_act_'] =  $this->fecha_ult_act_; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['fecha_ult_act__hora'] =  $this->fecha_ult_act__hora; 
             $this->form_vert_form_asp_requisitos_admvo[$sc_seq_vert]['ip_last_'] =  $this->ip_last_; 
              $sc_seq_vert++; 
          } 
          if (!$this->NM_ajax_flag || !isset($this->nmgp_refresh_fields)) {
              $this->nm_proc_onload(false);
          }
      }  
  }
// 
   function NM_gera_log_key($evt) 
   {
       $this->SC_log_arr = array();
       $this->SC_log_atv = true;
       if ($evt == "incluir")
       {
           $this->SC_log_evt = "insert";
       }
       if ($evt == "alterar")
       {
           $this->SC_log_evt = "update";
       }
       if ($evt == "excluir")
       {
           $this->SC_log_evt = "delete";
       }
       $this->SC_log_arr['keys']['id_asp_req'] =  $this->id_asp_req_;
   }
// 
   function NM_gera_log_old($sc_seq_vert) 
   {
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert] ))
       {
           $nmgp_dados_select = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dados_select'][$sc_seq_vert] ;
           $this->SC_log_arr['fields']['id_asp_FK']['0'] =  $nmgp_dados_select['id_asp_fk_'];
           $this->SC_log_arr['fields']['login_FK']['0'] =  $nmgp_dados_select['login_fk_'];
           $this->SC_log_arr['fields']['id_lisreq_FK']['0'] =  $nmgp_dados_select['id_lisreq_fk_'];
           $this->SC_log_arr['fields']['num_req']['0'] =  $nmgp_dados_select['num_req_'];
           $this->SC_log_arr['fields']['archivo']['0'] =  $nmgp_dados_select['archivo_'];
           $this->SC_log_arr['fields']['notas_aspirante']['0'] =  $nmgp_dados_select['notas_aspirante_'];
           $this->SC_log_arr['fields']['cc_correcto']['0'] =  $nmgp_dados_select['cc_correcto_'];
           $this->SC_log_arr['fields']['cc_carta']['0'] =  $nmgp_dados_select['cc_carta_'];
           $this->SC_log_arr['fields']['prefijo_requisito']['0'] =  $nmgp_dados_select['prefijo_requisito_'];
           $this->SC_log_arr['fields']['notas_revisor']['0'] =  $nmgp_dados_select['notas_revisor_'];
           $this->SC_log_arr['fields']['fecha_revision']['0'] =  $nmgp_dados_select['fecha_revision_'];
           $this->SC_log_arr['fields']['notas_internas']['0'] =  $nmgp_dados_select['notas_internas_'];
           $this->SC_log_arr['fields']['id_carga_req']['0'] =  $nmgp_dados_select['id_carga_req_'];
           $this->SC_log_arr['fields']['usu_carga_req']['0'] =  $nmgp_dados_select['usu_carga_req_'];
           $this->SC_log_arr['fields']['ip_revision']['0'] =  $nmgp_dados_select['ip_revision_'];
           $this->SC_log_arr['fields']['login_insert']['0'] =  $nmgp_dados_select['login_insert_'];
           $this->SC_log_arr['fields']['fecha_alta']['0'] =  $nmgp_dados_select['fecha_alta_'];
           $this->SC_log_arr['fields']['ip_alta']['0'] =  $nmgp_dados_select['ip_alta_'];
           $this->SC_log_arr['fields']['login_last']['0'] =  $nmgp_dados_select['login_last_'];
           $this->SC_log_arr['fields']['fecha_ult_act']['0'] =  $nmgp_dados_select['fecha_ult_act_'];
           $this->SC_log_arr['fields']['ip_last']['0'] =  $nmgp_dados_select['ip_last_'];
       }
   }
// 
   function NM_gera_log_new() 
   {
       $this->SC_log_arr['fields']['id_asp_FK']['1'] =  $this->id_asp_fk_;
       $this->SC_log_arr['fields']['login_FK']['1'] =  $this->login_fk_;
       $this->SC_log_arr['fields']['id_lisreq_FK']['1'] =  $this->id_lisreq_fk_;
       $this->SC_log_arr['fields']['num_req']['1'] =  $this->num_req_;
       $this->SC_log_arr['fields']['archivo']['1'] =  $this->archivo_;
       $this->SC_log_arr['fields']['notas_aspirante']['1'] =  $this->notas_aspirante_;
       $this->SC_log_arr['fields']['cc_correcto']['1'] =  $this->cc_correcto_;
       $this->SC_log_arr['fields']['cc_carta']['1'] =  $this->cc_carta_;
       $this->SC_log_arr['fields']['prefijo_requisito']['1'] =  $this->prefijo_requisito_;
       $this->SC_log_arr['fields']['notas_revisor']['1'] =  $this->notas_revisor_;
       $this->SC_log_arr['fields']['fecha_revision']['1'] =  $this->fecha_revision_;
       $this->SC_log_arr['fields']['notas_internas']['1'] =  $this->notas_internas_;
       $this->SC_log_arr['fields']['id_carga_req']['1'] =  $this->id_carga_req_;
       $this->SC_log_arr['fields']['usu_carga_req']['1'] =  $this->usu_carga_req_;
       $this->SC_log_arr['fields']['ip_revision']['1'] =  $this->ip_revision_;
       $this->SC_log_arr['fields']['login_insert']['1'] =  $this->login_insert_;
       $this->SC_log_arr['fields']['fecha_alta']['1'] =  $this->fecha_alta_;
       $this->SC_log_arr['fields']['ip_alta']['1'] =  $this->ip_alta_;
       $this->SC_log_arr['fields']['login_last']['1'] =  $this->login_last_;
       $this->SC_log_arr['fields']['fecha_ult_act']['1'] =  $this->fecha_ult_act_;
       $this->SC_log_arr['fields']['ip_last']['1'] =  $this->ip_last_;
   }
// 
   function NM_gera_log_compress() 
   {
       foreach ($this->SC_log_arr['fields'] as $fild => $data_f)
       {
           if ($data_f[0] == $data_f[1] || ($data_f[0] == "" && $data_f[1] == "null"))
           {
               unset($this->SC_log_arr['fields'][$fild]);
           }
       }
   }
// 
   function NM_gera_log_output() 
   {
       $Log_output = "";
       $prim_delim = "";
       $Log_labels = array();
       $Log_labels['id_asp_FK'] =  "{lang_asp_requisitos_fld_id_asp_FK}";
       $Log_labels['login_FK'] =  "{lang_asp_requisitos_fld_login_FK}";
       $Log_labels['id_lisreq_FK'] =  "{lang_asp_requisitos_fld_id_lisreq_FK}";
       $Log_labels['num_req'] =  "{lang_asp_requisitos_fld_num_req}";
       $Log_labels['archivo'] =  "{lang_asp_requisitos_fld_archivo}";
       $Log_labels['notas_aspirante'] =  "Notas del aspirante";
       $Log_labels['cc_correcto'] =  "{lang_asp_requisitos_fld_cc_correcto}";
       $Log_labels['cc_carta'] =  "Cc Carta";
       $Log_labels['prefijo_requisito'] =  "Prefijo Requisito";
       $Log_labels['notas_revisor'] =  "{lang_asp_requisitos_fld_notas_revisor}";
       $Log_labels['fecha_revision'] =  "{lang_asp_requisitos_fld_fecha_revision}";
       $Log_labels['notas_internas'] =  "{lang_asp_requisitos_fld_notas_internas}";
       $Log_labels['id_carga_req'] =  "{lang_asp_requisitos_fld_id_carga_req}";
       $Log_labels['usu_carga_req'] =  "{lang_asp_requisitos_fld_usu_carga_req}";
       $Log_labels['ip_revision'] =  "{lang_asp_requisitos_fld_ip_revision}";
       $Log_labels['login_insert'] =  "{lang_asp_requisitos_fld_login_insert}";
       $Log_labels['fecha_alta'] =  "{lang_asp_requisitos_fld_fecha_alta}";
       $Log_labels['ip_alta'] =  "{lang_asp_requisitos_fld_ip_alta}";
       $Log_labels['login_last'] =  "{lang_asp_requisitos_fld_login_last}";
       $Log_labels['fecha_ult_act'] =  "{lang_asp_requisitos_fld_fecha_ult_act}";
       $Log_labels['ip_last'] =  "{lang_asp_requisitos_fld_ip_last}";
       foreach ($this->SC_log_arr as $type => $dats)
       {
           if ($type == "keys")
           {
               $Log_output .= "--> keys <-- ";
               foreach ($dats as $key => $data)
               {
                   $Log_output .=  $prim_delim . $key . " : " . $data;
                   $prim_delim  = "||";
               }
           }
           if ($type == "fields")
           {
               $Log_output .= $prim_delim . "--> fields <-- ";
               $prim_delim = "";
               if (empty($dats) && $this->SC_log_evt == "update")
               {
                   return;
               }
               foreach ($dats as $key => $data)
               {
                   foreach ($data as $tp => $val)
                   {
                      $tpok = ($tp == 0) ? " (old) " : " (new) ";
                      $Log_output .= $prim_delim . $key . $tpok . " : " . $val;
                      $prim_delim  = "||";
                   }
                   $Log_output .= $prim_delim . $key . " (label) " . " : " . $Log_labels[$key];
               }
           }
       }
       $this->NM_gera_log_insert("Scriptcase", $this->SC_log_evt, $Log_output);
   }
   function NM_gera_nav_page() 
   {
       $this->SC_nav_page = "";
       $Arr_result        = array();
       $Ind_result        = 0;
       $Reg_Page   = $this->sc_max_reg;
       $Max_link   = 5;
       $Mid_link   = ceil($Max_link / 2);
       $Corr_link  = (($Max_link % 2) == 0) ? 0 : 1;
       $rec_tot    = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'] + 1;
       $rec_fim    = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] + $this->sc_max_reg;
       $rec_fim    = ($rec_fim > $rec_tot) ? $rec_tot : $rec_fim;
       if ($rec_tot == 0)
       {
           return;
       }
       $Qtd_Pages  = ceil($rec_tot / $Reg_Page);
       $Page_Atu   = ceil($rec_fim / $Reg_Page);
       $Link_ini   = 1;
       if ($Page_Atu > $Max_link)
       {
           $Link_ini = $Page_Atu - $Mid_link + $Corr_link;
       }
       elseif ($Page_Atu > $Mid_link)
       {
           $Link_ini = $Page_Atu - $Mid_link + $Corr_link;
       }
       if (($Qtd_Pages - $Link_ini) < $Max_link)
       {
           $Link_ini = ($Qtd_Pages - $Max_link) + 1;
       }
       if ($Link_ini < 1)
       {
           $Link_ini = 1;
       }
       for ($x = 0; $x < $Max_link && $Link_ini <= $Qtd_Pages; $x++)
       {
           $rec = (($Link_ini - 1) * $Reg_Page) + 1;
           if ($Link_ini == $Page_Atu)
           {
               $Arr_result[$Ind_result] = '<span class="scFormToolbarNavOpen" style="vertical-align: middle;">' . $Link_ini . '</span>';
           }
           else
           {
               $Arr_result[$Ind_result] = '<a class="scFormToolbarNav" style="vertical-align: middle;" href="javascript: nm_navpage(' . $rec . ')">' . $Link_ini . '</a>';
           }
           $Link_ini++;
           $Ind_result++;
           if (!isset($this->Ini->Str_toolbarnav_separator))
           {
               $this->Ini->Str_toolbarnav_separator = "";
           }
           if (($x + 1) < $Max_link && $Link_ini <= $Qtd_Pages && '' != $this->Ini->Str_toolbarnav_separator && @is_file($this->Ini->root . $this->Ini->path_img_global . $this->Ini->Str_toolbarnav_separator))
           {
               $Arr_result[$Ind_result] = '<img src="' . $this->Ini->path_img_global . $this->Ini->Str_toolbarnav_separator . '" align="absmiddle" style="vertical-align: middle;">';
               $Ind_result++;
           }
       }
       if ($_SESSION['scriptcase']['reg_conf']['css_dir'] == "RTL")
       {
           krsort($Arr_result);
       }
       foreach ($Arr_result as $Ind_result => $Lin_result)
       {
           $this->SC_nav_page .= $Lin_result;
       }
   }
        function initializeRecordState() {
                $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'] = array();
        }

        function storeRecordState($sc_seq_vert = 0) {
                if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'])) {
                        $this->initializeRecordState();
                }
                if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'][$sc_seq_vert])) {
                        $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'][$sc_seq_vert] = array();
                }

                $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'][$sc_seq_vert]['buttons'] = array(
                        'delete' => $this->nmgp_botoes['delete'],
                        'update' => $this->nmgp_botoes['update']
                );
        }

        function loadRecordState($sc_seq_vert = 0) {
                if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state']) || !isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'][$sc_seq_vert])) {
                        return;
                }

                if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'][$sc_seq_vert]['buttons']['delete'])) {
                        $this->nmgp_botoes['delete'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'][$sc_seq_vert]['buttons']['delete'];
                }
                if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'][$sc_seq_vert]['buttons']['update'])) {
                        $this->nmgp_botoes['update'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['record_state'][$sc_seq_vert]['buttons']['update'];
                }
        }

//
function chg_filename()
{
$_SESSION['scriptcase']['form_asp_requisitos_admvo']['contr_erro'] = 'on';
if (!isset($this->sc_temp_generacion)) {$this->sc_temp_generacion = (isset($_SESSION['generacion'])) ? $_SESSION['generacion'] : "";}
if (!isset($this->sc_temp_cont_file)) {$this->sc_temp_cont_file = (isset($_SESSION['cont_file'])) ? $_SESSION['cont_file'] : "";}
  
if($this->sc_temp_cont_file!='' && $this->archivo_ !=''){
$ext=substr($this->archivo_ , -3, 3);
$id_asp=substr($this->id_asp_fk_ , -3, 3);

$ruta =$_SERVER['DOCUMENT_ROOT']."/sce_asp/_lib/file/doc/aspirantes/".$this->sc_temp_generacion."/".$this->login_fk_ ."/";

$nw_na=$this->sc_temp_generacion."_".$id_asp."_".$this->num_req_ .".".$ext;
$nom_original=$ruta.$this->archivo_ ;

rename($nom_original, $ruta.$nw_na);

$update_sql = "UPDATE asp_requisitos SET archivo='".$nw_na."' WHERE login_FK='".$this->login_fk_ ."' AND num_req=".$this->num_req_ ;

     $nm_select = $update_sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                form_asp_requisitos_admvo_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      
}
//
 function nm_gera_html()
 {
    global
           $nm_url_saida, $nmgp_url_saida, $nm_saida_global, $nm_apl_dependente, $glo_subst, $sc_check_excl, $sc_check_incl, $nmgp_num_form, $NM_run_iframe;
     if ($this->Embutida_proc)
     {
         return;
     }
     if ($this->nmgp_form_show == 'off')
     {
         exit;
     }
      if (isset($NM_run_iframe) && $NM_run_iframe == 1)
      {
          $this->nmgp_botoes['exit'] = "off";
      }
     $HTTP_REFERER = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : ""; 
     $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
     $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['botoes'] = $this->nmgp_botoes;
     if ($this->nmgp_opcao != "recarga" && $this->nmgp_opcao != "muda_form")
     {
         $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opc_ant'] = $this->nmgp_opcao;
     }
     else
     {
         $this->nmgp_opcao = $this->nmgp_opc_ant;
     }
     if (!empty($this->Campos_Mens_erro)) 
     {
         $this->Erro->mensagem(__FILE__, __LINE__, "critica", $this->Campos_Mens_erro); 
         $this->Campos_Mens_erro = "";
     }
     if (($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "F" || $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "R") && $this->nm_flag_iframe && empty($this->nm_todas_criticas))
     {
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe_ajax']))
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['retorno_edit'] = array("edit", "");
          }
          else
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['retorno_edit'] .= "&nmgp_opcao=edit";
          }
          if ($this->sc_evento == "insert" && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "F")
          {
              if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe_ajax']))
              {
                  $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['retorno_edit'] = array("edit", "fim");
              }
              else
              {
                  $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['retorno_edit'] .= "&rec=fim";
              }
          }
          $this->NM_close_db(); 
          $sJsParent = '';
          if ($this->NM_ajax_flag && isset($this->NM_ajax_info['param']['buffer_output']) && $this->NM_ajax_info['param']['buffer_output'])
          {
              if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe_ajax']))
              {
                  $this->NM_ajax_info['ajaxJavascript'][] = array("parent.ajax_navigate", $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['retorno_edit']);
              }
              else
              {
                  $sJsParent .= 'parent';
                  $this->NM_ajax_info['redir']['metodo'] = 'location';
                  $this->NM_ajax_info['redir']['action'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['retorno_edit'];
                  $this->NM_ajax_info['redir']['target'] = $sJsParent;
              }
              form_asp_requisitos_admvo_pack_ajax_response();
              exit;
          }
?>
<!DOCTYPE html>

         <html><body>
         <script type="text/javascript">
<?php
    
    if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe_ajax']))
    {
        $opc = ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] == "F" && $this->sc_evento == "insert") ? "fim" : "";
        echo "parent.ajax_navigate('edit', '" .$opc . "');";
    }
    else
    {
        echo $sJsParent . "parent.location = '" . $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['retorno_edit'] . "';";
    }
?>
         </script>
         </body></html>
<?php
         exit;
     }
        $this->initFormPages();
   if ($this->NM_ajax_flag && 'add_new_line' == $this->NM_ajax_opcao)
   {
        $this->Form_Corpo(true);
   }
   elseif ($this->NM_ajax_flag && 'table_refresh' == $this->NM_ajax_opcao)
   {
        $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['table_refresh'] = true;
        $this->Form_Table(true);
        $this->Form_Corpo(false, true);
   }
   else
   {
        $this->Form_Init();
        $this->Form_Table();
        $this->Form_Corpo();
        $this->Form_Fim();
   }
        $this->hideFormPages();
 }

        function initFormPages() {
        } // initFormPages

        function hideFormPages() {
        } // hideFormPages

    function form_format_readonly($field, $value)
    {
        $result = $value;

        $this->form_highlight_search($result, $field, $value);

        return $result;
    }

    function form_highlight_search(&$result, $field, $value)
    {
        if ($this->proc_fast_search) {
            $this->form_highlight_search_quicksearch($result, $field, $value);
        }
    }

    function form_highlight_search_quicksearch(&$result, $field, $value)
    {
        $searchOk = false;
        if ('SC_all_Cmp' == $this->nmgp_fast_search && in_array($field, array("id_asp_req_", "id_asp_fk_", "login_fk_", "id_lisreq_fk_", "num_req_", "archivo_", "cc_correcto_", "notas_revisor_", "id_carga_req_", "usu_carga_req_", "ip_revision_", "login_insert_", "ip_alta_", "login_last_", "ip_last_"))) {
            $searchOk = true;
        }
        elseif ($field == $this->nmgp_fast_search && in_array($field, array(""))) {
            $searchOk = true;
        }

        if (!$searchOk || '' == $this->nmgp_arg_fast_search) {
            return;
        }

        $htmlIni = '<div class="highlight" style="background-color: #fafaca; display: inline-block">';
        $htmlFim = '</div>';

        if ('qp' == $this->nmgp_cond_fast_search) {
            $keywords = preg_quote($this->nmgp_arg_fast_search, '/');
            $result = preg_replace('/'. $keywords .'/i', $htmlIni . '$0' . $htmlFim, $result);
        } elseif ('eq' == $this->nmgp_cond_fast_search) {
            if (strcasecmp($this->nmgp_arg_fast_search, $value) == 0) {
                $result = $htmlIni. $result .$htmlFim;
            }
        }
    }


    function form_encode_input($string)
    {
        if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['table_refresh']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['table_refresh'])
        {
            return NM_encode_input(NM_encode_input($string));
        }
        else
        {
            return NM_encode_input($string);
        }
    } // form_encode_input

   function jqueryCalendarDtFormat($sFormat, $sSep)
   {
       $sFormat = chunk_split(str_replace('yyyy', 'yy', $sFormat), 2, $sSep);

       if ($sSep == substr($sFormat, -1))
       {
           $sFormat = substr($sFormat, 0, -1);
       }

       return $sFormat;
   } // jqueryCalendarDtFormat

   function jqueryCalendarTimeStart($sFormat, $value)
   {
       $aDateParts = explode(';', $sFormat);

       if (2 == sizeof($aDateParts))
       {
           $sTime = $aDateParts[1];
       }
       else
       {
           $sTime = 'hh:mm:ss';
       }

       if ('now' == $value) {
           return str_replace(array('hh', 'mm', 'ii', 'ss'), array(date('H'), date('i'), date('i'), date('s')), $sTime);
       } elseif ('end' == $value) {
           return str_replace(array('hh', 'mm', 'ii', 'ss'), array('23', '59', '59', '59'), $sTime);
       } else {
           return str_replace(array('h', 'm', 'i', 's'), array('0', '0', '0', '0'), $sTime);
       }
   } // jqueryCalendarTimeStart

   function jqueryCalendarWeekInit($sDay)
   {
       switch ($sDay) {
           case 'MO': return 1; break;
           case 'TU': return 2; break;
           case 'WE': return 3; break;
           case 'TH': return 4; break;
           case 'FR': return 5; break;
           case 'SA': return 6; break;
           default  : return 7; break;
       }
   } // jqueryCalendarWeekInit

   function jqueryIconFile($sModule)
   {
       $sImage = '';
       if ('calendar' == $sModule)
       {
           if (isset($this->arr_buttons['bcalendario']) && isset($this->arr_buttons['bcalendario']['type']) && 'image' == $this->arr_buttons['bcalendario']['type'] && 'only_fontawesomeicon' != $this->arr_buttons['bcalendario']['display'])
           {
               $sImage = $this->arr_buttons['bcalendario']['image'];
           }
       }
       elseif ('calculator' == $sModule)
       {
           if (isset($this->arr_buttons['bcalculadora']) && isset($this->arr_buttons['bcalculadora']['type']) && 'image' == $this->arr_buttons['bcalculadora']['type'] && 'only_fontawesomeicon' != $this->arr_buttons['bcalculadora']['display'])
           {
               $sImage = $this->arr_buttons['bcalculadora']['image'];
           }
       }

       return '' == $sImage ? '' : $this->Ini->path_icones . '/' . $sImage;
   } // jqueryIconFile

   function jqueryFAFile($sModule)
   {
       $sFA = '';
       if ('calendar' == $sModule)
       {
           if (isset($this->arr_buttons['bcalendario']) && isset($this->arr_buttons['bcalendario']['type']) && ('image' == $this->arr_buttons['bcalendario']['type'] || 'button' == $this->arr_buttons['bcalendario']['type']) && 'only_fontawesomeicon' == $this->arr_buttons['bcalendario']['display'])
           {
               $sFA = $this->arr_buttons['bcalendario']['fontawesomeicon'];
           }
       }
       elseif ('calculator' == $sModule)
       {
           if (isset($this->arr_buttons['bcalculadora']) && isset($this->arr_buttons['bcalculadora']['type']) && ('image' == $this->arr_buttons['bcalculadora']['type'] || 'button' == $this->arr_buttons['bcalculadora']['type']) && 'only_fontawesomeicon' == $this->arr_buttons['bcalculadora']['display'])
           {
               $sFA = $this->arr_buttons['bcalculadora']['fontawesomeicon'];
           }
       }

       return '' == $sFA ? '' : "<span class='scButton_fontawesome " . $sFA . "'></span>";
   } // jqueryFAFile

   function jqueryButtonText($sModule)
   {
       $sClass = '';
       $sText  = '';
       if ('calendar' == $sModule)
       {
           if (isset($this->arr_buttons['bcalendario']) && isset($this->arr_buttons['bcalendario']['type']) && ('image' == $this->arr_buttons['bcalendario']['type'] || 'button' == $this->arr_buttons['bcalendario']['type']))
           {
               if ('only_text' == $this->arr_buttons['bcalendario']['display'])
               {
                   $sClass = 'scButton_' . $this->arr_buttons['bcalendario']['style'];
                   $sText  = $this->arr_buttons['bcalendario']['value'];
               }
               elseif ('text_fontawesomeicon' == $this->arr_buttons['bcalendario']['display'])
               {
                   $sClass = 'scButton_' . $this->arr_buttons['bcalendario']['style'];
                   if ('text_right' == $this->arr_buttons['bcalendario']['display_position'])
                   {
                       $sText = "<i class='icon_fa " . $this->arr_buttons['bcalendario']['fontawesomeicon'] . "'></i> " . $this->arr_buttons['bcalendario']['value'];
                   }
                   else
                   {
                       $sText = $this->arr_buttons['bcalendario']['value'] . " <i class='icon_fa " . $this->arr_buttons['bcalendario']['fontawesomeicon'] . "'></i>";
                   }
               }
           }
       }
       elseif ('calculator' == $sModule)
       {
           if (isset($this->arr_buttons['bcalculadora']) && isset($this->arr_buttons['bcalculadora']['type']) && ('image' == $this->arr_buttons['bcalculadora']['type'] || 'button' == $this->arr_buttons['bcalculadora']['type']))
           {
               if ('only_text' == $this->arr_buttons['bcalculadora']['display'])
               {
                   $sClass = 'scButton_' . $this->arr_buttons['bcalendario']['style'];
                   $sText  = $this->arr_buttons['bcalculadora']['value'];
               }
               elseif ('text_fontawesomeicon' == $this->arr_buttons['bcalculadora']['display'])
               {
                   $sClass = 'scButton_' . $this->arr_buttons['bcalendario']['style'];
                   if ('text_right' == $this->arr_buttons['bcalendario']['display_position'])
                   {
                       $sText = "<i class='icon_fa " . $this->arr_buttons['bcalculadora']['fontawesomeicon'] . "'></i> " . $this->arr_buttons['bcalculadora']['value'];
                   }
                   else
                   {
                       $sText = $this->arr_buttons['bcalculadora']['value'] . " <i class='icon_fa " . $this->arr_buttons['bcalculadora']['fontawesomeicon'] . "'></i> ";
                   }
               }
           }
       }

       return '' == $sText ? array('', '') : array($sText, $sClass);
   } // jqueryButtonText


    function scCsrfGetToken()
    {
        if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['csrf_token']))
        {
            $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['csrf_token'] = $this->scCsrfGenerateToken();
        }

        return $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['csrf_token'];
    }

    function scCsrfGenerateToken()
    {
        $aSources = array(
            'abcdefghijklmnopqrstuvwxyz',
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            '1234567890',
            '!@$*()-_[]{},.;:'
        );

        $sRandom = '';

        $aSourcesSizes = array();
        $iSourceSize   = sizeof($aSources) - 1;
        for ($i = 0; $i <= $iSourceSize; $i++)
        {
            $aSourcesSizes[$i] = strlen($aSources[$i]) - 1;
        }

        for ($i = 0; $i < 64; $i++)
        {
            $iSource = $this->scCsrfRandom(0, $iSourceSize);
            $sRandom .= substr($aSources[$iSource], $this->scCsrfRandom(0, $aSourcesSizes[$iSource]), 1);
        }

        return $sRandom;
    }

    function scCsrfRandom($iMin, $iMax)
    {
        return mt_rand($iMin, $iMax);
    }

        function addUrlParam($url, $param, $value) {
                $urlParts  = explode('?', $url);
                $urlParams = isset($urlParts[1]) ? explode('&', $urlParts[1]) : array();
                $objParams = array();
                foreach ($urlParams as $paramInfo) {
                        $paramParts = explode('=', $paramInfo);
                        $objParams[ $paramParts[0] ] = isset($paramParts[1]) ? $paramParts[1] : '';
                }
                $objParams[$param] = $value;
                $urlParams = array();
                foreach ($objParams as $paramName => $paramValue) {
                        $urlParams[] = $paramName . '=' . $paramValue;
                }
                return $urlParts[0] . '?' . implode('&', $urlParams);
        }
 function allowedCharsCharset($charlist)
 {
     if ($_SESSION['scriptcase']['charset'] != 'UTF-8')
     {
         $charlist = NM_conv_charset($charlist, $_SESSION['scriptcase']['charset'], 'UTF-8');
     }
     return str_replace("'", "\'", $charlist);
 }

function sc_file_size($file, $format = false)
{
    if ('' == $file) {
        return '';
    }
    if (!@is_file($file)) {
        return '';
    }
    $fileSize = @filesize($file);
    if ($format) {
        $suffix = '';
        if (1024 >= $fileSize) {
            $fileSize /= 1024;
            $suffix    = ' KB';
        }
        if (1024 >= $fileSize) {
            $fileSize /= 1024;
            $suffix    = ' MB';
        }
        if (1024 >= $fileSize) {
            $fileSize /= 1024;
            $suffix    = ' GB';
        }
        $fileSize = $fileSize . $suffix;
    }
    return $fileSize;
}


 function new_date_format($type, $field)
 {
     $new_date_format_out = '';

     if ('DT' == $type)
     {
         $date_format  = $this->field_config[$field]['date_format'];
         $date_sep     = $this->field_config[$field]['date_sep'];
         $date_display = $this->field_config[$field]['date_display'];
         $time_format  = '';
         $time_sep     = '';
         $time_display = '';
     }
     elseif ('DH' == $type)
     {
         $date_format  = false !== strpos($this->field_config[$field]['date_format'] , ';') ? substr($this->field_config[$field]['date_format'] , 0, strpos($this->field_config[$field]['date_format'] , ';')) : $this->field_config[$field]['date_format'];
         $date_sep     = $this->field_config[$field]['date_sep'];
         $date_display = false !== strpos($this->field_config[$field]['date_display'], ';') ? substr($this->field_config[$field]['date_display'], 0, strpos($this->field_config[$field]['date_display'], ';')) : $this->field_config[$field]['date_display'];
         $time_format  = false !== strpos($this->field_config[$field]['date_format'] , ';') ? substr($this->field_config[$field]['date_format'] , strpos($this->field_config[$field]['date_format'] , ';') + 1) : '';
         $time_sep     = $this->field_config[$field]['time_sep'];
         $time_display = false !== strpos($this->field_config[$field]['date_display'], ';') ? substr($this->field_config[$field]['date_display'], strpos($this->field_config[$field]['date_display'], ';') + 1) : '';
     }
     elseif ('HH' == $type)
     {
         $date_format  = '';
         $date_sep     = '';
         $date_display = '';
         $time_format  = $this->field_config[$field]['date_format'];
         $time_sep     = $this->field_config[$field]['time_sep'];
         $time_display = $this->field_config[$field]['date_display'];
     }

     if ('DT' == $type || 'DH' == $type)
     {
         $date_array = array();
         $date_index = 0;
         $date_ult   = '';
         for ($i = 0; $i < strlen($date_format); $i++)
         {
             $char = strtolower(substr($date_format, $i, 1));
             if (in_array($char, array('d', 'm', 'y', 'a')))
             {
                 if ('a' == $char)
                 {
                     $char = 'y';
                 }
                 if ($char == $date_ult)
                 {
                     $date_array[$date_index] .= $char;
                 }
                 else
                 {
                     if ('' != $date_ult)
                     {
                         $date_index++;
                     }
                     $date_array[$date_index] = $char;
                 }
             }
             $date_ult = $char;
         }

         $disp_array = array();
         $date_index = 0;
         $date_ult   = '';
         for ($i = 0; $i < strlen($date_display); $i++)
         {
             $char = strtolower(substr($date_display, $i, 1));
             if (in_array($char, array('d', 'm', 'y', 'a')))
             {
                 if ('a' == $char)
                 {
                     $char = 'y';
                 }
                 if ($char == $date_ult)
                 {
                     $disp_array[$date_index] .= $char;
                 }
                 else
                 {
                     if ('' != $date_ult)
                     {
                         $date_index++;
                     }
                     $disp_array[$date_index] = $char;
                 }
             }
             $date_ult = $char;
         }

         $date_final = array();
         foreach ($date_array as $date_part)
         {
             if (in_array($date_part, $disp_array))
             {
                 $date_final[] = $date_part;
             }
         }

         $date_format = implode($date_sep, $date_final);
     }
     if ('HH' == $type || 'DH' == $type)
     {
         $time_array = array();
         $time_index = 0;
         $time_ult   = '';
         for ($i = 0; $i < strlen($time_format); $i++)
         {
             $char = strtolower(substr($time_format, $i, 1));
             if (in_array($char, array('h', 'i', 's')))
             {
                 if ($char == $time_ult)
                 {
                     $time_array[$time_index] .= $char;
                 }
                 else
                 {
                     if ('' != $time_ult)
                     {
                         $time_index++;
                     }
                     $time_array[$time_index] = $char;
                 }
             }
             $time_ult = $char;
         }

         $disp_array = array();
         $time_index = 0;
         $time_ult   = '';
         for ($i = 0; $i < strlen($time_display); $i++)
         {
             $char = strtolower(substr($time_display, $i, 1));
             if (in_array($char, array('h', 'i', 's')))
             {
                 if ($char == $time_ult)
                 {
                     $disp_array[$time_index] .= $char;
                 }
                 else
                 {
                     if ('' != $time_ult)
                     {
                         $time_index++;
                     }
                     $disp_array[$time_index] = $char;
                 }
             }
             $time_ult = $char;
         }

         $time_final = array();
         foreach ($time_array as $time_part)
         {
             if (in_array($time_part, $disp_array))
             {
                 $time_final[] = $time_part;
             }
         }

         $time_format = implode($time_sep, $time_final);
     }

     if ('DT' == $type)
     {
         $old_date_format = $date_format;
     }
     elseif ('DH' == $type)
     {
         $old_date_format = $date_format . ';' . $time_format;
     }
     elseif ('HH' == $type)
     {
         $old_date_format = $time_format;
     }

     for ($i = 0; $i < strlen($old_date_format); $i++)
     {
         $char = substr($old_date_format, $i, 1);
         if ('/' == $char)
         {
             $new_date_format_out .= $date_sep;
         }
         elseif (':' == $char)
         {
             $new_date_format_out .= $time_sep;
         }
         else
         {
             $new_date_format_out .= $char;
         }
     }

     $this->field_config[$field]['date_format'] = $new_date_format_out;
     if ('DH' == $type)
     {
         $new_date_format_out                                  = explode(';', $new_date_format_out);
         $this->field_config[$field]['date_format_js']        = $new_date_format_out[0];
         $this->field_config[$field . '_hora']['date_format'] = $new_date_format_out[1];
         $this->field_config[$field . '_hora']['time_sep']    = $this->field_config[$field]['time_sep'];
     }
 } // new_date_format

   function Form_lookup_cc_correcto_()
   {
       $nmgp_def_dados  = "";
       $nmgp_def_dados .= "Pendiente cargar?#??#?N?@?";
       $nmgp_def_dados .= "Pendiente revisar?#?0?#?N?@?";
       $nmgp_def_dados .= "Si?#?1?#?N?@?";
       $nmgp_def_dados .= "No aplica?#?2?#?N?@?";
       $nmgp_def_dados .= "No?#?3?#?N?@?";
       $todo = explode("?@?", $nmgp_def_dados);
       return $todo;

   }
   function SC_fast_search($in_fields, $arg_search, $data_search)
   {
      $fields = (strpos($in_fields, "SC_all_Cmp") !== false) ? array("SC_all_Cmp") : explode(";", $in_fields);
      $this->NM_case_insensitive = false;
      if (empty($data_search)) 
      {
         unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dyn_search_and_or']);
         unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dyn_search_cache']);
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter']);
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total']);
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['fast_search']);
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_detal']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_detal'])) 
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter'] = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_detal'];
          }
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['empty_filter']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['empty_filter'])
          {
              unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['empty_filter']);
              $this->NM_ajax_info['empty_filter'] = 'ok';
              form_asp_requisitos_admvo_pack_ajax_response();
              exit;
          }
          return;
      }
      $comando = "";
      if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($data_search))
      {
          $data_search = NM_conv_charset($data_search, $_SESSION['scriptcase']['charset'], "UTF-8");
      }
      $sv_data = $data_search;
      foreach ($fields as $field) {
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "id_asp_req", $arg_search, str_replace(",", ".", $data_search), "INT", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "id_asp_FK", $arg_search, str_replace(",", ".", $data_search), "INT", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "login_FK", $arg_search, $data_search, "VARCHAR", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "id_lisreq_FK", $arg_search, str_replace(",", ".", $data_search), "INT", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "num_req", $arg_search, str_replace(",", ".", $data_search), "TINYINT", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "archivo", $arg_search, $data_search, "VARCHAR", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $data_lookup = $this->SC_lookup_cc_correcto_($arg_search, $data_search);
              if (is_array($data_lookup) && !empty($data_lookup)) 
              {
                  $this->SC_monta_condicao($comando, "cc_correcto", $arg_search, $data_lookup, "INT", false);
              }
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "notas_revisor", $arg_search, $data_search, "VARCHAR", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "id_carga_req", $arg_search, str_replace(",", ".", $data_search), "INT", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "usu_carga_req", $arg_search, $data_search, "VARCHAR", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "ip_revision", $arg_search, $data_search, "VARCHAR", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "login_insert", $arg_search, $data_search, "VARCHAR", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "ip_alta", $arg_search, $data_search, "VARCHAR", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "login_last", $arg_search, $data_search, "VARCHAR", false);
          }
          if ($field == "SC_all_Cmp") 
          {
              $this->SC_monta_condicao($comando, "ip_last", $arg_search, $data_search, "VARCHAR", false);
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_detal']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_detal']) && !empty($comando)) 
      {
          $comando = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_detal'] . " and (" .  $comando . ")";
      }
      if (empty($comando)) 
      {
          $comando = " 1 <> 1 "; 
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter_form']) && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter_form'])
      {
          $sc_where = " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter_form'] . " and (" . $comando . ")";
      }
      else
      {
         $sc_where = " where " . $comando;
      }
      $nmgp_select = "SELECT count(*) AS countTest from " . $this->Ini->nm_tabela . $sc_where; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
      $rt = $this->Db->Execute($nmgp_select) ; 
      if ($rt === false && !$rt->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1) 
      { 
          $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
          exit ; 
      }  
      $qt_geral_reg_form_asp_requisitos_admvo = isset($rt->fields[0]) ? $rt->fields[0] - 1 : 0; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'] = $qt_geral_reg_form_asp_requisitos_admvo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['where_filter'] = $comando;
      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['fast_search'][0] = $field;
      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['fast_search'][1] = $arg_search;
      $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['fast_search'][2] = $sv_data;
      $rt->Close(); 
      if (isset($rt->fields[0]) && $rt->fields[0] > 0 &&  isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['empty_filter']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['empty_filter'])
      {
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['empty_filter']);
          $this->NM_ajax_info['empty_filter'] = 'ok';
          form_asp_requisitos_admvo_pack_ajax_response();
          exit;
      }
      elseif (!isset($rt->fields[0]) || $rt->fields[0] == 0)
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['empty_filter'] = true;
          $this->NM_ajax_info['empty_filter'] = 'ok';
          form_asp_requisitos_admvo_pack_ajax_response();
          exit;
      }
   }
   function SC_monta_condicao(&$comando, $nome, $condicao, $campo, $tp_campo="", $tp_unaccent=false)
   {
      $nm_aspas   = "'";
      $nm_aspas1  = "'";
      $nm_numeric = array();
      $Nm_datas   = array();
      $nm_esp_postgres = array();
      $campo_join = strtolower(str_replace(".", "_", $nome));
      $nm_ini_lower = "";
      $nm_fim_lower = "";
      $Nm_accent = $this->Ini->Nm_accent_no;
      if ($tp_unaccent) {
          $Nm_accent = $this->Ini->Nm_accent_yes;
      }
      $nm_numeric[] = "id_asp_req";$nm_numeric[] = "id_asp_fk";$nm_numeric[] = "id_lisreq_fk";$nm_numeric[] = "num_req";$nm_numeric[] = "cc_correcto";$nm_numeric[] = "cc_carta";$nm_numeric[] = "id_carga_req";
      if (in_array($campo_join, $nm_numeric))
      {
         if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['decimal_db'] == ".")
         {
             $nm_aspas  = "";
             $nm_aspas1 = "";
         }
         if (is_array($campo))
         {
             foreach ($campo as $Ind => $Cmp)
             {
                if (!is_numeric($Cmp))
                {
                    return;
                }
                if ($Cmp == "")
                {
                    $campo[$Ind] = 0;
                }
             }
         }
         else
         {
             if (!is_numeric($campo))
             {
                 return;
             }
             if ($campo == "")
             {
                $campo = 0;
             }
         }
      }
      if (is_array($campo)) {
          foreach ($campo as $Ind => $Cmp) {
             if ($Cmp != null) {
                 $campo[$Ind] = substr($this->Ini->Db->qstr($Cmp), 1, -1);
             }
          }
      }
      else {
          $campo = substr($this->Ini->Db->qstr($campo), 1, -1);
      }
         if (in_array($campo_join, $nm_numeric) && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres) && (strtoupper($condicao) == "II" || strtoupper($condicao) == "QP" || strtoupper($condicao) == "NP"))
         {
             $nome      = "CAST ($nome AS TEXT)";
             $nm_aspas  = "'";
             $nm_aspas1 = "'";
         }
         if (in_array($campo_join, $nm_esp_postgres) && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres))
         {
             $nome      = "CAST ($nome AS TEXT)";
             $nm_aspas  = "'";
             $nm_aspas1 = "'";
         }
         if (in_array($campo_join, $nm_numeric) && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase) && (strtoupper($condicao) == "II" || strtoupper($condicao) == "QP" || strtoupper($condicao) == "NP"))
         {
             $nome      = "CAST ($nome AS VARCHAR)";
             $nm_aspas  = "'";
             $nm_aspas1 = "'";
         }
         if (in_array($campo_join, $nm_numeric) && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_progress) && (strtoupper($condicao) == "II" || strtoupper($condicao) == "QP" || strtoupper($condicao) == "NP"))
         {
             $nome      = "CAST ($nome AS VARCHAR(255))";
             $nm_aspas  = "'";
             $nm_aspas1 = "'";
         }
      $Nm_datas["fecha_revision"] = "datetime";$Nm_datas["fecha_alta"] = "datetime";$Nm_datas["fecha_ult_act"] = "datetime";
         if (isset($Nm_datas[$campo_join]))
         {
             for ($x = 0; $x < strlen($campo); $x++)
             {
                 $tst = substr($campo, $x, 1);
                 if (!is_numeric($tst) && ($tst != "-" && $tst != ":" && $tst != " "))
                 {
                     return;
                 }
             }
         }
          if (isset($Nm_datas[$campo_join]))
          {
          if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_access))
          {
             $nm_aspas  = "#";
             $nm_aspas1 = "#";
          }
              if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['SC_sep_date']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['SC_sep_date']))
              {
                  $nm_aspas  = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['SC_sep_date'];
                  $nm_aspas1 = $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['SC_sep_date1'];
              }
          }
      if (isset($Nm_datas[$campo_join]) && (strtoupper($condicao) == "II" || strtoupper($condicao) == "QP" || strtoupper($condicao) == "NP" || strtoupper($condicao) == "DF"))
      {
          if (strtoupper($condicao) == "DF")
          {
              $condicao = "NP";
          }
          if (($Nm_datas[$campo_join] == "datetime" || $Nm_datas[$campo_join] == "timestamp") && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres))
          {
              $nome = "to_char (" . $nome . ", 'YYYY-MM-DD hh24:mi:ss')";
          }
          elseif ($Nm_datas[$campo_join] == "date" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres))
          {
              $nome = "to_char (" . $nome . ", 'YYYY-MM-DD')";
          }
          elseif ($Nm_datas[$campo_join] == "time" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres))
          {
              $nome = "to_char (" . $nome . ", 'hh24:mi:ss')";
          }
          elseif ($Nm_datas[$campo_join] == "date" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
          {
              $nome = "convert(char(10)," . $nome . ",121)";
          }
          elseif (($Nm_datas[$campo_join] == "datetime" || $Nm_datas[$campo_join] == "timestamp") && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
          {
              $nome = "convert(char(19)," . $nome . ",121)";
          }
          elseif (($Nm_datas[$campo_join] == "times" || $Nm_datas[$campo_join] == "datetime" || $Nm_datas[$campo_join] == "timestamp") && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
          {
              $nome  = "TO_DATE(TO_CHAR(" . $nome . ", 'yyyy-mm-dd hh24:mi:ss'), 'yyyy-mm-dd hh24:mi:ss')";
          }
          elseif ($Nm_datas[$campo_join] == "datetime" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
          {
              $nome = "EXTEND(" . $nome . ", YEAR TO FRACTION)";
          }
          elseif ($Nm_datas[$campo_join] == "date" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
          {
              $nome = "EXTEND(" . $nome . ", YEAR TO DAY)";
          }
          elseif ($Nm_datas[$campo_join] == "datetime" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_progress))
          {
              $nome = "to_char (" . $nome . ", 'YYYY-MM-DD hh24:mi:ss')";
          }
          elseif ($Nm_datas[$campo_join] == "date" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_progress))
          {
              $nome = "to_char (" . $nome . ", 'YYYY-MM-DD')";
          }
      }
         $comando .= (!empty($comando) ? " or " : "");
         if (is_array($campo))
         {
             $prep = "";
             foreach ($campo as $Ind => $Cmp)
             {
                 $prep .= (!empty($prep)) ? "," : "";
                 $Cmp   = substr($this->Db->qstr($Cmp), 1, -1);
                 $prep .= $nm_ini_lower . $nm_aspas . $Cmp . $nm_aspas1 . $nm_fim_lower;
             }
             $prep .= (empty($prep)) ? $nm_aspas . $nm_aspas1 : "";
             $comando .= $nm_ini_lower . $nome . $nm_fim_lower . " in (" . $prep . ")";
             return;
         }
         $campo  = substr($this->Db->qstr($campo), 1, -1);
         $cond_tst = strtoupper($condicao);
         if ($cond_tst == "II" || $cond_tst == "QP" || $cond_tst == "NP")
         {
             if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_postgres) && $this->NM_case_insensitive)
             {
                 $op_like      = " ilike ";
                 $nm_ini_lower = "";
                 $nm_fim_lower = "";
             }
             else
             {
                 $op_like = " like ";
             }
         }
         switch ($cond_tst)
         {
            case "EQ":     // 
               $comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " = " . $nm_ini_lower . $nm_aspas . $campo . $nm_aspas1 . $nm_fim_lower;
            break;
            case "II":     // 
               $comando        .= $nm_ini_lower . $Nm_accent['cmp_i'] . $nome . $Nm_accent['cmp_f'] . $nm_fim_lower . $Nm_accent['cmp_apos'] . $op_like . $nm_ini_lower . "'" . $Nm_accent['arg_i'] . sc_sql_escape($this->Ini->nm_tpbanco, $campo) . $Nm_accent['arg_f'] . "%'" . $nm_fim_lower . $Nm_accent['arg_apos'] . $_SESSION['sc_session']['sc_sql_escape'];
            break;
            case "QP":     // 
               $comando        .= $nm_ini_lower . $Nm_accent['cmp_i'] . $nome . $Nm_accent['cmp_f'] . $nm_fim_lower . $Nm_accent['cmp_apos'] . $op_like . $nm_ini_lower . "'%" . $Nm_accent['arg_i'] . sc_sql_escape($this->Ini->nm_tpbanco, $campo) . $Nm_accent['arg_f'] . "%'" . $nm_fim_lower . $Nm_accent['arg_apos'] . $_SESSION['sc_session']['sc_sql_escape'];
            break;
            case "NP":     // 
               $comando        .= $nm_ini_lower . $Nm_accent['cmp_i'] . $nome . $Nm_accent['cmp_f'] . $nm_fim_lower . $Nm_accent['cmp_apos'] . " not" . $op_like . $nm_ini_lower . "'%" . $Nm_accent['arg_i'] . sc_sql_escape($this->Ini->nm_tpbanco, $campo) . $Nm_accent['arg_f'] . "%'" . $nm_fim_lower . $Nm_accent['arg_apos'] . $_SESSION['sc_session']['sc_sql_escape'];
            break;
            case "DF":     // 
               $comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " <> " . $nm_ini_lower . $nm_aspas . $campo . $nm_aspas1 . $nm_fim_lower;
            break;
            case "GT":     // 
               $comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " > " . $nm_ini_lower . $nm_aspas . $campo . $nm_aspas1 . $nm_fim_lower;
            break;
            case "GE":     // 
               $comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " >= " . $nm_ini_lower . $nm_aspas . $campo . $nm_aspas1 . $nm_fim_lower;
            break;
            case "LT":     // 
               $comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " < " . $nm_ini_lower . $nm_aspas . $campo . $nm_aspas1 . $nm_fim_lower;
            break;
            case "LE":     // 
               $comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " <= " . $nm_ini_lower . $nm_aspas . $campo . $nm_aspas1 . $nm_fim_lower;
            break;
         }
   }
   function SC_lookup_cc_correcto_($condicao, $campo)
   {
       $data_look = array();
       $campo  = substr($this->Db->qstr($campo), 1, -1);
       $data_look[''] = "Pendiente cargar";
       $data_look['0'] = "Pendiente revisar";
       $data_look['1'] = "Si";
       $data_look['2'] = "No aplica";
       $data_look['3'] = "No";
       $result = array();
       foreach ($data_look as $chave => $label) 
       {
           if ($condicao == "eq" && $campo == $label)
           {
               $result[] = $chave;
           }
           if ($condicao == "ii" && $campo == substr($label, 0, strlen($campo)))
           {
               $result[] = $chave;
           }
           if ($condicao == "qp" && strstr($label, $campo))
           {
               $result[] = $chave;
           }
           if ($condicao == "np" && !strstr($label, $campo))
           {
               $result[] = $chave;
           }
           if ($condicao == "df" && $campo != $label)
           {
               $result[] = $chave;
           }
           if ($condicao == "gt" && $label > $campo )
           {
               $result[] = $chave;
           }
           if ($condicao == "ge" && $label >= $campo)
            {
               $result[] = $chave;
           }
           if ($condicao == "lt" && $label < $campo)
           {
               $result[] = $chave;
           }
           if ($condicao == "le" && $label <= $campo)
           {
               $result[] = $chave;
           }
          
       }
       return $result;
   }
function nmgp_redireciona($tipo=0)
{
   global $nm_apl_dependente;
   if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno']) && $_SESSION['scriptcase']['sc_tp_saida'] != "D" && $nm_apl_dependente != 1) 
   {
       $nmgp_saida_form = $_SESSION['scriptcase']['nm_sc_retorno'];
   }
   else
   {
       $nmgp_saida_form = $_SESSION['scriptcase']['sc_url_saida'][$this->Ini->sc_page];
   }
   if ($tipo == 2)
   {
       $nmgp_saida_form = "form_asp_requisitos_admvo_fim.php";
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['redir']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['redir'] == 'redir')
   {
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']);
   }
   unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['opc_ant']);
   if ($tipo == 2 && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['nm_run_menu']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['nm_run_menu'] == 1)
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['nm_run_menu'] = 2;
       $nmgp_saida_form = "form_asp_requisitos_admvo_fim.php";
   }
   $diretorio = explode("/", $nmgp_saida_form);
   $cont = count($diretorio);
   $apl = $diretorio[$cont - 1];
   $apl = str_replace(".php", "", $apl);
   $pos = strpos($apl, "?");
   if ($pos !== false)
   {
       $apl = substr($apl, 0, $pos);
   }
   if ($tipo != 1 && $tipo != 2)
   {
       unset($_SESSION['sc_session'][$this->Ini->sc_page][$apl]['where_orig']);
   }
   if ($this->NM_ajax_flag)
   {
       $sTarget = '_self';
       $this->NM_ajax_info['redir']['metodo']              = 'post';
       $this->NM_ajax_info['redir']['action']              = $nmgp_saida_form;
       $this->NM_ajax_info['redir']['target']              = $sTarget;
       $this->NM_ajax_info['redir']['script_case_init']    = $this->Ini->sc_page;
       if (0 == $tipo)
       {
           $this->NM_ajax_info['redir']['nmgp_url_saida'] = $this->nm_location;
       }
       form_asp_requisitos_admvo_pack_ajax_response();
       exit;
   }
?>
<!DOCTYPE html>

   <HTML>
   <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
    <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
    <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
    <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
    <META http-equiv="Pragma" content="no-cache"/>
    <link rel="shortcut icon" href="../_lib/img/grp__NM__ico__NM__grp__NM__ico__NM__favicon_posgrado.ico">
   </HEAD>
   <BODY>
   <FORM name="form_ok" method="POST" action="<?php echo $this->form_encode_input($nmgp_saida_form); ?>" target="_self">
<?php
   if ($tipo == 0)
   {
?>
     <INPUT type="hidden" name="nmgp_url_saida" value="<?php echo $this->form_encode_input($this->nm_location); ?>"> 
<?php
   }
?>
     <INPUT type="hidden" name="script_case_init" value="<?php echo $this->form_encode_input($this->Ini->sc_page); ?>"> 
   </FORM>
   <SCRIPT type="text/javascript">
      bLigEditLookupCall = <?php if ($this->lig_edit_lookup_call) { ?>true<?php } else { ?>false<?php } ?>;
      function scLigEditLookupCall()
      {
<?php
   if ($this->lig_edit_lookup && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['sc_modal'])
   {
?>
        parent.<?php echo $this->lig_edit_lookup_cb; ?>(<?php echo $this->lig_edit_lookup_row; ?>);
<?php
   }
   elseif ($this->lig_edit_lookup)
   {
?>
        opener.<?php echo $this->lig_edit_lookup_cb; ?>(<?php echo $this->lig_edit_lookup_row; ?>);
<?php
   }
?>
      }
      if (bLigEditLookupCall)
      {
        scLigEditLookupCall();
      }
<?php
if ($tipo == 2 && isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['masterValue']))
{
    if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['under_dashboard']) {
?>
var dbParentFrame = $(parent.document).find("[name='<?php echo $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['parent_widget']; ?>']");
if (dbParentFrame && dbParentFrame[0] && dbParentFrame[0].contentWindow.scAjaxDetailValue)
{
<?php
        foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['masterValue'] as $cmp_master => $val_master)
        {
?>
    dbParentFrame[0].contentWindow.scAjaxDetailValue('<?php echo $cmp_master ?>', '<?php echo $val_master ?>');
<?php
        }
        unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['masterValue']);
?>
}
<?php
    }
    else {
?>
if (parent && parent.scAjaxDetailValue)
{
<?php
        foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['masterValue'] as $cmp_master => $val_master)
        {
?>
    parent.scAjaxDetailValue('<?php echo $cmp_master ?>', '<?php echo $val_master ?>');
<?php
        }
        unset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['masterValue']);
?>
}
<?php
    }
}
?>
      document.form_ok.submit();
   </SCRIPT>
   </BODY>
   </HTML>
<?php
  exit;
}
    function getButtonIds($buttonName) {
        switch ($buttonName) {
            case "update":
                return array("sc_b_upd_t.sc-unique-btn-1");
                break;
            case "help":
                return array("sc_b_hlp_t");
                break;
            case "exit":
                return array("sc_b_sai_t.sc-unique-btn-2", "sc_b_sai_t.sc-unique-btn-4", "sc_b_sai_t.sc-unique-btn-3");
                break;
            case "birpara":
                return array("brec_b");
                break;
            case "first":
                return array("sc_b_ini_b.sc-unique-btn-5");
                break;
            case "back":
                return array("sc_b_ret_b.sc-unique-btn-6");
                break;
            case "forward":
                return array("sc_b_avc_b.sc-unique-btn-7");
                break;
            case "last":
                return array("sc_b_fim_b.sc-unique-btn-8");
                break;
        }

        return array($buttonName);
    } // getButtonIds

    function displayAppHeader()
    {
        if ($this->Embutida_call) {
            return;
        }
        if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['mostra_cab']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['mostra_cab'] == "N") {
            return;
        }
        if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['under_dashboard'] && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['compact_mode'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['dashboard_info']['maximized']) {
            return;
        }
        if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['link_info']['compact_mode']) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['link_info']['compact_mode']) {
            return;
        }
?>
    <tr><td class="sc-app-header">
<style>
    .scMenuTHeaderFont img, .scGridHeaderFont img , .scFormHeaderFont img , .scTabHeaderFont img , .scContainerHeaderFont img , .scFilterHeaderFont img { height:23px;}
</style>
<div class="scFormHeader" style="height: 54px; padding: 17px 15px; box-sizing: border-box;margin: -1px 0px 0px 0px;width: 100%;">
    <div class="scFormHeaderFont" style="float: left; text-transform: uppercase;"><?php if ($this->nmgp_opcao == "novo") { echo "" . $this->Ini->Nm_lang['lang_othr_frmi_title'] . " " . $this->Ini->Nm_lang['lang_tbl_asp_requisitos'] . ""; } else { echo "" . $this->Ini->Nm_lang['lang_othr_frmu_title'] . " " . $this->Ini->Nm_lang['lang_tbl_asp_requisitos'] . ""; } ?></div>
    <div class="scFormHeaderFont" style="float: right;"><?php echo date($this->dateDefaultFormat()); ?></div>
</div>
    </td></tr>
<?php
    }

    function displayAppFooter()
    {
    }

    function displayAppToolbars()
    {
        if (($this->Embutida_form || !$this->Embutida_call || $this->Grid_editavel || $this->Embutida_multi || ($this->Embutida_call && 'on' == $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['embutida_liga_form_btn_nav'])) && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] != "F" && $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['run_iframe'] != "R") {
        } else {
            return false;
        }
        return true;
    } // displayAppToolbars

    function displayTopToolbar()
    {
        if (!$this->displayAppToolbars()) {
            return;
        }
    } // displayTopToolbar

    function displayBottomToolbar()
    {
        if (!$this->displayAppToolbars()) {
            return;
        }
    } // displayBottomToolbar

    function getSummaryLine()
    {
        $summaryLine = "[" . $this->Ini->Nm_lang['lang_othr_smry_info'] . "]";
        $summaryLine = str_replace(
            [
                '?start?',
                '?final?',
                '?total?',
            ],
            [
                'total' == $this->form_paginacao ? 1 : $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] + 1,
                $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['reg_start'] + $this->summary_record_count,
                $_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['total'] + 1,
            ],
            $summaryLine
        );

        return $summaryLine;
    } // getSummaryLine

    function scGetColumnOrderRule($fieldName, &$orderColName, &$orderColOrient, &$orderColRule)
    {
        $sortRule = 'nosort';
        if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_cmp'] == $fieldName) {
            $orderColName = $fieldName;
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['form_asp_requisitos_admvo']['ordem_ord'] == " desc") {
                $orderColOrient = $nome_img = $this->Ini->Label_sort_desc;
                $orderColRule = $sortRule = 'desc';
            } else {
                $orderColOrient = $nome_img = $this->Ini->Label_sort_asc;
                $orderColRule = $sortRule = 'asc';
            }
        }
        return $sortRule;
    }

    function scGetColumnOrderIcon($fieldName, $sortRule)
    {        if ($this->scIsFieldNumeric($fieldName)) {
            $defaultOffIcon = 'asc' == $this->scGetDefaultFieldOrder($fieldName) ? "fas fa-sort-numeric-down" : "fas fa-sort-numeric-down-alt";
            if ('desc' == $sortRule) {
                return "<span class=\"fas fa-sort-numeric-down-alt sc-form-order-icon\"></span>";
            } elseif ('asc' == $sortRule) {
                return "<span class=\"fas fa-sort-numeric-down sc-form-order-icon\"></span>";
            } else {
                return "<span class=\"" . $defaultOffIcon . " sc-form-order-icon sc-form-order-icon-unused\"></span>";
            }
        } else {
            $defaultOffIcon = 'asc' == $this->scGetDefaultFieldOrder($fieldName) ? "fas fa-sort-alpha-down" : "fas fa-sort-alpha-down-alt";
            if ('desc' == $sortRule) {
                return "<span class=\"fas fa-sort-alpha-down-alt sc-form-order-icon\"></span>";
            } elseif ('asc' == $sortRule) {
                return "<span class=\"fas fa-sort-alpha-down sc-form-order-icon\"></span>";
            } else {
                return "<span class=\"" . $defaultOffIcon . " sc-form-order-icon sc-form-order-icon-unused\"></span>";
            }
        }
    }

    function scIsFieldNumeric($fieldName)
    {
        switch ($fieldName) {
            case "cc_correcto":
                return true;
            case "num_req":
                return true;
            case "id_asp_req":
                return true;
            case "id_asp_FK":
                return true;
            case "id_lisreq_FK":
                return true;
            case "cc_carta":
                return true;
            case "id_carga_req":
                return true;
            default:
                return false;
        }
        return false;
    }

    function scGetDefaultFieldOrder($fieldName)
    {
        switch ($fieldName) {
            case "cc_correcto":
                return 'desc';
            case "num_req":
                return 'desc';
            case "id_asp_req":
                return 'desc';
            case "id_asp_FK":
                return 'desc';
            case "id_lisreq_FK":
                return 'desc';
            case "cc_carta":
                return 'desc';
            case "fecha_revision":
                return 'desc';
            case "notas_internas":
                return 'desc';
            case "id_carga_req":
                return 'desc';
            case "fecha_alta":
                return 'desc';
            case "fecha_ult_act":
                return 'desc';
            default:
                return 'asc';
        }
        return 'asc';
    }

}
?>
