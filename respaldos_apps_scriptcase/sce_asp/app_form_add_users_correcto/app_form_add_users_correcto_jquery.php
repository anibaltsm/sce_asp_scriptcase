
function scJQGeneralAdd() {
  scLoadScInput('input:text.sc-js-input');
  scLoadScInput('input:password.sc-js-input');
  scLoadScInput('input:checkbox.sc-js-input');
  scLoadScInput('input:radio.sc-js-input');
  scLoadScInput('select.sc-js-input');
  scLoadScInput('textarea.sc-js-input');

} // scJQGeneralAdd

function scFocusField(sField) {
  var $oField = $('#id_sc_field_' + sField);

  if (0 == $oField.length) {
    $oField = $('input[name=' + sField + ']');
  }

  if (0 == $oField.length && document.F1.elements[sField]) {
    $oField = $(document.F1.elements[sField]);
  }

  if ($("#id_ac_" + sField).length > 0) {
    if ($oField.hasClass("select2-hidden-accessible")) {
      if (false == scSetFocusOnField($oField, sField)) {
        setTimeout(function() { scSetFocusOnField($oField, sField); }, 500);
      }
    }
    else {
      if (false == scSetFocusOnField($oField, sField)) {
        if (false == scSetFocusOnField($("#id_ac_" + sField, sField))) {
          setTimeout(function() { scSetFocusOnField($("#id_ac_" + sField, sField)); }, 500);
        }
      }
      else {
        setTimeout(function() { scSetFocusOnField($oField, sField); }, 500);
      }
    }
  }
  else {
    setTimeout(function() { scSetFocusOnField($oField, sField); }, 500);
  }
} // scFocusField

function scSetFocusOnField($oField, sField) {
  if ($oField.length > 0 && $oField[0].offsetHeight > 0 && $oField[0].offsetWidth > 0 && !$oField[0].disabled) {
    $oField[0].focus();
    return true;
  }
  return false;
} // scSetFocusOnField

