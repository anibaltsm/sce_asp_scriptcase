#!/bin/bash
# Parche para mover la lógica de bloqueo de onLoad a onLoadRecord
# Ejecutar: bash patch_onloadrecord.sh
# Requiere: archivo en /Applications/XAMPP/xamppfiles/htdocs/sce_asp/form_recomendantes/

APL="/Applications/XAMPP/xamppfiles/htdocs/sce_asp/form_recomendantes/form_recomendantes_apl.php"
BACKUP="${APL}.bak.$(date +%Y%m%d_%H%M%S)"

if [ ! -f "$APL" ]; then
    echo "Error: No se encuentra $APL"
    exit 1
fi

cp "$APL" "$BACKUP"
echo "Backup creado: $BACKUP"

# Usar perl para el reemplazo multílínea
perl -i -0pe 's/function nm_proc_onload_record\(\$sc_seq_vert=0\)\s*\{\s*\}\s*function nm_proc_onload/function nm_proc_onload_record(\$sc_seq_vert=0)\n  \{\n      if (\$this->cc_edit_ !== null \&\& \$this->cc_edit_ !== '"'"''"'"' \&\& \$this->cc_edit_ == 0) {\n          \$this->sc_field_readonly("nombre_", '"'"'on'"'"', \$sc_seq_vert);\n          \$_SESSION['"'"'sc_session'"'"'][\$this->Ini->sc_page]['"'"'form_recomendantes'"'"']['"'"'Field_disabled_macro'"'"']['"'"'nombre_'"'"'] = array('"'"'I'"'"'=>array(),'"'"'U'"'"'=>array());\n          \$this->sc_field_readonly("apellido_p_", '"'"'on'"'"', \$sc_seq_vert);\n          \$_SESSION['"'"'sc_session'"'"'][\$this->Ini->sc_page]['"'"'form_recomendantes'"'"']['"'"'Field_disabled_macro'"'"']['"'"'apellido_p_'"'"'] = array('"'"'I'"'"'=>array(),'"'"'U'"'"'=>array());\n          \$this->sc_field_readonly("apellido_m_", '"'"'on'"'"', \$sc_seq_vert);\n          \$_SESSION['"'"'sc_session'"'"'][\$this->Ini->sc_page]['"'"'form_recomendantes'"'"']['"'"'Field_disabled_macro'"'"']['"'"'apellido_m_'"'"'] = array('"'"'I'"'"'=>array(),'"'"'U'"'"'=>array());\n          \$this->sc_field_readonly("correo_", '"'"'on'"'"', \$sc_seq_vert);\n          \$_SESSION['"'"'sc_session'"'"'][\$this->Ini->sc_page]['"'"'form_recomendantes'"'"']['"'"'Field_disabled_macro'"'"']['"'"'correo_'"'"'] = array('"'"'I'"'"'=>array(),'"'"'U'"'"'=>array());\n      }\n  }\n  function nm_proc_onload/s' "$APL" 2>/dev/null || echo "Intento 1 falló"

# Quitar el bloque if cc_edit de nm_proc_onload
perl -i -0pe 's/if \(\$this->cc_edit_\s+!== null && \$this->cc_edit_\s+!== '"'"''"'"' && \$this->cc_edit_\s+== 0\) \{\s*\n\s+\$this->sc_field_readonly\("nombre_", '"'"'on'"'"', \([^)]+\)\);.*?\}\n(?:if \(\$this->NM_ajax_flag\))/if (\$this->NM_ajax_flag)/s' "$APL" 2>/dev/null || echo "Intento 2 (quitar bloque onload) - revisar manualmente"

echo "Parche aplicado. Revisar el archivo y probar la aplicación."
