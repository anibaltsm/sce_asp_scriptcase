<?php
//
   include_once('respaldo_app_enbc_Login_session.php');
           include_once("../_lib/lib/php/fix.php");
   @ini_set('session.cookie_httponly', 1);
   @ini_set('session.use_only_cookies', 1);
   @ini_set('session.cookie_secure', 0);
   @session_start() ;
       if (!function_exists("sc_check_mobile"))
       {
           include_once("../_lib/lib/php/nm_check_mobile.php");
       }
       $_SESSION['scriptcase']['device_mobile'] = sc_check_mobile();
       $_SESSION['scriptcase']['proc_mobile']   = $_SESSION['scriptcase']['device_mobile'];
       if (!isset($_SESSION['scriptcase']['display_mobile']))
       {
           $_SESSION['scriptcase']['display_mobile'] = true;
       }
       if ($_SESSION['scriptcase']['device_mobile'])
       {
           if ($_SESSION['scriptcase']['display_mobile'] && isset($_POST['_sc_force_mobile']) && 'out' == $_POST['_sc_force_mobile'])
           {
               $_SESSION['scriptcase']['display_mobile'] = false;
           }
           elseif (!$_SESSION['scriptcase']['display_mobile'] && isset($_POST['_sc_force_mobile']) && 'in' == $_POST['_sc_force_mobile'])
           {
               $_SESSION['scriptcase']['display_mobile'] = true;
           }
       }
        if (isset($_GET['_sc_force_mobile'])) {
            $_SESSION['scriptcase']['force_mobile'] = 'Y' == $_GET['_sc_force_mobile'];
        }
        if (isset($_SESSION['scriptcase']['force_mobile'])) {
            if ($_SESSION['scriptcase']['force_mobile']) {
                $_SESSION['scriptcase']['device_mobile'] = true;
            }
            $_SESSION['scriptcase']['display_mobile'] = $_SESSION['scriptcase']['force_mobile'];
        }

   $_SESSION['scriptcase']['respaldo_app_enbc_Login']['error_buffer'] = '';

   $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_perfil']          = "conn_enbc";
   $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_prod']       = "";
   $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imagens']    = "";
   $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imag_temp']  = "";
   $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_cache']  = "";
   $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_doc']        = "";
   $NM_dir_atual = getcwd();
   if (empty($NM_dir_atual))
   {
       $str_path_sys  = (isset($_SERVER['SCRIPT_FILENAME'])) ? $_SERVER['SCRIPT_FILENAME'] : $_SERVER['ORIG_PATH_TRANSLATED'];
       $str_path_sys  = str_replace("\\", '/', $str_path_sys);
   }
   else
   {
       $sc_nm_arquivo = explode("/", $_SERVER['PHP_SELF']);
       $str_path_sys  = str_replace("\\", "/", getcwd()) . "/" . $sc_nm_arquivo[count($sc_nm_arquivo)-1];
   }
   //check publication with the prod
   $str_path_apl_url = $_SERVER['PHP_SELF'];
   $str_path_apl_url = str_replace("\\", '/', $str_path_apl_url);
   $str_path_apl_url = substr($str_path_apl_url, 0, strrpos($str_path_apl_url, "/"));
   $str_path_apl_url = substr($str_path_apl_url, 0, strrpos($str_path_apl_url, "/")+1);
   $str_path_apl_dir = substr($str_path_sys, 0, strrpos($str_path_sys, "/"));
   $str_path_apl_dir = substr($str_path_apl_dir, 0, strrpos($str_path_apl_dir, "/")+1);
   //check prod
   if(empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_prod']))
   {
           /*check prod*/$_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_prod'] = $str_path_apl_url . "_lib/prod";
   }
   //check img
   if(empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imagens']))
   {
           /*check img*/$_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imagens'] = $str_path_apl_url . "_lib/file/img";
   }
   //check tmp
   if(empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imag_temp']))
   {
           /*check tmp*/$_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imag_temp'] = $str_path_apl_url . "_lib/tmp";
   }
   //check cache
   if(empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_cache']))
   {
           /*check cache*/$_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_cache'] = $str_path_apl_dir . "_lib/file/cache";
   }
   //check doc
   if(empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_doc']))
   {
           /*check doc*/$_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_doc'] = $str_path_apl_dir . "_lib/file/doc";
   }
   //end check publication with the prod
//
class respaldo_app_enbc_Login_ini
{
   var $nm_cod_apl;
   var $nm_nome_apl;
   var $nm_seguranca;
   var $nm_grupo;
   var $nm_grupo_versao;
   var $nm_autor;
   var $nm_versao_sc;
   var $nm_tp_lic_sc;
   var $nm_dt_criacao;
   var $nm_hr_criacao;
   var $nm_autor_alt;
   var $nm_dt_ult_alt;
   var $nm_hr_ult_alt;
   var $nm_timestamp;
   var $cor_bg_table;
   var $border_grid;
   var $cor_bg_grid;
   var $cor_cab_grid;
   var $cor_borda;
   var $cor_txt_cab_grid;
   var $cab_fonte_tipo;
   var $cab_fonte_tamanho;
   var $rod_fonte_tipo;
   var $rod_fonte_tamanho;
   var $cor_rod_grid;
   var $cor_txt_rod_grid;
   var $cor_barra_nav;
   var $cor_titulo;
   var $cor_txt_titulo;
   var $titulo_fonte_tipo;
   var $titulo_fonte_tamanho;
   var $cor_grid_impar;
   var $cor_grid_par;
   var $cor_txt_grid;
   var $texto_fonte_tipo;
   var $texto_fonte_tamanho;
   var $cor_lin_grupo;
   var $cor_txt_grupo;
   var $grupo_fonte_tipo;
   var $grupo_fonte_tamanho;
   var $cor_lin_sub_tot;
   var $cor_txt_sub_tot;
   var $sub_tot_fonte_tipo;
   var $sub_tot_fonte_tamanho;
   var $cor_lin_tot;
   var $cor_txt_tot;
   var $tot_fonte_tipo;
   var $tot_fonte_tamanho;
   var $cor_link_cab;
   var $cor_link_dados;
   var $img_fun_pag;
   var $img_fun_cab;
   var $img_fun_rod;
   var $img_fun_tit;
   var $img_fun_gru;
   var $img_fun_tot;
   var $img_fun_sub;
   var $img_fun_imp;
   var $img_fun_par;
   var $root;
   var $server;
   var $sc_protocolo;
   var $path_prod;
   var $path_link;
   var $path_aplicacao;
   var $path_embutida;
   var $path_botoes;
   var $path_img_global;
   var $path_img_modelo;
   var $path_icones;
   var $path_imagens;
   var $path_imag_cab;
   var $path_imag_temp;
   var $path_libs;
   var $path_doc;
   var $str_lang;
   var $str_schema_all;
   var $str_google_fonts;
   var $str_conf_reg;
   var $path_cep;
   var $path_secure;
   var $path_js;
   var $path_adodb;
   var $path_grafico;
   var $path_atual;
   var $Gd_missing;
   var $sc_site_ssl;
   var $nm_cont_lin;
   var $nm_limite_lin;
   var $nm_limite_lin_prt;
   var $nm_falta_var;
   var $nm_falta_var_db;
   var $nm_tpbanco;
   var $nm_servidor;
   var $nm_usuario;
   var $nm_senha;
   var $nm_database_encoding;
   var $nm_arr_db_extra_args = array();
   var $nm_con_db2 = array();
   var $nm_con_persistente;
   var $nm_con_use_schema;
   var $nm_tabela;
   var $nm_col_dinamica   = array();
   var $nm_order_dinamico = array();
   var $nm_hidden_pages   = array();
   var $nm_page_names     = array();
   var $nm_page_blocks    = array();
   var $nm_block_page     = array();
   var $nm_hidden_blocos  = array();
   var $sc_tem_trans_banco;
   var $nm_bases_all;
   var $nm_bases_access;
   var $nm_bases_db2;
   var $nm_bases_ibase;
   var $nm_bases_informix;
   var $nm_bases_mssql;
   var $nm_bases_mysql;
   var $nm_bases_postgres;
   var $nm_bases_oracle;
   var $nm_bases_sqlite;
   var $nm_bases_sybase;
   var $nm_bases_vfp;
   var $nm_bases_odbc;
   var $nm_bases_progress;
   var $sc_page;
   var $sc_lig_md5 = array();
   var $sc_lig_target = array();
   var $sc_lig_iframe = array();
   var $force_db_utf8 = true;
//
   function init()
   {
       global
             $nm_url_saida, $nm_apl_dependente, $script_case_init;

      @ini_set('magic_quotes_runtime', 0);
      $this->sc_page = $script_case_init;
      $_SESSION['scriptcase']['sc_num_page'] = $script_case_init;
      $_SESSION['scriptcase']['sc_ctl_ajax'] = 'part';
      $_SESSION['scriptcase']['sc_cnt_sql']  = 0;
      $this->sc_charset['UTF-8'] = 'utf-8';
      $this->sc_charset['ISO-2022-JP'] = 'iso-2022-jp';
      $this->sc_charset['ISO-2022-KR'] = 'iso-2022-kr';
      $this->sc_charset['ISO-8859-1'] = 'iso-8859-1';
      $this->sc_charset['ISO-8859-2'] = 'iso-8859-2';
      $this->sc_charset['ISO-8859-3'] = 'iso-8859-3';
      $this->sc_charset['ISO-8859-4'] = 'iso-8859-4';
      $this->sc_charset['ISO-8859-5'] = 'iso-8859-5';
      $this->sc_charset['ISO-8859-6'] = 'iso-8859-6';
      $this->sc_charset['ISO-8859-7'] = 'iso-8859-7';
      $this->sc_charset['ISO-8859-8'] = 'iso-8859-8';
      $this->sc_charset['ISO-8859-8-I'] = 'iso-8859-8-i';
      $this->sc_charset['ISO-8859-9'] = 'iso-8859-9';
      $this->sc_charset['ISO-8859-10'] = 'iso-8859-10';
      $this->sc_charset['ISO-8859-13'] = 'iso-8859-13';
      $this->sc_charset['ISO-8859-14'] = 'iso-8859-14';
      $this->sc_charset['ISO-8859-15'] = 'iso-8859-15';
      $this->sc_charset['WINDOWS-1250'] = 'windows-1250';
      $this->sc_charset['WINDOWS-1251'] = 'windows-1251';
      $this->sc_charset['WINDOWS-1252'] = 'windows-1252';
      $this->sc_charset['TIS-620'] = 'tis-620';
      $this->sc_charset['WINDOWS-1253'] = 'windows-1253';
      $this->sc_charset['WINDOWS-1254'] = 'windows-1254';
      $this->sc_charset['WINDOWS-1255'] = 'windows-1255';
      $this->sc_charset['WINDOWS-1256'] = 'windows-1256';
      $this->sc_charset['WINDOWS-1257'] = 'windows-1257';
      $this->sc_charset['KOI8-R'] = 'koi8-r';
      $this->sc_charset['BIG-5'] = 'big5';
      $this->sc_charset['EUC-CN'] = 'EUC-CN';
      $this->sc_charset['GB18030'] = 'GB18030';
      $this->sc_charset['GB2312'] = 'gb2312';
      $this->sc_charset['EUC-JP'] = 'euc-jp';
      $this->sc_charset['SJIS'] = 'shift-jis';
      $this->sc_charset['EUC-KR'] = 'euc-kr';
      $_SESSION['scriptcase']['charset_entities']['UTF-8'] = 'UTF-8';
      $_SESSION['scriptcase']['charset_entities']['ISO-8859-1'] = 'ISO-8859-1';
      $_SESSION['scriptcase']['charset_entities']['ISO-8859-5'] = 'ISO-8859-5';
      $_SESSION['scriptcase']['charset_entities']['ISO-8859-15'] = 'ISO-8859-15';
      $_SESSION['scriptcase']['charset_entities']['WINDOWS-1251'] = 'cp1251';
      $_SESSION['scriptcase']['charset_entities']['WINDOWS-1252'] = 'cp1252';
      $_SESSION['scriptcase']['charset_entities']['BIG-5'] = 'BIG5';
      $_SESSION['scriptcase']['charset_entities']['EUC-CN'] = 'GB2312';
      $_SESSION['scriptcase']['charset_entities']['GB2312'] = 'GB2312';
      $_SESSION['scriptcase']['charset_entities']['SJIS'] = 'Shift_JIS';
      $_SESSION['scriptcase']['charset_entities']['EUC-JP'] = 'EUC-JP';
      $_SESSION['scriptcase']['charset_entities']['KOI8-R'] = 'KOI8-R';
      $_SESSION['scriptcase']['trial_version'] = 'N';
      $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['decimal_db'] = "."; 

      $this->nm_cod_apl      = "respaldo_app_enbc_Login"; 
      $this->nm_nome_apl     = "Login - Initial Application"; 
      $this->nm_seguranca    = ""; 
      $this->nm_grupo        = "SubsistemaENBC_dev"; 
      $this->nm_grupo_versao = "1"; 
      $this->nm_autor        = "admin"; 
      $this->nm_script_by    = "netmake"; 
      $this->nm_script_type  = "PHP"; 
      $this->nm_versao_sc    = "v9"; 
      $this->nm_tp_lic_sc    = "ep_bronze"; 
      $this->nm_dt_criacao   = "20240925"; 
      $this->nm_hr_criacao   = "151428"; 
      $this->nm_autor_alt    = "admin"; 
      $this->nm_dt_ult_alt   = "20241010"; 
      $this->nm_hr_ult_alt   = "193042"; 
      list($NM_usec, $NM_sec) = explode(" ", microtime()); 
      $this->nm_timestamp    = (float) $NM_sec; 
      $this->nm_app_version  = "1.0.0"; 
// 
      $this->border_grid           = ""; 
      $this->cor_bg_grid           = ""; 
      $this->cor_bg_table          = ""; 
      $this->cor_borda             = ""; 
      $this->cor_cab_grid          = ""; 
      $this->cor_txt_pag           = ""; 
      $this->cor_link_pag          = ""; 
      $this->pag_fonte_tipo        = ""; 
      $this->pag_fonte_tamanho     = ""; 
      $this->cor_txt_cab_grid      = ""; 
      $this->cab_fonte_tipo        = ""; 
      $this->cab_fonte_tamanho     = ""; 
      $this->rod_fonte_tipo        = ""; 
      $this->rod_fonte_tamanho     = ""; 
      $this->cor_rod_grid          = ""; 
      $this->cor_txt_rod_grid      = ""; 
      $this->cor_barra_nav         = ""; 
      $this->cor_titulo            = ""; 
      $this->cor_txt_titulo        = ""; 
      $this->titulo_fonte_tipo     = ""; 
      $this->titulo_fonte_tamanho  = ""; 
      $this->cor_grid_impar        = ""; 
      $this->cor_grid_par          = ""; 
      $this->cor_txt_grid          = ""; 
      $this->texto_fonte_tipo      = ""; 
      $this->texto_fonte_tamanho   = ""; 
      $this->cor_lin_grupo         = ""; 
      $this->cor_txt_grupo         = ""; 
      $this->grupo_fonte_tipo      = ""; 
      $this->grupo_fonte_tamanho   = ""; 
      $this->cor_lin_sub_tot       = ""; 
      $this->cor_txt_sub_tot       = ""; 
      $this->sub_tot_fonte_tipo    = ""; 
      $this->sub_tot_fonte_tamanho = ""; 
      $this->cor_lin_tot           = ""; 
      $this->cor_txt_tot           = ""; 
      $this->tot_fonte_tipo        = ""; 
      $this->tot_fonte_tamanho     = ""; 
      $this->cor_link_cab          = ""; 
      $this->cor_link_dados        = ""; 
      $this->img_fun_pag           = ""; 
      $this->img_fun_cab           = ""; 
      $this->img_fun_rod           = ""; 
      $this->img_fun_tit           = ""; 
      $this->img_fun_gru           = ""; 
      $this->img_fun_tot           = ""; 
      $this->img_fun_sub           = ""; 
      $this->img_fun_imp           = ""; 
      $this->img_fun_par           = ""; 
// 
      $NM_dir_atual = getcwd();
      if (empty($NM_dir_atual))
      {
          $str_path_sys          = (isset($_SERVER['SCRIPT_FILENAME'])) ? $_SERVER['SCRIPT_FILENAME'] : $_SERVER['ORIG_PATH_TRANSLATED'];
          $str_path_sys          = str_replace("\\", '/', $str_path_sys);
      }
      else
      {
          $sc_nm_arquivo         = explode("/", $_SERVER['PHP_SELF']);
          $str_path_sys          = str_replace("\\", "/", getcwd()) . "/" . $sc_nm_arquivo[count($sc_nm_arquivo)-1];
      }
      //check publication with the prod
      $str_path_apl_url = $_SERVER['PHP_SELF'];
      $str_path_apl_url = str_replace("\\", '/', $str_path_apl_url);
      $str_path_apl_url = substr($str_path_apl_url, 0, strrpos($str_path_apl_url, "/"));
      $str_path_apl_url = substr($str_path_apl_url, 0, strrpos($str_path_apl_url, "/")+1);
      $str_path_apl_dir = substr($str_path_sys, 0, strrpos($str_path_sys, "/"));
      $str_path_apl_dir = substr($str_path_apl_dir, 0, strrpos($str_path_apl_dir, "/")+1);
// 
      $this->sc_site_ssl     = (isset($_SERVER['HTTP_REFERER']) && strtolower(substr($_SERVER['HTTP_REFERER'], 0, 5)) == 'https') ? true : false;
      $this->sc_protocolo    = ($this->sc_site_ssl) ? 'https://' : 'http://';
      $this->path_prod       = $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_prod'];
      $this->path_imagens    = $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imagens'];
      $this->path_imag_temp  = $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imag_temp'];
      $this->path_cache      = $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_cache'];
      $this->path_doc        = $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_doc'];
      if (!isset($_SESSION['scriptcase']['str_lang']) || empty($_SESSION['scriptcase']['str_lang']))
      {
          $_SESSION['scriptcase']['str_lang'] = "es";
      }
      if (!isset($_SESSION['scriptcase']['str_conf_reg']) || empty($_SESSION['scriptcase']['str_conf_reg']))
      {
          $_SESSION['scriptcase']['str_conf_reg'] = "es_mx";
      }
      $this->str_lang        = $_SESSION['scriptcase']['str_lang'];
      $this->str_conf_reg    = $_SESSION['scriptcase']['str_conf_reg'];
      $this->str_schema_all  = (isset($_SESSION['scriptcase']['str_schema_all']) && !empty($_SESSION['scriptcase']['str_schema_all'])) ? $_SESSION['scriptcase']['str_schema_all'] : "Sc9_Lemon/Sc9_Lemon";
      $this->str_google_fonts  = isset($str_google_fonts)?$str_google_fonts:'';
      $this->server          = (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
      if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80 && !$this->sc_site_ssl )
      {
          $this->server         .= ":" . $_SERVER['SERVER_PORT'];
      }
      $this->server_pdf      = $this->sc_protocolo . $this->server;
      $this->server          = "";
      $this->sc_protocolo    = "";
      $str_path_web          = $_SERVER['PHP_SELF'];
      $str_path_web          = str_replace("\\", '/', $str_path_web);
      $str_path_web          = str_replace('//', '/', $str_path_web);
      $this->root            = substr($str_path_sys, 0, -1 * strlen($str_path_web));
      $this->path_aplicacao  = substr($str_path_sys, 0, strrpos($str_path_sys, '/'));
      $this->path_aplicacao  = substr($this->path_aplicacao, 0, strrpos($this->path_aplicacao, '/')) . '/respaldo_app_enbc_Login';
      $this->path_embutida   = substr($this->path_aplicacao, 0, strrpos($this->path_aplicacao, '/') + 1);
      $this->path_aplicacao .= '/';
      $this->path_link       = substr($str_path_web, 0, strrpos($str_path_web, '/'));
      $this->path_link       = substr($this->path_link, 0, strrpos($this->path_link, '/')) . '/';
      $this->path_help       = $this->path_link . "_lib/webhelp/";
      $this->path_lang       = "../_lib/lang/";
      $this->path_lang_js    = "../_lib/js/";
      $this->path_botoes     = $this->path_link . "_lib/img";
      $this->path_img_global = $this->path_link . "_lib/img";
      $this->path_img_modelo = $this->path_link . "_lib/img";
      $this->path_icones     = $this->path_link . "_lib/img";
      $this->path_imag_cab   = $this->path_link . "_lib/img";
      $this->path_btn        = $this->root . $this->path_link . "_lib/buttons/";
      $this->path_css        = $this->root . $this->path_link . "_lib/css/";
      $this->path_lib_php    = $this->root . $this->path_link . "_lib/lib/php/";
      $this->url_lib_js      = $this->path_link . "_lib/lib/js/";
      $this->url_lib         = $this->path_link . '/_lib/';
      $this->url_third       = $this->path_prod . '/third/';
      $this->path_cep        = $this->path_prod . "/cep";
      $this->path_cor        = $this->path_prod . "/cor";
      $this->path_js         = $this->path_prod . "/lib/js";
      $this->path_libs       = $this->root . $this->path_prod . "/lib/php";
      $this->path_third      = $this->root . $this->path_prod . "/third";
      $this->path_adodb      = $this->root . $this->path_prod . "/third/adodb";

      include("../_lib/css/" . $this->str_schema_all . "_form.php");
      $temp_Str_btn_form    = trim($str_button);
      include($this->path_btn . $temp_Str_btn_form . '/' . $temp_Str_btn_form . $_SESSION['scriptcase']['reg_conf']['css_dir'] . '.php');
      $this->css_help_tooltip_faicon = !isset($css_help_tooltip_faicon) || "" == trim($css_help_tooltip_faicon) ? "fas fa-question-circle" : trim($css_help_tooltip_faicon);
      $this->css_schema_info_tooltiptheme = !isset($css_schema_info_tooltiptheme) || "" == trim($css_schema_info_tooltiptheme) ? "" : trim($css_schema_info_tooltiptheme);
      $this->tippy_themes = [];
      $this->tippy_theme_default = '';
      if ('' != $this->css_schema_info_tooltiptheme) {
          $this->scGetTippyCssTheme($this->tippy_themes, $this->css_schema_info_tooltiptheme);
          $this->tippy_theme_default = $this->css_schema_info_tooltiptheme;
      }

      $_SESSION['scriptcase']['dir_temp'] = $this->root . $this->path_imag_temp;
      if (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['lang'])) {
          $this->str_lang = $_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['lang'];
      }
      elseif (!isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['actual_lang']) || $_SESSION['scriptcase']['respaldo_app_enbc_Login']['actual_lang'] != $this->str_lang) {
          $_SESSION['scriptcase']['respaldo_app_enbc_Login']['actual_lang'] = $this->str_lang;
          setcookie('sc_actual_lang_SubsistemaENBC_dev',$this->str_lang,'0','/', '', ini_get('session.cookie_secure'), ini_get('session.cookie_httponly'));
      }
      global $inicial_respaldo_app_enbc_Login;
      if (isset($_SESSION['scriptcase']['user_logout']))
      {
          foreach ($_SESSION['scriptcase']['user_logout'] as $ind => $parms)
          {
              if (isset($_SESSION[$parms['V']]) && $_SESSION[$parms['V']] == $parms['U'])
              {
                  $nm_apl_dest = $parms['R'];
                  $dir = explode("/", $nm_apl_dest);
                  if (count($dir) == 1)
                  {
                      $nm_apl_dest = str_replace(".php", "", $nm_apl_dest);
                      $nm_apl_dest = $this->path_link . SC_dir_app_name($nm_apl_dest) . "/";
                  }
                  unset($_SESSION['scriptcase']['user_logout'][$ind]);
                  if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag) && $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag)
                  {
                      $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']['action']  = $nm_apl_dest;
                      $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']['target']  = $parms['T'];
                      $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']['metodo']  = "post";
                      $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']['script_case_init']  = $this->sc_page;
                      respaldo_app_enbc_Login_pack_ajax_response();
                      exit;
                  }
?>
                  <!DOCTYPE html>
                  <html>
                  <body>
                  <form name="FRedirect" method="POST" action="<?php echo $nm_apl_dest; ?>" target="<?php echo $parms['T']; ?>">
                  </form>
                  <script>
                   document.FRedirect.submit();
                  </script>
                  </body>
                  </html>
<?php
                  exit;
              }
          }
      }
      $str_path = substr($this->path_prod, 0, strrpos($this->path_prod, '/') + 1); 
      if (!is_file($this->root . $str_path . 'devel/class/xmlparser/nmXmlparserIniSys.class.php'))
      {
          unset($_SESSION['scriptcase']['nm_sc_retorno']);
          unset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao']);
      }
      include($this->path_lang . $this->str_lang . ".lang.php");
      include($this->path_lang . "config_region.php");
      include($this->path_lang . "lang_config_region.php");
      $_SESSION['scriptcase']['charset'] = "UTF-8";
      ini_set('default_charset', $_SESSION['scriptcase']['charset']);
      $_SESSION['scriptcase']['charset_html']  = (isset($this->sc_charset[$_SESSION['scriptcase']['charset']])) ? $this->sc_charset[$_SESSION['scriptcase']['charset']] : $_SESSION['scriptcase']['charset'];

      asort($this->Nm_lang_conf_region);
      foreach ($this->Nm_lang_conf_region as $ind => $dados)
      {
         if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($dados))
         {
             $this->Nm_lang_conf_region[$ind] = sc_convert_encoding($dados, $_SESSION['scriptcase']['charset'], "UTF-8");
         }
      }
      if (isset($this->Nm_lang['lang_errm_dbcn_conn']))
      {
          $_SESSION['scriptcase']['db_conn_error'] = $this->Nm_lang['lang_errm_dbcn_conn'];
      }
      if (!function_exists("mb_convert_encoding"))
      {
          echo "<div><font size=6>" . $this->Nm_lang['lang_othr_prod_xtmb'] . "</font></div>";exit;
      } 
      elseif (!function_exists("sc_convert_encoding"))
      {
          echo "<div><font size=6>" . $this->Nm_lang['lang_othr_prod_xtsc'] . "</font></div>";exit;
      } 
      foreach ($this->Nm_conf_reg[$this->str_conf_reg] as $ind => $dados)
      {
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($dados))
          {
              $this->Nm_conf_reg[$this->str_conf_reg][$ind] = sc_convert_encoding($dados, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
      }
      $this->Nm_lang['lang_errm_ajax_rqrd'] = $this->Nm_lang['lang_errm_ajax_rqrd'];
      foreach ($this->Nm_lang as $ind => $dados)
      {
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($ind))
          {
              $ind = sc_convert_encoding($ind, $_SESSION['scriptcase']['charset'], "UTF-8");
              $this->Nm_lang[$ind] = $dados;
          }
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($dados))
          {
              $this->Nm_lang[$ind] = sc_convert_encoding($dados, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->Nm_lang[$ind] = str_replace('"', '&quot;',  $this->Nm_lang[$ind]);
      }
      if (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir'])) {
          $SS_cod_html  = '<!DOCTYPE html>

';
          $SS_cod_html .= "<HTML>\r\n";
          $SS_cod_html .= " <HEAD>\r\n";
          $SS_cod_html .= "  <TITLE></TITLE>\r\n";
          $SS_cod_html .= "   <META http-equiv=\"Content-Type\" content=\"text/html; charset=" . $_SESSION['scriptcase']['charset_html'] . "\"/>\r\n";
          if ($_SESSION['scriptcase']['proc_mobile']) {
              $SS_cod_html .= "   <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\"/>\r\n";
          }
          $SS_cod_html .= "   <META http-equiv=\"Expires\" content=\"Fri, Jan 01 1900 00:00:00 GMT\"/>\r\n";
          $SS_cod_html .= "    <META http-equiv=\"Pragma\" content=\"no-cache\"/>\r\n";
          if ($_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir_tp'] == "R") {
              $SS_cod_html .= "  </HEAD>\r\n";
              $SS_cod_html .= "   <body>\r\n";
          }
          else {
              $SS_cod_html .= "    <link rel=\"shortcut icon\" href=\"../_lib/img/grp__NM__bg__NM__favicon-16x16.png\">\r\n";
              $SS_cod_html .= "    <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->str_schema_all . "_form.css\"/>\r\n";
              $SS_cod_html .= "    <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->str_schema_all . "_form" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css\"/>\r\n";
              $SS_cod_html .= "  </HEAD>\r\n";
              $SS_cod_html .= "   <body class=\"scFormPage\">\r\n";
              $SS_cod_html .= "    <table align=\"center\"><tr><td style=\"padding: 0\"><div class=\"scFormBorder\">\r\n";
              $SS_cod_html .= "    <table width='100%' cellspacing=0 cellpadding=0><tr><td class=\"scFormDataOdd\" style=\"padding: 15px 30px; text-align: center\">\r\n";
              $SS_cod_html .= $this->Nm_lang['lang_errm_expired_session'] . "\r\n";
              $SS_cod_html .= "     <form name=\"Fsession_redir\" method=\"post\"\r\n";
              $SS_cod_html .= "           target=\"_self\">\r\n";
              $SS_cod_html .= "           <input type=\"button\" name=\"sc_sai_seg\" value=\"OK\" onclick=\"sc_session_redir('" . $_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir'] . "');\">\r\n";
              $SS_cod_html .= "     </form>\r\n";
              $SS_cod_html .= "    </td></tr></table>\r\n";
              $SS_cod_html .= "    </div></td></tr></table>\r\n";
          }
          $SS_cod_html .= "    <script type=\"text/javascript\">\r\n";
          if ($_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir_tp'] == "R") {
              $SS_cod_html .= "      sc_session_redir('" . $_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir'] . "');\r\n";
          }
          $SS_cod_html .= "      function sc_session_redir(url_redir)\r\n";
          $SS_cod_html .= "      {\r\n";
          $SS_cod_html .= "         if (window.parent && window.parent.document != window.document && typeof window.parent.sc_session_redir === 'function')\r\n";
          $SS_cod_html .= "         {\r\n";
          $SS_cod_html .= "            window.parent.sc_session_redir(url_redir);\r\n";
          $SS_cod_html .= "         }\r\n";
          $SS_cod_html .= "         else\r\n";
          $SS_cod_html .= "         {\r\n";
          $SS_cod_html .= "             if (window.opener && typeof window.opener.sc_session_redir === 'function')\r\n";
          $SS_cod_html .= "             {\r\n";
          $SS_cod_html .= "                 window.close();\r\n";
          $SS_cod_html .= "                 window.opener.sc_session_redir(url_redir);\r\n";
          $SS_cod_html .= "             }\r\n";
          $SS_cod_html .= "             else\r\n";
          $SS_cod_html .= "             {\r\n";
          $SS_cod_html .= "                 window.location = url_redir;\r\n";
          $SS_cod_html .= "             }\r\n";
          $SS_cod_html .= "         }\r\n";
          $SS_cod_html .= "      }\r\n";
          $SS_cod_html .= "    </script>\r\n";
          $SS_cod_html .= " </body>\r\n";
          $SS_cod_html .= "</HTML>\r\n";
          unset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']);
          unset($_SESSION['sc_session']);
      }
      if (isset($SS_cod_html) && isset($_GET['nmgp_opcao']) && (substr($_GET['nmgp_opcao'], 0, 14) == "ajax_aut_comp_" || substr($_GET['nmgp_opcao'], 0, 13) == "ajax_autocomp"))
      {
          unset($_SESSION['sc_session']);
          $oJson = new Services_JSON();
          echo $oJson->encode("ss_time_out");
          exit;
      }
      elseif (isset($SS_cod_html) && isset($_POST['nmgp_opcao']) && ($_POST['nmgp_opcao'] == "ajax_dyn_refresh_field" || $_POST['nmgp_opcao'] == "ajax_add_dyn_search" || $_POST['nmgp_opcao'] == "ajax_ch_bi_dyn_search"))
      {
          unset($_SESSION['sc_session']);
          $this->Arr_result = array();
          $this->Arr_result['ss_time_out'] = true;
          $oJson = new Services_JSON();
          echo $oJson->encode($this->Arr_result);
          exit;
      }
      elseif (isset($SS_cod_html) && isset($_POST['rs']) && !is_array($_POST['rs']) && 'ajax_' == substr($_POST['rs'], 0, 5) && isset($_POST['rsargs']) && !empty($_POST['rsargs']))
      {
          $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']['action']  = "./";
          $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']['target']  = "_self";
          $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']['metodo']  = "post";
          $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']['script_case_init']  = $this->sc_page;
          respaldo_app_enbc_Login_pack_ajax_response();
          exit;
      }
      elseif (isset($SS_cod_html))
      {
          echo $SS_cod_html;
          exit;
      }
      if (isset($_SESSION['sc_session']['SC_parm_violation']) && !isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir']))
      {
          unset($_SESSION['sc_session']['SC_parm_violation']);
          echo "<!DOCTYPE html>";
          echo "<html>";
          echo "<body>";
          echo "<table align=\"center\" width=\"50%\" border=1 height=\"50px\">";
          echo "<tr>";
          echo "   <td align=\"center\">";
          echo "       <b><font size=4>" . $this->Nm_lang['lang_errm_ajax_data'] . "</font>";
          echo "   </b></td>";
          echo " </tr>";
          echo "</table>";
          echo "</body>";
          echo "</html>";
          exit;
      }
      $PHP_ver = str_replace(".", "", phpversion()); 
      if (substr($PHP_ver, 0, 3) < 434)
      {
          echo "<div><font size=6>" . $this->Nm_lang['lang_othr_prod_phpv'] . "</font></div>";exit;
      }
      if (file_exists($this->path_libs . "/ver.dat"))
      {
          $SC_ver = file($this->path_libs . "/ver.dat"); 
          $SC_ver = str_replace(".", "", $SC_ver[0]); 
          if (substr($SC_ver, 0, 5) < 40015)
          {
              echo "<div><font size=6>" . $this->Nm_lang['lang_othr_prod_incp'] . "</font></div>";exit;
          } 
      } 
      if (-1 != version_compare(phpversion(), '5.0.0'))
      {
         $this->path_grafico    = $this->root . $this->path_prod . "/third/jpgraph5/src";
      }
      else
      {
          $this->path_grafico    = $this->root . $this->path_prod . "/third/jpgraph4/src";
      }
      $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['path_doc'] = $this->path_doc; 
      $_SESSION['scriptcase']['nm_path_prod'] = $this->root . $this->path_prod . "/"; 
      $_SESSION['scriptcase']['nm_root_cep']  = $this->root; 
      $_SESSION['scriptcase']['nm_path_cep']  = $this->path_cep; 
      if (empty($this->path_imag_cab))
      {
          $this->path_imag_cab = $this->path_img_global;
      }
      if (!isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu'])) {
          $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu'] = "";
      }
      if (!isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'])) {
          $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] = "";
      }
      if (!is_dir($this->root . $this->path_prod))
      {
          $str_message = "<html>

<head>
    <title>{var_str_title}</title>
    <style>
        body {
            margin: 0px;
            padding: 0px;
            overflow-x: hidden;
            min-width: 320px;
            background: #FFFFFF;
            font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.4285em;
            color: rgba(0, 0, 0, 0.87);
            font-smoothing: antialiased;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        user agent stylesheet body {
            display: block;
            margin: 8px;
        }

        html {
            font-size: 14px;
        }

        html {
            line-height: 1.15;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        ::selection {
            background-color: #CCE2FF;
            color: rgba(0, 0, 0, 0.87);
        }

        .ui.container {
            width: 933px;
            min-width: 992px;
            max-width: 1199px;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .ui.container {
            display: block;
            max-width: 100% !important;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        .ui.message:last-child {
            margin-bottom: 0em;
        }

        .ui.message:first-child {
            margin-top: 0em;
        }

        .ui.message {
            font-size: 1em;
        }

        .ui.message {
            position: relative;
            min-height: 1em;
            margin: 1em 0em;
            background: #F8F8F9;
            padding: 1em 1.5em;
            line-height: 1.4285em;
            color: rgba(0, 0, 0, 0.87);
            transition: opacity 0.1s ease, color 0.1s ease, background 0.1s ease, box-shadow 0.1s ease;
            border-radius: 0.28571429rem;
            box-shadow: 0px 0px 0px 1px rgba(34, 36, 38, 0.22) inset, 0px 0px 0px 0px rgba(0, 0, 0, 0);
        }

        article,
        aside,
        footer,
        header,
        nav,
        section {
            display: block;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        .ui.message> :last-child {
            margin-bottom: 0em;
        }

        .ui.message> :first-child {
            margin-top: 0em;
        }

        .ui.message .header+p {
            margin-top: 0.25em;
        }

        .ui.message p {
            opacity: 0.85;
            margin: 0.75em 0em;
        }

        p {
            margin: 0em 0em 1em;
            line-height: 1.4285em;
        }

        .ui.message .header:not(.ui) {
            font-size: 1.14285714em;
        }

        .ui.message .header {
            display: block;
            font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-weight: bold;
            margin: -0.14285714em 0em 1.2rem 0em;
        }

        .ui.button {
            cursor: pointer;
            display: inline-block;
            min-height: 1em;
            outline: 0;
            border: none;
            vertical-align: baseline;
            background: #e0e1e2 none;
            color: rgba(0, 0, 0, .6);
            font-family: Lato, 'Helvetica Neue', Arial, Helvetica, sans-serif;
            margin: 0 .25em 0 0;
            padding: .78571429em 1.5em .78571429em;
            text-transform: none;
            text-shadow: none;
            font-weight: 700;
            line-height: 1em;
            font-style: normal;
            text-align: center;
            text-decoration: none;
            border-radius: .28571429rem;
            box-shadow: 0 0 0 1px transparent inset, 0 0 0 0 rgba(34, 36, 38, .15) inset;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            transition: opacity .1s ease, background-color .1s ease, color .1s ease, box-shadow .1s ease, background .1s ease;
            will-change: '';
            -webkit-tap-highlight-color: transparent;
        }
        
        .ui.button,
        .ui.buttons .button,
        .ui.buttons .or {
            font-size: 1rem;
            flex-flow: row nowrap;
            justify-content: center;
            align-items: center;
            column-gap: .5rem;
            display: flex;
        }
        
        .ui.primary.button,
        .ui.primary.buttons .button {
            background-color: #2185d0;
            color: #fff;
            text-shadow: none;
            background-image: none;
        }
        
        .ui.primary.button {
            box-shadow: 0 0 0 0 rgba(34, 36, 38, .15) inset;
        }

        [type=reset], [type=submit], button, html [type=button] {
            -webkit-appearance: button;
        }

        .icon{
            position: relative;
            width: 1.2rem;
            height: 1.2rem;
            display: block;
            color: inherit;
            background-repeat: no-repeat;
        }

        .icon.database{
            background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" fill=\"%23FFFFFF\"><path d=\"M448 80v48c0 44.2-100.3 80-224 80S0 172.2 0 128V80C0 35.8 100.3 0 224 0S448 35.8 448 80zM393.2 214.7c20.8-7.4 39.9-16.9 54.8-28.6V288c0 44.2-100.3 80-224 80S0 332.2 0 288V186.1c14.9 11.8 34 21.2 54.8 28.6C99.7 230.7 159.5 240 224 240s124.3-9.3 169.2-25.3zM0 346.1c14.9 11.8 34 21.2 54.8 28.6C99.7 390.7 159.5 400 224 400s124.3-9.3 169.2-25.3c20.8-7.4 39.9-16.9 54.8-28.6V432c0 44.2-100.3 80-224 80S0 476.2 0 432V346.1z\"/></svg>');
        }
    </style>
</head>

<body>
    <div class='ui container' style='padding-top:2rem'>
        <section class='ui message'>
            <div class='content'>
                <div class='header'>
                    <h1 class='ui header'>{var_str_title}</h1>
                </div>
                <p>{var_str_message}</p>
                <p>{var_str_message_conn}</p>
                {v_str_btn_inside}
            </div>
        </section>
    </div>";
          $str_message_end = "</body>
</html>";
          $str_message = str_replace('{var_str_title}', $this->Nm_lang['lang_errm_cmlb_nfndtitle'], $str_message);
          $str_message = str_replace('{var_str_message}', $this->Nm_lang['lang_errm_cmlb_nfnd'], $str_message);
          $str_message = str_replace('{v_str_btn_inside}', '', $str_message);
          echo $str_message;
          if (!$_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu'] && (!isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan']) || $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan'] != 'respaldo_app_enbc_Login')) 
          { 
              if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno'])) 
              { 
?>
                  <input type="button" id="sai" onClick="window.location='<?php echo $_SESSION['scriptcase']['nm_sc_retorno'] ?>'; return false" class="scButton_default" value="<?php echo $this->Nm_lang['lang_btns_back'] ?>" title="<?php echo $this->Nm_lang['lang_btns_back_hint'] ?>" style="<?php echo $sCondStyle; ?>vertical-align: middle;display: ''">

<?php
              } 
              else 
              { 
?>
                  <input type="button" id="sai" onClick="window.location='<?php echo $nm_url_saida ?>'; return false" class="scButton_default" value="<?php echo $this->Nm_lang['lang_btns_exit'] ?>" title="<?php echo $this->Nm_lang['lang_btns_exit_hint'] ?>" style="<?php echo $sCondStyle; ?>vertical-align: middle;display: ''">

<?php
              } 
          } 
          echo $str_message_end;
          exit ;
      }

      $this->path_atual  = getcwd();
      $opsys = strtolower(php_uname());

      global $under_dashboard, $dashboard_app, $own_widget, $parent_widget, $compact_mode, $remove_margin, $remove_border, $remove_background;
      if (!isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['under_dashboard']))
      {
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['under_dashboard'] = false;
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['dashboard_app']   = '';
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['own_widget']      = '';
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['parent_widget']   = '';
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['compact_mode']    = false;
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_margin']   = false;
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_border']   = false;
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_background'] = false;
      }
      if (isset($_GET['under_dashboard']) && 1 == $_GET['under_dashboard'])
      {
          if (isset($_GET['own_widget']) && 'dbifrm_widget' == substr($_GET['own_widget'], 0, 13)) {
              $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['own_widget'] = $_GET['own_widget'];
              $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['under_dashboard'] = true;
              if (isset($_GET['dashboard_app'])) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['dashboard_app'] = $_GET['dashboard_app'];
              }
              if (isset($_GET['parent_widget'])) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['parent_widget'] = $_GET['parent_widget'];
              }
              if (isset($_GET['compact_mode'])) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['compact_mode'] = 1 == $_GET['compact_mode'];
              }
              if (isset($_GET['remove_margin'])) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_margin'] = 1 == $_GET['remove_margin'];
              }
              if (isset($_GET['remove_border'])) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_border'] = 1 == $_GET['remove_border'];
              }
              if (isset($_GET['remove_background'])) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_background'] = 1 == $_GET['remove_background'];
              }
          }
      }
      elseif (isset($under_dashboard) && 1 == $under_dashboard)
      {
          if (isset($own_widget) && 'dbifrm_widget' == substr($own_widget, 0, 13)) {
              $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['own_widget'] = $own_widget;
              $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['under_dashboard'] = true;
              if (isset($dashboard_app)) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['dashboard_app'] = $dashboard_app;
              }
              if (isset($parent_widget)) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['parent_widget'] = $parent_widget;
              }
              if (isset($compact_mode)) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['compact_mode'] = 1 == $compact_mode;
              }
              if (isset($remove_margin)) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_margin'] = 1 == $remove_margin;
              }
              if (isset($remove_border)) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_border'] = 1 == $remove_border;
              }
              if (isset($remove_background)) {
                  $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['remove_background'] = 1 == $remove_background;
              }
          }
      }
      if (!isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['maximized']))
      {
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['maximized'] = false;
      }
      if (isset($_GET['maximized']))
      {
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['maximized'] = 1 == $_GET['maximized'];
      }
      if ($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['under_dashboard'])
      {
          $sTmpDashboardApp = $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['dashboard_info']['dashboard_app'];
          if ('' != $sTmpDashboardApp && isset($_SESSION['scriptcase']['dashboard_targets'][$sTmpDashboardApp]["respaldo_app_enbc_Login"]))
          {
              foreach ($_SESSION['scriptcase']['dashboard_targets'][$sTmpDashboardApp]["respaldo_app_enbc_Login"] as $sTmpTargetLink => $sTmpTargetWidget)
              {
                  if (isset($this->sc_lig_target[$sTmpTargetLink]))
                  {
                      if (isset($this->sc_lig_iframe[$this->sc_lig_target[$sTmpTargetLink]]))
                      {
                          $this->sc_lig_iframe[$this->sc_lig_target[$sTmpTargetLink]] = $sTmpTargetWidget;
                      }
                      $this->sc_lig_target[$sTmpTargetLink] = $sTmpTargetWidget;
                  }
              }
          }
      }
        global $link_compact_mode, $link_remove_margin, $link_remove_border, $link_remove_background, $link_margin_top;
        if (isset($link_compact_mode) && 'ok' == $link_compact_mode) {
            if (!isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'])) {
                $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'] = array();
            }
            $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info']['compact_mode'] = true;
        }
        if (isset($link_remove_margin) && 'ok' == $link_remove_margin) {
            if (!isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'])) {
                $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'] = array();
            }
            $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info']['remove_margin'] = true;
        }
        if (isset($link_remove_border) && 'ok' == $link_remove_border) {
            if (!isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'])) {
                $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'] = array();
            }
            $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info']['remove_border'] = true;
        }
        if (isset($link_remove_background) && 'ok' == $link_remove_background) {
            if (!isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'])) {
                $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'] = array();
            }
            $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info']['remove_background'] = true;
        }
        if (isset($link_margin_top) && '' != $link_margin_top) {
            if (!isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'])) {
                $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info'] = array();
            }
            $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['link_info']['margin_top'] = $link_margin_top;
        }

      $this->nm_cont_lin       = 0;
      $this->nm_limite_lin     = 0;
      $this->nm_limite_lin_prt = 0;
