<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('input_lenguaje'))
{
    function input_lenguaje($tipo, $lenguajes, $datas_lang, $campo, $titulo, $placeholder='', $required = false, $max=0, $class=''){ 
		$req = ($required)? 'required="required"' : ''; 
		$req_label = ($required)? '<span class="required">*</span>' : '';
		if(!empty($max)){
			$placeholder .= ' (Máximo '.$max.' caracteres)';
		}
		foreach($lenguajes as $lenguaje):
		?>
		<div class="row lang_<?=$lenguaje->codlang?>"  <?=$tipo=='hidden'?'hidden':''?>>
		  	<label class="col-sm-2 col-form-label" for="<?=$campo?>_<?=$lenguaje->codlang?>"><?=$titulo?> <code><?=$lenguaje->nombre?></code> <img src="img/flag_<?=$lenguaje->codlang?>.png" width="16" height="16"/>  <?=$req_label?></label>
		  	<div class="col-sm-10">
				<div class="form-group">
					<?if($tipo=='text' || $tipo=='hidden'):
						$maxlength= (empty($max))? 255 : $max ;?>  
						<input type="<?=$tipo?>" id="<?=$campo?>_<?=$lenguaje->codlang?>" <?=$req?> class="form-control" name="<?=$campo?>_<?=$lenguaje->codlang?>" maxlength="<?=$maxlength?>" value="<?=(!empty($datas_lang[$lenguaje->codlang]) && !empty($datas_lang[$lenguaje->codlang][$campo]) )?$datas_lang[$lenguaje->codlang][$campo]:''?>"  />
					<?else:
						$maxlength= (empty($max))? '' : 'maxlength="'.$max.'"' ;
						$rows = ($max>299)? 'rows="'.ceil($max/180).'"' : 'rows="7"' ; ?>
						<textarea <?=$rows?> id="<?=$campo?>_<?=$lenguaje->codlang?>"  <?=$req?> class="form-control <?=$class?>" name="<?=$campo?>_<?=$lenguaje->codlang?>" <?=$maxlength?> placeholder="<?=$placeholder?>" ><?=(!empty($datas_lang[$lenguaje->codlang]) && !empty($datas_lang[$lenguaje->codlang][$campo]) )?$datas_lang[$lenguaje->codlang][$campo]:''?></textarea>
					<?endif;?>
					<span class="bmd-help"><?=$placeholder?></span>
				</div>
		  	</div>
		</div>
	  <?endforeach;
    }   
}


if ( ! function_exists('input_text'))
{
    function input_text($tipo, $data, $campo, $titulo, $placeholder='', $required = false, $max=0){ 
		$req = ($required)? 'required="required"' : ''; 
		$req_label = ($required)? '<span class="required">*</span>' : ''; 
		if(!empty($max)){
			$placeholder .= ' (Máximo '.$max.' caracteres)';
		}		
		?>
		<div class="row">
			<label class="col-sm-2 col-form-label" for="<?=$campo?>"><?=$titulo?> <?=$req_label?></label>
			<div class="col-sm-10">
					<div class="form-group">
						<?if($tipo=='text' || $tipo=='email' || $tipo=='password'|| $tipo=='url' || $tipo=='number'):
							$maxlength= (empty($max))? 255 : $max ;	?>  
							<input type="<?=$tipo?>" id="<?=$campo?>" <?=$req?> class="form-control" name="<?=$campo?>" maxlength="<?=$maxlength?>" value="<?=(!empty($data) && !empty($data[$campo]) )?$data[$campo]:''?>" />							
						<?elseif($tipo=='date'):?>  
							<input type="<?=$tipo?>" id="<?=$campo?>" <?=$req?> class="form-control" name="<?=$campo?>" value="<?=(!empty($data) && !empty($data[$campo]) )?$data[$campo]:''?>" />
						<?elseif($tipo=='datetimepicker'):?>  
							<input type="text" id="<?=$campo?>" <?=$req?> class="form-control datetimepicker" name="<?=$campo?>" value="<?=(!empty($data) && !empty($data[$campo]) )?$data[$campo]:''?>" />
						<?else:
							$maxlength= (empty($max))? '' : 'maxlength="'.$max.'"' ;?>
							<textarea id="<?=$campo?>" <?=$req?> class="form-control" name="<?=$campo?>" <?=$maxlength?> ><?=(!empty($data) && !empty($data[$campo]) )?$data[$campo]:''?></textarea>
						<?endif;?>
						<span class="bmd-help"><?=$placeholder?></span>
					</div>
			</div>
		</div>
	  <?
	}
}