function scEventControl_init(iSeqRow) {
  scEventControl_data["login" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["pswd" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["confirm_pswd" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["name" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["apat" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["amat" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["email" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
}

function scEventControl_active(iSeqRow) {
  if (scEventControl_data["login" + iSeqRow] && scEventControl_data["login" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["login" + iSeqRow] && scEventControl_data["login" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["pswd" + iSeqRow] && scEventControl_data["pswd" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["pswd" + iSeqRow] && scEventControl_data["pswd" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["confirm_pswd" + iSeqRow] && scEventControl_data["confirm_pswd" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["confirm_pswd" + iSeqRow] && scEventControl_data["confirm_pswd" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["name" + iSeqRow] && scEventControl_data["name" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["name" + iSeqRow] && scEventControl_data["name" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["apat" + iSeqRow] && scEventControl_data["apat" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["apat" + iSeqRow] && scEventControl_data["apat" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["amat" + iSeqRow] && scEventControl_data["amat" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["amat" + iSeqRow] && scEventControl_data["amat" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["email" + iSeqRow] && scEventControl_data["email" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["email" + iSeqRow] && scEventControl_data["email" + iSeqRow]["change"]) {
    return true;
  }
  return false;
} // scEventControl_active

function scEventControl_onFocus(oField, iSeq) {
  var fieldId, fieldName;
  fieldId = $(oField).attr("id");
  fieldName = fieldId.substr(12);
  scEventControl_data[fieldName]["blur"] = true;
  scEventControl_data[fieldName]["change"] = false;
} // scEventControl_onFocus

function scEventControl_onBlur(sFieldName) {
  scEventControl_data[sFieldName]["blur"] = false;
  if (scEventControl_data[sFieldName]["change"]) {
        if (scEventControl_data[sFieldName]["original"] == $("#id_sc_field_" + sFieldName).val() || scEventControl_data[sFieldName]["calculated"] == $("#id_sc_field_" + sFieldName).val()) {
          scEventControl_data[sFieldName]["change"] = false;
        }
  }
} // scEventControl_onBlur

function scEventControl_onChange(sFieldName) {
  scEventControl_data[sFieldName]["change"] = false;
} // scEventControl_onChange

function scEventControl_onAutocomp(sFieldName) {
  scEventControl_data[sFieldName]["autocomp"] = false;
} // scEventControl_onChange

var scEventControl_data = {};

function scJQEventsAdd(iSeqRow) {
  $('#id_sc_field_login' + iSeqRow).bind('blur', function() { setTimeout(function() {sc_app_form_add_users_correcto_login_onblur('#id_sc_field_login' + iSeqRow, iSeqRow, event);}, 300) })
                                   .bind('change', function() { sc_app_form_add_users_correcto_login_onchange(this, iSeqRow, event) })
                                   .bind('focus', function() { sc_app_form_add_users_correcto_login_onfocus(this, iSeqRow, event) });
  $('#id_sc_field_pswd' + iSeqRow).bind('blur', function() { sc_app_form_add_users_correcto_pswd_onblur('#id_sc_field_pswd' + iSeqRow, iSeqRow, event) })
                                  .bind('change', function() { sc_app_form_add_users_correcto_pswd_onchange(this, iSeqRow, event) })
                                  .bind('focus', function() { sc_app_form_add_users_correcto_pswd_onfocus(this, iSeqRow, event) });
  $('#id_sc_field_name' + iSeqRow).bind('blur', function() { sc_app_form_add_users_correcto_name_onblur('#id_sc_field_name' + iSeqRow, iSeqRow, event) })
                                  .bind('change', function() { sc_app_form_add_users_correcto_name_onchange(this, iSeqRow, event) })
                                  .bind('focus', function() { sc_app_form_add_users_correcto_name_onfocus(this, iSeqRow, event) });
  $('#id_sc_field_apat' + iSeqRow).bind('blur', function() { sc_app_form_add_users_correcto_apat_onblur('#id_sc_field_apat' + iSeqRow, iSeqRow, event) })
                                  .bind('change', function() { sc_app_form_add_users_correcto_apat_onchange(this, iSeqRow, event) })
                                  .bind('focus', function() { sc_app_form_add_users_correcto_apat_onfocus(this, iSeqRow, event) });
  $('#id_sc_field_amat' + iSeqRow).bind('blur', function() { sc_app_form_add_users_correcto_amat_onblur('#id_sc_field_amat' + iSeqRow, iSeqRow, event) })
                                  .bind('change', function() { sc_app_form_add_users_correcto_amat_onchange(this, iSeqRow, event) })
                                  .bind('focus', function() { sc_app_form_add_users_correcto_amat_onfocus(this, iSeqRow, event) });
  $('#id_sc_field_email' + iSeqRow).bind('blur', function() { sc_app_form_add_users_correcto_email_onblur('#id_sc_field_email' + iSeqRow, iSeqRow, event) })
                                   .bind('change', function() { sc_app_form_add_users_correcto_email_onchange(this, iSeqRow, event) })
                                   .bind('focus', function() { sc_app_form_add_users_correcto_email_onfocus(this, iSeqRow, event) });
  $('#id_sc_field_active' + iSeqRow).bind('change', function() { sc_app_form_add_users_correcto_active_onchange(this, iSeqRow, event) });
  $('#id_sc_field_activation_code' + iSeqRow).bind('change', function() { sc_app_form_add_users_correcto_activation_code_onchange(this, iSeqRow, event) });
  $('#id_sc_field_priv_admin' + iSeqRow).bind('change', function() { sc_app_form_add_users_correcto_priv_admin_onchange(this, iSeqRow, event) });
  $('#id_sc_field_ip_alta' + iSeqRow).bind('change', function() { sc_app_form_add_users_correcto_ip_alta_onchange(this, iSeqRow, event) });
  $('#id_sc_field_fecha_alta' + iSeqRow).bind('change', function() { sc_app_form_add_users_correcto_fecha_alta_onchange(this, iSeqRow, event) });
  $('#id_sc_field_fecha_alta_hora' + iSeqRow).bind('change', function() { sc_app_form_add_users_correcto_fecha_alta_hora_onchange(this, iSeqRow, event) });
  $('#id_sc_field_confirm_pswd' + iSeqRow).bind('blur', function() { setTimeout(function() {sc_app_form_add_users_correcto_confirm_pswd_onblur('#id_sc_field_confirm_pswd' + iSeqRow, iSeqRow, event);}, 300) })
                                          .bind('change', function() { sc_app_form_add_users_correcto_confirm_pswd_onchange(this, iSeqRow, event) })
                                          .bind('focus', function() { sc_app_form_add_users_correcto_confirm_pswd_onfocus(this, iSeqRow, event) });
} // scJQEventsAdd

Upload_Cancel = false;
function sc_app_form_add_users_correcto_login_onblur(oThis, iSeqRow, event) {
  do_ajax_app_form_add_users_correcto_validate_login();
  scCssBlur(oThis);
}

function sc_app_form_add_users_correcto_login_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_login_onfocus(oThis, iSeqRow, event) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_app_form_add_users_correcto_pswd_onblur(oThis, iSeqRow, event) {
  do_ajax_app_form_add_users_correcto_validate_pswd();
  scCssBlur(oThis);
}

function sc_app_form_add_users_correcto_pswd_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_pswd_onfocus(oThis, iSeqRow, event) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_app_form_add_users_correcto_name_onblur(oThis, iSeqRow, event) {
  do_ajax_app_form_add_users_correcto_validate_name();
  scCssBlur(oThis);
}

function sc_app_form_add_users_correcto_name_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_name_onfocus(oThis, iSeqRow, event) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_app_form_add_users_correcto_apat_onblur(oThis, iSeqRow, event) {
  do_ajax_app_form_add_users_correcto_validate_apat();
  scCssBlur(oThis);
}

function sc_app_form_add_users_correcto_apat_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_apat_onfocus(oThis, iSeqRow, event) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_app_form_add_users_correcto_amat_onblur(oThis, iSeqRow, event) {
  do_ajax_app_form_add_users_correcto_validate_amat();
  scCssBlur(oThis);
}

function sc_app_form_add_users_correcto_amat_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_amat_onfocus(oThis, iSeqRow, event) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_app_form_add_users_correcto_email_onblur(oThis, iSeqRow, event) {
  do_ajax_app_form_add_users_correcto_validate_email();
  scCssBlur(oThis);
}

function sc_app_form_add_users_correcto_email_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_email_onfocus(oThis, iSeqRow, event) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_app_form_add_users_correcto_active_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_activation_code_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_priv_admin_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_ip_alta_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_fecha_alta_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_fecha_alta_hora_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_confirm_pswd_onblur(oThis, iSeqRow, event) {
  do_ajax_app_form_add_users_correcto_validate_confirm_pswd();
  scCssBlur(oThis);
}

function sc_app_form_add_users_correcto_confirm_pswd_onchange(oThis, iSeqRow, event) {
  scMarkFormAsChanged();
}

function sc_app_form_add_users_correcto_confirm_pswd_onfocus(oThis, iSeqRow, event) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function displayChange_block(block, status) {
        if ("0" == block) {
                displayChange_block_0(status);
        }
}

function displayChange_block_0(status) {
        displayChange_field("login", "", status);
        displayChange_field("pswd", "", status);
        displayChange_field("confirm_pswd", "", status);
        displayChange_field("name", "", status);
        displayChange_field("apat", "", status);
        displayChange_field("amat", "", status);
        displayChange_field("email", "", status);
}

function displayChange_row(row, status) {
        displayChange_field_login(row, status);
        displayChange_field_pswd(row, status);
        displayChange_field_confirm_pswd(row, status);
        displayChange_field_name(row, status);
        displayChange_field_apat(row, status);
        displayChange_field_amat(row, status);
        displayChange_field_email(row, status);
}

function displayChange_field(field, row, status) {
        if ("login" == field) {
                displayChange_field_login(row, status);
        }
        if ("pswd" == field) {
                displayChange_field_pswd(row, status);
        }
        if ("confirm_pswd" == field) {
                displayChange_field_confirm_pswd(row, status);
        }
        if ("name" == field) {
                displayChange_field_name(row, status);
        }
        if ("apat" == field) {
                displayChange_field_apat(row, status);
        }
        if ("amat" == field) {
                displayChange_field_amat(row, status);
        }
        if ("email" == field) {
                displayChange_field_email(row, status);
        }
}

function displayChange_field_login(row, status) {
    var fieldId;
}

function displayChange_field_pswd(row, status) {
    var fieldId;
}

function displayChange_field_confirm_pswd(row, status) {
    var fieldId;
}

function displayChange_field_name(row, status) {
    var fieldId;
}

function displayChange_field_apat(row, status) {
    var fieldId;
}

function displayChange_field_amat(row, status) {
    var fieldId;
}

function displayChange_field_email(row, status) {
    var fieldId;
}

function scRecreateSelect2() {
}
function scResetPagesDisplay() {
        $(".sc-form-page").show();
}

function scHidePage(pageNo) {
        $("#id_app_form_add_users_correcto_form" + pageNo).hide();
}

function scCheckNoPageSelected() {
        if (!$(".sc-form-page").filter(".scTabActive").filter(":visible").length) {
                var inactiveTabs = $(".sc-form-page").filter(".scTabInactive").filter(":visible");
                if (inactiveTabs.length) {
                        var tabNo = $(inactiveTabs[0]).attr("id").substr(38);
                }
        }
}
var sc_jq_calendar_value = {};

function scJQCalendarAdd(iSeqRow) {
  $("#id_sc_field_fecha_alta" + iSeqRow).datepicker('destroy');
  $("#id_sc_field_fecha_alta" + iSeqRow).datepicker({
    beforeShow: function(input, inst) {
      var $oField = $(this),
          aParts  = $oField.val().split(" "),
          sTime   = "";
      sc_jq_calendar_value["#id_sc_field_fecha_alta" + iSeqRow] = $oField.val();
      if (2 == aParts.length) {
        sTime = " " + aParts[1];
      }
      if ('' == sTime || ' ' == sTime) {
        sTime = ' <?php echo $this->jqueryCalendarTimeStart($this->field_config['fecha_alta']['date_format'], 'start'); ?>';
      }
      $oField.datepicker("option", "dateFormat", "<?php echo $this->jqueryCalendarDtFormat("" . str_replace(array('/', 'aaaa', 'hh', 'ii', 'ss', ':', ';', $_SESSION['scriptcase']['reg_conf']['date_sep'], $_SESSION['scriptcase']['reg_conf']['time_sep']), array('', 'yyyy', '','','', '', '', '', ''), $this->field_config['fecha_alta']['date_format']) . "", "" . $_SESSION['scriptcase']['reg_conf']['date_sep'] . ""); ?>" + sTime)
<?php
if ('' != $miniCalendarFA) {
?>
    .next('button').append("<?php echo $miniCalendarFA; ?>")
<?php
}
elseif ('' != $miniCalendarButton[0]) {
?>
    .next('button').append("<?php echo $miniCalendarButton[0]; ?>")
<?php
}
?>
    },
    onClose: function(dateText, inst) {
      do_ajax_app_form_add_users_correcto_validate_fecha_alta(iSeqRow);
    },
    showWeek: true,
    numberOfMonths: 1,
    changeMonth: true,
    changeYear: true,
    yearRange: 'c-5:c+5',
    dayNames: ["<?php        echo html_entity_decode($this->Ini->Nm_lang['lang_days_sund'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_mond'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_tued'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_wend'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_thud'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_frid'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_satd'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>"],
    dayNamesMin: ["<?php     echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_sund'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_mond'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_tued'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_wend'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_thud'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_frid'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_satd'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>"],
    monthNames: ["<?php      echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_janu"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_febr"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_marc"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_apri"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_mayy"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_june"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_july"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_augu"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_sept"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_octo"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_nove"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_dece"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>"],
    monthNamesShort: ["<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_janu'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_febr'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_marc'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_apri'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_mayy'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_june'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_july'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_augu'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_sept'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_octo'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_nove'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_dece'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>"],
    weekHeader: "<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_days_sem'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>",
    firstDay: <?php echo $this->jqueryCalendarWeekInit("" . $_SESSION['scriptcase']['reg_conf']['date_week_ini'] . ""); ?>,
    dateFormat: "<?php echo $this->jqueryCalendarDtFormat("" . str_replace(array('/', 'aaaa', 'hh', 'ii', 'ss', ':', ';', $_SESSION['scriptcase']['reg_conf']['date_sep'], $_SESSION['scriptcase']['reg_conf']['time_sep']), array('', 'yyyy', '','','', '', '', '', ''), $this->field_config['fecha_alta']['date_format']) . "", "" . $_SESSION['scriptcase']['reg_conf']['date_sep'] . ""); ?>",
    showOtherMonths: true,
    showOn: "button",
<?php
$miniCalendarIcon   = $this->jqueryIconFile('calendar');
$miniCalendarFA     = $this->jqueryFAFile('calendar');
$miniCalendarButton = $this->jqueryButtonText('calendar');
if ('' != $miniCalendarIcon) {
?>
    buttonImage: "<?php echo $miniCalendarIcon; ?>",
    buttonImageOnly: true,
<?php
}
elseif ('' != $miniCalendarFA) {
?>
    buttonText: "",
<?php
}
elseif ('' != $miniCalendarButton[0]) {
?>
    buttonText: "",
<?php
}
?>
    currentText: "<?php  echo html_entity_decode($this->Ini->Nm_lang["lang_per_today"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);       ?>",
    closeText: "<?php  echo html_entity_decode($this->Ini->Nm_lang["lang_btns_mess_clse"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);       ?>",
  })
<?php
if ('' != $miniCalendarFA) {
?>
    .next('button').append("<?php echo $miniCalendarFA; ?>")
<?php
}
elseif ('' != $miniCalendarButton[0]) {
?>
    .next('button').append("<?php echo $miniCalendarButton[0]; ?>")
<?php
}
?>
} // scJQCalendarAdd

function scJQUploadAdd(iSeqRow) {
} // scJQUploadAdd

var api_cache_requests = [];
function ajax_check_file(img_name, field  ,t, p, p_cache, iSeqRow, hasRun, img_before){
    setTimeout(function(){
        if(img_name == '') return;
        iSeqRow= iSeqRow !== undefined && iSeqRow !== null ? iSeqRow : '';
        var hasVar = p.indexOf('_@NM@_') > -1 || p_cache.indexOf('_@NM@_') > -1 ? true : false;

        p = p.split('_@NM@_');
        $.each(p, function(i,v){
            try{
                p[i] = $('[name='+v+iSeqRow+']').val();
            }
            catch(err){
                p[i] = v;
            }
        });
        p = p.join('');

        p_cache = p_cache.split('_@NM@_');
        $.each(p_cache, function(i,v){
            try{
                p_cache[i] = $('[name='+v+iSeqRow+']').val();
            }
            catch(err){
                p_cache[i] = v;
            }
        });
        p_cache = p_cache.join('');

        img_before = img_before !== undefined ? img_before : $(t).attr('src');
        var str_key_cache = '<?php echo $this->Ini->sc_page; ?>' + img_name+field+p+p_cache;
        if(api_cache_requests[ str_key_cache ] !== undefined && api_cache_requests[ str_key_cache ] !== null){
            if(api_cache_requests[ str_key_cache ] != false){
                do_ajax_check_file(api_cache_requests[ str_key_cache ], field  ,t, iSeqRow);
            }
            return;
        }
        //scAjaxProcOn();
        $(t).attr('src', '<?php echo $this->Ini->path_icones ?>/scriptcase__NM__ajax_load.gif');
        api_cache_requests[ str_key_cache ] = false;
        var rs =$.ajax({
                    type: "POST",
                    url: 'index.php?script_case_init=<?php echo $this->Ini->sc_page; ?>',
                    async: true,
                    data:'nmgp_opcao=ajax_check_file&AjaxCheckImg=' + encodeURI(img_name) +'&rsargs='+ field + '&p=' + p + '&p_cache=' + p_cache,
                    success: function (rs) {
                        if(rs.indexOf('</span>') != -1){
                            rs = rs.substr(rs.indexOf('</span>') + 7);
                        }
                        if(rs.indexOf('/') != -1 && rs.indexOf('/') != 0){
                            rs = rs.substr(rs.indexOf('/'));
                        }
                        rs = sc_trim(rs);

                        // if(rs == 0 && hasVar && hasRun === undefined){
                        //     delete window.api_cache_requests[ str_key_cache ];
                        //     ajax_check_file(img_name, field  ,t, p, p_cache, iSeqRow, 1, img_before);
                        //     return;
                        // }
                        window.api_cache_requests[ str_key_cache ] = rs;
                        do_ajax_check_file(rs, field  ,t, iSeqRow)
                        if(rs == 0){
                            delete window.api_cache_requests[ str_key_cache ];

                           // $(t).attr('src',img_before);
                            do_ajax_check_file(img_before+'_@@NM@@_' + img_before, field  ,t, iSeqRow)

                        }


                    }
        });
    },100);
}

function do_ajax_check_file(rs, field  ,t, iSeqRow){
    if (rs != 0) {
        rs_split = rs.split('_@@NM@@_');
        rs_orig = rs_split[0];
        rs2 = rs_split[1];
        try{
            if(!$(t).is('img')){

                if($('#id_read_on_'+field+iSeqRow).length > 0 ){
                                    var usa_read_only = false;

                switch(field){

                }
                     if(usa_read_only && $('a',$('#id_read_on_'+field+iSeqRow)).length == 0){
                         $(t).html("<a href=\"javascript:nm_mostra_doc('0', '"+rs2+"', 'app_form_add_users_correcto')\">"+$('#id_read_on_'+field+iSeqRow).text()+"</a>");
                     }
                }
                if($('#id_ajax_doc_'+field+iSeqRow+' a').length > 0){
                    var target = $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href').split(',');
                    target[1] = "'"+rs2+"'";
                    $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href', target.join(','));
                }else{
                    var target = $(t).attr('href').split(',');
                     target[1] = "'"+rs2+"'";
                     $(t).attr('href', target.join(','));
                }
            }else{
                $(t).attr('src', rs2);
                $(t).css('display', '');
                if($('#id_ajax_doc_'+field+iSeqRow+' a').length > 0){
                    var target = $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href').split(',');
                    target[1] = "'"+rs2+"'";
                    $(t).attr('href', target.join(','));
                }else{
                     var t_link = $(t).parent('a');
                     var target = $(t_link).attr('href').split(',');
                     target[0] = "javascript:nm_mostra_img('"+rs_orig+"'";
                     $(t_link).attr('href', target.join(','));
                }

            }
            eval("window.var_ajax_img_"+field+iSeqRow+" = '"+rs_orig+"';");

        } catch(err){
                        eval("window.var_ajax_img_"+field+iSeqRow+" = '"+rs_orig+"';");

        }
    }
   /* hasFalseCacheRequest = false;
    $.each(api_cache_requests, function(i,v){
        if(v == false){
            hasFalseCacheRequest = true;
        }
    });
    if(hasFalseCacheRequest == false){
        scAjaxProcOff();
    }*/
}

$(document).ready(function(){
});

function scJQSelect2Add(seqRow, specificField) {
} // scJQSelect2Add


function scJQElementsAdd(iLine) {
  scJQEventsAdd(iLine);
  scEventControl_init(iLine);
  scJQCalendarAdd(iLine);
  scJQUploadAdd(iLine);
  scJQSelect2Add(iLine);
} // scJQElementsAdd

function scGetFileExtension(fileName)
{
    fileNameParts = fileName.split(".");

    if (1 === fileNameParts.length || (2 === fileNameParts.length && "" == fileNameParts[0])) {
        return "";
    }

    return fileNameParts.pop().toLowerCase();
}

function scFormatExtensionSizeErrorMsg(errorMsg)
{
    var msgInfo = errorMsg.split("||"), returnMsg = "";

    if ("err_size" == msgInfo[0]) {
        returnMsg = "<?php echo $this->Ini->Nm_lang['lang_errm_file_size'] ?>. <?php echo $this->Ini->Nm_lang['lang_errm_file_size_extension'] ?>".replace("{SC_EXTENSION}", msgInfo[1]).replace("{SC_LIMIT}", msgInfo[2]);
    } else if ("err_extension" == msgInfo[0]) {
        returnMsg = "<?php echo $this->Ini->Nm_lang['lang_errm_file_invl'] ?>";
    }

    return returnMsg;
}