// 
      include_once($this->path_adodb . "/adodb.inc.php");
      $this->sc_Include($this->path_libs . "/nm_sec_prod.php", "F", "nm_reg_prod");
      $this->sc_Include($this->path_libs . "/nm_ini_perfil.php", "F", "perfil_lib");
      if(function_exists('set_php_timezone'))  set_php_timezone('respaldo_app_enbc_Login'); 
      $this->sc_Include($this->path_lib_php . "/nm_data.class.php", "C", "nm_data") ; 
      $this->sc_Include($this->path_lib_php . "/nm_edit.php", "F", "nmgp_Form_Num_Val") ; 
      $this->sc_Include($this->path_lib_php . "/nm_conv_dados.php", "F", "nm_conv_limpa_dado") ; 
      $this->sc_Include($this->path_lib_php . "/nm_functions.php", "", "") ; 
      global $bol_api_prod; 
      $bol_api_prod = true; 
      if (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao']) && !empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'])) 
      { 
          $bol_api_prod = false;
      } 
      $this->sc_Include($this->path_lib_php . "/nm_api.php", "", "") ; 
      $this->sc_Include($this->path_lib_php . "/fix.php", "", "") ; 
      $this->nm_data = new nm_data("es");
      global $inicial_respaldo_app_enbc_Login, $NM_run_iframe;
      if ((isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag) && $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag) || (isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['embutida_call']) && $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['embutida_call']) || $NM_run_iframe == 1)
      {
           $_SESSION['scriptcase']['sc_ctl_ajax'] = 'part';
      }
      perfil_lib($this->path_libs);
      if (!isset($_SESSION['sc_session'][$this->sc_page]['SC_Check_Perfil']))
      {
          if(function_exists("nm_check_perfil_exists")) nm_check_perfil_exists($this->path_libs, $this->path_prod);
          $_SESSION['sc_session'][$this->sc_page]['SC_Check_Perfil'] = true;
      }
      if (function_exists("nm_check_pdf_server")) $this->server_pdf = nm_check_pdf_server($this->path_libs, $this->server_pdf);
      if (!isset($_SESSION['scriptcase']['sc_num_img']) || empty($_SESSION['scriptcase']['sc_num_img']))
      { 
          $_SESSION['scriptcase']['sc_num_img'] = 1; 
      } 
      $this->Export_img_zip = false;;
      $this->Img_export_zip  = array();
      $this->regionalDefault();
      $this->sc_tem_trans_banco = false;
      $this->nm_bases_access     = array("access", "ado_access", "ace_access");
      $this->nm_bases_db2        = array("db2", "db2_odbc", "odbc_db2", "odbc_db2v6", "pdo_db2_odbc", "pdo_ibm");
      $this->nm_bases_ibase      = array("ibase", "firebird", "pdo_firebird", "borland_ibase");
      $this->nm_bases_informix   = array("informix", "informix72", "pdo_informix");
      $this->nm_bases_mssql      = array("mssql", "ado_mssql", "adooledb_mssql", "odbc_mssql", "mssqlnative", "pdo_sqlsrv", "pdo_dblib", "azure_mssql", "azure_ado_mssql", "azure_adooledb_mssql", "azure_odbc_mssql", "azure_mssqlnative", "azure_pdo_sqlsrv", "azure_pdo_dblib", "googlecloud_mssql", "googlecloud_ado_mssql", "googlecloud_adooledb_mssql", "googlecloud_odbc_mssql", "googlecloud_mssqlnative", "googlecloud_pdo_sqlsrv", "googlecloud_pdo_dblib", "amazonrds_mssql", "amazonrds_ado_mssql", "amazonrds_adooledb_mssql", "amazonrds_odbc_mssql", "amazonrds_mssqlnative", "amazonrds_pdo_sqlsrv", "amazonrds_pdo_dblib");
      $this->nm_bases_mysql      = array("mysql", "mysqlt", "mysqli", "maxsql", "pdo_mysql", "pdo_mariadb", "azure_mysql", "azure_mysqlt", "azure_mysqli", "azure_maxsql", "azure_pdo_mysql", "azure_pdo_mariadb", "googlecloud_mysql", "googlecloud_mysqlt", "googlecloud_mysqli", "googlecloud_maxsql", "googlecloud_pdo_mysql", "googlecloud_pdo_mariadb", "amazonrds_mysql", "amazonrds_mysqlt", "amazonrds_mysqli", "amazonrds_maxsql", "amazonrds_pdo_mysql", "amazonrds_pdo_mariadb");
      $this->nm_bases_postgres   = array("postgres", "postgres64", "postgres7", "pdo_pgsql", "azure_postgres", "azure_postgres64", "azure_postgres7", "azure_pdo_pgsql", "googlecloud_postgres", "googlecloud_postgres64", "googlecloud_postgres7", "googlecloud_pdo_pgsql", "amazonrds_postgres", "amazonrds_postgres64", "amazonrds_postgres7", "amazonrds_pdo_pgsql");
      $this->nm_bases_oracle     = array("oci8", "oci805", "oci8po", "odbc_oracle", "oracle", "pdo_oracle", "oraclecloud_oci8", "oraclecloud_oci805", "oraclecloud_oci8po", "oraclecloud_odbc_oracle", "oraclecloud_oracle", "oraclecloud_pdo_oracle", "amazonrds_oci8", "amazonrds_oci805", "amazonrds_oci8po", "amazonrds_odbc_oracle", "amazonrds_oracle", "amazonrds_pdo_oracle");
      $this->nm_bases_sqlite     = array("sqlite", "sqlite3", "pdosqlite");
      $this->nm_bases_sybase     = array("sybase", "pdo_sybase_odbc", "pdo_sybase_dblib");
      $this->nm_bases_vfp        = array("vfp");
      $this->nm_bases_odbc       = array("odbc");
      $this->nm_bases_progress   = array("progress", "pdo_progress_odbc");
      $this->nm_bases_all        = array_merge($this->nm_bases_access, $this->nm_bases_db2, $this->nm_bases_ibase, $this->nm_bases_informix, $this->nm_bases_mssql, $this->nm_bases_mysql, $this->nm_bases_postgres, $this->nm_bases_oracle, $this->nm_bases_sqlite, $this->nm_bases_sybase, $this->nm_bases_vfp, $this->nm_bases_odbc, $this->nm_bases_progress);
      $_SESSION['scriptcase']['nm_bases_security']  = "enc_nm_enc_v1HQNmZSX7D1BeV5FGDMBYZSNiDWFYHIFUHQNwZ1F7D1rwHQJwDEBODkFeH5FYVoFGHQJKDQBqHArYHQXGDMvsVIB/DWXCHIJeHQBiZ1X7D1zGD5XGHgvCHArsDWFqHMX7HQFYDQFaDSN7HuJeDMrwVcB/HEF/HINUDcNmZkFGDSNOHQFUHgvCHArsDWXCHMFaHQXsH9FUD1veHuF7HgNKDkBODuFqDoFGDcBqVIJwD1rwHQrqHgBYVkJ3H5BmDoJeHQJKZSBiHIBeHuJwDMrwV9FeDur/HIJsHQNwZSBOHINKZMXGHgvCHEJqHEXCHMJsHQXsZ9XGHAN7HuF7DMrwV9BUDur/HIBiDcFYVINUHINKZMJeDMrYZSXeDuFYVoXGDcJeZ9rqD1BeHQJeDMvsZSNiDWFYHMXGHQNwZ1FGZ1NOHuBqHgvCHArCDuXKZuJeHQXsDuFaHAvOV5BqDMrwVcB/DWXCHMJwDcFYH9BqZ1NOHQBOHgvCHArCHEXKZuXGDcXGZSBiHArYHuX7HgNKDkBODuFqDoFGDcBqVIJwD1rwD5JeDMBYZSJqV5FaDoBODcJeDQFGD1veD5BOHgrYZSJ3V5X7VoraD9XOZ1rqD1vsD5FaHgNOZSXeH5FYDoJeD9JKDQFGHAveVWJsHgvsDkBODWFaVoFGDcJUZkFUZ1BeZMBqHgBYHAFKV5FqDoBOD9JKDQJwHANKVWBODMvOV9FiV5X7VEF7D9BiH9FaHIBeD5XGDEBOZSXeV5FaZuFaHQXGZSFGD1BeV5FGHuzGVIBOHEFYVorqD9BiZ1F7D1rwD5NUDErKZSXeH5FGDoB/DcJUZSX7HIBeD5BqHgvsZSJ3H5FqVoFGDcBqH9BOZ1BeV5XGDEBOZSJGH5FYZuFaDcXOZSFGD1BeV5BOHuBYVIFCDWXCDoF7HQJmZ1F7Z1vmD5rqDEBOHArCDWF/ZuBqDcBwZSFGHAN7HuX7DMBOVcFKHEX7HMraDcFYZ1F7DSrYZMBOHgrKHErsH5F/ZuBOHQFYDQFaHAveD5NUHgNKDkBOV5FYHMBiHQFYH9FaHAN7V5FaDErKZSJGDWF/DoraD9XsDQJsD1veV5JwHgrYDkBODWFaVorqD9XOZ1X7Z1BeV5FaDEBOVkXeDWr/DoF7DcXOZSBiHIBeV5JwHgrKDkBOHEFYDoJsHQFYZSFaHArKV5XGDErKHErCDWF/VoBiDcJUZSX7Z1BYHuFaDMvmVcFKV5BmVoBqD9BsZkFGHArKHuBODEBeZSJ3V5FaZuFaD9FYDQB/DSN7HuJwHuvmDkBODWFaDoJsD9XOH9B/D1rKHQJwDEBODkFeH5FYVoFGHQJKDQJsHABYV5JeHgrYDkBODWJeVoX7D9BsH9B/Z1NOZMJwDMzGHArCDWF/VoBiDcJUZSX7Z1BYHuFaDMvOZSNiDWB3VoX7HQNwVINUHAvsD5XGHgveDkXKDWXCHIJsD9XsZ9JeD1BeD5F7DMvmVcrsDWFYVoBiDcFYH9BqDSNOZMJeDEBOHArCDWB3ZuXGDcXGZSBiHAveD5NUHgNKDkBOV5FYHMBiHQXOZkFGZ1NOHQBiHgBeZSJ3V5FaHMBOHQJKDQJsZ1vCV5FGHuNOV9FeDWB3VEFGHQFYVINUHAvsZMNU";
      $this->prep_conect();
      if (isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['initialize']) && $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['initialize'])  
      { 
          $this->conectDB();
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['Gera_log_access'] = true;
      }
   }

   function init2()
   {
      if (isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['initialize']) && $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['initialize'])  
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['respaldo_app_enbc_Login']['initialize'] = false;
          $this->Db->Close(); 
      } 
      $this->conectDB();
      if (!in_array(strtolower($this->nm_tpbanco), $this->nm_bases_all))
      {
          echo "<tr>";
          echo "   <td bgcolor=\"\">";
          echo "       <b><font size=\"4\">" . $this->Nm_lang['lang_errm_dbcn_nspt'] . "</font>";
          echo "  " . $perfil_trab;
          echo "   </b></td>";
          echo " </tr>";
          echo "</table>";
          if (!$_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu'] && (!isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan']) || $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan'] != 'respaldo_app_enbc_Login')) 
          { 
              if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno'])) 
              { 
                  echo "<a href='" . $_SESSION['scriptcase']['nm_sc_retorno'] . "' target='_self'><img border='0' src='" . $this->path_botoes . "/nm_scriptcase9_Rhino_bvoltar.gif' title='" . $this->Nm_lang['lang_btns_rtrn_scrp_hint'] . "' align=absmiddle></a> \n" ; 
              } 
              else 
              { 
                  echo "<a href='$nm_url_saida' target='_self'><img border='0' src='" . $this->path_botoes . "/nm_scriptcase9_Rhino_bsair.gif' title='" . $this->Nm_lang['lang_btns_exit_appl_hint'] . "' align=absmiddle></a> \n" ; 
              } 
          } 
          exit ;
      } 
      $this->Nm_accent_access    = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_db2       = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_ibase     = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_informix  = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_mssql     = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_mysql     = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_postgres  = array('cmp_i'=>"unaccent(",'cmp_f'=>")",'cmp_apos'=>"",'arg_i'=>"' || unaccent('",'arg_f'=>"') || '",'arg_apos'=>"");
      $this->Nm_accent_oracle    = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_sqlite    = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_sybase    = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_vfp       = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_odbc      = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");
      $this->Nm_accent_progress  = array('cmp_i'=>"",'cmp_f'=>"",'cmp_apos'=>"",'arg_i'=>"",'arg_f'=>"",'arg_apos'=>"");

      $this->Nm_accent_no = array('cmp_i'=>'','cmp_f'=>'','cmp_apos'=>'','arg_i'=>'','arg_f'=>'','arg_apos'=>'');
      if (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_access)) {
          $this->Nm_accent_yes = $this->Nm_accent_access;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_db2)) {
          $this->Nm_accent_yes = $this->Nm_accent_db2;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_ibase)) {
          $this->Nm_accent_yes = $this->Nm_accent_ibase;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_informix)) {
          $this->Nm_accent_yes = $this->Nm_accent_informix;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_mssql)) {
          $this->Nm_accent_yes = $this->Nm_accent_mssql;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_mysql)) {
          $this->Nm_accent_yes = $this->Nm_accent_mysql;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_postgres)) {
          $this->Nm_accent_yes = $this->Nm_accent_postgres;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_oracle)) {
          $this->Nm_accent_yes = $this->Nm_accent_oracle;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_sqlite)) {
          $this->Nm_accent_yes = $this->Nm_accent_sqlite;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_sybase)) {
          $this->Nm_accent_yes = $this->Nm_accent_sybase;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_vfp)) {
          $this->Nm_accent_yes = $this->Nm_accent_vfp;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_odbc)) {
          $this->Nm_accent_yes = $this->Nm_accent_odbc;
      }
      elseif (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_progress)) {
          $this->Nm_accent_yes = $this->Nm_accent_progress;
      }
      else {
          $this->Nm_accent_yes = $this->Nm_accent_no;
      }
   }

    function scGetTippyCssTheme(&$themeList, $themeName)
    {
        if (isset($themeList[$themeName])) {
            return;
        }

        $themeNameParts = explode('__NM__', $themeName);

        $themeList[$themeName] = [
            'tippy' => $themeNameParts[1],
            'file' => '../_lib/freecss/' . $themeName . '.css'
        ];
    }

   function prep_conect()
   {
      $con_devel             =  (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'])) ? $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'] : ""; 
      $perfil_trab           = ""; 
      $this->nm_falta_var    = ""; 
      $this->nm_falta_var_db = ""; 
      $nm_crit_perfil        = false;
      if (isset($_SESSION['scriptcase']['sc_connection']) && !empty($_SESSION['scriptcase']['sc_connection']))
      {
          foreach ($_SESSION['scriptcase']['sc_connection'] as $NM_con_orig => $NM_con_dest)
          {
              if (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao']) && $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'] == $NM_con_orig)
              {
/*NM*/            $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'] = $NM_con_dest;
              }
              if (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_perfil']) && $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_perfil'] == $NM_con_orig)
              {
/*NM*/            $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_perfil'] = $NM_con_dest;
              }
              if (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_con_' . $NM_con_orig]))
              {
                  $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_con_' . $NM_con_orig] = $NM_con_dest;
              }
          }
      }
      if (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao']) && !empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao']))
      {
          db_conect_devel($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'], $this->root . $this->path_prod, 'SubsistemaENBC_dev', 2, $this->force_db_utf8); 
          if (empty($_SESSION['scriptcase']['glo_tpbanco']) && empty($_SESSION['scriptcase']['glo_banco']))
          {
              $nm_crit_perfil = true;
          }
      }
      if (isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_perfil']) && !empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_perfil']))
      {
          $perfil_trab = $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_perfil'];
      }
      elseif (isset($_SESSION['scriptcase']['glo_perfil']) && !empty($_SESSION['scriptcase']['glo_perfil']))
      {
          $perfil_trab = $_SESSION['scriptcase']['glo_perfil'];
      }
      if (!empty($perfil_trab))
      {
          $_SESSION['scriptcase']['glo_senha_protect'] = "";
          carrega_perfil($perfil_trab, $this->path_libs, "S");
          if (empty($_SESSION['scriptcase']['glo_senha_protect']))
          {
              $nm_crit_perfil = true;
          }
      }
      else
      {
          $perfil_trab = $con_devel;
      }
