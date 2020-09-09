<script>
var icos = ['abeja', 'agricultor', 'agtech-app', 'agtech-dron', 'aguacate', 'agua-plantas', 'agua', 'algodon', 'aumento-porcentaje', 'banana', 'brote', 'cafe', 'calidad', 'cebollas', 'ciclo-agua', 'citrico', 'clima-calor', 'co2', 'comunicacion', 'comunidad', 'cuidado-agua', 'cuidado-comunidad', 'cursos', 'decremento', 'diploma', 'energiaslimpias', 'espantapajaros', 'frutafina', 'frutas', 'frutasyverduras', 'gallina', 'ganaderia', 'girasol', 'gotas', 'granero', 'granjas', 'granjero', 'hongos', 'ideas', 'incremento', 'inundaciones', 'lacteos', 'maiz', 'manuales', 'medioambiente', 'miel', 'noticias', 'ovejas', 'ozono', 'papa', 'pina', 'plaga', 'porcino', 'proceso-continuo', 'produccion-vegetales', 'publicaciones', 'red-comunitaria', 'rendimiento-frutas', 'rendimiento', 'residuos', 'riego', 'roedores', 'semillas', 'silo', 'solidaridad', 'trabajando-sobre-planta', 'tractor', 'training', 'uvas', 'websites', 'zanahoria'];
$(document).ready(function(){
	$(".picker").each(function(){
		div=$(this);
		if (icos){
			var iconos="<ul>";
			for (var i=0; i<icos.length; i++) { iconos+="<li><img width='30' height='30' data-valor='"+icos[i]+"' rel='"+icos[i]+"' src='img/iconos/"+icos[i]+".svg'/></li>"; }
			iconos+="</ul>";
		}
		//console.log(icos.length);
		div.append("<div class='oculto'><input type='text' placeholder='Encuentra tu icono...'>"+iconos+"</div>");
		$(".inputpicker").click(function(){
			$(".oculto").fadeToggle("fast");
		});
		$(document).on("click",".oculto ul li",function(){
			$(".inputpicker").val($(this).find("img").data("valor"));
			$(".oculto").fadeToggle("fast");
		});
		$(document).on("keyup",".oculto input[type=text]",function(){
			var value=$(this).val();
			$(".oculto ul li img").each(function(){
				if ($(this).attr("rel").search(value) > -1) $(this).closest("li").show();
				else $(this).closest("li").hide();
			});
		});
	});
});
  

</script>