if ( ! function_exists('input_number'))
{
    function input_number($data, $campo, $titulo, $placeholder='', $required = false){ 
		$req = ($required)? 'required="required"' : ''; 
		$req_label = ($required)? '<span class="required">*</span>' : ''; 
		?>
		<div class="row">
			<label class="col-sm-2 col-form-label" for="<?=$campo?>"><?=$titulo?> <?=$req_label?></label>
			<div class="col-sm-10">
				<div class="form-group">
					<input type="number" id="<?=$campo?>" <?=$req?> class="form-control" name="<?=$campo?>" value="<?=(!empty($data))?$data[$campo]:''?>" />
					<span class="bmd-help"><?=$placeholder?></span>
				</div>
			</div>
		</div>
	  <?

    }   
}


if ( ! function_exists('input_check'))
{
    function input_check($data, $campo, $titulo, $default = false){ 
		$checked = $default ? 'checked="checked"':'';
		if(!empty($data)){
			$checked = empty($data[$campo]) ? '' : 'checked="checked"';			
		}
		?>
		<div class="row">
			<label class="col-sm-2 col-form-label" for="<?=$campo?>"><?=$titulo?> </label>
			<div class="col-sm-10">									
				<div class="togglebutton" style="margin-top: 10px;">
					<label>
						<input type="checkbox" name="<?=$campo?>" <?=$checked?>  > 
						<span class="toggle"></span>
					</label>
				</div>
			</div>
		</div>
	  <?

    }   
}


if ( ! function_exists('input_select'))
{
    function input_select($data, $opciones, $campo, $titulo, $required = false){ 
		$req = ($required)? 'required="required"' : ''; 
		$req_label = ($required)? '<span class="required">*</span>' : ''; 
		?>
		<div class="row">
			<label class="col-sm-2 col-form-label" for="<?=$campo?>"><?=$titulo?> <?=$req_label?></label>
			<div class="col-sm-10">
				<div class="form-group">
					<select class="selectpicker form-control alcien" name="<?=$campo?>" id="<?=$campo?>" <?=$req?> data-style="select-with-transition" title="Seleccione..." data-size="5">
						<? foreach($opciones as $opcion):?>
							<option value="<?=$opcion['id']?>" <?=(!empty($data) && $data[$campo]==$opcion['id'])?'SELECTED':''?> ><?=$opcion['nombre']?></option>
						<? endforeach;?>
					</select>
				</div>
			</div>
		</div>
	  <?
    }   
}


if ( ! function_exists('input_imagen'))
{
    function input_imagen($data, $campo, $titulo, $carpeta, $required = false, $prefijo = '400_', $eliminar=false){ 
		$req = ($required)? 'required="required"' : ''; 
		$req_label = ($required)? '<span class="required">*</span>' : ''; 
		?>
		<div class="row">
			<label class="col-sm-2 col-form-label" for="<?=$campo?>"><?=$titulo?> <?=$req_label?></label>
			<div class="col-sm-10">
				<br>
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" >
						<img src="<?=(empty($data) || empty($data[$campo]))? 'material/assets/img/image_placeholder.jpg': 'uploads/'.$carpeta.'/'.$prefijo.$data[$campo]?>"  alt="...">
					</div>
					<div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
					<div>
						<span class="btn btn-outline-secondary btn-file">
							<span class="fileinput-new">Seleccionar imagen</span>
							<span class="fileinput-exists">Cambiar</span>
							<input type="file" name="<?=$campo?>">
						</span>
						<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remover</a>
						<?if($eliminar && !empty($data) && !empty($data[$campo])):?>
						<label style="color:red"><input type="checkbox" name="<?=$campo?>_delete" value="valor"> Eliminar imagen cargada</label>
						<?endif?>
					</div>
				</div>
			</div>
		</div>
	  <?

    }   
}


if ( ! function_exists('input_lenguaje_imagen'))
{
    function input_lenguaje_imagen($lenguajes, $datas_lang, $campo, $titulo, $carpeta, $eliminar=false){ 
		foreach($lenguajes as $lenguaje):
		?>
		<div class="row lang_<?=$lenguaje->codlang?>">
			<label class="col-sm-2 col-form-label" for="<?=$campo?>_<?=$lenguaje->codlang?>"><?=$titulo?> <code><?=$lenguaje->nombre?></code> <img src="img/flag_<?=$lenguaje->codlang?>.png" width="16" height="16"/></label>
			<div class="col-sm-10">
				<br>
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" >
						<img src="<?=(empty($datas_lang[$lenguaje->codlang]) || empty($datas_lang[$lenguaje->codlang][$campo]))? 'material/assets/img/image_placeholder.jpg': 'uploads/'.$carpeta.'/'.$datas_lang[$lenguaje->codlang][$campo]?>"  alt="...">
					</div>
					<div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
					<div>
						<span class="btn btn-outline-secondary btn-file">
							<span class="fileinput-new">Seleccionar imagen</span>
							<span class="fileinput-exists">Cambiar</span>
							<input type="file" name="<?=$campo?>_<?=$lenguaje->codlang?>">
						</span>
						<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remover</a>
						<?if($eliminar && !empty($datas_lang[$lenguaje->codlang]) && !empty($datas_lang[$lenguaje->codlang][$campo]) ):?>
						<label style="color:red"><input type="checkbox" name="<?=$campo?>_<?=$lenguaje->codlang?>_delete" value="valor"> Eliminar imagen cargada</label>
						<?endif?>
					</div>
				</div>
			</div>
		</div>
	  <?endforeach;

    }   
}