// 
      if (!isset($_SESSION['scriptcase']['glo_tpbanco']))
      {
          if (!$nm_crit_perfil)
          {
              $this->nm_falta_var_db .= "glo_tpbanco; ";
          }
      }
      else
      {
          $this->nm_tpbanco = $_SESSION['scriptcase']['glo_tpbanco']; 
      }
      if (!isset($_SESSION['scriptcase']['glo_servidor']))
      {
          if (!$nm_crit_perfil)
          {
              $this->nm_falta_var_db .= "glo_servidor; ";
          }
      }
      else
      {
          $this->nm_servidor = $_SESSION['scriptcase']['glo_servidor']; 
      }
      if (!isset($_SESSION['scriptcase']['glo_banco']))
      {
          if (!$nm_crit_perfil)
          {
              $this->nm_falta_var_db .= "glo_banco; ";
          }
      }
      else
      {
          $this->nm_banco = $_SESSION['scriptcase']['glo_banco']; 
      }
      if (!isset($_SESSION['scriptcase']['glo_usuario']))
      {
          if (!$nm_crit_perfil)
          {
              $this->nm_falta_var_db .= "glo_usuario; ";
          }
      }
      else
      {
          $this->nm_usuario = $_SESSION['scriptcase']['glo_usuario']; 
      }
      if (!isset($_SESSION['scriptcase']['glo_senha']))
      {
          if (!$nm_crit_perfil)
          {
              $this->nm_falta_var_db .= "glo_senha; ";
          }
      }
      else
      {
          $this->nm_senha = $_SESSION['scriptcase']['glo_senha']; 
      }
      if (isset($_SESSION['scriptcase']['glo_db2_autocommit']))
      {
          $this->nm_con_db2['db2_autocommit'] = $_SESSION['scriptcase']['glo_db2_autocommit']; 
      }
      if (isset($_SESSION['scriptcase']['glo_database_encoding']))
      {
          $this->nm_database_encoding = $_SESSION['scriptcase']['glo_database_encoding']; 
      }
      if (isset($_SESSION['scriptcase']['glo_db2_i5_lib']))
      {
          $this->nm_con_db2['db2_i5_lib'] = $_SESSION['scriptcase']['glo_db2_i5_lib']; 
      }
      if (isset($_SESSION['scriptcase']['glo_db2_i5_naming']))
      {
          $this->nm_con_db2['db2_i5_naming'] = $_SESSION['scriptcase']['glo_db2_i5_naming']; 
      }
      if (isset($_SESSION['scriptcase']['glo_db2_i5_commit']))
      {
          $this->nm_con_db2['db2_i5_commit'] = $_SESSION['scriptcase']['glo_db2_i5_commit']; 
      }
      if (isset($_SESSION['scriptcase']['glo_db2_i5_query_optimize']))
      {
          $this->nm_con_db2['db2_i5_query_optimize'] = $_SESSION['scriptcase']['glo_db2_i5_query_optimize']; 
      }
      if (isset($_SESSION['scriptcase']['glo_use_persistent']))
      {
          $this->nm_con_persistente = $_SESSION['scriptcase']['glo_use_persistent']; 
      }
      if (isset($_SESSION['scriptcase']['glo_use_schema']))
      {
          $this->nm_con_use_schema = $_SESSION['scriptcase']['glo_use_schema']; 
      }
      $this->nm_arr_db_extra_args = array(); 
      if (isset($_SESSION['scriptcase']['glo_use_ssl']))
      {
          $this->nm_arr_db_extra_args['use_ssl'] = $_SESSION['scriptcase']['glo_use_ssl']; 
      }
      if (isset($_SESSION['scriptcase']['glo_mysql_ssl_key']))
      {
          $this->nm_arr_db_extra_args['mysql_ssl_key'] = $_SESSION['scriptcase']['glo_mysql_ssl_key']; 
      }
      if (isset($_SESSION['scriptcase']['glo_mysql_ssl_cert']))
      {
          $this->nm_arr_db_extra_args['mysql_ssl_cert'] = $_SESSION['scriptcase']['glo_mysql_ssl_cert']; 
      }
      if (isset($_SESSION['scriptcase']['glo_mysql_ssl_capath']))
      {
          $this->nm_arr_db_extra_args['mysql_ssl_capath'] = $_SESSION['scriptcase']['glo_mysql_ssl_capath']; 
      }
      if (isset($_SESSION['scriptcase']['glo_mysql_ssl_ca']))
      {
          $this->nm_arr_db_extra_args['mysql_ssl_ca'] = $_SESSION['scriptcase']['glo_mysql_ssl_ca']; 
      }
      if (isset($_SESSION['scriptcase']['glo_mysql_ssl_cipher']))
      {
          $this->nm_arr_db_extra_args['mysql_ssl_cipher'] = $_SESSION['scriptcase']['glo_mysql_ssl_cipher']; 
      }
      if (isset($_SESSION['scriptcase']['oracle_type']))
      {
          $this->nm_arr_db_extra_args['oracle_type'] = $_SESSION['scriptcase']['oracle_type']; 
      }
      if (isset($_SESSION['scriptcase']['ibase_charset']))
      {
          $this->nm_arr_db_extra_args['ibase_charset'] = $_SESSION['scriptcase']['ibase_charset']; 
      }
      if (isset($_SESSION['scriptcase']['ibase_rolename']))
      {
          $this->nm_arr_db_extra_args['ibase_rolename'] = $_SESSION['scriptcase']['ibase_rolename']; 
      }
      if (isset($_SESSION['scriptcase']['ibase_dialect']))
      {
          $this->nm_arr_db_extra_args['ibase_dialect'] = $_SESSION['scriptcase']['ibase_dialect']; 
      }
      if (isset($_SESSION['scriptcase']['postgres_sslmode']))
      {
          $this->nm_arr_db_extra_args['postgres_sslmode'] = $_SESSION['scriptcase']['postgres_sslmode']; 
      }
      if (isset($_SESSION['scriptcase']['postgres_sslrootcert']))
      {
          $this->nm_arr_db_extra_args['postgres_sslrootcert'] = $_SESSION['scriptcase']['postgres_sslrootcert']; 
      }
      if (isset($_SESSION['scriptcase']['postgres_sslkey']))
      {
          $this->nm_arr_db_extra_args['postgres_sslkey'] = $_SESSION['scriptcase']['postgres_sslkey']; 
      }
      if (isset($_SESSION['scriptcase']['postgres_sslcert']))
      {
          $this->nm_arr_db_extra_args['postgres_sslcert'] = $_SESSION['scriptcase']['postgres_sslcert']; 
      }
      if (isset($_SESSION['scriptcase']['mssql_encrypt']))
      {
          $this->nm_arr_db_extra_args['mssql_encrypt'] = $_SESSION['scriptcase']['mssql_encrypt']; 
      }
      if (isset($_SESSION['scriptcase']['mssql_trustservercertificate']))
      {
          $this->nm_arr_db_extra_args['mssql_trustservercertificate'] = $_SESSION['scriptcase']['mssql_trustservercertificate']; 
      }
      if (isset($_SESSION['scriptcase']['mssql_truststore']))
      {
          $this->nm_arr_db_extra_args['mssql_truststore'] = $_SESSION['scriptcase']['mssql_truststore']; 
      }
      if (isset($_SESSION['scriptcase']['mssql_truststorepassword']))
      {
          $this->nm_arr_db_extra_args['mssql_truststorepassword'] = $_SESSION['scriptcase']['mssql_truststorepassword']; 
      }
      if (isset($_SESSION['scriptcase']['mssql_hostnameincertificate']))
      {
          $this->nm_arr_db_extra_args['mssql_hostnameincertificate'] = $_SESSION['scriptcase']['mssql_hostnameincertificate']; 
      }
      if (isset($_SESSION['scriptcase']['security']))
      {
          $this->nm_arr_db_extra_args['security'] = $_SESSION['scriptcase']['security']; 
      }
      if (isset($_SESSION['scriptcase']['sslservercertificate']))
      {
          $this->nm_arr_db_extra_args['sslservercertificate'] = $_SESSION['scriptcase']['sslservercertificate']; 
      }
      if (isset($_SESSION['scriptcase']['sslclientkeystoredb']))
      {
          $this->nm_arr_db_extra_args['sslclientkeystoredb'] = $_SESSION['scriptcase']['sslclientkeystoredb']; 
      }
      if (isset($_SESSION['scriptcase']['sslclientkeystash']))
      {
          $this->nm_arr_db_extra_args['sslclientkeystash'] = $_SESSION['scriptcase']['sslclientkeystash']; 
      }
      if (isset($_SESSION['scriptcase']['authentication']))
      {
          $this->nm_arr_db_extra_args['authentication'] = $_SESSION['scriptcase']['authentication']; 
      }
      if (isset($_SESSION['scriptcase']['sslclientlabel']))
      {
          $this->nm_arr_db_extra_args['sslclientlabel'] = $_SESSION['scriptcase']['sslclientlabel']; 
      }
      if (isset($_SESSION['scriptcase']['use_ssh']))
      {
          $this->nm_arr_db_extra_args['use_ssh'] = $_SESSION['scriptcase']['use_ssh']; 
      }
      if (isset($_SESSION['scriptcase']['ssh_server']))
      {
          $this->nm_arr_db_extra_args['ssh_server'] = $_SESSION['scriptcase']['ssh_server']; 
      }
      if (isset($_SESSION['scriptcase']['ssh_user']))
      {
          $this->nm_arr_db_extra_args['ssh_user'] = $_SESSION['scriptcase']['ssh_user']; 
      }
      if (isset($_SESSION['scriptcase']['ssh_port']))
      {
          $this->nm_arr_db_extra_args['ssh_port'] = $_SESSION['scriptcase']['ssh_port']; 
      }
      if (isset($_SESSION['scriptcase']['ssh_privatecert']))
      {
          $this->nm_arr_db_extra_args['ssh_privatecert'] = $_SESSION['scriptcase']['ssh_privatecert']; 
      }
      if (isset($_SESSION['scriptcase']['ssh_localserver']))
      {
          $this->nm_arr_db_extra_args['ssh_localserver'] = $_SESSION['scriptcase']['ssh_localserver']; 
      }
      if (isset($_SESSION['scriptcase']['ssh_localport']))
      {
          $this->nm_arr_db_extra_args['ssh_localport'] = $_SESSION['scriptcase']['ssh_localport']; 
      }
      if (isset($_SESSION['scriptcase']['ssh_localportforwarding']))
      {
          $this->nm_arr_db_extra_args['ssh_localportforwarding'] = $_SESSION['scriptcase']['ssh_localportforwarding']; 
      }
      $this->date_delim  = "'";
      $this->date_delim1 = "'";
      if (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_access))
      {
          $this->date_delim  = "#";
          $this->date_delim1 = "#";
      }
      if (isset($_SESSION['scriptcase']['glo_decimal_db']) && !empty($_SESSION['scriptcase']['glo_decimal_db']))
      {
         $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['decimal_db'] = $_SESSION['scriptcase']['glo_decimal_db']; 
      }
      if (isset($_SESSION['scriptcase']['glo_date_separator']) && !empty($_SESSION['scriptcase']['glo_date_separator']))
      {
          $SC_temp = trim($_SESSION['scriptcase']['glo_date_separator']);
          if (strlen($SC_temp) == 2)
          {
              $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date']  = substr($SC_temp, 0, 1); 
              $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date1'] = substr($SC_temp, 1, 1); 
          }
          else
          {
              $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date']  = $SC_temp; 
              $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date1'] = $SC_temp; 
          }
          $this->date_delim  = $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date'];
          $this->date_delim1 = $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date1'];
      }
      if (empty($this->nm_tabela))
      {
          $this->nm_tabela = ""; 
      }
