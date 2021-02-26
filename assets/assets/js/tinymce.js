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
    "Arial=arial,helvetica,sans-serif;Sans Serif=sans-serif;Courier New=courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings",
});


tinymce.init({
  selector: '#entriKonten',
  // readonly: 1,
  plugins: 'lineheight style fullpage print preview powerpaste casechange searchreplace autosave save directionality advcode visualblocks visualchars fullscreen table charmap hr nonbreaking toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter permanentpen charmap mentions',
  height: 500,
  theme: 'silver',
  convert_fonts_to_spans : false,  
  toolbar:
    'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify lineheight | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | charmap | fullscreen  preview save print | a11ycheck',
  lineheight_formats: '1 1.1 1.2 1.3 1.4 1.5 2',
  font_formats:
    "Arial=arial,helvetica,sans-serif;Sans Serif=sans-serif;Courier New=courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings",
});


function editKonten(mode) {
  console.log(mode);
  var variabel_input = document.getElementById('variabel_input');
  var layout_konten = document.getElementById('layout_konten');

  if(mode) {
      variabel_input.innerHTML = `
      <div class="col-12">
          <li class="list-group-item">
              <p class="card-description">Klik tombol dibawah ini untuk menyisipkan variabel kedalam surat.</p>
              <div class="row mt-2">
                  <div class="btn btn-light m-2" id="nama" onclick="variabel('nama')">Nama</div>
                  <div class="btn btn-light m-2" id="email" onclick="variabel('email')">Email</div>
                  <div class="btn btn-light m-2" id="perihal" onclick="variabel('perihal')">Perihal</div>
                  <div class="btn btn-light m-2" id="nosurat" onclick="variabel('nosurat')">No Surat</div>
                  <div class="btn btn-light m-2" id="tglsurat" onclick="variabel('tglsurat')">Tgl Surat</div>
                  <div class="btn btn-light m-2" id="tujuan" onclick="variabel('tujuan')">Tujuan</div>
                  <div class="btn btn-light m-2" id="karakteristik" onclick="variabel('karakteristik')">Karakteristik</div>
                  <div class="btn btn-light m-2" id="derajat" onclick="variabel('derajat')">Derajat</div>
              </div>
          </li>
      </div>
      `;

      tinymce.get('entriKonten').mode.set("design");
      layout_konten.classList.remove('d-none');
      
    }else {
      variabel_input.innerHTML = ``;
      layout_konten.classList.add('d-none');
      // tinymce.get('entriKonten').getBody().innerHTML = <?php echo $tp_konten; ?>;
      tinymce.get('entriKonten').mode.set("readonly");
  }
}
