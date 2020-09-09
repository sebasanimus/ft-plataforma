	<script>
	var summetToolbar = [	
		['style', ['bold', 'italic', 'underline', 'clear']],			
		['fontsize', ['fontsize']],
		['para', ['ul']],
		['font', ['clear']]
			];
	function registerSummernote(element, placeholder, max, callbackMax) {
		calbacks = {
			onPaste: function (e) {
				var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
				e.preventDefault();
				document.execCommand('insertText', false, bufferText);
			}
		};
		if(max>0){
			calbacks = {
				onKeydown: function(e) {
					var t = e.currentTarget.innerText;
					if (t.trim().length >= max) {
					//delete key
					if (e.keyCode != 8)
						e.preventDefault();
					// add other keys ...
					}
				},
				onKeyup: function(e) {
					var t = e.currentTarget.innerText;
					if (typeof callbackMax == 'function') {
						callbackMax(max - t.trim().length);
					}
				},
				onPaste: function(e) {
					var t = e.currentTarget.innerText;
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					var all = t + bufferText;
					document.execCommand('insertText', false, all.trim().substring(0, 400));
					if (typeof callbackMax == 'function') {
						callbackMax(max - t.length);
					}
				}
			}
		} 
		$(element).summernote({
			toolbar: summetToolbar,
			placeholder,
			callbacks: calbacks
		});
	}

	$(document).ready(function(){	

		$("textarea").each(function() {
			console.log($(this).attr('maxlength'));
			let maximo = ($(this).attr('maxlength') != undefined)?  $(this).attr('maxlength') : 0;
			registerSummernote('#'+$(this).attr('id'), $(this).attr('placeholder'), maximo, function(max) {
				console.log(max);
			});
			
		});
    });

	</script>