// 
      if (!empty($this->nm_falta_var) || !empty($this->nm_falta_var_db) || $nm_crit_perfil)
      {
          $str_message = "<html>

<head>
    <title>{var_str_title}</title>
    <style>
        body {
            margin: 0px;
            padding: 0px;
            overflow-x: hidden;
            min-width: 320px;
            background: #FFFFFF;
            font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.4285em;
            color: rgba(0, 0, 0, 0.87);
            font-smoothing: antialiased;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        user agent stylesheet body {
            display: block;
            margin: 8px;
        }

        html {
            font-size: 14px;
        }

        html {
            line-height: 1.15;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        ::selection {
            background-color: #CCE2FF;
            color: rgba(0, 0, 0, 0.87);
        }

        .ui.container {
            width: 933px;
            min-width: 992px;
            max-width: 1199px;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .ui.container {
            display: block;
            max-width: 100% !important;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        .ui.message:last-child {
            margin-bottom: 0em;
        }

        .ui.message:first-child {
            margin-top: 0em;
        }

        .ui.message {
            font-size: 1em;
        }

        .ui.message {
            position: relative;
            min-height: 1em;
            margin: 1em 0em;
            background: #F8F8F9;
            padding: 1em 1.5em;
            line-height: 1.4285em;
            color: rgba(0, 0, 0, 0.87);
            transition: opacity 0.1s ease, color 0.1s ease, background 0.1s ease, box-shadow 0.1s ease;
            border-radius: 0.28571429rem;
            box-shadow: 0px 0px 0px 1px rgba(34, 36, 38, 0.22) inset, 0px 0px 0px 0px rgba(0, 0, 0, 0);
        }

        article,
        aside,
        footer,
        header,
        nav,
        section {
            display: block;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        .ui.message> :last-child {
            margin-bottom: 0em;
        }

        .ui.message> :first-child {
            margin-top: 0em;
        }

        .ui.message .header+p {
            margin-top: 0.25em;
        }

        .ui.message p {
            opacity: 0.85;
            margin: 0.75em 0em;
        }

        p {
            margin: 0em 0em 1em;
            line-height: 1.4285em;
        }

        .ui.message .header:not(.ui) {
            font-size: 1.14285714em;
        }

        .ui.message .header {
            display: block;
            font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-weight: bold;
            margin: -0.14285714em 0em 1.2rem 0em;
        }

        .ui.button {
            cursor: pointer;
            display: inline-block;
            min-height: 1em;
            outline: 0;
            border: none;
            vertical-align: baseline;
            background: #e0e1e2 none;
            color: rgba(0, 0, 0, .6);
            font-family: Lato, 'Helvetica Neue', Arial, Helvetica, sans-serif;
            margin: 0 .25em 0 0;
            padding: .78571429em 1.5em .78571429em;
            text-transform: none;
            text-shadow: none;
            font-weight: 700;
            line-height: 1em;
            font-style: normal;
            text-align: center;
            text-decoration: none;
            border-radius: .28571429rem;
            box-shadow: 0 0 0 1px transparent inset, 0 0 0 0 rgba(34, 36, 38, .15) inset;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            transition: opacity .1s ease, background-color .1s ease, color .1s ease, box-shadow .1s ease, background .1s ease;
            will-change: '';
            -webkit-tap-highlight-color: transparent;
        }
        
        .ui.button,
        .ui.buttons .button,
        .ui.buttons .or {
            font-size: 1rem;
            flex-flow: row nowrap;
            justify-content: center;
            align-items: center;
            column-gap: .5rem;
            display: flex;
        }
        
        .ui.primary.button,
        .ui.primary.buttons .button {
            background-color: #2185d0;
            color: #fff;
            text-shadow: none;
            background-image: none;
        }
        
        .ui.primary.button {
            box-shadow: 0 0 0 0 rgba(34, 36, 38, .15) inset;
        }

        [type=reset], [type=submit], button, html [type=button] {
            -webkit-appearance: button;
        }

        .icon{
            position: relative;
            width: 1.2rem;
            height: 1.2rem;
            display: block;
            color: inherit;
            background-repeat: no-repeat;
        }

        .icon.database{
            background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" fill=\"%23FFFFFF\"><path d=\"M448 80v48c0 44.2-100.3 80-224 80S0 172.2 0 128V80C0 35.8 100.3 0 224 0S448 35.8 448 80zM393.2 214.7c20.8-7.4 39.9-16.9 54.8-28.6V288c0 44.2-100.3 80-224 80S0 332.2 0 288V186.1c14.9 11.8 34 21.2 54.8 28.6C99.7 230.7 159.5 240 224 240s124.3-9.3 169.2-25.3zM0 346.1c14.9 11.8 34 21.2 54.8 28.6C99.7 390.7 159.5 400 224 400s124.3-9.3 169.2-25.3c20.8-7.4 39.9-16.9 54.8-28.6V432c0 44.2-100.3 80-224 80S0 476.2 0 432V346.1z\"/></svg>');
        }
    </style>
</head>

<body>
    <div class='ui container' style='padding-top:2rem'>
        <section class='ui message'>
            <div class='content'>
                <div class='header'>
                    <h1 class='ui header'>{var_str_title}</h1>
                </div>
                <p>{var_str_message}</p>
                <p>{var_str_message_conn}</p>
                {v_str_btn_inside}
            </div>
        </section>
    </div>";
          $str_message_end = "</body>
</html>";
          $str_message = str_replace('{var_str_title}', $this->Nm_lang['lang_errm_dbcn_create'], $str_message);
          if (empty($this->nm_falta_var_db))
          {
              if (!empty($this->nm_falta_var))
              {
                  $str_message = str_replace('{var_str_message}', $this->Nm_lang['lang_errm_glob'] . $this->nm_falta_var, $str_message);
              }
              if ($nm_crit_perfil)
              {
                  $str_message = str_replace('{var_str_message}', $this->Nm_lang['lang_errm_dbcn_nfnd'] . ' ' . $perfil_trab, $str_message);
                  $str_message = str_replace('{v_str_btn_inside}', "<button class='ui button primary' style='font-size: 16px!important;'><a href='" . $this->path_prod . "' style='color: white;text-decoration:none'><i class='icon database' style='float: left;padding-right: .5rem;'></i>". $this->Nm_lang['lang_errm_dbcn_create'] ."</a></button>", $str_message);
              }
          }
          else
          {
              $str_message = str_replace('{var_str_message}', $this->Nm_lang['lang_errm_dbcn_data'], $str_message);
          }
          $str_message = str_replace('{v_str_btn_inside}', '', $str_message);
          echo $str_message;
          if (!$_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['iframe_menu'] && (!isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['sc_outra_jan']) || $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['sc_outra_jan'] != 'respaldo_app_enbc_Login')) 
          { 
              if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno'])) 
              { 
?>
                  <input type="button" id="sai" onClick="window.location='<?php echo $_SESSION['scriptcase']['nm_sc_retorno'] ?>'; return false" class="scButton_default" value="<?php echo $this->Nm_lang['lang_btns_back'] ?>" title="<?php echo $this->Nm_lang['lang_btns_back_hint'] ?>" style="<?php echo $sCondStyle; ?>vertical-align: middle;display: ''">

<?php
              } 
              elseif(!empty($nm_url_saida)) 
              { 
?>
                  <input type="button" id="sai" onClick="window.location='<?php echo $nm_url_saida ?>'; return false" class="scButton_default" value="<?php echo $this->Nm_lang['lang_btns_exit'] ?>" title="<?php echo $this->Nm_lang['lang_btns_exit_hint'] ?>" style="<?php echo $sCondStyle; ?>vertical-align: middle;display: ''">

<?php
              } 
          } 
          echo $str_message_end;
          exit ;
      }

      if (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_db2) && $this->force_db_utf8) {
          putenv('DB2CODEPAGE=1208');
      }

      if (isset($_SESSION['scriptcase']['glo_db_master_usr']) && !empty($_SESSION['scriptcase']['glo_db_master_usr']))
      {
          $this->nm_usuario = $_SESSION['scriptcase']['glo_db_master_usr']; 
      }
      if (isset($_SESSION['scriptcase']['glo_db_master_pass']) && !empty($_SESSION['scriptcase']['glo_db_master_pass']))
      {
          $this->nm_senha = $_SESSION['scriptcase']['glo_db_master_pass']; 
      }
      if (isset($_SESSION['scriptcase']['glo_db_master_cript']) && !empty($_SESSION['scriptcase']['glo_db_master_cript']))
      {
          $_SESSION['scriptcase']['glo_senha_protect'] = $_SESSION['scriptcase']['glo_db_master_cript']; 
      }
  } 
// 
  function conectDB()
  {
      $glo_senha_protect = (isset($_SESSION['scriptcase']['glo_senha_protect'])) ? $_SESSION['scriptcase']['glo_senha_protect'] : "S";
      if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno']) && isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao']) && !empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao']))
      { 
          $this->Db = db_conect_devel($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'], $this->root . $this->path_prod, 'SubsistemaENBC_dev', 1, $this->force_db_utf8); 
      } 
      else 
      { 
         if (!isset($this->nm_con_persistente))
         {
            $this->nm_con_persistente = 'N';
         }
         if (!isset($this->nm_con_db2))
         {
            $this->nm_con_db2 = '';
         }
         if (!isset($this->nm_database_encoding))
         {
            $this->nm_database_encoding = '';
         }
         if ($this->force_db_utf8)
         {
            $this->nm_database_encoding = 'utf8';
         }
         if (!isset($this->nm_arr_db_extra_args))
         {
            $this->nm_arr_db_extra_args = array();
         }
         $this->Db = db_conect($this->nm_tpbanco, $this->nm_servidor, $this->nm_usuario, $this->nm_senha, $this->nm_banco, $glo_senha_protect, "S", $this->nm_con_persistente, $this->nm_con_db2, $this->nm_database_encoding, $this->nm_arr_db_extra_args); 
      } 
      if (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_ibase))
      {
          if (function_exists('ibase_timefmt'))
          {
              ibase_timefmt('%Y-%m-%d %H:%M:%S');
          } 
      } 
      if (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_sybase))
      {
          $this->Db->fetchMode = ADODB_FETCH_BOTH;
          $this->Db->Execute("set dateformat ymd");
          $this->Db->Execute("set quoted_identifier ON");
      } 
      if (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_db2))
      {
          $this->Db->fetchMode = ADODB_FETCH_NUM;
      } 
      if (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_mssql))
      {
          $this->Db->Execute("set dateformat ymd");
      } 
      if (in_array(strtolower($this->nm_tpbanco), $this->nm_bases_oracle))
      {
          $this->Db->Execute("alter session set nls_date_format         = 'yyyy-mm-dd hh24:mi:ss'");
          $this->Db->Execute("alter session set nls_timestamp_format    = 'yyyy-mm-dd hh24:mi:ss'");
          $this->Db->Execute("alter session set nls_timestamp_tz_format = 'yyyy-mm-dd hh24:mi:ss'");
          $this->Db->Execute("alter session set nls_time_format         = 'hh24:mi:ss'");
          $this->Db->Execute("alter session set nls_time_tz_format      = 'hh24:mi:ss'");
          $this->Db->Execute("alter session set nls_numeric_characters  = '.,'");
          $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['decimal_db'] = "."; 
      } 
  }

  function setConnectionHash() {
    if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno']) && isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao']) && !empty($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'])) {
      list($connectionDbms, $connectionHost, $connectionUser, $connectionPassword, $connectionDatabase) = db_conect_devel($_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_conexao'], $this->root . $this->path_prod, 'SubsistemaENBC_dev', 1, $this->force_db_utf8);
    }
    else {
      $connectionDbms     = $this->nm_tpbanco;
      $connectionHost     = $this->nm_servidor;
      $connectionUser     = $this->nm_usuario;
      $connectionPassword = $this->nm_senha;
      $connectionDatabase = $this->nm_banco;
    }

    $this->connectionHash = "{$connectionDbms}_SC_" . md5("{$connectionHost}_SC_{$connectionUser}_SC_{$connectionPassword}_SC_{$connectionDatabase}");
  } // setConnectionHash
// 

   function regionalDefault($sConfReg = '')
   {
      if ('' == $sConfReg)
      {
         $sConfReg = $this->str_conf_reg;
      }

      $_SESSION['scriptcase']['reg_conf']['date_format']           = (isset($this->Nm_conf_reg[$sConfReg]['data_format']))              ?  $this->Nm_conf_reg[$sConfReg]['data_format']                  : "ddmmyyyy";
      $_SESSION['scriptcase']['reg_conf']['date_sep']              = (isset($this->Nm_conf_reg[$sConfReg]['data_sep']))                 ?  $this->Nm_conf_reg[$sConfReg]['data_sep']                     : "/";
      $_SESSION['scriptcase']['reg_conf']['date_week_ini']         = (isset($this->Nm_conf_reg[$sConfReg]['prim_dia_sema']))            ?  $this->Nm_conf_reg[$sConfReg]['prim_dia_sema']                : "SU";
      $_SESSION['scriptcase']['reg_conf']['time_format']           = (isset($this->Nm_conf_reg[$sConfReg]['hora_format']))              ?  $this->Nm_conf_reg[$sConfReg]['hora_format']                  : "hhiiss";
      $_SESSION['scriptcase']['reg_conf']['time_sep']              = (isset($this->Nm_conf_reg[$sConfReg]['hora_sep']))                 ?  $this->Nm_conf_reg[$sConfReg]['hora_sep']                     : ":";
      $_SESSION['scriptcase']['reg_conf']['time_pos_ampm']         = (isset($this->Nm_conf_reg[$sConfReg]['hora_pos_ampm']))            ?  $this->Nm_conf_reg[$sConfReg]['hora_pos_ampm']                : "right_without_space";
      $_SESSION['scriptcase']['reg_conf']['time_simb_am']          = (isset($this->Nm_conf_reg[$sConfReg]['hora_simbolo_am']))          ?  $this->Nm_conf_reg[$sConfReg]['hora_simbolo_am']              : "am";
      $_SESSION['scriptcase']['reg_conf']['time_simb_pm']          = (isset($this->Nm_conf_reg[$sConfReg]['hora_simbolo_pm']))          ?  $this->Nm_conf_reg[$sConfReg]['hora_simbolo_pm']              : "pm";
      $_SESSION['scriptcase']['reg_conf']['simb_neg']              = (isset($this->Nm_conf_reg[$sConfReg]['num_sinal_neg']))            ?  $this->Nm_conf_reg[$sConfReg]['num_sinal_neg']                : "-";
      $_SESSION['scriptcase']['reg_conf']['grup_num']              = (isset($this->Nm_conf_reg[$sConfReg]['num_sep_agr']))              ?  $this->Nm_conf_reg[$sConfReg]['num_sep_agr']                  : ".";
      $_SESSION['scriptcase']['reg_conf']['dec_num']               = (isset($this->Nm_conf_reg[$sConfReg]['num_sep_dec']))              ?  $this->Nm_conf_reg[$sConfReg]['num_sep_dec']                  : ",";
      $_SESSION['scriptcase']['reg_conf']['neg_num']               = (isset($this->Nm_conf_reg[$sConfReg]['num_format_num_neg']))       ?  $this->Nm_conf_reg[$sConfReg]['num_format_num_neg']           : 2;
      $_SESSION['scriptcase']['reg_conf']['monet_simb']            = (isset($this->Nm_conf_reg[$sConfReg]['unid_mont_simbolo']))        ?  $this->Nm_conf_reg[$sConfReg]['unid_mont_simbolo']            : "$";
      $_SESSION['scriptcase']['reg_conf']['monet_f_pos']           = (isset($this->Nm_conf_reg[$sConfReg]['unid_mont_format_num_pos'])) ?  $this->Nm_conf_reg[$sConfReg]['unid_mont_format_num_pos']     : 3;
      $_SESSION['scriptcase']['reg_conf']['monet_f_neg']           = (isset($this->Nm_conf_reg[$sConfReg]['unid_mont_format_num_neg'])) ?  $this->Nm_conf_reg[$sConfReg]['unid_mont_format_num_neg']     : 13;
      $_SESSION['scriptcase']['reg_conf']['grup_val']              = (isset($this->Nm_conf_reg[$sConfReg]['unid_mont_sep_agr']))        ?  $this->Nm_conf_reg[$sConfReg]['unid_mont_sep_agr']            : ".";
      $_SESSION['scriptcase']['reg_conf']['dec_val']               = (isset($this->Nm_conf_reg[$sConfReg]['unid_mont_sep_dec']))        ?  $this->Nm_conf_reg[$sConfReg]['unid_mont_sep_dec']            : ",";
      $_SESSION['scriptcase']['reg_conf']['num_group_digit']       = (isset($this->Nm_conf_reg[$sConfReg]['num_group_digit']))          ?  $this->Nm_conf_reg[$sConfReg]['num_group_digit']              : "1";
      $_SESSION['scriptcase']['reg_conf']['unid_mont_group_digit'] = (isset($this->Nm_conf_reg[$sConfReg]['unid_mont_group_digit']))    ?  $this->Nm_conf_reg[$sConfReg]['unid_mont_group_digit']        : "1";
      $_SESSION['scriptcase']['reg_conf']['html_dir']              = (isset($this->Nm_conf_reg[$sConfReg]['ger_ltr_rtl']))              ?  " DIR='" . $this->Nm_conf_reg[$sConfReg]['ger_ltr_rtl'] . "'" : "";
      $_SESSION['scriptcase']['reg_conf']['css_dir']               = (isset($this->Nm_conf_reg[$sConfReg]['ger_ltr_rtl']))              ?  $this->Nm_conf_reg[$sConfReg]['ger_ltr_rtl'] : "LTR";
      if ('' == $_SESSION['scriptcase']['reg_conf']['num_group_digit'])
      {
          $_SESSION['scriptcase']['reg_conf']['num_group_digit'] = '1';
      }
      if ('' == $_SESSION['scriptcase']['reg_conf']['unid_mont_group_digit'])
      {
          $_SESSION['scriptcase']['reg_conf']['unid_mont_group_digit'] = '1';
      }
   }
   function sc_Include($path, $tp, $name)
   {
       if ((empty($tp) && empty($name)) || ($tp == "F" && !function_exists($name)) || ($tp == "C" && !class_exists($name)))
       {
           include_once($path);
       }
   } // sc_Include
   function sc_Sql_Protect($var, $tp, $conex="")
   {
       if (empty($conex) || $conex == "conn_enbc")
       {
           $TP_banco = $_SESSION['scriptcase']['glo_tpbanco'];
       }
       else
       {
           eval ("\$TP_banco = \$this->nm_con_" . $conex . "['tpbanco'];");
       }
       if ($tp == "date")
       {
           $delim  = "'";
           $delim1 = "'";
           if (in_array(strtolower($TP_banco), $this->nm_bases_access))
           {
               $delim  = "#";
               $delim1 = "#";
           }
           if (isset($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date']) && !empty($_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date']))
           {
               $delim  = $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date'];
               $delim1 = $_SESSION['sc_session'][$this->sc_page]['respaldo_app_enbc_Login']['SC_sep_date1'];
           }
           return $delim . $var . $delim1;
       }
       else
       {
           return $var;
       }
   } // sc_Sql_Protect
function fb_return()
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_facebook_name)) {$this->sc_temp_facebook_name = (isset($_SESSION['facebook_name'])) ? $_SESSION['facebook_name'] : "";}
if (!isset($this->sc_temp_facebook_email)) {$this->sc_temp_facebook_email = (isset($_SESSION['facebook_email'])) ? $_SESSION['facebook_email'] : "";}
if (!isset($this->sc_temp_facebook_user)) {$this->sc_temp_facebook_user = (isset($_SESSION['facebook_user'])) ? $_SESSION['facebook_user'] : "";}
if (!isset($this->sc_temp_facebook_error_msg)) {$this->sc_temp_facebook_error_msg = (isset($_SESSION['facebook_error_msg'])) ? $_SESSION['facebook_error_msg'] : "";}
if (!isset($this->sc_temp_facebook_error_code)) {$this->sc_temp_facebook_error_code = (isset($_SESSION['facebook_error_code'])) ? $_SESSION['facebook_error_code'] : "";}
  
if(!empty($this->sc_temp_facebook_error_code))
{
	
 if (!isset($this->Campos_Mens_erro)){$this->Campos_Mens_erro = "";}
 if (!empty($this->Campos_Mens_erro)){$this->Campos_Mens_erro .= "<br>";}$this->Campos_Mens_erro .= 'urlencode($this->sc_temp_facebook_error_msg)';
 if ('submit_form' == $this->NM_ajax_opcao || 'event_' == substr($this->NM_ajax_opcao, 0, 6) || (isset($this->wizard_action) && 'change_step' == $this->wizard_action))
 {
  if (isset($this->wizard_action) && 'change_step' == $this->wizard_action) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } elseif ('submit_form' == $this->NM_ajax_opcao) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } else {
   $sErrorIndex = substr(substr($this->NM_ajax_opcao, 0, strrpos($this->NM_ajax_opcao, '_')), 6);
  }
  $this->NM_ajax_info['errList'][$sErrorIndex][] = 'urlencode($this->sc_temp_facebook_error_msg)';
 }
;
}
else
{
	$this->get_social("facebook", $this->sc_temp_facebook_user, $this->sc_temp_facebook_email, $this->sc_temp_facebook_name);
}
if (isset($this->sc_temp_facebook_error_code)) { $_SESSION['facebook_error_code'] = $this->sc_temp_facebook_error_code;}
if (isset($this->sc_temp_facebook_error_msg)) { $_SESSION['facebook_error_msg'] = $this->sc_temp_facebook_error_msg;}
if (isset($this->sc_temp_facebook_user)) { $_SESSION['facebook_user'] = $this->sc_temp_facebook_user;}
if (isset($this->sc_temp_facebook_email)) { $_SESSION['facebook_email'] = $this->sc_temp_facebook_email;}
if (isset($this->sc_temp_facebook_name)) { $_SESSION['facebook_name'] = $this->sc_temp_facebook_name;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function get_settings()
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
  

$check_sql = "SELECT set_name, set_value  FROM sec_enbc_settings";

 
      $nm_select = $check_sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->rs[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs = false;
          $this->rs_erro = $this->Db->ErrorMsg();
      } 


if (isset($this->rs[0][0]))     
{
    foreach($this->rs as $f ){
        $_SESSION[ 'sett_'. $f[0] ] = $f[1];
    }
}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function get_social($resource, $user_id, $email, $name)
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_usr_email)) {$this->sc_temp_usr_email = (isset($_SESSION['usr_email'])) ? $_SESSION['usr_email'] : "";}
if (!isset($this->sc_temp_usr_name)) {$this->sc_temp_usr_name = (isset($_SESSION['usr_name'])) ? $_SESSION['usr_name'] : "";}
if (!isset($this->sc_temp_usr_login)) {$this->sc_temp_usr_login = (isset($_SESSION['usr_login'])) ? $_SESSION['usr_login'] : "";}
  
if(empty($user_id)) return;

	$sql = "SELECT 
				active, 
				name,
				login
			FROM sec_enbc_users 
				WHERE email = ". $this->Db->qstr($email).
		" OR login = (
		SELECT
			login
		FROM
			sec_enbc_users_social
		WHERE
			resource = '". $resource ."'
			AND resource_id = ". $this->Db->qstr($user_id) .")";
	

	 
      $nm_select = $sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->rs[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs = false;
          $this->rs_erro = $this->Db->ErrorMsg();
      } 


	if(count($this->rs) == 0)
	{
		$this->link_user($resource, $user_id, $email, $name);
		$this->NM_gera_log_insert("User", 'login Fail',  $this->Nm_lang['lang_login_fail']  . $resource. "_".$user_id);
		$this->sc_logged_in_fail($user_id);
		
 if (!isset($this->Campos_Mens_erro)){$this->Campos_Mens_erro = "";}
 if (!empty($this->Campos_Mens_erro)){$this->Campos_Mens_erro .= "<br>";}$this->Campos_Mens_erro .=  $this->Nm_lang['lang_error_login'] ;
 if ('submit_form' == $this->NM_ajax_opcao || 'event_' == substr($this->NM_ajax_opcao, 0, 6) || (isset($this->wizard_action) && 'change_step' == $this->wizard_action))
 {
  if (isset($this->wizard_action) && 'change_step' == $this->wizard_action) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } elseif ('submit_form' == $this->NM_ajax_opcao) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } else {
   $sErrorIndex = substr(substr($this->NM_ajax_opcao, 0, strrpos($this->NM_ajax_opcao, '_')), 6);
  }
  $this->NM_ajax_info['errList'][$sErrorIndex][] =  $this->Nm_lang['lang_error_login'] ;
 }
;
	}
	else if($this->rs[0][0] == 'Y')
	{
		$usr_login		= $this->rs[0][2];
		$usr_name		= $this->rs[0][1];
		$usr_email		= $email;
		 if (isset($usr_login)) {$this->sc_temp_usr_login = $usr_login;}
;
		 if (isset($usr_name)) {$this->sc_temp_usr_name = $usr_name;}
;
		 if (isset($usr_email)) {$this->sc_temp_usr_email = $usr_email;}
;
		$this->sc_validate_success();
	}
	else
	{
		
 if (!isset($this->Campos_Mens_erro)){$this->Campos_Mens_erro = "";}
 if (!empty($this->Campos_Mens_erro)){$this->Campos_Mens_erro .= "<br>";}$this->Campos_Mens_erro .=  $this->Nm_lang['lang_error_not_active'] ;
 if ('submit_form' == $this->NM_ajax_opcao || 'event_' == substr($this->NM_ajax_opcao, 0, 6) || (isset($this->wizard_action) && 'change_step' == $this->wizard_action))
 {
  if (isset($this->wizard_action) && 'change_step' == $this->wizard_action) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } elseif ('submit_form' == $this->NM_ajax_opcao) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } else {
   $sErrorIndex = substr(substr($this->NM_ajax_opcao, 0, strrpos($this->NM_ajax_opcao, '_')), 6);
  }
  $this->NM_ajax_info['errList'][$sErrorIndex][] =  $this->Nm_lang['lang_error_not_active'] ;
 }