if ( ! function_exists('modal_input_lenguaje'))
{
    function modal_input_lenguaje($tipo, $lenguajes, $campo, $form, $titulo, $placeholder='', $max=0){ 		
		if(!empty($max)){
			$placeholder .= ' (Máximo '.$max.' caracteres)';
		}
		foreach($lenguajes as $lenguaje):
		?>
		<div class="form-group bmd-form-group lang_<?=$lenguaje->codlang?>">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text"><img src="img/flag_<?=$lenguaje->codlang?>.png" width="24" height="24"/></div>
				</div>
				<div class="form-group" style="flex: 1 1 auto;">
					<?if($tipo=='text'):
						$maxlength= (empty($max))? 255 : $max ;?>  
						<input type="text" id="<?=$form?>_<?=$campo?>_<?=$lenguaje->codlang?>" placeholder="<?=$titulo?>" class="form-control" name="<?=$campo?>_<?=$lenguaje->codlang?>" maxlength="<?=$maxlength?>"  />
					<?else:
						$maxlength= (empty($max))? '' : 'maxlength="'.$max.'"' ;
						$rows = ($max>299)? 'rows="'.ceil($max/180).'"' : '' ; ?>
						<textarea <?=$rows?> id="<?=$form?>_<?=$campo?>_<?=$lenguaje->codlang?>" placeholder="<?=$titulo?>" class="form-control" name="<?=$campo?>_<?=$lenguaje->codlang?>" <?=$maxlength?> ></textarea>
					<?endif;?>
					<span class="bmd-help"><?=$placeholder?></span>
				</div>
			</div>		  
		</div>
	  <?endforeach;
    }   
}


if ( ! function_exists('modal_input_text'))
{
    function modal_input_text($tipo, $campo, $form, $icono, $titulo, $placeholder='', $max=0){  
		if(!empty($max)){
			$placeholder .= ' (Máximo '.$max.' caracteres)';
		}		
		?>
		<div class="form-group bmd-form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text"><i class="material-icons"><?=$icono?></i></div>
				</div>
				<div class="form-group" style="flex: 1 1 auto;">			
					<?if($tipo=='text' || $tipo=='email' || $tipo=='password'|| $tipo=='url'|| $tipo=='number'):
						$maxlength= (empty($max))? 255 : $max ;	?>  
						<input type="<?=$tipo?>" id="<?=$form?>_<?=$campo?>" placeholder="<?=$titulo?>" class="form-control" name="<?=$campo?>" maxlength="<?=$maxlength?>" />							
					<?elseif($tipo=='date'):?>  
						<input type="<?=$tipo?>" id="<?=$form?>_<?=$campo?>" placeholder="<?=$titulo?>" class="form-control" name="<?=$campo?>" />
					<?else:
						$maxlength= (empty($max))? '' : 'maxlength="'.$max.'"' ;?>
						<textarea id="<?=$form?>_<?=$campo?>" placeholder="<?=$titulo?>" class="form-control" name="<?=$campo?>" <?=$maxlength?> ></textarea>
					<?endif;?>
					<span class="bmd-help"><?=$placeholder?></span>
				</div>
			</div>
		</div>
	  <?
	}
}

if ( ! function_exists('modal_input_select'))
{
    function modal_input_select($opciones, $campo, $form, $icono, $titulo){ 		
		?>
		<div class="form-group bmd-form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text"><i class="material-icons"><?=$icono?></i></div>
				</div>
				<select class="selectpicker selectCopado" id="<?=$form?>_<?=$campo?>" name="<?=$campo?>" data-style="select-with-transition" title="<?=$titulo?>" data-size="7">
					<? foreach($opciones as $opcion):?>
						<option value="<?=$opcion['id']?>" ><?=$opcion['nombre']?></option>
					<? endforeach;?>
				</select>
			</div>
		</div>		
	  <?
    }   
}


?>
