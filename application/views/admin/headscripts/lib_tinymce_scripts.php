
    <script src="tinymce/tinymce.min.js"></script>
    <script>
    
    $(document).ready(function(){
        tinymce.init({
			selector: '.tinymce',
			height: 350,
			relative_urls : false,
					remove_script_host : true,
					document_base_url : '<?=base_url()?>',
					fontsize_formats: '6pt 8pt 10pt 12pt 14pt 18pt 20pt 24pt 28pt 32pt 36pt 42pt',
					extended_valid_elements: 'script[language|type|src]',
					valid_elements : '*[*]',
					allow_script_urls: true,
					menubar: false,
					plugins: [
					'advlist autolink lists link charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime media table contextmenu paste code table textcolor colorpicker filemanager image table media'
					],
					toolbar: 'undo redo | insert | styleselect | forecolor backcolor bold italic underline strikethrough superscript | fontselect fontsizeselect removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table code',
					content_css: [
					'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
					'//www.tinymce.com/css/codepen.min.css']
        });
    });      
	  
    </script>