;
		if (isset($this->Campos_Mens_erro) && !empty($this->Campos_Mens_erro))
{
 if (isset($this->sc_temp_usr_login)) { $_SESSION['usr_login'] = $this->sc_temp_usr_login;}
 if (isset($this->sc_temp_usr_name)) { $_SESSION['usr_name'] = $this->sc_temp_usr_name;}
 if (isset($this->sc_temp_usr_email)) { $_SESSION['usr_email'] = $this->sc_temp_usr_email;}
    $_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
    return;
}
}
if (isset($this->sc_temp_usr_login)) { $_SESSION['usr_login'] = $this->sc_temp_usr_login;}
if (isset($this->sc_temp_usr_name)) { $_SESSION['usr_name'] = $this->sc_temp_usr_name;}
if (isset($this->sc_temp_usr_email)) { $_SESSION['usr_email'] = $this->sc_temp_usr_email;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function go_return()
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_google_name)) {$this->sc_temp_google_name = (isset($_SESSION['google_name'])) ? $_SESSION['google_name'] : "";}
if (!isset($this->sc_temp_google_email)) {$this->sc_temp_google_email = (isset($_SESSION['google_email'])) ? $_SESSION['google_email'] : "";}
if (!isset($this->sc_temp_google_user)) {$this->sc_temp_google_user = (isset($_SESSION['google_user'])) ? $_SESSION['google_user'] : "";}
if (!isset($this->sc_temp_google_error_msg)) {$this->sc_temp_google_error_msg = (isset($_SESSION['google_error_msg'])) ? $_SESSION['google_error_msg'] : "";}
if (!isset($this->sc_temp_google_error_code)) {$this->sc_temp_google_error_code = (isset($_SESSION['google_error_code'])) ? $_SESSION['google_error_code'] : "";}
  
if(!empty($this->sc_temp_google_error_code))
{
	
 if (!isset($this->Campos_Mens_erro)){$this->Campos_Mens_erro = "";}
 if (!empty($this->Campos_Mens_erro)){$this->Campos_Mens_erro .= "<br>";}$this->Campos_Mens_erro .= 'urlencode($this->sc_temp_google_error_msg)';
 if ('submit_form' == $this->NM_ajax_opcao || 'event_' == substr($this->NM_ajax_opcao, 0, 6) || (isset($this->wizard_action) && 'change_step' == $this->wizard_action))
 {
  if (isset($this->wizard_action) && 'change_step' == $this->wizard_action) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } elseif ('submit_form' == $this->NM_ajax_opcao) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } else {
   $sErrorIndex = substr(substr($this->NM_ajax_opcao, 0, strrpos($this->NM_ajax_opcao, '_')), 6);
  }
  $this->NM_ajax_info['errList'][$sErrorIndex][] = 'urlencode($this->sc_temp_google_error_msg)';
 }
;
}
else
{
	$this->get_social("google", $this->sc_temp_google_user, $this->sc_temp_google_email, $this->sc_temp_google_name);
}
if (isset($this->sc_temp_google_error_code)) { $_SESSION['google_error_code'] = $this->sc_temp_google_error_code;}
if (isset($this->sc_temp_google_error_msg)) { $_SESSION['google_error_msg'] = $this->sc_temp_google_error_msg;}
if (isset($this->sc_temp_google_user)) { $_SESSION['google_user'] = $this->sc_temp_google_user;}
if (isset($this->sc_temp_google_email)) { $_SESSION['google_email'] = $this->sc_temp_google_email;}
if (isset($this->sc_temp_google_name)) { $_SESSION['google_name'] = $this->sc_temp_google_name;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function has_priv($param)
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
  
return ($param == 'Y' ? 'on' : 'off');

$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function link_user($resource, $usr_id, $email, $name)
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_usr_email)) {$this->sc_temp_usr_email = (isset($_SESSION['usr_email'])) ? $_SESSION['usr_email'] : "";}
if (!isset($this->sc_temp_usr_priv_admin)) {$this->sc_temp_usr_priv_admin = (isset($_SESSION['usr_priv_admin'])) ? $_SESSION['usr_priv_admin'] : "";}
if (!isset($this->sc_temp_usr_login)) {$this->sc_temp_usr_login = (isset($_SESSION['usr_login'])) ? $_SESSION['usr_login'] : "";}
  
	$group_default = 2;

	$sql = "INSERT INTO
				sec_enbc_users( login, name, pswd, email, active )
			VALUES 
				(". $this->Db->qstr($usr_id). ", ".
					$this->Db->qstr($name) . ", ".
					$this->Db->qstr(hash("sha1",date("YmdHis"))) . ", ".
					$this->Db->qstr($email) . ", 'Y')";
			
	
	
     $nm_select = $sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      
	
	$sql = "INSERT INTO
				sec_enbc_users_social( sec_enbc_users_social.login, sec_enbc_users_social.resource, sec_enbc_users_social.resource_id )
			VALUES 
				(". $this->Db->qstr($usr_id). ", ".
					$this->Db->qstr($resource) . ", ".
					$this->Db->qstr($usr_id) . ")";
			
	
	
     $nm_select = $sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      
									 
	
	$sql = "INSERT INTO
				sec_enbc_users_groups( login, group_id )
			VALUES 
				(". $this->Db->qstr($usr_id). ", ".
					$this->Db->qstr($group_default) . ")";
			
	
	
     $nm_select = $sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      

	
	$usr_login			= $usr_id;
	$usr_priv_admin 	= FALSE;
	$usr_email			= $email;
	 if (isset($usr_login)) {$this->sc_temp_usr_login = $usr_login;}
;
	 if (isset($usr_priv_admin)) {$this->sc_temp_usr_priv_admin = $usr_priv_admin;}
;
	 if (isset($usr_email)) {$this->sc_temp_usr_email = $usr_email;}
;
	$this->sc_validate_success();
if (isset($this->sc_temp_usr_login)) { $_SESSION['usr_login'] = $this->sc_temp_usr_login;}
if (isset($this->sc_temp_usr_priv_admin)) { $_SESSION['usr_priv_admin'] = $this->sc_temp_usr_priv_admin;}
if (isset($this->sc_temp_usr_email)) { $_SESSION['usr_email'] = $this->sc_temp_usr_email;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function remember_me_init()
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_usr_email)) {$this->sc_temp_usr_email = (isset($_SESSION['usr_email'])) ? $_SESSION['usr_email'] : "";}
if (!isset($this->sc_temp_usr_name)) {$this->sc_temp_usr_name = (isset($_SESSION['usr_name'])) ? $_SESSION['usr_name'] : "";}
if (!isset($this->sc_temp_usr_priv_admin)) {$this->sc_temp_usr_priv_admin = (isset($_SESSION['usr_priv_admin'])) ? $_SESSION['usr_priv_admin'] : "";}
if (!isset($this->sc_temp_usr_login)) {$this->sc_temp_usr_login = (isset($_SESSION['usr_login'])) ? $_SESSION['usr_login'] : "";}
  
if(isset($_COOKIE['usr_data']) && !empty($_COOKIE['usr_data'])){

    $usr_data = unserialize(decode_string($_COOKIE['usr_data']));
    
    if(substr($usr_data['code'], 0, 7) == 'cookie_'){
        


        $sql = "SELECT 
                    priv_admin,
                    active, 
                    name, 
                    email 
                FROM sec_enbc_users 
                WHERE login = ". $this->Db->qstr($usr_data['login']) ."
                AND activation_code = ".$this->Db->qstr($usr_data['code']);
         
      $nm_select = $sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->rs[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs = false;
          $this->rs_erro = $this->Db->ErrorMsg();
      } 


        if(count($this->rs) != 0 && $this->rs[0][1] == 'Y')
        {
            $this->sc_temp_usr_login		= $usr_data['login'];
            $this->sc_temp_usr_priv_admin 	= ($this->rs[0][0] == 'Y') ? TRUE : FALSE;
            $this->sc_temp_usr_name		= $this->rs[0][2];
            $this->sc_temp_usr_email		= $this->rs[0][3];
            
            $this->sc_validate_success();
        }
    }
}
if (isset($this->sc_temp_usr_login)) { $_SESSION['usr_login'] = $this->sc_temp_usr_login;}
if (isset($this->sc_temp_usr_priv_admin)) { $_SESSION['usr_priv_admin'] = $this->sc_temp_usr_priv_admin;}
if (isset($this->sc_temp_usr_name)) { $_SESSION['usr_name'] = $this->sc_temp_usr_name;}
if (isset($this->sc_temp_usr_email)) { $_SESSION['usr_email'] = $this->sc_temp_usr_email;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function remember_me_validate()
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_sett_cookie_expiration_time)) {$this->sc_temp_sett_cookie_expiration_time = (isset($_SESSION['sett_cookie_expiration_time'])) ? $_SESSION['sett_cookie_expiration_time'] : "";}
  
if($this->remember_me  == 1){

    $chars  = 'abcdefghijklmnopqrstuvxywz';
    $chars .= 'ABCDEFGHIJKLMNOPQRSTUVXYWZ';
    $chars .= '0123456789!@$*.,;:';
    $max = strlen($chars)-1;
    $code = "cookie_";
    for($i=0; $i < 25; $i++)
    {
        $code .= $chars[mt_rand(0, $max)];
    }
    
    $slogin = $this->Db->qstr($this->login );

    
     $nm_select ="UPDATE sec_enbc_users SET activation_code = ". $this->Db->qstr($code) . " WHERE login = ". $slogin; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      

    $usr_data = array(
        'login' => $this->login ,
        'code' => $code,
    );
    $remember_me_expiry_cookie = $this->sc_temp_sett_cookie_expiration_time;
    setcookie("usr_data", encode_string(serialize($usr_data)),time()+60*60*24* $remember_me_expiry_cookie, '/');
}
if (isset($this->sc_temp_sett_cookie_expiration_time)) { $_SESSION['sett_cookie_expiration_time'] = $this->sc_temp_sett_cookie_expiration_time;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function sc_validate_success()
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_generacion)) {$this->sc_temp_generacion = (isset($_SESSION['generacion'])) ? $_SESSION['generacion'] : "";}
if (!isset($this->sc_temp_usr_login)) {$this->sc_temp_usr_login = (isset($_SESSION['usr_login'])) ? $_SESSION['usr_login'] : "";}
  
$sql = "SELECT 
		app_name,
		priv_access,
		priv_insert,
		priv_delete,
		priv_update,
		priv_export,
		priv_print
	      FROM sec_enbc_groups_apps
	      WHERE group_id IN
	          (SELECT
		       group_id
		   FROM
		       sec_enbc_users_groups 
		   WHERE
		       login = '". $this->sc_temp_usr_login ."')";
		
 
      $nm_select = $sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($this->rs = $this->Db->Execute($nm_select)) 
      { }
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs = false;
          $this->rs_erro = $this->Db->ErrorMsg();
      } 


$arr_default = array(
					'access' => 'off',
					'insert' => 'off',
					'delete' => 'off',
					'update' => 'off',
					'export' => 'btn_display_off',
					'print'  => 'btn_display_off',
					);
if ($this->rs !== false)
{

	$arr_perm = array();
	while (!$this->rs->EOF)
	{
		$app = $this->rs->fields[0];
		
		if(!isset($arr_perm[$app]))
		{
		   $arr_perm[$app] = $arr_default;
		}
		if( $this->rs->fields[1] == 'Y')
		{
			$arr_perm[$app][ 'access' ] = 'on';
		}
		if($this->rs->fields[2] == 'Y')
		{
			$arr_perm[$app][ 'insert' ] = 'on';
		}
		if($this->rs->fields[3] == 'Y')
		{
			$arr_perm[$app][ 'delete' ] = 'on';
		}
		if($this->rs->fields[4] == 'Y')
		{
			$arr_perm[$app][ 'update' ] = 'on';
		}
		if($this->rs->fields[5] == 'Y')
		{
			$arr_perm[$app]['export'] =  'btn_display_on';
		}
		if($this->rs->fields[6] == 'Y')
		{
			$arr_perm[$app]['print'] =  'btn_display_on';
		}


		$this->rs->MoveNext();	
	}
	$this->rs->Close();
		   
	foreach($arr_perm as $app => $perm)
	{
		$_SESSION['scriptcase']['sc_apl_seg'][$app] = $perm['access'];;
		
		$_SESSION['scriptcase']['sc_apl_conf'][$app]['insert'] = $perm['insert'];
		$_SESSION['scriptcase']['sc_apl_conf'][$app]['delete'] = $perm['delete'];
		$_SESSION['scriptcase']['sc_apl_conf'][$app]['update'] = $perm['update'];
		if ($perm['export'] == 'btn_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['xls'] = 'on';
}
elseif ($perm['export'] == 'btn_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['xls'] = 'off';
}
elseif ($perm['export'] == 'field_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['xls'] = 'on';
}
elseif ($perm['export'] == 'field_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['xls'] = 'off';
}
elseif ($perm['export'] == 'field_readonly') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']]['xls'] = 'on';
}
else {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']] = 'xls';
}
;
		if ($perm['export'] == 'btn_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['word'] = 'on';
}
elseif ($perm['export'] == 'btn_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['word'] = 'off';
}
elseif ($perm['export'] == 'field_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['word'] = 'on';
}
elseif ($perm['export'] == 'field_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['word'] = 'off';
}
elseif ($perm['export'] == 'field_readonly') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']]['word'] = 'on';
}
else {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']] = 'word';
}
;
		if ($perm['export'] == 'btn_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['pdf'] = 'on';
}
elseif ($perm['export'] == 'btn_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['pdf'] = 'off';
}
elseif ($perm['export'] == 'field_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['pdf'] = 'on';
}
elseif ($perm['export'] == 'field_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['pdf'] = 'off';
}
elseif ($perm['export'] == 'field_readonly') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']]['pdf'] = 'on';
}
else {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']] = 'pdf';
}
;
		if ($perm['export'] == 'btn_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['xml'] = 'on';
}
elseif ($perm['export'] == 'btn_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['xml'] = 'off';
}
elseif ($perm['export'] == 'field_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['xml'] = 'on';
}
elseif ($perm['export'] == 'field_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['xml'] = 'off';
}
elseif ($perm['export'] == 'field_readonly') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']]['xml'] = 'on';
}
else {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']] = 'xml';
}
;
		if ($perm['export'] == 'btn_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['csv'] = 'on';
}
elseif ($perm['export'] == 'btn_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['csv'] = 'off';
}
elseif ($perm['export'] == 'field_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['csv'] = 'on';
}
elseif ($perm['export'] == 'field_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['csv'] = 'off';
}
elseif ($perm['export'] == 'field_readonly') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']]['csv'] = 'on';
}
else {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']] = 'csv';
}
;
		if ($perm['export'] == 'btn_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['rtf'] = 'on';
}
elseif ($perm['export'] == 'btn_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['rtf'] = 'off';
}
elseif ($perm['export'] == 'field_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['rtf'] = 'on';
}
elseif ($perm['export'] == 'field_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['rtf'] = 'off';
}
elseif ($perm['export'] == 'field_readonly') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']]['rtf'] = 'on';
}
else {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']] = 'rtf';
}
;
		if ($perm['export'] == 'btn_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['json'] = 'on';
}
elseif ($perm['export'] == 'btn_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['json'] = 'off';
}
elseif ($perm['export'] == 'field_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['json'] = 'on';
}
elseif ($perm['export'] == 'field_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['json'] = 'off';
}
elseif ($perm['export'] == 'field_readonly') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']]['json'] = 'on';
}
else {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['export']] = 'json';
}
;
		if ($perm['print'] == 'btn_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['print'] = 'on';
}
elseif ($perm['print'] == 'btn_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['btn_display']['print'] = 'off';
}
elseif ($perm['print'] == 'field_display_on') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['print'] = 'on';
}
elseif ($perm['print'] == 'field_display_off') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app]['field_display']['print'] = 'off';
}
elseif ($perm['print'] == 'field_readonly') {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['print']]['print'] = 'on';
}
else {
    $_SESSION['scriptcase']['sc_apl_conf'][$app][$perm['print']] = 'print';
}
;

	}
		
		
		$this->NM_gera_log_insert("User", 'login',  $this->Nm_lang['lang_login_ok'] );
	
	$gen='SELECT generacion FROM sce.convocatorias_posg WHERE cc_activa=1';
		 
      $nm_select = $gen; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs3 = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->rs3[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs3 = false;
          $this->rs3_erro = $this->Db->ErrorMsg();
      } 

		$this->sc_temp_generacion = $this->rs3[0][0];	
	
	$sql_command="		SELECT group_id
						FROM sec_enbc_users_groups
						WHERE login='".$this->sc_temp_usr_login."'";
		 
      $nm_select = $sql_command; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->ds = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->ds[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->ds = false;
          $this->ds_erro = $this->Db->ErrorMsg();
      } 

        $tipousu = $this->ds[0][0];
		echo $tipousu;
        switch ($tipousu){
          case 1:
                    $menu = 'menu_enbc';
            break;
          case 2: 
                    $menu = 'menu_asp_enbc';
            break;
		  case 3: 
                    $menu = 'menu_admvo_enbc';
            break;
        }	
     if (isset($this->sc_temp_usr_login)) { $_SESSION['usr_login'] = $this->sc_temp_usr_login;}
 if (isset($this->sc_temp_generacion)) { $_SESSION['generacion'] = $this->sc_temp_generacion;}
 if (!isset($this->Campos_Mens_erro) || empty($this->Campos_Mens_erro))
 {
$this->nmgp_redireciona_form($menu, $this->nm_location, "", "_self", "ret_self", 440, 630);
 };	
}
if (isset($this->sc_temp_usr_login)) { $_SESSION['usr_login'] = $this->sc_temp_usr_login;}
if (isset($this->sc_temp_generacion)) { $_SESSION['generacion'] = $this->sc_temp_generacion;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function tw_return()
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_twitter_name)) {$this->sc_temp_twitter_name = (isset($_SESSION['twitter_name'])) ? $_SESSION['twitter_name'] : "";}
if (!isset($this->sc_temp_twitter_email)) {$this->sc_temp_twitter_email = (isset($_SESSION['twitter_email'])) ? $_SESSION['twitter_email'] : "";}
if (!isset($this->sc_temp_twitter_user)) {$this->sc_temp_twitter_user = (isset($_SESSION['twitter_user'])) ? $_SESSION['twitter_user'] : "";}
  
$this->get_social("twitter", $this->sc_temp_twitter_user, $this->sc_temp_twitter_email,$this->sc_temp_twitter_name);


if (isset($this->sc_temp_twitter_user)) { $_SESSION['twitter_user'] = $this->sc_temp_twitter_user;}
if (isset($this->sc_temp_twitter_email)) { $_SESSION['twitter_email'] = $this->sc_temp_twitter_email;}
if (isset($this->sc_temp_twitter_name)) { $_SESSION['twitter_name'] = $this->sc_temp_twitter_name;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function sc_logged($user, $ip = '')
	{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
  
		$str_sql = "SELECT date_login, ip FROM sec_enbc_logged WHERE login = ". $this->Db->qstr($user) ." AND sc_session <> ".$this->Db->qstr('_SC_FAIL_SC_');

		 
      $nm_select = $str_sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($this->data = $this->Db->Execute($nm_select)) 
      { }
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->data = false;
          $this->data_erro = $this->Db->ErrorMsg();
      } 


    if($this->data  === FALSE || !isset($this->data->fields[0]))
		{
            $ip = ($ip == '') ? $_SERVER['REMOTE_ADDR'] : $ip;
            $this->sc_logged_in($user, $ip);
            return true;
        }
		else
		{
            if (isset($_SESSION['scriptcase']['sc_apl_conf']['app_enbc_logged']))
{
unset($_SESSION['scriptcase']['sc_apl_conf']['app_enbc_logged']);
}
;
            $_SESSION['scriptcase']['sc_apl_seg']['app_enbc_logged'] = "on";;
			 if (!isset($this->Campos_Mens_erro) || empty($this->Campos_Mens_erro))
 {
$this->nmgp_redireciona_form($this->path_link . "" . SC_dir_app_name('app_enbc_logged') . "/", $this->nm_location, "user?#?" . NM_encode_input($user) . "?@?", "modal", "ret_self", 440, 630);
 };
            return false;
        }
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function sc_verify_logged()
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_logged_date_login)) {$this->sc_temp_logged_date_login = (isset($_SESSION['logged_date_login'])) ? $_SESSION['logged_date_login'] : "";}
if (!isset($this->sc_temp_logged_user)) {$this->sc_temp_logged_user = (isset($_SESSION['logged_user'])) ? $_SESSION['logged_user'] : "";}
  
		$str_sql = "SELECT count(*) FROM sec_enbc_logged WHERE login = ". $this->Db->qstr($this->sc_temp_logged_user) . " AND date_login = ". $this->Db->qstr($this->sc_temp_logged_date_login) ." AND sc_session <> ".$this->Db->qstr('_SC_FAIL_SC_');
     
      $nm_select = $str_sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs_logged = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->rs_logged[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs_logged = false;
          $this->rs_logged_erro = $this->Db->ErrorMsg();
      } 

    if($this->rs_logged[0][0] != 1)
		{
			 if (isset($this->sc_temp_logged_user)) { $_SESSION['logged_user'] = $this->sc_temp_logged_user;}
 if (isset($this->sc_temp_logged_date_login)) { $_SESSION['logged_date_login'] = $this->sc_temp_logged_date_login;}
 if (!isset($this->Campos_Mens_erro) || empty($this->Campos_Mens_erro))
 {
$this->nmgp_redireciona_form($this->path_link . "" . SC_dir_app_name('app_enbc_Login') . "/", $this->nm_location, "", "_parent", "ret_self", 440, 630);
 };
        }
if (isset($this->sc_temp_logged_user)) { $_SESSION['logged_user'] = $this->sc_temp_logged_user;}
if (isset($this->sc_temp_logged_date_login)) { $_SESSION['logged_date_login'] = $this->sc_temp_logged_date_login;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function sc_logged_in($user, $ip = '')
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_logged_date_login)) {$this->sc_temp_logged_date_login = (isset($_SESSION['logged_date_login'])) ? $_SESSION['logged_date_login'] : "";}
if (!isset($this->sc_temp_logged_user)) {$this->sc_temp_logged_user = (isset($_SESSION['logged_user'])) ? $_SESSION['logged_user'] : "";}
  
    $ip = ($ip == '') ? $_SERVER['REMOTE_ADDR'] : $ip;
    $this->sc_temp_logged_user = $user;
    $this->sc_temp_logged_date_login = microtime(true);

        $str_sql = "DELETE FROM sec_enbc_logged WHERE login = ". $this->Db->qstr($user) . " AND sc_session = ".$this->Db->qstr('_SC_FAIL_SC_')." AND ip = ".$this->Db->qstr($ip);
    
     $nm_select = $str_sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      

    	$str_sql = "INSERT INTO sec_enbc_logged(login, date_login, sc_session, ip) VALUES (". $this->Db->qstr($user) .", ". $this->Db->qstr($this->sc_temp_logged_date_login) .", ". $this->Db->qstr(session_id()) .", ". $this->Db->qstr($ip) .")";
    
     $nm_select = $str_sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      
