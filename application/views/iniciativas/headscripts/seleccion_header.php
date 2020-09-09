
<style>
.contpaso{
	/*display:none;*/
}

.temas .form-check .form-check-label {
	padding-left: 25px;
}

.form-check-seleccionado{
	font-weight: bold;
    color: #83c559;;
}

.pasoCompletitud{
	clear: both;
	width: 2%;
	position: absolute;
    z-index: 0;
    top: 0;
    left: 0;
    height: 100%;
	display: block;
	/*height: 1px;*/
	border-radius: 3px;
	background: #350155;
	transition: width .6s ease;
}

.selectCopado{
	position: relative;
	flex: 1 1 auto;
	width: 220px !important;
	margin-bottom: 0;
}

.hidden{
	display: none;
}

.bootstrap-tagsinput{
	width:100%;
	background-image: linear-gradient(0deg, #66cdcc 2px, rgba(131, 197, 89, 0) 0), linear-gradient(0deg, #d2d2d2 1px, hsla(0, 0%, 82%, 0) 0);
}

.form-control:invalid{
	background-size: 100% 100%, 100% 100%;
}

.columns{
	width:100%;
}

.close-card{
	float:right;
	margin-top: 10px;
}


#adjuntoArea1, #adjuntoArea2{
	width: 80%;
	height: 300px;
	text-align: center;
	border-width: 2px;
	border-color: #BBBBBB;
	border-style: dashed;
	clear: both;
	display: block;
	margin: 10px 10%;
	border-radius: 20px;
}
#adjuntoArea1.highlight, #adjuntoArea2.highlight{
	background-color: rgba(0,0,255,0.2);
}
#adjuntoArea1 .adentro, #adjuntoArea2 .adentro {
	display: block;
	font-size: 25px;
	line-height: 300px;
}
</style>