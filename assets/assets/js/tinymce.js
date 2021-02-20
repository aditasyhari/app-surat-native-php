tinymce.init({
  selector: '#tinymceExample',
  plugins: 'lineheight style fullpage print preview powerpaste casechange searchreplace autosave save directionality advcode visualblocks visualchars fullscreen table charmap hr nonbreaking toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter permanentpen charmap mentions',
  height: 265,
  theme: 'silver',
  convert_fonts_to_spans : false,
  toolbar:
    'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify lineheight | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | charmap | fullscreen  preview save print | a11ycheck',
  lineheight_formats: '1 1.1 1.2 1.3 1.4 1.5 2',
  font_formats:
    "Arial=arial,helvetica,sans-serif;Sans Serif=sans-serif;Courier New=courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings"

});

function check(mode) { 
  
  if (mode) {
    tinymce.get('tinymceExample').mode.set("design");
  } else {
    tinymce.get('tinymceExample').getBody().innerHTML = null;
    tinymce.get('tinymceExample').mode.set("readonly");
  }
  
}

tinymce.init({
  selector: '#kontenTemplate',
  plugins: 'lineheight style fullpage print preview powerpaste casechange searchreplace autosave save directionality advcode visualblocks visualchars fullscreen table charmap hr nonbreaking toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter permanentpen charmap mentions',
  height: 500,
  theme: 'silver',
  convert_fonts_to_spans : false,  
  toolbar:
    'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify lineheight | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | charmap | fullscreen  preview save print | a11ycheck',
  lineheight_formats: '1 1.1 1.2 1.3 1.4 1.5 2',
  font_formats:
    "Arial=arial,helvetica,sans-serif;Sans Serif=sans-serif;Courier New=courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings"
  
});