if (isset($this->sc_temp_logged_user)) { $_SESSION['logged_user'] = $this->sc_temp_logged_user;}
if (isset($this->sc_temp_logged_date_login)) { $_SESSION['logged_date_login'] = $this->sc_temp_logged_date_login;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function sc_logged_in_fail($user, $ip = '')
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
  
    $ip = ($ip == '') ? $_SERVER['REMOTE_ADDR'] : $ip;
    $user = $this->Db->qstr($user);
        $str_sql = "INSERT INTO sec_enbc_logged(login, date_login, sc_session, ip) VALUES (" . $this->Db->qstr($user) . ", " . $this->Db->qstr(microtime(true)) . ", ". $this->Db->qstr('_SC_FAIL_SC_').", " . $this->Db->qstr($ip) . ")";
    
     $nm_select = $str_sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      
    return true;
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function sc_logged_is_blocked($ip = '')
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_sett_brute_force_attempts)) {$this->sc_temp_sett_brute_force_attempts = (isset($_SESSION['sett_brute_force_attempts'])) ? $_SESSION['sett_brute_force_attempts'] : "";}
if (!isset($this->sc_temp_sett_brute_force_time_block)) {$this->sc_temp_sett_brute_force_time_block = (isset($_SESSION['sett_brute_force_time_block'])) ? $_SESSION['sett_brute_force_time_block'] : "";}
  
    $ip = ($ip == '') ? $_SERVER['REMOTE_ADDR'] : $ip;
    $minutes_ago = strtotime("-". $this->sc_temp_sett_brute_force_time_block ." minutes");
    $str_select = "SELECT count(*) FROM sec_enbc_logged WHERE sc_session = ".$this->Db->qstr('_SC_BLOCKED_SC_')." AND ip = ".$this->Db->qstr($ip)." AND date_login > ". $this->Db->qstr($minutes_ago);
     
      $nm_select = $str_select; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs_logged = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->rs_logged[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs_logged = false;
          $this->rs_logged_erro = $this->Db->ErrorMsg();
      } 

    if($this->rs_logged  !== FALSE && $this->rs_logged[0][0] == 1)
        {
            $message =  $this->Nm_lang['lang_user_blocked'] ;
                $message = sprintf($message, 10);
                
 if (!isset($this->Campos_Mens_erro)){$this->Campos_Mens_erro = "";}
 if (!empty($this->Campos_Mens_erro)){$this->Campos_Mens_erro .= "<br>";}$this->Campos_Mens_erro .= $message;
 if ('submit_form' == $this->NM_ajax_opcao || 'event_' == substr($this->NM_ajax_opcao, 0, 6) || (isset($this->wizard_action) && 'change_step' == $this->wizard_action))
 {
  if (isset($this->wizard_action) && 'change_step' == $this->wizard_action) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } elseif ('submit_form' == $this->NM_ajax_opcao) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } else {
   $sErrorIndex = substr(substr($this->NM_ajax_opcao, 0, strrpos($this->NM_ajax_opcao, '_')), 6);
  }
  $this->NM_ajax_info['errList'][$sErrorIndex][] = $message;
 }
;
                return true;
        }

        $str_select = "SELECT count(*) FROM sec_enbc_logged WHERE sc_session = ".$this->Db->qstr('_SC_FAIL_SC_')." AND ip = ".$this->Db->qstr($ip)." AND date_login > ". $this->Db->qstr($minutes_ago);
         
      $nm_select = $str_select; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs_logged = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->rs_logged[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs_logged = false;
          $this->rs_logged_erro = $this->Db->ErrorMsg();
      } 


        if($this->rs_logged  !== FALSE && $this->rs_logged[0][0] == $this->sc_temp_sett_brute_force_attempts )
        {
            $str_sql = "INSERT INTO sec_enbc_logged(login, date_login, sc_session, ip) VALUES (".$this->Db->qstr('blocked').", ". $this->Db->qstr(microtime(true)) .", ".$this->Db->qstr('_SC_BLOCKED_SC_'). ", ". $this->Db->qstr($ip) .")";
            
     $nm_select = $str_sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      
            $message =  $this->Nm_lang['lang_user_blocked'] ;
                $message = sprintf($message, $this->sc_temp_sett_brute_force_time_block);
                
 if (!isset($this->Campos_Mens_erro)){$this->Campos_Mens_erro = "";}
 if (!empty($this->Campos_Mens_erro)){$this->Campos_Mens_erro .= "<br>";}$this->Campos_Mens_erro .= $message;
 if ('submit_form' == $this->NM_ajax_opcao || 'event_' == substr($this->NM_ajax_opcao, 0, 6) || (isset($this->wizard_action) && 'change_step' == $this->wizard_action))
 {
  if (isset($this->wizard_action) && 'change_step' == $this->wizard_action) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } elseif ('submit_form' == $this->NM_ajax_opcao) {
   $sErrorIndex = 'geral_respaldo_app_enbc_Login';
  } else {
   $sErrorIndex = substr(substr($this->NM_ajax_opcao, 0, strrpos($this->NM_ajax_opcao, '_')), 6);
  }
  $this->NM_ajax_info['errList'][$sErrorIndex][] = $message;
 }
;
                return true;
        }
        return false;
if (isset($this->sc_temp_sett_brute_force_time_block)) { $_SESSION['sett_brute_force_time_block'] = $this->sc_temp_sett_brute_force_time_block;}
if (isset($this->sc_temp_sett_brute_force_attempts)) { $_SESSION['sett_brute_force_attempts'] = $this->sc_temp_sett_brute_force_attempts;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function sc_logged_out($user, $date_login = '')
{
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_logged_user)) {$this->sc_temp_logged_user = (isset($_SESSION['logged_user'])) ? $_SESSION['logged_user'] : "";}
if (!isset($this->sc_temp_logged_date_login)) {$this->sc_temp_logged_date_login = (isset($_SESSION['logged_date_login'])) ? $_SESSION['logged_date_login'] : "";}
  
		$date_login = ($date_login == '' ? "" : " AND date_login = ". $this->Db->qstr($date_login) ."");

		$str_sql = "SELECT sc_session FROM sec_enbc_logged WHERE login = ". $this->Db->qstr($user) ." ". $date_login . " AND sc_session <> ".$this->Db->qstr('_SC_FAIL_SC_');
     
      $nm_select = $str_sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->data = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                      $this->data[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->data = false;
          $this->data_erro = $this->Db->ErrorMsg();
      } 

    if(isset($this->data[0][0]) && !empty($this->data[0][0]))
        {
            $session_bkp = $_SESSION;
            $sessionid = session_id();
            session_write_close();

            session_id($this->data[0][0]);
			session_start();
			$_SESSION['logged_user'] = 'logout';
			session_write_close();

			session_id($sessionid);
			session_start();
			$_SESSION = $session_bkp;
		}


		$str_sql = "DELETE FROM sec_enbc_logged WHERE login = ". $this->Db->qstr($user) . " " . $date_login;
		
     $nm_select = $str_sql; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             $this->NM_rollback_db(); 
             if ($this->NM_ajax_flag)
             {
                respaldo_app_enbc_Login_pack_ajax_response();
             }
             exit;
         }
         $rf->Close();
      
		 unset($_SESSION['logged_date_login']);
 unset($this->sc_temp_logged_date_login);
 unset($_SESSION['logged_user']);
 unset($this->sc_temp_logged_user);
;
if (isset($this->sc_temp_logged_date_login)) { $_SESSION['logged_date_login'] = $this->sc_temp_logged_date_login;}
if (isset($this->sc_temp_logged_user)) { $_SESSION['logged_user'] = $this->sc_temp_logged_user;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
function sc_looged_check_logout()
    {
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'on';
if (!isset($this->sc_temp_usr_email)) {$this->sc_temp_usr_email = (isset($_SESSION['usr_email'])) ? $_SESSION['usr_email'] : "";}
if (!isset($this->sc_temp_logged_date_login)) {$this->sc_temp_logged_date_login = (isset($_SESSION['logged_date_login'])) ? $_SESSION['logged_date_login'] : "";}
if (!isset($this->sc_temp_logged_user)) {$this->sc_temp_logged_user = (isset($_SESSION['logged_user'])) ? $_SESSION['logged_user'] : "";}
if (!isset($this->sc_temp_usr_login)) {$this->sc_temp_usr_login = (isset($_SESSION['usr_login'])) ? $_SESSION['usr_login'] : "";}
  
        if(isset($this->sc_temp_logged_user) && ($this->sc_temp_logged_user == 'logout' || empty($this->sc_temp_logged_user)))
        {
             unset($_SESSION['usr_login']);
 unset($this->sc_temp_usr_login);
 unset($_SESSION['logged_user']);
 unset($this->sc_temp_logged_user);
 unset($_SESSION['logged_date_login']);
 unset($this->sc_temp_logged_date_login);
 unset($_SESSION['usr_email']);
 unset($this->sc_temp_usr_email);
;
        }
if (isset($this->sc_temp_usr_login)) { $_SESSION['usr_login'] = $this->sc_temp_usr_login;}
if (isset($this->sc_temp_logged_user)) { $_SESSION['logged_user'] = $this->sc_temp_logged_user;}
if (isset($this->sc_temp_logged_date_login)) { $_SESSION['logged_date_login'] = $this->sc_temp_logged_date_login;}
if (isset($this->sc_temp_usr_email)) { $_SESSION['usr_email'] = $this->sc_temp_usr_email;}
$_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
}
//
}
//===============================================================================
class respaldo_app_enbc_Login_edit
{
    var $contr_respaldo_app_enbc_Login;
    function inicializa()
    {
        global $nm_opc_lookup, $nm_opc_php, $script_case_init;
        require_once("respaldo_app_enbc_Login_apl.php");
        $this->contr_respaldo_app_enbc_Login = new respaldo_app_enbc_Login_apl();
    }
}
if (!function_exists("NM_is_utf8"))
{
    include_once("../_lib/lib/php/nm_utf8.php");
}
ob_start();
//
//----------------  
//
    $_SESSION['scriptcase']['respaldo_app_enbc_Login']['contr_erro'] = 'off';
    if (!function_exists("NM_is_utf8"))
    {
        include_once("../_lib/lib/php/nm_utf8.php");
    }
    if (!function_exists("SC_dir_app_ini"))
    {
        include_once("../_lib/lib/php/nm_ctrl_app_name.php");
    }
    SC_dir_app_ini('SubsistemaENBC_dev');
    $sc_conv_var = array();
    if (!empty($_FILES))
    {
        foreach ($_FILES as $nmgp_campo => $nmgp_valores)
        {
             if (isset($sc_conv_var[$nmgp_campo]))
             {
                 $nmgp_campo = $sc_conv_var[$nmgp_campo];
             }
             elseif (isset($sc_conv_var[strtolower($nmgp_campo)]))
             {
                 $nmgp_campo = $sc_conv_var[strtolower($nmgp_campo)];
             }
             $tmp_scfile_name     = $nmgp_campo . "_scfile_name";
             $tmp_scfile_type     = $nmgp_campo . "_scfile_type";
             $$nmgp_campo = is_array($nmgp_valores['tmp_name']) ? $nmgp_valores['tmp_name'][0] : $nmgp_valores['tmp_name'];
             $$tmp_scfile_type   = is_array($nmgp_valores['type'])     ? $nmgp_valores['type'][0]     : $nmgp_valores['type'];
             $$tmp_scfile_name   = is_array($nmgp_valores['name'])     ? $nmgp_valores['name'][0]     : $nmgp_valores['name'];
        }
    }
    $Sc_lig_md5 = false;
    $Sem_Session = (!isset($_SESSION['sc_session'])) ? true : false;
    $_SESSION['scriptcase']['sem_session'] = false;
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
             if (isset($sc_conv_var[$nmgp_var]))
             {
                 $nmgp_var = $sc_conv_var[$nmgp_var];
             }
             elseif (isset($sc_conv_var[strtolower($nmgp_var)]))
             {
                 $nmgp_var = $sc_conv_var[strtolower($nmgp_var)];
             }
             nm_limpa_str_respaldo_app_enbc_Login($nmgp_val);
             $nmgp_val = NM_decode_input($nmgp_val);
             $$nmgp_var = $nmgp_val;
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
             if (isset($sc_conv_var[$nmgp_var]))
             {
                 $nmgp_var = $sc_conv_var[$nmgp_var];
             }
             elseif (isset($sc_conv_var[strtolower($nmgp_var)]))
             {
                 $nmgp_var = $sc_conv_var[strtolower($nmgp_var)];
             }
             nm_limpa_str_respaldo_app_enbc_Login($nmgp_val);
             $nmgp_val = NM_decode_input($nmgp_val);
             $$nmgp_var = $nmgp_val;
        }
    }
    if (!isset($_SERVER['HTTP_REFERER']) || (!isset($nmgp_parms) && !isset($script_case_init) && !isset($_POST['rs']) && !isset($nmgp_start) ))
    {
        $Sem_Session = false;
    }
    $NM_dir_atual = getcwd();
    if (empty($NM_dir_atual)) {
        $str_path_sys  = (isset($_SERVER['SCRIPT_FILENAME'])) ? $_SERVER['SCRIPT_FILENAME'] : $_SERVER['ORIG_PATH_TRANSLATED'];
        $str_path_sys  = str_replace("\\", '/', $str_path_sys);
    }
    else {
        $sc_nm_arquivo = explode("/", $_SERVER['PHP_SELF']);
        $str_path_sys  = str_replace("\\", "/", getcwd()) . "/" . $sc_nm_arquivo[count($sc_nm_arquivo)-1];
    }
    $str_path_web    = $_SERVER['PHP_SELF'];
    $str_path_web    = str_replace("\\", '/', $str_path_web);
    $str_path_web    = str_replace('//', '/', $str_path_web);
    $path_aplicacao  = substr($str_path_web, 0, strrpos($str_path_web, '/'));
    $path_aplicacao  = substr($path_aplicacao, 0, strrpos($path_aplicacao, '/'));
    $root            = substr($str_path_sys, 0, -1 * strlen($str_path_web));
    if ($Sem_Session && (!isset($nmgp_start) || $nmgp_start != "SC")) {
        if (isset($_COOKIE['sc_apl_default_SubsistemaENBC_dev'])) {
            $apl_def = explode(",", $_COOKIE['sc_apl_default_SubsistemaENBC_dev']);
        }
        elseif (is_file($root . $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imag_temp'] . "/sc_apl_default_SubsistemaENBC_dev.txt")) {
            $apl_def = explode(",", file_get_contents($root . $_SESSION['scriptcase']['respaldo_app_enbc_Login']['glo_nm_path_imag_temp'] . "/sc_apl_default_SubsistemaENBC_dev.txt"));
        }
        if (isset($apl_def)) {
            if ($apl_def[0] != "respaldo_app_enbc_Login") {
                $_SESSION['scriptcase']['sem_session'] = true;
                if (strtolower(substr($apl_def[0], 0 , 7)) == "http://" || strtolower(substr($apl_def[0], 0 , 8)) == "https://" || substr($apl_def[0], 0 , 2) == "..") {
                    $_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir'] = $apl_def[0];
                }
                else {
                    $_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir'] = $path_aplicacao . "/" . SC_dir_app_name($apl_def[0]) . "/index.php";
                }
                $Redir_tp = (isset($apl_def[1])) ? trim(strtoupper($apl_def[1])) : "";
                $_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir_tp'] = $Redir_tp;
            }
            if (isset($_COOKIE['sc_actual_lang_SubsistemaENBC_dev'])) {
                $_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['lang'] = $_COOKIE['sc_actual_lang_SubsistemaENBC_dev'];
            }
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
    if (isset($SC_where_pdf) && !empty($SC_where_pdf))
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['where_filter'] = $SC_where_pdf;
    }

    if (isset($_POST['rs']) && !is_array($_POST['rs']) && 'ajax_' == substr($_POST['rs'], 0, 5) && isset($_POST['rsargs']) && !empty($_POST['rsargs']) && !isset($_SESSION['scriptcase']['respaldo_app_enbc_Login']['session_timeout']['redir']))
    {
        if ('ajax_respaldo_app_enbc_Login_validate_login' == $_POST['rs'])
        {
            $login = NM_utf8_urldecode($_POST['rsargs'][0]);
            $script_case_init = NM_utf8_urldecode($_POST['rsargs'][1]);
        }
        if ('ajax_respaldo_app_enbc_Login_validate_pswd' == $_POST['rs'])
        {
            $pswd = NM_utf8_urldecode($_POST['rsargs'][0]);
            $script_case_init = NM_utf8_urldecode($_POST['rsargs'][1]);
        }
        if ('ajax_respaldo_app_enbc_Login_validate_remember_me' == $_POST['rs'])
        {
            $remember_me = NM_utf8_urldecode($_POST['rsargs'][0]);
            $script_case_init = NM_utf8_urldecode($_POST['rsargs'][1]);
        }
        if ('ajax_respaldo_app_enbc_Login_validate_new_user' == $_POST['rs'])
        {
            $new_user = NM_utf8_urldecode($_POST['rsargs'][0]);
            $script_case_init = NM_utf8_urldecode($_POST['rsargs'][1]);
        }
        if ('ajax_respaldo_app_enbc_Login_validate_retrieve_pswd' == $_POST['rs'])
        {
            $retrieve_pswd = NM_utf8_urldecode($_POST['rsargs'][0]);
            $script_case_init = NM_utf8_urldecode($_POST['rsargs'][1]);
        }
        if ('ajax_respaldo_app_enbc_Login_submit_form' == $_POST['rs'])
        {
            $login = NM_utf8_urldecode($_POST['rsargs'][0]);
            $pswd = NM_utf8_urldecode($_POST['rsargs'][1]);
            $remember_me = NM_utf8_urldecode($_POST['rsargs'][2]);
            $new_user = NM_utf8_urldecode($_POST['rsargs'][3]);
            $retrieve_pswd = NM_utf8_urldecode($_POST['rsargs'][4]);
            $new_user_sc_target_name = NM_utf8_urldecode($_POST['rsargs'][5]);
            $retrieve_pswd_sc_target_name = NM_utf8_urldecode($_POST['rsargs'][6]);
            $nm_form_submit = NM_utf8_urldecode($_POST['rsargs'][7]);
            $nmgp_url_saida = NM_utf8_urldecode($_POST['rsargs'][8]);
            $nmgp_opcao = NM_utf8_urldecode($_POST['rsargs'][9]);
            $nmgp_ancora = NM_utf8_urldecode($_POST['rsargs'][10]);
            $nmgp_num_form = NM_utf8_urldecode($_POST['rsargs'][11]);
            $nmgp_parms = NM_utf8_urldecode($_POST['rsargs'][12]);
            $script_case_init = NM_utf8_urldecode($_POST['rsargs'][13]);
            $csrf_token = NM_utf8_urldecode($_POST['rsargs'][14]);
            $bok = NM_utf8_urldecode($_POST['rsargs'][15]);
        }
        if ('ajax_respaldo_app_enbc_Login_navigate_form' == $_POST['rs'])
        {
            $nm_form_submit = NM_utf8_urldecode($_POST['rsargs'][0]);
            $nmgp_opcao = NM_utf8_urldecode($_POST['rsargs'][1]);
            $nmgp_ordem = NM_utf8_urldecode($_POST['rsargs'][2]);
            $nmgp_arg_dyn_search = NM_utf8_urldecode($_POST['rsargs'][3]);
            $script_case_init = NM_utf8_urldecode($_POST['rsargs'][4]);
        }
    }

    if (!empty($glo_perfil))  
    { 
        $_SESSION['scriptcase']['glo_perfil'] = $glo_perfil;
    }   
    if (isset($glo_servidor)) 
    {
        $_SESSION['scriptcase']['glo_servidor'] = $glo_servidor;
    }
    if (isset($glo_banco)) 
    {
        $_SESSION['scriptcase']['glo_banco'] = $glo_banco;
    }
    if (isset($glo_tpbanco)) 
    {
        $_SESSION['scriptcase']['glo_tpbanco'] = $glo_tpbanco;
    }
    if (isset($glo_usuario)) 
    {
        $_SESSION['scriptcase']['glo_usuario'] = $glo_usuario;
    }
    if (isset($glo_senha)) 
    {
        $_SESSION['scriptcase']['glo_senha'] = $glo_senha;
    }
    if (isset($glo_senha_protect)) 
    {
        $_SESSION['scriptcase']['glo_senha_protect'] = $glo_senha_protect;
    }
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['lig_edit_lookup']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['lig_edit_lookup']     = false;
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['lig_edit_lookup_cb']  = '';
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['lig_edit_lookup_row'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_call']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_call'] = false;
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_proc']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_proc'] = false;
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_form_insert']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_form_insert'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_form_update']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_form_update'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_form_delete']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_form_delete'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_form_btn_nav']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_form_btn_nav'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_grid_edit']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_grid_edit'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_grid_edit_link']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_grid_edit_link'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_qtd_reg']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_qtd_reg'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_tp_pag']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_liga_tp_pag'] = '';
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && !isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_modal']))
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_modal'] = isset($_GET['nmgp_url_saida']) && 'modal' == $_GET['nmgp_url_saida'];
    } 
    if (isset($script_case_init) && !is_array($script_case_init) && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_proc'])
    {
        return;
    }
    if (isset($script_case_init) && !is_array($script_case_init) && isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_parms']))
    { 
        $tmp_nmgp_parms = '';
        if (isset($nmgp_parms) && '' != $nmgp_parms)
        {
            $tmp_nmgp_parms = $nmgp_parms . '?@?';
        }
        $nmgp_parms = $tmp_nmgp_parms . $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_parms'];
        unset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_parms']);
    } 
    if (isset($nmgp_parms) && !empty($nmgp_parms) && !is_array($nmgp_parms)) 
    { 
        if (isset($_SESSION['nm_aba_bg_color'])) 
        { 
            unset($_SESSION['nm_aba_bg_color']);
        }   
        $nmgp_parms = NM_decode_input($nmgp_parms);
        $nmgp_parms = str_replace("@aspass@", "'", $nmgp_parms);
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
               nm_limpa_str_respaldo_app_enbc_Login($cadapar[1]);
               if (isset($sc_conv_var[$cadapar[0]]))
               {
                   $cadapar[0] = $sc_conv_var[$cadapar[0]];
               }
               elseif (isset($sc_conv_var[strtolower($cadapar[0])]))
               {
                   $cadapar[0] = $sc_conv_var[strtolower($cadapar[0])];
               }
               if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
               $Tmp_par   = $cadapar[0];
               $$Tmp_par = $cadapar[1];
           }
           $ix++;
        }
        if (isset($facebook_error_code)) 
        {
            $_SESSION['facebook_error_code'] = $facebook_error_code;
        }
        if (isset($facebook_error_msg)) 
        {
            $_SESSION['facebook_error_msg'] = $facebook_error_msg;
        }
        if (isset($facebook_user)) 
        {
            $_SESSION['facebook_user'] = $facebook_user;
        }
        if (isset($facebook_email)) 
        {
            $_SESSION['facebook_email'] = $facebook_email;
        }
        if (isset($facebook_name)) 
        {
            $_SESSION['facebook_name'] = $facebook_name;
        }
        if (isset($google_error_code)) 
        {
            $_SESSION['google_error_code'] = $google_error_code;
        }
        if (isset($google_error_msg)) 
        {
            $_SESSION['google_error_msg'] = $google_error_msg;
        }
        if (isset($google_user)) 
        {
            $_SESSION['google_user'] = $google_user;
        }
        if (isset($google_email)) 
        {
            $_SESSION['google_email'] = $google_email;
        }
        if (isset($google_name)) 
        {
            $_SESSION['google_name'] = $google_name;
        }
        if (isset($logged_date_login)) 
        {
            $_SESSION['logged_date_login'] = $logged_date_login;
        }
        if (isset($usr_login)) 
        {
            $_SESSION['usr_login'] = $usr_login;
        }
        if (isset($usr_email)) 
        {
            $_SESSION['usr_email'] = $usr_email;
        }
        if (isset($sett_remember_me)) 
        {
            $_SESSION['sett_remember_me'] = $sett_remember_me;
        }
        if (isset($sett_new_users)) 
        {
            $_SESSION['sett_new_users'] = $sett_new_users;
        }
        if (isset($sett_retrieve_password)) 
        {
            $_SESSION['sett_retrieve_password'] = $sett_retrieve_password;
        }
        if (isset($sett_brute_force)) 
        {
            $_SESSION['sett_brute_force'] = $sett_brute_force;
        }
        if (isset($usr_priv_admin)) 
        {
            $_SESSION['usr_priv_admin'] = $usr_priv_admin;
        }
        if (isset($usr_name)) 
        {
            $_SESSION['usr_name'] = $usr_name;
        }
        if (isset($remember_me)) 
        {
            $_SESSION['remember_me'] = $remember_me;
        }
        if (isset($sett_enable_2fa)) 
        {
            $_SESSION['sett_enable_2fa'] = $sett_enable_2fa;
        }
        if (isset($sett_cookie_expiration_time)) 
        {
            $_SESSION['sett_cookie_expiration_time'] = $sett_cookie_expiration_time;
        }
        if (isset($generacion)) 
        {
            $_SESSION['generacion'] = $generacion;
        }
        if (isset($twitter_user)) 
        {
            $_SESSION['twitter_user'] = $twitter_user;
        }
        if (isset($twitter_email)) 
        {
            $_SESSION['twitter_email'] = $twitter_email;
        }
        if (isset($twitter_name)) 
        {
            $_SESSION['twitter_name'] = $twitter_name;
        }
    } 
    elseif (isset($script_case_init) && !empty($script_case_init) && !is_array($script_case_init) && isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['parms']))
    {
        if (!isset($nmgp_opcao) || ($nmgp_opcao != "incluir" && $nmgp_opcao != "novo" && $nmgp_opcao != "recarga" && $nmgp_opcao != "muda_form"))
        {
            $todox = str_replace("?#?@?@?", "?#?@ ?@?", $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['parms']);
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
               $Tmp_par   = $cadapar[0];
               $$Tmp_par = $cadapar[1];
               $ix++;
            }
        }
    } 
    if (isset($script_case_init) && $script_case_init != preg_replace('/[^0-9.-]/', '', $script_case_init))
    {
        unset($script_case_init);
    }
    if (!isset($script_case_init) || empty($script_case_init) || is_array($script_case_init))
    {
        $script_case_init = rand(2, 10000);
    }
    $salva_run = "N";
    $salva_iframe = false;
    if (isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu']))
    {
        $salva_iframe = $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu'];
        unset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu']);
    }
    if (isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe']))
    {
        $salva_run = $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'];
        unset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe']);
    }
    if (isset($nm_run_menu) && $nm_run_menu == 1)
    {
        if (isset($_SESSION['scriptcase']['sc_aba_iframe']) && isset($_SESSION['scriptcase']['sc_apl_menu_atual']))
        {
            foreach ($_SESSION['scriptcase']['sc_aba_iframe'] as $aba => $apls_aba)
            {
                if ($aba == $_SESSION['scriptcase']['sc_apl_menu_atual'])
                {
                    unset($_SESSION['scriptcase']['sc_aba_iframe'][$aba]);
                    break;
                }
            }
        }
        $_SESSION['scriptcase']['sc_apl_menu_atual'] = "respaldo_app_enbc_Login";
        $achou = false;
        if (isset($_SESSION['sc_session'][$script_case_init]))
        {
            foreach ($_SESSION['sc_session'][$script_case_init] as $nome_apl => $resto)
            {
                if ($nome_apl == 'respaldo_app_enbc_Login' || $achou)
                {
                    unset($_SESSION['sc_session'][$script_case_init][$nome_apl]);
                    if (!empty($_SESSION['sc_session'][$script_case_init][$nome_apl]))
                    {
                        $achou = true;
                    }
                }
            }
            if (!$achou && isset($nm_apl_menu))
            {
                foreach ($_SESSION['sc_session'][$script_case_init] as $nome_apl => $resto)
                {
                    if ($nome_apl == $nm_apl_menu || $achou)
                    {
                        $achou = true;
                        if ($nome_apl != $nm_apl_menu)
                        {
                            unset($_SESSION['sc_session'][$script_case_init][$nome_apl]);
                        }
                    }
                }
            }
        }
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu']  = true;
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['mostra_cab']   = "S";
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe']   = "N";
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['retorno_edit'] = "";
    }
    else
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe']  = $salva_run;
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['iframe_menu'] = $salva_iframe;
    }

    if (!isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['db_changed']))
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['db_changed'] = false;
    }
    if (isset($_GET['nmgp_outra_jan']) && 'true' == $_GET['nmgp_outra_jan'] && isset($_GET['nmgp_url_saida']) && 'modal' == $_GET['nmgp_url_saida'])
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['db_changed'] = false;
    }

    if (isset($_SESSION['scriptcase']['sc_outra_jan']) && $_SESSION['scriptcase']['sc_outra_jan'] == 'respaldo_app_enbc_Login')
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan'] = true;
         unset($_SESSION['scriptcase']['sc_outra_jan']);
    }
    if (isset($nmgp_outra_jan) && $nmgp_outra_jan == 'true')
    {
        if (isset($nmgp_url_saida) && $nmgp_url_saida == "modal")
        {
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_modal'] = true;
            $nm_url_saida = "respaldo_app_enbc_Login_fim.php"; 
        }
        $nm_apl_dependente = 0;
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan'] = true;
    }
    if (!isset($nm_apl_dependente)) {
        $nm_apl_dependente = 0;
    }

    if (!isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['initialize']))
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['initialize'] = true;
    }
    elseif (!isset($_SERVER['HTTP_REFERER']))
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['initialize'] = false;
    }
    elseif (false === strpos($_SERVER['HTTP_REFERER'], '/respaldo_app_enbc_Login/'))
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['initialize'] = true;
    }
    else
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['initialize'] = false;
    }

    if (isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['first_time']))
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['first_time'] = false;
    }
    else
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['first_time'] = true;
    }

    $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['menu_desenv'] = false;   
    if (!defined("SC_ERROR_HANDLER"))
    {
        define("SC_ERROR_HANDLER", 1);
    }
    include_once(dirname(__FILE__) . "/respaldo_app_enbc_Login_erro.php");
    $nm_browser = strpos($_SERVER['HTTP_USER_AGENT'], "Konqueror") ;
    if (is_int($nm_browser))   
    {
        $nm_browser = "Konqueror"; 
    } 
    else  
    {
        $nm_browser = strpos($_SERVER['HTTP_USER_AGENT'], "Opera") ;
        if (is_int($nm_browser))   
        {
            $nm_browser = "Opera"; 
        }
    } 
    $_SESSION['scriptcase']['change_regional_old'] = '';
    $_SESSION['scriptcase']['change_regional_new'] = '';
    if (!empty($nmgp_opcao) && ($nmgp_opcao == "change_lang_t" || $nmgp_opcao == "change_lang_b" || $nmgp_opcao == "change_lang_f" || $nmgp_opcao == "force_lang"))  
    {
        $Temp_lang = $nmgp_opcao == "force_lang" ? explode(";" , $nmgp_idioma) : explode(";" , $nmgp_idioma_novo);  
        if (isset($Temp_lang[0]) && !empty($Temp_lang[0]))  
        { 
            $_SESSION['scriptcase']['str_lang'] = $Temp_lang[0];
        } 
        if (isset($Temp_lang[1]) && !empty($Temp_lang[1])) 
        { 
            $_SESSION['scriptcase']['change_regional_old'] = (isset($_SESSION['scriptcase']['str_conf_reg']) && !empty($_SESSION['scriptcase']['str_conf_reg'])) ? $_SESSION['scriptcase']['str_conf_reg'] : "es_mx";
            $_SESSION['scriptcase']['str_conf_reg']        = $Temp_lang[1];
            $_SESSION['scriptcase']['change_regional_new'] = $_SESSION['scriptcase']['str_conf_reg'];
        } 
        $nmgp_opcao = $nmgp_opcao == "force_lang" ? "inicio" : "recarga";
    } 
    if (!empty($nmgp_opcao) && ($nmgp_opcao == "change_schema_t" || $nmgp_opcao == "change_schema_b" || $nmgp_opcao == "change_schema_f"))  
    {
        if ($nmgp_opcao == "change_schema_t")  
        {
            $nmgp_schema = $nmgp_schema_t . "/" . $nmgp_schema_t;  
        } 
        elseif ($nmgp_opcao == "change_schema_b")  
        {
            $nmgp_schema = $nmgp_schema_b . "/" . $nmgp_schema_b;  
        } 
        else 
        {
            $nmgp_schema = $nmgp_schema_f . "/" . $nmgp_schema_f;  
        } 
        $_SESSION['scriptcase']['str_schema_all'] = $nmgp_schema;
        $nmgp_opcao = "recarga";  
    } 
    if (!empty($nmgp_opcao) && $nmgp_opcao == "lookup")  
    {
        $nm_opc_lookup = $nmgp_opcao;
    }
    elseif (!empty($nmgp_opcao) && $nmgp_opcao == "formphp")  
    {
        $nm_opc_form_php = $nmgp_opcao;
    }
    else
    {
        if (!empty($nmgp_opcao))  
        {
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['opcao'] = $nmgp_opcao ; 
        }
        if (isset($_POST["facebook_error_code"])) 
        {
            $_SESSION['facebook_error_code'] = $_POST["facebook_error_code"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_error_code']);
        }
        if (isset($_GET["facebook_error_code"])) 
        {
            $_SESSION['facebook_error_code'] = $_GET["facebook_error_code"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_error_code']);
        }
        if (isset($_POST["facebook_error_msg"])) 
        {
            $_SESSION['facebook_error_msg'] = $_POST["facebook_error_msg"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_error_msg']);
        }
        if (isset($_GET["facebook_error_msg"])) 
        {
            $_SESSION['facebook_error_msg'] = $_GET["facebook_error_msg"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_error_msg']);
        }
        if (isset($_POST["facebook_user"])) 
        {
            $_SESSION['facebook_user'] = $_POST["facebook_user"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_user']);
        }
        if (isset($_GET["facebook_user"])) 
        {
            $_SESSION['facebook_user'] = $_GET["facebook_user"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_user']);
        }
        if (isset($_POST["facebook_email"])) 
        {
            $_SESSION['facebook_email'] = $_POST["facebook_email"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_email']);
        }
        if (isset($_GET["facebook_email"])) 
        {
            $_SESSION['facebook_email'] = $_GET["facebook_email"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_email']);
        }
        if (isset($_POST["facebook_name"])) 
        {
            $_SESSION['facebook_name'] = $_POST["facebook_name"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_name']);
        }
        if (isset($_GET["facebook_name"])) 
        {
            $_SESSION['facebook_name'] = $_GET["facebook_name"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['facebook_name']);
        }
        if (isset($_POST["google_error_code"])) 
        {
            $_SESSION['google_error_code'] = $_POST["google_error_code"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_error_code']);
        }
        if (isset($_GET["google_error_code"])) 
        {
            $_SESSION['google_error_code'] = $_GET["google_error_code"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_error_code']);
        }
        if (isset($_POST["google_error_msg"])) 
        {
            $_SESSION['google_error_msg'] = $_POST["google_error_msg"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_error_msg']);
        }
        if (isset($_GET["google_error_msg"])) 
        {
            $_SESSION['google_error_msg'] = $_GET["google_error_msg"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_error_msg']);
        }
        if (isset($_POST["google_user"])) 
        {
            $_SESSION['google_user'] = $_POST["google_user"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_user']);
        }
        if (isset($_GET["google_user"])) 
        {
            $_SESSION['google_user'] = $_GET["google_user"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_user']);
        }
        if (isset($_POST["google_email"])) 
        {
            $_SESSION['google_email'] = $_POST["google_email"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_email']);
        }
        if (isset($_GET["google_email"])) 
        {
            $_SESSION['google_email'] = $_GET["google_email"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_email']);
        }
        if (isset($_POST["google_name"])) 
        {
            $_SESSION['google_name'] = $_POST["google_name"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_name']);
        }
        if (isset($_GET["google_name"])) 
        {
            $_SESSION['google_name'] = $_GET["google_name"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['google_name']);
        }
        if (isset($_POST["logged_date_login"])) 
        {
            $_SESSION['logged_date_login'] = $_POST["logged_date_login"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['logged_date_login']);
        }
        if (isset($_GET["logged_date_login"])) 
        {
            $_SESSION['logged_date_login'] = $_GET["logged_date_login"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['logged_date_login']);
        }
        if (isset($_POST["usr_login"])) 
        {
            $_SESSION['usr_login'] = $_POST["usr_login"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['usr_login']);
        }
        if (isset($_GET["usr_login"])) 
        {
            $_SESSION['usr_login'] = $_GET["usr_login"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['usr_login']);
        }
        if (isset($_POST["usr_email"])) 
        {
            $_SESSION['usr_email'] = $_POST["usr_email"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['usr_email']);
        }
        if (isset($_GET["usr_email"])) 
        {
            $_SESSION['usr_email'] = $_GET["usr_email"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['usr_email']);
        }
        if (isset($_POST["sett_remember_me"])) 
        {
            $_SESSION['sett_remember_me'] = $_POST["sett_remember_me"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_remember_me']);
        }
        if (isset($_GET["sett_remember_me"])) 
        {
            $_SESSION['sett_remember_me'] = $_GET["sett_remember_me"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_remember_me']);
        }
        if (isset($_POST["sett_new_users"])) 
        {
            $_SESSION['sett_new_users'] = $_POST["sett_new_users"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_new_users']);
        }
        if (isset($_GET["sett_new_users"])) 
        {
            $_SESSION['sett_new_users'] = $_GET["sett_new_users"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_new_users']);
        }
        if (isset($_POST["sett_retrieve_password"])) 
        {
            $_SESSION['sett_retrieve_password'] = $_POST["sett_retrieve_password"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_retrieve_password']);
        }
        if (isset($_GET["sett_retrieve_password"])) 
        {
            $_SESSION['sett_retrieve_password'] = $_GET["sett_retrieve_password"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_retrieve_password']);
        }
        if (isset($_POST["sett_brute_force"])) 
        {
            $_SESSION['sett_brute_force'] = $_POST["sett_brute_force"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_brute_force']);
        }
        if (isset($_GET["sett_brute_force"])) 
        {
            $_SESSION['sett_brute_force'] = $_GET["sett_brute_force"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_brute_force']);
        }
        if (isset($_POST["usr_priv_admin"])) 
        {
            $_SESSION['usr_priv_admin'] = $_POST["usr_priv_admin"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['usr_priv_admin']);
        }
        if (isset($_GET["usr_priv_admin"])) 
        {
            $_SESSION['usr_priv_admin'] = $_GET["usr_priv_admin"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['usr_priv_admin']);
        }
        if (isset($_POST["usr_name"])) 
        {
            $_SESSION['usr_name'] = $_POST["usr_name"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['usr_name']);
        }
        if (isset($_GET["usr_name"])) 
        {
            $_SESSION['usr_name'] = $_GET["usr_name"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['usr_name']);
        }
        if (isset($_POST["remember_me"])) 
        {
            $_SESSION['remember_me'] = $_POST["remember_me"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['remember_me']);
        }
        if (isset($_GET["remember_me"])) 
        {
            $_SESSION['remember_me'] = $_GET["remember_me"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['remember_me']);
        }
        if (isset($_POST["sett_enable_2fa"])) 
        {
            $_SESSION['sett_enable_2fa'] = $_POST["sett_enable_2fa"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_enable_2fa']);
        }
        if (isset($_GET["sett_enable_2fa"])) 
        {
            $_SESSION['sett_enable_2fa'] = $_GET["sett_enable_2fa"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_enable_2fa']);
        }
        if (isset($_POST["sett_cookie_expiration_time"])) 
        {
            $_SESSION['sett_cookie_expiration_time'] = $_POST["sett_cookie_expiration_time"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_cookie_expiration_time']);
        }
        if (isset($_GET["sett_cookie_expiration_time"])) 
        {
            $_SESSION['sett_cookie_expiration_time'] = $_GET["sett_cookie_expiration_time"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['sett_cookie_expiration_time']);
        }
        if (isset($_POST["generacion"])) 
        {
            $_SESSION['generacion'] = $_POST["generacion"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['generacion']);
        }
        if (isset($_GET["generacion"])) 
        {
            $_SESSION['generacion'] = $_GET["generacion"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['generacion']);
        }
        if (isset($_POST["twitter_user"])) 
        {
            $_SESSION['twitter_user'] = $_POST["twitter_user"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['twitter_user']);
        }
        if (isset($_GET["twitter_user"])) 
        {
            $_SESSION['twitter_user'] = $_GET["twitter_user"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['twitter_user']);
        }
        if (isset($_POST["twitter_email"])) 
        {
            $_SESSION['twitter_email'] = $_POST["twitter_email"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['twitter_email']);
        }
        if (isset($_GET["twitter_email"])) 
        {
            $_SESSION['twitter_email'] = $_GET["twitter_email"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['twitter_email']);
        }
        if (isset($_POST["twitter_name"])) 
        {
            $_SESSION['twitter_name'] = $_POST["twitter_name"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['twitter_name']);
        }
        if (isset($_GET["twitter_name"])) 
        {
            $_SESSION['twitter_name'] = $_GET["twitter_name"];
            nm_limpa_str_respaldo_app_enbc_Login($_SESSION['twitter_name']);
        }
        if (!empty($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_redirect_apl']))
        {
            $_SESSION['scriptcase']['sc_url_saida'][$script_case_init] = $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_redirect_apl']; 
            $nm_apl_dependente = $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_redirect_tp']; 
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_redirect_apl'] = "";
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_redirect_tp'] = "";
            $nm_url_saida = "respaldo_app_enbc_Login_fim.php"; 
        }
        elseif (isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan']) && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan'] == 'true')
        {
               $nm_url_saida = "respaldo_app_enbc_Login_fim.php"; 
        }
        elseif ($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "F" && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "R")
        {
           $nm_url_saida = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ""; 
           $nm_url_saida = str_replace("_fim.php", ".php", $nm_url_saida); 
            $nm_saida_global = $nm_url_saida;
            if (!empty($nmgp_url_saida) && empty($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['retorno_edit'])) 
            {
                $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['retorno_edit'] = $nmgp_url_saida ; 
            } 
            if (!empty($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['retorno_edit'])) 
            {
                $nm_url_saida = $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['retorno_edit'] . "?script_case_init=" . $script_case_init;  
                $nm_apl_dependente = 1 ; 
                $nm_saida_global = $nm_url_saida;
            } 
            if ($nm_apl_dependente != 1) 
            { 
                $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] = "N"; 
            } 
            if ($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "F" && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "R" && (!isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_call']) || !$_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['embutida_call']))
            { 
                $_SESSION['scriptcase']['sc_url_saida'][$script_case_init] = $nm_url_saida; 
                $nm_url_saida = "respaldo_app_enbc_Login_fim.php"; 
                $_SESSION['scriptcase']['sc_tp_saida'] = "P"; 
                if ($nm_apl_dependente == 1) 
                { 
                    $_SESSION['scriptcase']['sc_tp_saida'] = "D"; 
                } 
                if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno']) && $nm_apl_dependente != 1) 
                { 
                    $_SESSION['scriptcase']['sc_url_saida'][$script_case_init] = $_SESSION['scriptcase']['nm_sc_retorno']; 
                } 
            } 
        }
        if (empty($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_tp']) && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "F" && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "R")
        {
            if (!isset($nm_saida_global)) {
                $nm_saida_global = $nm_url_saida;
            }
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_php'] = $nm_url_saida;
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_apl'] = $nm_saida_global;
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_ss']  = (isset($_SESSION['scriptcase']['sc_url_saida'][$script_case_init])) ? $_SESSION['scriptcase']['sc_url_saida'][$script_case_init] : "";
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_dep'] = (isset($nm_apl_dependente)) ? $nm_apl_dependente : "";
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_tp']  = (isset($_SESSION['scriptcase']['sc_tp_saida'])) ? $_SESSION['scriptcase']['sc_tp_saida'] : "";
        }
        $nm_url_saida      = (isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_php'])) ? $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_php'] : "";
        $nm_apl_dependente = (isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_dep'])) ? $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_dep'] : "";
        $nm_saida_global   = $nm_url_saida;
        if ($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "F" && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "R" && !empty($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_ss'])) 
        { 
            $_SESSION['scriptcase']['sc_url_saida'][$script_case_init] = $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_ss'];
            $_SESSION['scriptcase']['sc_tp_saida']  = $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['volta_tp'];
        } 
        if ($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] == "F" || $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] == "R") 
        { 
            if (!empty($nmgp_url_saida) && empty($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['retorno_edit'])) 
            {
                $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['retorno_edit'] = $nmgp_url_saida . "?script_case_init=" . $script_case_init; 
            } 
        } 
        if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno']) && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "F" && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['run_iframe'] != "R") 
        { 
            $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['menu_desenv'] = true;   
        } 
    }
    if (isset($nmgp_redir)) 
    { 
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['redir'] = $nmgp_redir;   
    } 
    if (isset($nmgp_outra_jan) && $nmgp_outra_jan == 'true')
    {
        $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan'] = true;
         if (isset($nmgp_url_saida) && $nmgp_url_saida == "modal")
         {
             $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_modal'] = true;
             $nm_url_saida = "respaldo_app_enbc_Login_fim.php"; 
         }
    }
    if (isset($_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan']) && $_SESSION['sc_session'][$script_case_init]['respaldo_app_enbc_Login']['sc_outra_jan'])
    {
        $nm_apl_dependente = 0;
    }
    $GLOBALS["NM_ERRO_IBASE"] = 0;  
    $inicial_respaldo_app_enbc_Login = new respaldo_app_enbc_Login_edit();
    $inicial_respaldo_app_enbc_Login->inicializa();

    $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['select_html'] = array();
    $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['select_html']['remember_me'] = " onClick=\"\" ";

    if (!defined('SC_SAJAX_LOADED'))
    {
        include_once(dirname(__FILE__) . '/respaldo_app_enbc_Login_sajax.php');
        define('SC_SAJAX_LOADED', 'YES');
    }
    if (!class_exists('Services_JSON'))
    {
        include_once(dirname(__FILE__) . '/respaldo_app_enbc_Login_json.php');
    }
    $sajax_request_type = "POST";
    sajax_init();
    //$sajax_debug_mode = 1;
    sajax_export("ajax_respaldo_app_enbc_Login_validate_login");
    sajax_export("ajax_respaldo_app_enbc_Login_validate_pswd");
    sajax_export("ajax_respaldo_app_enbc_Login_validate_remember_me");
    sajax_export("ajax_respaldo_app_enbc_Login_validate_new_user");
    sajax_export("ajax_respaldo_app_enbc_Login_validate_retrieve_pswd");
    sajax_export("ajax_respaldo_app_enbc_Login_submit_form");
    sajax_export("ajax_respaldo_app_enbc_Login_navigate_form");
    sajax_handle_client_request();

    if (isset($_POST['wizard_action']) && 'change_step' == $_POST['wizard_action']) {
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'] = true;
        ob_start();
    }

    $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->controle();
//
    function nm_limpa_str_respaldo_app_enbc_Login(&$str)
    {
    }

    function ajax_respaldo_app_enbc_Login_validate_login($login, $script_case_init)
    {
        global $inicial_respaldo_app_enbc_Login;
        //register_shutdown_function("respaldo_app_enbc_Login_pack_ajax_response");
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag          = true;
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_opcao         = 'validate_login';
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param'] = array(
                  'login' => NM_utf8_urldecode($login),
                  'script_case_init' => NM_utf8_urldecode($script_case_init),
                  'buffer_output' => true,
                 );
        if ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'])
        {
            ob_start();
        }
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->controle();
        exit;
    } // ajax_validate_login

    function ajax_respaldo_app_enbc_Login_validate_pswd($pswd, $script_case_init)
    {
        global $inicial_respaldo_app_enbc_Login;
        //register_shutdown_function("respaldo_app_enbc_Login_pack_ajax_response");
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag          = true;
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_opcao         = 'validate_pswd';
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param'] = array(
                  'pswd' => NM_utf8_urldecode($pswd),
                  'script_case_init' => NM_utf8_urldecode($script_case_init),
                  'buffer_output' => true,
                 );
        if ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'])
        {
            ob_start();
        }
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->controle();
        exit;
    } // ajax_validate_pswd

    function ajax_respaldo_app_enbc_Login_validate_remember_me($remember_me, $script_case_init)
    {
        global $inicial_respaldo_app_enbc_Login;
        //register_shutdown_function("respaldo_app_enbc_Login_pack_ajax_response");
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag          = true;
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_opcao         = 'validate_remember_me';
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param'] = array(
                  'remember_me' => NM_utf8_urldecode($remember_me),
                  'script_case_init' => NM_utf8_urldecode($script_case_init),
                  'buffer_output' => true,
                 );
        if ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'])
        {
            ob_start();
        }
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->controle();
        exit;
    } // ajax_validate_remember_me

    function ajax_respaldo_app_enbc_Login_validate_new_user($new_user, $script_case_init)
    {
        global $inicial_respaldo_app_enbc_Login;
        //register_shutdown_function("respaldo_app_enbc_Login_pack_ajax_response");
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag          = true;
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_opcao         = 'validate_new_user';
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param'] = array(
                  'new_user' => NM_utf8_urldecode($new_user),
                  'script_case_init' => NM_utf8_urldecode($script_case_init),
                  'buffer_output' => true,
                 );
        if ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'])
        {
            ob_start();
        }
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->controle();
        exit;
    } // ajax_validate_new_user

    function ajax_respaldo_app_enbc_Login_validate_retrieve_pswd($retrieve_pswd, $script_case_init)
    {
        global $inicial_respaldo_app_enbc_Login;
        //register_shutdown_function("respaldo_app_enbc_Login_pack_ajax_response");
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag          = true;
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_opcao         = 'validate_retrieve_pswd';
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param'] = array(
                  'retrieve_pswd' => NM_utf8_urldecode($retrieve_pswd),
                  'script_case_init' => NM_utf8_urldecode($script_case_init),
                  'buffer_output' => true,
                 );
        if ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'])
        {
            ob_start();
        }
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->controle();
        exit;
    } // ajax_validate_retrieve_pswd

    function ajax_respaldo_app_enbc_Login_submit_form($login, $pswd, $remember_me, $new_user, $retrieve_pswd, $new_user_sc_target_name, $retrieve_pswd_sc_target_name, $nm_form_submit, $nmgp_url_saida, $nmgp_opcao, $nmgp_ancora, $nmgp_num_form, $nmgp_parms, $script_case_init, $csrf_token, $bok)
    {
        global $inicial_respaldo_app_enbc_Login;
        //register_shutdown_function("respaldo_app_enbc_Login_pack_ajax_response");
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag          = true;
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_opcao         = 'submit_form';
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param'] = array(
                  'login' => NM_utf8_urldecode($login),
                  'pswd' => NM_utf8_urldecode($pswd),
                  'remember_me' => NM_utf8_urldecode($remember_me),
                  'new_user' => NM_utf8_urldecode($new_user),
                  'retrieve_pswd' => NM_utf8_urldecode($retrieve_pswd),
                  'new_user_sc_target_name' => NM_utf8_urldecode($new_user_sc_target_name),
                  'retrieve_pswd_sc_target_name' => NM_utf8_urldecode($retrieve_pswd_sc_target_name),
                  'nm_form_submit' => NM_utf8_urldecode($nm_form_submit),
                  'nmgp_url_saida' => NM_utf8_urldecode($nmgp_url_saida),
                  'nmgp_opcao' => NM_utf8_urldecode($nmgp_opcao),
                  'nmgp_ancora' => NM_utf8_urldecode($nmgp_ancora),
                  'nmgp_num_form' => NM_utf8_urldecode($nmgp_num_form),
                  'nmgp_parms' => NM_utf8_urldecode($nmgp_parms),
                  'script_case_init' => NM_utf8_urldecode($script_case_init),
                  'csrf_token' => NM_utf8_urldecode($csrf_token),
                  'bok' => NM_utf8_urldecode($bok),
                  'buffer_output' => true,
                 );
        if ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'])
        {
            ob_start();
        }
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->controle();
        exit;
    } // ajax_submit_form

    function ajax_respaldo_app_enbc_Login_navigate_form($nm_form_submit, $nmgp_opcao, $nmgp_ordem, $nmgp_arg_dyn_search, $script_case_init)
    {
        global $inicial_respaldo_app_enbc_Login;
        //register_shutdown_function("respaldo_app_enbc_Login_pack_ajax_response");
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_flag          = true;
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_opcao         = 'navigate_form';
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param'] = array(
                  'nm_form_submit' => NM_utf8_urldecode($nm_form_submit),
                  'nmgp_opcao' => NM_utf8_urldecode($nmgp_opcao),
                  'nmgp_ordem' => NM_utf8_urldecode($nmgp_ordem),
                  'nmgp_arg_dyn_search' => NM_utf8_urldecode($nmgp_arg_dyn_search),
                  'script_case_init' => NM_utf8_urldecode($script_case_init),
                  'buffer_output' => true,
                 );
        if ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'])
        {
            ob_start();
        }
        $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->controle();
        exit;
    } // ajax_navigate_form


   function respaldo_app_enbc_Login_pack_ajax_response()
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp = array();

      if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['wizard']))
      {
          $aResp['wizard'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['wizard'];
      }
      if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['empty_filter']))
      {
          $aResp['empty_filter'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['empty_filter'];
      }
      if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['dyn_search']['NM_Dynamic_Search']))
      {
          $aResp['dyn_search']['NM_Dynamic_Search'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['dyn_search']['NM_Dynamic_Search'];
      }
      if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['dyn_search']['id_dyn_search_cmd_str']))
      {
          $aResp['dyn_search']['id_dyn_search_cmd_str'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['dyn_search']['id_dyn_search_cmd_str'];
      }
      if ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['calendarReload'])
      {
         $aResp['result'] = 'CALENDARRELOAD';
      }
      elseif ('' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['autoComp'])
      {
         $aResp['result'] = 'AUTOCOMP';
      }
//mestre_detalhe
      elseif (!empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['newline']))
      {
         $aResp['result'] = 'NEWLINE';
         ob_end_clean();
      }
      elseif (!empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['tableRefresh']))
      {
         $aResp['result'] = 'TABLEREFRESH';
      }
//-----
      elseif (!empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['errList']))
      {
         $aResp['result'] = 'ERROR';
      }
      elseif (!empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['fldList']))
      {
         $aResp['result'] = 'SET';
      }
      else
      {
         $aResp['result'] = 'OK';
      }
      if ('AUTOCOMP' == $aResp['result'])
      {
         $aResp = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['autoComp'];
      }
//mestre_detalhe
      elseif ('NEWLINE' == $aResp['result'])
      {
         $aResp = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['newline'];
      }
      else
//-----
      {
         $aResp['ajaxRequest'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_opcao;
         if ('CALENDARRELOAD' == $aResp['result'])
         {
            respaldo_app_enbc_Login_pack_calendar_reload($aResp);
         }
         elseif ('ERROR' == $aResp['result'])
         {
            respaldo_app_enbc_Login_pack_ajax_errors($aResp);
         }
         elseif ('SET' == $aResp['result'])
         {
            respaldo_app_enbc_Login_pack_ajax_set_fields($aResp);
         }
         elseif ('TABLEREFRESH' == $aResp['result'])
         {
            respaldo_app_enbc_Login_pack_ajax_set_fields($aResp);
            $aResp['tableRefresh'] = respaldo_app_enbc_Login_pack_protect_string($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['tableRefresh']);
         }
         if ('OK' == $aResp['result'] || 'SET' == $aResp['result'])
         {
            respaldo_app_enbc_Login_pack_ajax_ok($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['focus']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['focus'])
         {
            $aResp['setFocus'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['focus'];
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['closeLine']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['closeLine'])
         {
            $aResp['closeLine'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['closeLine'];
         }
         else
         {
            $aResp['closeLine'] = 'N';
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['clearUpload']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['clearUpload'])
         {
            $aResp['clearUpload'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['clearUpload'];
         }
         else
         {
            $aResp['clearUpload'] = 'N';
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnDisabled']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnDisabled'])
         {
            respaldo_app_enbc_Login_pack_btn_disabled($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnLabel']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnLabel'])
         {
            respaldo_app_enbc_Login_pack_btn_label($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['varList']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['varList']))
         {
            respaldo_app_enbc_Login_pack_var_list($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['masterValue']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['masterValue'])
         {
            respaldo_app_enbc_Login_pack_master_value($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxAlert']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxAlert'])
         {
            respaldo_app_enbc_Login_pack_ajax_alert($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage'])
         {
            respaldo_app_enbc_Login_pack_ajax_message($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxJavascript']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxJavascript'])
         {
            respaldo_app_enbc_Login_pack_ajax_javascript($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir']))
         {
            respaldo_app_enbc_Login_pack_ajax_redir($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redirExit']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redirExit']))
         {
            respaldo_app_enbc_Login_pack_ajax_redir_exit($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['blockDisplay']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['blockDisplay']))
         {
            respaldo_app_enbc_Login_pack_ajax_block_display($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['fieldDisplay']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['fieldDisplay']))
         {
            respaldo_app_enbc_Login_pack_ajax_field_display($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['buttonDisplay']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['buttonDisplay']))
         {
/* mantis 0021191 */            $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['buttonDisplay'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->nmgp_botoes;
            respaldo_app_enbc_Login_pack_ajax_button_display($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['buttonDisplayVert']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['buttonDisplayVert']))
         {
            respaldo_app_enbc_Login_pack_ajax_button_display_vert($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['fieldLabel']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['fieldLabel']))
         {
            respaldo_app_enbc_Login_pack_ajax_field_label($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['readOnly']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['readOnly']))
         {
            respaldo_app_enbc_Login_pack_ajax_readonly($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navStatus']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navStatus']))
         {
            respaldo_app_enbc_Login_pack_ajax_nav_status($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navSummary']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navSummary']))
         {
            respaldo_app_enbc_Login_pack_ajax_nav_Summary($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navPage']))
         {
            respaldo_app_enbc_Login_pack_ajax_navPage($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnVars']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnVars']))
         {
            respaldo_app_enbc_Login_pack_ajax_btn_vars($aResp);
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['quickSearchRes']) && $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['quickSearchRes'])
         {
            $aResp['quickSearchRes'] = 'Y';
         }
         else
         {
            $aResp['quickSearchRes'] = 'N';
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['dyn_search']) && !empty($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['dyn_search']))
         {
            $aResp['dyn_search'] = array();
            foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['dyn_search'] as $Tag => $Val) {
                $aResp['dyn_search'][$Tag] = $Val;
            }
         }
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['event_field']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['event_field'])
         {
            $aResp['eventField'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['event_field'];
         }
         else
         {
            $aResp['eventField'] = '__SC_NO_FIELD';
         }
         $aResp['htmOutput'] = '';
    
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output']) && $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['buffer_output'])
         {
            $aResp['htmOutput'] = ob_get_contents();
            if (false === $aResp['htmOutput'])
            {
               $aResp['htmOutput'] = '';
            }
            else
            {
               $aResp['htmOutput'] = respaldo_app_enbc_Login_pack_protect_string(NM_charset_to_utf8($aResp['htmOutput']));
               ob_end_clean();
            }
         }
      }
      if (is_array($aResp))
      {
          if (isset($aResp['wizard'])) {
              echo json_encode($aResp);
          }
          else {
              $oJson = new Services_JSON();
              echo "var res = " . trim(sajax_get_js_repr($oJson->encode($aResp))) . "; res;";
          }
      }
      else
      {
          echo "var res = " . trim(sajax_get_js_repr($aResp)) . "; res;";
      }
      exit;
   } // respaldo_app_enbc_Login_pack_ajax_response

   function respaldo_app_enbc_Login_pack_calendar_reload(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['calendarReload'] = 'OK';
   } // respaldo_app_enbc_Login_pack_calendar_reload

   function respaldo_app_enbc_Login_pack_ajax_errors(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['errList'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['errList'] as $sField => $aMsg)
      {
         if ('geral_respaldo_app_enbc_Login' == $sField)
         {
             $aMsg = respaldo_app_enbc_Login_pack_ajax_remove_erros($aMsg);
         }
         foreach ($aMsg as $sMsg)
         {
            $iNumLinha = (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['nmgp_refresh_row']) && 'geral_respaldo_app_enbc_Login' != $sField)
                       ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['nmgp_refresh_row'] : "";
            $aResp['errList'][] = array('fldName'  => $sField,
                                        'msgText'  => respaldo_app_enbc_Login_pack_protect_string(NM_charset_to_utf8($sMsg)),
                                        'numLinha' => $iNumLinha);
         }
      }
   } // respaldo_app_enbc_Login_pack_ajax_errors

   function respaldo_app_enbc_Login_pack_ajax_remove_erros($aErrors)
   {
       $aNewErrors = array();
       if (!empty($aErrors))
       {
           $sErrorMsgs = str_replace(array('<br />', '<br>', '<BR />'), array('<BR>', '<BR>', '<BR>'), implode('<br />', $aErrors));
           $aErrorMsgs = explode('<BR>', $sErrorMsgs);
           foreach ($aErrorMsgs as $sErrorMsg)
           {
               $sErrorMsg = trim($sErrorMsg);
               if ('' != $sErrorMsg && !in_array($sErrorMsg, $aNewErrors))
               {
                   $aNewErrors[] = $sErrorMsg;
               }
           }
       }
       return $aNewErrors;
   } // respaldo_app_enbc_Login_pack_ajax_remove_erros

   function respaldo_app_enbc_Login_pack_ajax_ok(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $iNumLinha = (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['nmgp_refresh_row']))
                 ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['nmgp_refresh_row'] : "";
      $aResp['msgDisplay'] = array('msgText'  => respaldo_app_enbc_Login_pack_protect_string($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['msgDisplay']),
                                   'numLinha' => $iNumLinha);
   } // respaldo_app_enbc_Login_pack_ajax_ok

   function respaldo_app_enbc_Login_pack_ajax_set_fields(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $iNumLinha = (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['nmgp_refresh_row']))
                 ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['param']['nmgp_refresh_row'] : "";
      if ('' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['rsSize'])
      {
         $aResp['rsSize'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['rsSize'];
      }
      $aResp['fldList'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['fldList'] as $sField => $aData)
      {
         $aField = array();
         if (isset($aData['colNum']))
         {
            $aField['colNum'] = $aData['colNum'];
         }
         if (isset($aData['row']))
         {
            $aField['row'] = $aData['row'];
         }
         if (isset($aData['imgFile']))
         {
            $aField['imgFile'] = respaldo_app_enbc_Login_pack_protect_string($aData['imgFile']);
         }
         if (isset($aData['imgOrig']))
         {
            $aField['imgOrig'] = respaldo_app_enbc_Login_pack_protect_string($aData['imgOrig']);
         }
         if (isset($aData['imgLink']))
         {
            $aField['imgLink'] = respaldo_app_enbc_Login_pack_protect_string($aData['imgLink']);
         }
         if (isset($aData['keepImg']))
         {
            $aField['keepImg'] = $aData['keepImg'];
         }
         if (isset($aData['hideName']))
         {
            $aField['hideName'] = $aData['hideName'];
         }
         if (isset($aData['docLink']))
         {
            $aField['docLink'] = respaldo_app_enbc_Login_pack_protect_string($aData['docLink']);
         }
         if (isset($aData['docIcon']))
         {
            $aField['docIcon'] = respaldo_app_enbc_Login_pack_protect_string($aData['docIcon']);
         }
         if (isset($aData['docReadonly']))
         {
            $aField['docReadonly'] = respaldo_app_enbc_Login_pack_protect_string($aData['docReadonly']);
         }
         if (isset($aData['keyVal']))
         {
            $aField['keyVal'] = $aData['keyVal'];
         }
         if (isset($aData['optComp']))
         {
            $aField['optComp'] = $aData['optComp'];
         }
         if (isset($aData['optClass']))
         {
            $aField['optClass'] = $aData['optClass'];
         }
         if (isset($aData['optMulti']))
         {
            $aField['optMulti'] = $aData['optMulti'];
         }
         if (isset($aData['switch']))
         {
            $aField['switch'] = $aData['switch'];
         }
         if (isset($aData['lookupCons']))
         {
            $aField['lookupCons'] = $aData['lookupCons'];
         }
         if (isset($aData['imgHtml']))
         {
            $aField['imgHtml'] = respaldo_app_enbc_Login_pack_protect_string($aData['imgHtml']);
         }
         if (isset($aData['mulHtml']))
         {
            $aField['mulHtml'] = respaldo_app_enbc_Login_pack_protect_string($aData['mulHtml']);
         }
         if (isset($aData['updInnerHtml']))
         {
            $aField['updInnerHtml'] = $aData['updInnerHtml'];
         }
         if (isset($aData['htmComp']))
         {
            $aField['htmComp'] = str_replace("'", '__AS__', str_replace('"', '__AD__', $aData['htmComp']));
         }
         $aField['fldName']  = $sField;
         $aField['fldType']  = $aData['type'];
         $aField['numLinha'] = $iNumLinha;
         $aField['valList']  = array();
         foreach ($aData['valList'] as $iIndex => $sValue)
         {
            $aValue = array();
            if (isset($aData['labList'][$iIndex]))
            {
               $aValue['label'] = respaldo_app_enbc_Login_pack_protect_string($aData['labList'][$iIndex]);
            }
            $aValue['value']     = ('_autocomp' != substr($sField, -9)) ? respaldo_app_enbc_Login_pack_protect_string($sValue) : $sValue;
            $aField['valList'][] = $aValue;
         }
         foreach ($aField['valList'] as $iIndex => $aFieldData)
         {
             if ("null" == $aFieldData['value'])
             {
                 $aField['valList'][$iIndex]['value'] = '';
             }
         }
         if (isset($aData['optList']) && false !== $aData['optList'])
         {
            if (is_array($aData['optList']))
            {
               $aField['optList'] = array();
               foreach ($aData['optList'] as $aOptList)
               {
                  foreach ($aOptList as $sValue => $sLabel)
                  {
                     $sOpt = ($sValue !== $sLabel) ? $sValue : $sLabel;
                     $aField['optList'][] = array('value' => respaldo_app_enbc_Login_pack_protect_string($sOpt),
                                                  'label' => respaldo_app_enbc_Login_pack_protect_string($sLabel));
                  }
               }
            }
            else
            {
               $aField['optList'] = $aData['optList'];
            }
         }
         $aResp['fldList'][] = $aField;
      }
   } // respaldo_app_enbc_Login_pack_ajax_set_fields

   function respaldo_app_enbc_Login_pack_ajax_redir(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;

      $aInfo              = array('metodo', 'action', 'target', 'nmgp_parms', 'nmgp_outra_jan', 'nmgp_url_saida', 'script_case_init', 'h_modal', 'w_modal');

      $aResp['redirInfo'] = array();
      foreach ($aInfo as $sTag)
      {
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir'][$sTag]))
         {
            $aResp['redirInfo'][$sTag] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redir'][$sTag];
         }
      }
   } // respaldo_app_enbc_Login_pack_ajax_redir

   function respaldo_app_enbc_Login_pack_ajax_redir_exit(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;

      $aInfo                  = array('metodo', 'action', 'target', 'nmgp_parms', 'nmgp_outra_jan', 'nmgp_url_saida', 'script_case_init');

      $aResp['redirExitInfo'] = array();
      foreach ($aInfo as $sTag)
      {
         if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redirExit'][$sTag]))
         {
            $aResp['redirExitInfo'][$sTag] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['redirExit'][$sTag];
         }
      }
   } // respaldo_app_enbc_Login_pack_ajax_redir_exit

   function respaldo_app_enbc_Login_pack_var_list(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['varList'] as $varData)
      {
         $aResp['varList'][] = array('index' => key($varData),
                                      'value' => current($varData));
      }
   } // respaldo_app_enbc_Login_pack_var_list

   function respaldo_app_enbc_Login_pack_master_value(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['masterValue'] as $sIndex => $sValue)
      {
         $aResp['masterValue'][] = array('index' => $sIndex,
                                         'value' => $sValue);
      }
   } // respaldo_app_enbc_Login_pack_master_value

   function respaldo_app_enbc_Login_pack_btn_disabled(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['btnDisabled'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnDisabled'] as $btnName => $btnStatus) {
        $aResp['btnDisabled'][$btnName] = $btnStatus;
      }
   } // respaldo_app_enbc_Login_pack_ajax_alert

   function respaldo_app_enbc_Login_pack_btn_label(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['btnLabel'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnLabel'] as $btnName => $btnLabel) {
        $aResp['btnLabel'][$btnName] = $btnLabel;
      }
   } // respaldo_app_enbc_Login_pack_ajax_alert

   function respaldo_app_enbc_Login_pack_ajax_alert(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
// PHP 8.0
      if (!isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxAlert']['message'])) {
          $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxAlert']['message'] = '';
      }
      if (!isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxAlert']['params'])) {
          $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxAlert']['params'] = '';
      }
//---
      $aResp['ajaxAlert'] = array('message' => $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxAlert']['message'], 'params' =>  $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxAlert']['params']);
   } // respaldo_app_enbc_Login_pack_ajax_alert

   function respaldo_app_enbc_Login_pack_ajax_message(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
// PHP 8.0
      if (!isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['message'])) {
          $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['message'] = '';
      }
      if (!isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['title'])) {
          $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['title'] = '';
      }
//---
      $aResp['ajaxMessage'] = array('message'      => respaldo_app_enbc_Login_pack_protect_string($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['message']),
                                    'title'        => respaldo_app_enbc_Login_pack_protect_string($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['title']),
                                    'modal'        => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['modal'])        ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['modal']        : 'N',
                                    'timeout'      => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['timeout'])      ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['timeout']      : '',
                                    'button'       => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['button'])       ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['button']       : '',
                                    'button_label' => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['button_label']) ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['button_label'] : 'Ok',
                                    'top'          => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['top'])          ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['top']          : '',
                                    'left'         => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['left'])         ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['left']         : '',
                                    'width'        => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['width'])        ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['width']        : '',
                                    'height'       => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['height'])       ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['height']       : '',
                                    'redir'        => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['redir'])        ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['redir']        : '',
                                    'show_close'   => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['show_close'])   ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['show_close']   : 'Y',
                                    'body_icon'    => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['body_icon'])    ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['body_icon']    : 'Y',
                                    'toast'        => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['toast'])        ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['toast']        : 'N',
                                    'toast_pos'    => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['toast_pos'])    ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['toast_pos']    : '',
                                    'type'         => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['type'])         ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['type']         : '',
                                    'redir_target' => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['redir_target']) ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['redir_target'] : '',
                                    'redir_par'    => isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['redir_par'])    ? $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxMessage']['redir_par']    : '');
   } // respaldo_app_enbc_Login_pack_ajax_message

   function respaldo_app_enbc_Login_pack_ajax_javascript(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['ajaxJavascript'] as $aJsFunc)
      {
         $aResp['ajaxJavascript'][] = $aJsFunc;
      }
   } // respaldo_app_enbc_Login_pack_ajax_javascript

   function respaldo_app_enbc_Login_pack_ajax_block_display(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['blockDisplay'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['blockDisplay'] as $sBlockName => $sBlockStatus)
      {
        $aResp['blockDisplay'][] = array($sBlockName, $sBlockStatus);
      }
   } // respaldo_app_enbc_Login_pack_ajax_block_display

   function respaldo_app_enbc_Login_pack_ajax_field_display(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['fieldDisplay'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['fieldDisplay'] as $sFieldName => $sFieldStatus)
      {
        $aResp['fieldDisplay'][] = array($sFieldName, $sFieldStatus);
      }
   } // respaldo_app_enbc_Login_pack_ajax_field_display

   function respaldo_app_enbc_Login_pack_ajax_button_display(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['buttonDisplay'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['buttonDisplay'] as $sButtonName => $sButtonStatus)
      {
        $aResp['buttonDisplay'][] = array($sButtonName, $sButtonStatus);
      }
   } // respaldo_app_enbc_Login_pack_ajax_button_display

   function respaldo_app_enbc_Login_pack_ajax_button_display_vert(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['buttonDisplayVert'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['buttonDisplayVert'] as $aButtonData)
      {
        $aResp['buttonDisplayVert'][] = $aButtonData;
      }
   } // respaldo_app_enbc_Login_pack_ajax_button_display

   function respaldo_app_enbc_Login_pack_ajax_field_label(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['fieldLabel'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['fieldLabel'] as $sFieldName => $sFieldLabel)
      {
        $aResp['fieldLabel'][] = array($sFieldName, respaldo_app_enbc_Login_pack_protect_string($sFieldLabel));
      }
   } // respaldo_app_enbc_Login_pack_ajax_field_label

   function respaldo_app_enbc_Login_pack_ajax_readonly(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['readOnly'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['readOnly'] as $sFieldName => $sFieldStatus)
      {
        $aResp['readOnly'][] = array($sFieldName, $sFieldStatus);
      }
   } // respaldo_app_enbc_Login_pack_ajax_readonly

   function respaldo_app_enbc_Login_pack_ajax_nav_status(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['navStatus'] = array();
      if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navStatus']['ret']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navStatus']['ret'])
      {
         $aResp['navStatus']['ret'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navStatus']['ret'];
      }
      if (isset($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navStatus']['ava']) && '' != $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navStatus']['ava'])
      {
         $aResp['navStatus']['ava'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navStatus']['ava'];
      }
   } // respaldo_app_enbc_Login_pack_ajax_nav_status

   function respaldo_app_enbc_Login_pack_ajax_nav_Summary(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['navSummary'] = array();
      $aResp['navSummary']['reg_ini'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navSummary']['reg_ini'];
      $aResp['navSummary']['reg_qtd'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navSummary']['reg_qtd'];
      $aResp['navSummary']['reg_tot'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navSummary']['reg_tot'];
      $aResp['navSummary']['summary_line'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['summary_line'];
   } // respaldo_app_enbc_Login_pack_ajax_nav_Summary

   function respaldo_app_enbc_Login_pack_ajax_navPage(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['navPage'] = $inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['navPage'];
   } // respaldo_app_enbc_Login_pack_ajax_navPage


   function respaldo_app_enbc_Login_pack_ajax_btn_vars(&$aResp)
   {
      global $inicial_respaldo_app_enbc_Login;
      $aResp['btnVars'] = array();
      foreach ($inicial_respaldo_app_enbc_Login->contr_respaldo_app_enbc_Login->NM_ajax_info['btnVars'] as $sBtnName => $sBtnValue)
      {
        $aResp['btnVars'][] = array($sBtnName, respaldo_app_enbc_Login_pack_protect_string($sBtnValue));
      }
   } // respaldo_app_enbc_Login_pack_ajax_btn_vars

   function respaldo_app_enbc_Login_pack_protect_string($sString)
   {
      $sString = (string) $sString;

      if (!empty($sString))
      {
         if (function_exists('NM_is_utf8') && NM_is_utf8($sString))
         {
             return $sString;
         }
         else
         {
/*             return htmlentities($sString, ENT_COMPAT, $_SESSION['scriptcase']['charset']); */
             return sc_htmlentities($sString);
         }
      }
      elseif ('0' === $sString || 0 === $sString)
      {
         return '0';
      }
      else
      {
         return '';
      }
   } // respaldo_app_enbc_Login_pack_protect_string
?>
