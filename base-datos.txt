CREATE TABLE tipousuario(
	idtipousuario INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	tipo VARCHAR(100) NOT NULL
);
INSERT INTO `tipousuario` (`idtipousuario`, `tipo`) VALUES (1, 'Administrador');
CREATE TABLE usuario(
	idusuario INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	password VARCHAR(255) NOT NULL, 
	lastlogin DATETIME, 
	habilitado BOOL NOT NULL DEFAULT 1,
	created timestamp NOT NULL default CURRENT_TIMESTAMP,
    	createdby INTEGER NOT NULL,
	idtipousuario INTEGER NOT NULL DEFAULT 1,
	avatar VARCHAR(100) NOT NULL DEFAULT '01',
	email VARCHAR(100) NOT NULL,
	institucion VARCHAR(100) NULL,
	posicion VARCHAR(100) NULL,
	foto VARCHAR(100) NULL,
	nombre VARCHAR(100) NULL,
	codlang char(2) NOT NULL DEFAULT 'es',
	tabid VARCHAR(25) NULL,
	tabidupdated TIMESTAMP NULL,
	tabid_ista VARCHAR(25) NULL,
	tabidupdated_ista TIMESTAMP NULL,
	pass_token VARCHAR(64) NULL,
	pass_token_updated DATETIME NULL ,
	somosnosotros BOOLEAN NOT NULL DEFAULT 0,
	alerta_mail BOOLEAN NOT NULL DEFAULT 1,
	alerta_nuevo_organismo BOOLEAN DEFAULT 0,
	alerta_contenidos BOOLEAN DEFAULT 0
);
ALTER TABLE usuario ADD INDEX(alerta_mail);
ALTER TABLE usuario ADD INDEX(alerta_nuevo_organismo);
ALTER TABLE usuario ADD INDEX(somosnosotros);

INSERT INTO `usuario` (`idusuario`, `password`, `lastlogin`, `habilitado`, `created`, `createdby`, `idtipousuario`, `avatar`, `email`, `institucion`, `posicion`, `foto`, `nombre`, `codlang`, `tabid`, `tabidupdated`, `tabid_ista`, `tabidupdated_ista`, `pass_token`, `pass_token_updated`, `somosnosotros`, `alerta_mail`, `alerta_nuevo_organismo`, `alerta_contenidos`) VALUES
(NULL, '$2y$10$POM43jGnc2jzPm2uSeiV7u0JiJeyBEVL7XeGLdU3S2jHjpINUFNCW', NULL, 1, '2020-09-07 11:47:25', 1, 1, '01', 'admin@admin.com', 'Test', 'Test', NULL, 'Admin', 'es', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0);



CREATE OR REPLACE VIEW v_usuario AS 
SELECT u.idusuario, email, habilitado, tipo, tu.idtipousuario, u.avatar, u.nombre, u.foto, u.institucion, u.posicion, u.codlang, alerta_mail, alerta_nuevo_organismo, alerta_contenidos, vup.propuestas 
FROM usuario u 
JOIN tipousuario tu ON u.idtipousuario = tu.idtipousuario
LEFT JOIN v_usuario_propuesta vup ON vup.idusuario=u.idusuario;

CREATE OR REPLACE VIEW v_usuario_propuesta AS
SELECT idusuario, GROUP_CONCAT(identificador, ' - ', titulo_simple SEPARATOR ' / ') as propuestas
FROM Propuesta_usuario pu  
JOIN v_Propuesta p ON p.idpropuesta=pu.idpropuesta 
GROUP BY idusuario;

ALTER TABLE usuario ADD FOREIGN KEY (idtipousuario) REFERENCES tipousuario(idtipousuario);

CREATE TABLE Propuesta(
	idpropuesta INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	identificador VARCHAR(50) NOT NULL,
	anio INTEGER NOT NULL,
	estado INTEGER NOT NULL DEFAULT 0,
	operacion INTEGER NOT NULL DEFAULT 0,
	linea_estrategica INTEGER NOT NULL DEFAULT 0,
	tipo_investigacion INTEGER NOT NULL DEFAULT 0,
	tipo_innovacion INTEGER NOT NULL DEFAULT 0,
	solucion_tecnologica INTEGER NOT NULL,
	aporte_fontagro DECIMAL(14,4) NOT NULL DEFAULT 0, 
	aporte_bid DECIMAL(14,4) NOT NULL DEFAULT 0,
	movilizacion_agencias DECIMAL(14,4) NOT NULL DEFAULT 0,
	aporte_contrapartida DECIMAL(14,4) NOT NULL DEFAULT 0,
	aporte_agencias DECIMAL(14,4) NOT NULL DEFAULT 0,
	total DECIMAL(14,4) NOT NULL DEFAULT 0,	
	deleted DATETIME DEFAULT NULL,	

	web_publicado BOOLEAN NOT NULL DEFAULT 0,
	web_foto VARCHAR(100) NULL,
	web_url VARCHAR(255) NULL,
	plazo INTEGER NULL,
	urlvieja VARCHAR(255) NULL,
	idperfil INTEGER NULL,
	UNIQUE(web_url),
	UNIQUE(identificador)	
); 

ALTER TABLE Propuesta ADD INDEX(anio);
ALTER TABLE Propuesta ADD INDEX(operacion);
ALTER TABLE Propuesta ADD INDEX(linea_estrategica);
ALTER TABLE Propuesta ADD INDEX(tipo_investigacion);
ALTER TABLE Propuesta ADD INDEX(tipo_innovacion);
ALTER TABLE Propuesta ADD INDEX(solucion_tecnologica);
ALTER TABLE Propuesta ADD INDEX(urlvieja);


CREATE TABLE Propuesta_lang(
	idpropuesta INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	titulo_completo VARCHAR(255) NOT NULL,
	titulo_simple VARCHAR(255) NOT NULL,
	area_investigacion VARCHAR(255) NOT NULL,
	rubro VARCHAR(255) NOT NULL,
	otras_agencias VARCHAR(255) NOT NULL,	
	plataforma VARCHAR(255) NOT NULL,
	web_impacto TEXT NULL,
	web_beneficiarios TEXT NULL,
	web_solucion TEXT NULL,
	web_resumen TEXT NULL,
	PRIMARY KEY(codlang, idpropuesta)
);

CREATE OR REPLACE VIEW v_Propuesta AS
SELECT p.*, 
pl.titulo_completo, 
pl.titulo_simple, 
al.nombre as area_investigacion, 
rl.nombre as rubro, 
sl.nombre as sector_productivo,
pl.otras_agencias, 
pl.web_impacto,
pl.web_beneficiarios,
pl.web_solucion,
pl.web_resumen,
el.nombre as elestado
FROM Propuesta p 
JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='es' 
LEFT JOIN Rubro_lang rl ON rl.id=p.idrubro AND rl.codlang='es'
LEFT JOIN Areainvestigacion_lang al ON al.id=p.idareainvestigacion AND al.codlang='es'
LEFT JOIN v_Sectores sl ON sl.idpropuesta=p.idpropuesta
LEFT JOIN Estado_lang el ON el.id=estado AND el.codlang='es'
WHERE p.deleted IS NULL;

ALTER TABLE `Propuesta_lang` ADD INDEX(`area_investigacion`);
ALTER TABLE `Propuesta_lang` ADD INDEX(`rubro`);

ALTER TABLE Propuesta_lang ADD FOREIGN KEY (idpropuesta) REFERENCES Propuesta(idpropuesta);

CREATE TABLE Item(
	iditem INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idpropuesta INTEGER NOT NULL,
	idorganismo INTEGER NULL,
	organismo VARCHAR(100) NOT NULL,
	participacion INTEGER NOT NULL DEFAULT 0,
	tipo_institucion INTEGER NOT NULL DEFAULT 0,
	region INTEGER NOT NULL DEFAULT 0,
	pais INTEGER NOT NULL DEFAULT 0,
	aporte_fontagro DECIMAL(14,4) NOT NULL DEFAULT 0, 
	aporte_bid DECIMAL(14,4) NOT NULL DEFAULT 0,
	movilizacion_agencias DECIMAL(14,4) NOT NULL DEFAULT 0,
	aporte_contrapartida DECIMAL(14,4) NOT NULL DEFAULT 0,
	aporte_agencias DECIMAL(14,4) NOT NULL DEFAULT 0,
	total DECIMAL(14,4) NOT NULL DEFAULT 0,
	deleted DATETIME DEFAULT NULL
);
ALTER TABLE Item ADD FOREIGN KEY (idorganismo) REFERENCES Organismo(idorganismo);

ALTER TABLE Item ADD INDEX(participacion);
ALTER TABLE Item ADD INDEX(tipo_institucion);
ALTER TABLE Item ADD INDEX(region);
ALTER TABLE Item ADD INDEX(pais);
ALTER TABLE Item ADD INDEX(organismo);

CREATE TABLE Pais(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	code CHAR(2) NOT NULL UNIQUE,
	latitud VARCHAR(20) NULL,
	longitud VARCHAR(20) NULL,
	esmiembro BOOLEAN NOT NULL DEFAULT FALSE,
	anio_desde INTEGER NULL,
	contribucion_fija DECIMAL(14,4) NULL
);

CREATE TABLE Pais_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Pais AS
SELECT p.code, p.latitud, p.longitud, p.esmiembro, p.anio_desde, p.contribucion_fija, pl.* FROM Pais p JOIN Pais_lang pl ON pl.id=p.id WHERE codlang='es';
ALTER TABLE Pais_lang ADD FOREIGN KEY (id) REFERENCES Pais(id); 




CREATE TABLE Estado(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Estado_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Estado AS
SELECT * FROM Estado_lang WHERE codlang='es';
ALTER TABLE Estado_lang ADD FOREIGN KEY (id) REFERENCES Estado(id);

CREATE TABLE Operacion(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Operacion_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Operacion AS
SELECT * FROM Operacion_lang WHERE codlang='es';
ALTER TABLE Operacion_lang ADD FOREIGN KEY (id) REFERENCES Operacion(id);

CREATE TABLE Estrategica(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Estrategica_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Estrategica AS
SELECT * FROM Estrategica_lang WHERE codlang='es';
ALTER TABLE Estrategica_lang ADD FOREIGN KEY (id) REFERENCES Estrategica(id);

CREATE TABLE Investigacion(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Investigacion_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Investigacion AS
SELECT * FROM Investigacion_lang WHERE codlang='es';
ALTER TABLE Investigacion_lang ADD FOREIGN KEY (id) REFERENCES Investigacion(id);


CREATE TABLE Innovacion(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Innovacion_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Innovacion AS
SELECT * FROM Innovacion_lang WHERE codlang='es';
ALTER TABLE Innovacion_lang ADD FOREIGN KEY (id) REFERENCES Innovacion(id);

CREATE TABLE Participacion(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Participacion_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Participacion AS
SELECT * FROM Participacion_lang WHERE codlang='es';
ALTER TABLE Participacion_lang ADD FOREIGN KEY (id) REFERENCES Participacion(id);

CREATE TABLE Institucion(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Institucion_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Institucion AS
SELECT * FROM Institucion_lang WHERE codlang='es';
ALTER TABLE Institucion_lang ADD FOREIGN KEY (id) REFERENCES Institucion(id);

CREATE TABLE Region(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Region_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Region AS
SELECT * FROM Region_lang WHERE codlang='es';
ALTER TABLE Region_lang ADD FOREIGN KEY (id) REFERENCES Region(id);

CREATE TABLE Solucion(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Solucion_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Solucion AS
SELECT * FROM Solucion_lang WHERE codlang='es'; 
ALTER TABLE Solucion_lang ADD FOREIGN KEY (id) REFERENCES Solucion(id);



CREATE TABLE Lenguaje (
  	idlenguaje int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  	codlang char(2) NOT NULL,
 	nombre varchar(100) DEFAULT NULL,
  	habilitado tinyint(1) NOT NULL DEFAULT '1',
  	UNIQUE(codlang)
);

CREATE OR REPLACE VIEW v_Item AS
SELECT 
i.iditem, idpropuesta, i.idorganismo, o.nombre organismo,
p.nombre as participacion,
ti.nombre as tipo_institucion,	
r.nombre as region,
aporte_fontagro, aporte_bid, movilizacion_agencias, aporte_contrapartida, aporte_agencias, total, 
pa.nombre as pais
FROM Item i 
JOIN v_Pais pa ON i.pais=pa.id 
JOIN v_Participacion p ON p.id=i.participacion
JOIN v_Institucion ti ON ti.id=i.tipo_institucion
JOIN v_Region r ON r.id=i.region
JOIN Organismo o ON i.idorganismo=o.idorganismo 
WHERE i.deleted IS NULL;

CREATE OR REPLACE VIEW v_ItemTotales AS
SELECT idpropuesta, 
SUM(aporte_fontagro) aporte_fontagro, 
SUM(aporte_bid) aporte_bid, 
SUM(movilizacion_agencias) movilizacion_agencias, 
SUM(aporte_contrapartida) aporte_contrapartida, 
SUM(aporte_agencias) aporte_agencias, 
SUM(total) total
FROM Item i WHERE i.deleted IS NULL GROUP BY idpropuesta; 

CREATE OR REPLACE VIEW v_PropuestaEjecutor AS
SELECT p.identificador, p.anio, p.tipo_investigacion, p.operacion, p.linea_estrategica, p.tipo_innovacion, p.solucion_tecnologica, p.estado, p.web_url, p.web_publicado, p.urlvieja,
p.aporte_fontagro p_aporte_fontagro,
p.aporte_bid p_aporte_bid, 
p.movilizacion_agencias p_movilizacion_agencias, 
p.aporte_contrapartida p_aporte_contrapartida, 
p.aporte_agencias p_aporte_agencias, 
p.total p_total,
i.iditem,
p.idpropuesta,
o.nombre as organismo,
i.idorganismo,
i.participacion,
i.tipo_institucion,	
i.region,
i.pais,
i.aporte_fontagro, 
i.aporte_bid,
i.movilizacion_agencias,
i.aporte_contrapartida,
i.aporte_agencias,
i.total,
i.deleted 
FROM Propuesta p 
LEFT JOIN Item i ON p.idpropuesta=i.idpropuesta 
LEFT JOIN Organismo o ON i.idorganismo=o.idorganismo
WHERE (i.participacion=3 OR i.idpropuesta IS NULL) AND p.deleted is NULL AND i.deleted IS NULL; 


CREATE OR REPLACE VIEW v_PropuestaParticipacion AS
SELECT p.anio, p.tipo_investigacion, p.operacion, p.linea_estrategica, p.tipo_innovacion, p.solucion_tecnologica, 
i.iditem, i.idpropuesta, i.idorganismo, i.participacion, i.tipo_institucion, i.region, i.pais, i.aporte_fontagro, i.aporte_bid, i.movilizacion_agencias, i.aporte_contrapartida, i.aporte_agencias, i.total, i.deleted, o.nombre as organismo
FROM Propuesta p 
JOIN Item i ON p.idpropuesta=i.idpropuesta 
JOIN Organismo o ON i.idorganismo=o.idorganismo
WHERE p.deleted IS NULL AND i.deleted IS NULL; 



CREATE TABLE Tecnica(
	idtecnica INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idpropuesta INTEGER NOT NULL,
	componente INTEGER NOT NULL DEFAULT 0,
	indicastandar INTEGER NOT NULL DEFAULT 0,
	paisindicador INTEGER NOT NULL DEFAULT 0,
	localidad VARCHAR(100) NOT NULL,
	anio_ind VARCHAR(20) NOT NULL,
	antes VARCHAR(20) NOT NULL,
	despues VARCHAR(20) NOT NULL,
	despues_san VARCHAR(20) NULL,
	unidad INTEGER NOT NULL DEFAULT 0,	
	deleted DATETIME DEFAULT NULL
);
ALTER TABLE Tecnica ADD INDEX(componente);
ALTER TABLE Tecnica ADD INDEX(unidad);
ALTER TABLE Tecnica ADD INDEX(idpropuesta);
ALTER TABLE Tecnica ADD INDEX(indicastandar);



CREATE TABLE Tecnica_lang(
	idtecnica INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	indicador VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, idtecnica)
);
ALTER TABLE Tecnica_lang ADD INDEX(indicador);
ALTER TABLE Tecnica_lang ADD FOREIGN KEY (idtecnica) REFERENCES Tecnica(idtecnica); 

CREATE TABLE Indicastandar(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	componente INTEGER NULL,
);
ALTER TABLE Indicastandar ADD INDEX(componente);
CREATE TABLE Indicastandar_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);


CREATE TABLE Unidad(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	fun VARCHAR(25) NULL
);
CREATE TABLE Unidad_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Unidad AS
SELECT u.id, u.fun, ul.codlang, ul.nombre FROM Unidad u JOIN Unidad_lang ul ON ul.id=u.id WHERE codlang='es';
ALTER TABLE Unidad_lang ADD FOREIGN KEY (id) REFERENCES Unidad(id); 

CREATE TABLE Componente(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Componente_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Componente AS
SELECT * FROM Componente_lang WHERE codlang='es';
ALTER TABLE Componente_lang ADD FOREIGN KEY (id) REFERENCES Componente(id); 

CREATE OR REPLACE VIEW v_Indicastandar AS
SELECT i.id, c.id AS idcomponente, c.nombre AS componente, il.nombre, il.codlang
FROM Indicastandar i 
JOIN Indicastandar_lang il ON il.id=i.id AND il.codlang='es'
LEFT JOIN Componente_lang c ON i.componente=c.id AND c.codlang='es';
ALTER TABLE Indicastandar_lang ADD FOREIGN KEY (id) REFERENCES Indicastandar(id); 

CREATE OR REPLACE VIEW v_Tecnica AS
SELECT t.*, tl.indicador, p.nombre as pais_nombre, c.nombre as componente_nombre, i.nombre as indicador_nombre, u.nombre as unidad_nombre
FROM Tecnica t 
JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='es'
LEFT JOIN v_Pais p ON t.paisindicador=p.id
JOIN v_Componente c ON c.id=t.componente 
JOIN v_Indicastandar i ON i.id=t.indicastandar 
JOIN v_Unidad u ON u.id=t.unidad
WHERE t.deleted is null;

CREATE TABLE Fontagro( 
	idfontagro INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	tecnologias_generadas INTEGER NULL,
	tecnologias_nuevas INTEGER NULL,
	tecnologias_relevantes INTEGER NULL
	
);
CREATE TABLE Fontagro_lang(
	idfontagro INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	sobreTitulo VARCHAR(100) NOT NULL,
	sobre TEXT NOT NULL,
	gobernanzaTitulo VARCHAR(100) NOT NULL,
	gobernanza TEXT NOT NULL,
	misionTitulo VARCHAR(100) NOT NULL,
	mision TEXT NOT NULL,
	planTitulo VARCHAR(100) NOT NULL,
	plan TEXT NOT NULL,
	enCifrasTitulo VARCHAR(100) NOT NULL,
	participacionTitulo VARCHAR(100) NOT NULL,
	origenTitulo VARCHAR(100) NOT NULL,
	fortalecimiento VARCHAR(100) NOT NULL,
	paisesMiembro VARCHAR(100) NOT NULL,	
	anio VARCHAR(100) NOT NULL,
	institucionLider VARCHAR(100) NOT NULL,
	miembros VARCHAR(100) NOT NULL,
	tema VARCHAR(100) NOT NULL,
	monto VARCHAR(100) NOT NULL,
	proyectosAprobados VARCHAR(100),
	montoTotal VARCHAR(100),
	otrosInvercionistas VARCHAR(100),
	paisesBeneficiados VARCHAR(100),
	tecnologiasGeneradas VARCHAR(100),
	tecnologiasNuevas VARCHAR(100),
	tecnologiasRelevantes VARCHAR(100),
	miembro VARCHAR(100),
	lider VARCHAR(100),
	aporteContrapartida VARCHAR(100),
	BID VARCHAR(100),
	otrasAgencias VARCHAR(100),
	ejemplos VARCHAR(100),
	paises VARCHAR(100),
	contribucion VARCHAR(100),
	participacion VARCHAR(100),
	PRIMARY KEY (idfontagro, codlang)	
);
ALTER TABLE Fontagro_lang ADD FOREIGN KEY (idfontagro) REFERENCES Fontagro(idfontagro); 


CREATE TABLE Breve(
	idbreve INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idpais INTEGER NOT NULL UNIQUE
);

CREATE TABLE Breve_lang(
	idbreve INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	contenido TEXT NOT NULL,
	fortalecimiento TEXT NOT NULL,
	PRIMARY KEY (codlang, idbreve)
);
ALTER TABLE Breve_lang ADD FOREIGN KEY (idbreve) REFERENCES Breve(idbreve); 


CREATE OR REPLACE VIEW v_Breve AS
SELECT bl.*, b.idpais, p.nombre, p.code, p.esmiembro, p.anio_desde 
FROM Breve b 
JOIN Breve_lang bl ON b.idbreve=bl.idbreve AND bl.codlang='es'
JOIN v_Pais p ON p.id=b.idpais;



CREATE OR REPLACE VIEW v_Pais_lang AS
SELECT pl.* 
FROM Pais p JOIN Pais_lang pl ON p.id=pl.id
WHERE p.esmiembro=1; 
CREATE OR REPLACE VIEW v_PaisTodos_lang AS
SELECT pl.* 
FROM Pais p JOIN Pais_lang pl ON p.id=pl.id;
 
CREATE OR REPLACE VIEW v_OrganismosCoEjecutores AS
SELECT i.idpropuesta, GROUP_CONCAT(CONCAT(o.nombre,' (', pal.nombre,')') SEPARATOR ', ') nombre
FROM Item i
JOIN Organismo o ON i.idorganismo=o.idorganismo 
JOIN Pais_lang pal ON i.pais=pal.id AND pal.codlang = 'es'
WHERE i.participacion<>3 AND i.deleted IS NULL
GROUP BY i.idpropuesta;


ALTER TABLE Propuesta ADD FOREIGN KEY (estado) REFERENCES Estado(id);
ALTER TABLE Propuesta ADD FOREIGN KEY (operacion) REFERENCES Operacion(id);
ALTER TABLE Propuesta ADD FOREIGN KEY (linea_estrategica) REFERENCES Estrategica(id);
ALTER TABLE Propuesta ADD FOREIGN KEY (tipo_investigacion) REFERENCES Investigacion(id);
ALTER TABLE Propuesta ADD FOREIGN KEY (tipo_innovacion) REFERENCES Innovacion(id);
ALTER TABLE Propuesta ADD FOREIGN KEY (solucion_tecnologica) REFERENCES Solucion(id);
ALTER TABLE Item ADD FOREIGN KEY (idpropuesta) REFERENCES Propuesta(idpropuesta);
ALTER TABLE Item ADD FOREIGN KEY (participacion) REFERENCES Participacion(id);
ALTER TABLE Item ADD FOREIGN KEY (tipo_institucion) REFERENCES Institucion(id);
ALTER TABLE Item ADD FOREIGN KEY (region) REFERENCES Region(id);
ALTER TABLE Item ADD FOREIGN KEY (pais) REFERENCES Pais(id);
ALTER TABLE Tecnica ADD FOREIGN KEY (componente) REFERENCES Componente(id);
ALTER TABLE Tecnica ADD FOREIGN KEY (unidad) REFERENCES Unidad(id);
ALTER TABLE Tecnica ADD FOREIGN KEY (idpropuesta) REFERENCES Propuesta(idpropuesta);
ALTER TABLE Tecnica ADD FOREIGN KEY (indicastandar) REFERENCES Indicastandar(id);
ALTER TABLE Indicastandar ADD FOREIGN KEY (componente) REFERENCES Componente(id);
ALTER TABLE Breve ADD FOREIGN KEY (idpais) REFERENCES Pais(id);


---------------
DROP TABLE IF EXISTS Webstory_adjunto;
DROP TABLE IF EXISTS Adjunto_lang;
DROP TABLE IF EXISTS Webstory_lang;
DROP TABLE IF EXISTS Webstory;
DROP TABLE IF EXISTS Adjunto;
DROP TABLE IF EXISTS TipoAdjunto;
DROP TABLE IF EXISTS ;
DROP TABLE IF EXISTS ;
DROP TABLE IF EXISTS ;
DROP TABLE IF EXISTS ;
DROP TABLE IF EXISTS ;

CREATE TABLE TipoAdjunto(
	idtipo INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(100), 
	webstories BOOL NOT NULL default 0,
	propuestas BOOL NOT NULL default 0
);
INSERT INTO TipoAdjunto(idtipo, nombre, webstories, propuestas) VALUES (1, 'Foto', 1, 1), (2, 'Video', 1, 1), (4, 'Foto Iniciativa', 1, 0), (3, 'Estadística', 1, 0), (5, 'Logo', 0, 0), (6, 'Documento', 0, 1), (7, 'Publicación', 0, 1), (8, 'Presentación', 0, 1);

CREATE TABLE TipoAdjunto_lang(
	idtipo INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(100) NULL,
	PRIMARY KEY (codlang, idtipo)
);
INSERT INTO TipoAdjunto_lang(idtipo, nombre, codlang) VALUES (1, 'Foto','es'), (2, 'Video','es'), (4, 'Foto Iniciativa', 'es'), (3, 'Estadística','es'), (5, 'Logo', 'es'), (6, 'Documento asociado', 'es'), (7, 'Publicación', 'es'), (8, 'Presentación', 'es')
INSERT INTO TipoAdjunto_lang(idtipo, nombre, codlang) VALUES (1, 'Picture','en'), (2, 'Video','en'), (4, 'Pic Initiative', 'en'), (3, 'Statistics','en'), (5, 'Logo', 'en'), (6, 'Associated document', 'en'), (7, 'Publication', 'en'), (8, 'Presentation', 'en');


CREATE TABLE Adjunto(
	idadjunto INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idtipo INTEGER NOT NULL, /* 1 foto, 2 video, 3 Estadistica, 4 infografia, 5 logo */	
	orden INTEGER NOT NULL DEFAULT 0,
	link VARCHAR(255) NULL,
	archivo VARCHAR(100) NOT NULL,
	autor VARCHAR(255) NULL,
	acepto BOOLEAN NOT NULL DEFAULT 1,
	fecha DATE NULL,
	created timestamp NOT NULL default CURRENT_TIMESTAMP,
	urlold VARCHAR(255) NULL,
	habilitado NOT NULL DEFAULT 1
);
ALTER TABLE Adjunto ADD FOREIGN KEY (idtipo) REFERENCES TipoAdjunto(idtipo);

CREATE TABLE Adjunto_lang(
	idadjunto INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NULL,
	descripcion TEXT NULL,
	taller VARCHAR(255) NULL,
	lugar VARCHAR(255) NULL,
	PRIMARY KEY (codlang, idadjunto)
);
ALTER TABLE Adjunto_lang ADD FOREIGN KEY (idadjunto) REFERENCES Adjunto(idadjunto);

CREATE TABLE Webstory(
	idwebstory INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idpropuesta INTEGER NOT NULL,	
	foto_principal VARCHAR(100) NULL,
	foto_cita VARCHAR(100) NULL,
	foto_link VARCHAR(100) NULL,
	url VARCHAR(255) NULL,
	video VARCHAR(255) NULL,
	habilitado BOOL NOT NULL DEFAULT 1,
	publica_inv BOOLEAN NOT NULL DEFAULT 1,
	link_publicacion VARCHAR(255) NULL,
	deleted DATETIME NULL
);
ALTER TABLE Webstory ADD FOREIGN KEY (idpropuesta) REFERENCES Propuesta(idpropuesta);
ALTER TABLE Webstory ADD UNIQUE(url);


CREATE TABLE Webstory_lang(
	idwebstory INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	titulo VARCHAR(255) NULL,
	bajada TEXT NULL,
	contexto TEXT NULL,
	iniciativa_titulo VARCHAR(255) NULL,
	iniciativa_descripcion TEXT NULL,
	solucion_titulo VARCHAR(255) NULL,
	solucion_descripcion TEXT NULL,
	cita_texto TEXT NULL,
	cita_fuente VARCHAR(255) NULL,
	impactos TEXT NULL,
	resultados TEXT NULL,
	infografia_titulo VARCHAR(255) NULL,
	infografia VARCHAR(255) NULL,
	codigo_infografia TEXT NULL,
	estadisticas_titulo VARCHAR(255) NULL,
	infografia_volanta VARCHAR(255) NULL,
	codigo_estadisticas TEXT NULL,
	tech_solucion TEXT NULL,
	tech_descripcion TEXT NULL,
	tech_resultados TEXT NULL,
	tech_titulo VARCHAR(255) NULL,
	link_publicacion_titulo VARCHAR(255) NULL,
	PRIMARY KEY (codlang, idwebstory)
);
ALTER TABLE Webstory_lang ADD FOREIGN KEY (idwebstory) REFERENCES Webstory(idwebstory);

CREATE OR REPLACE VIEW v_Webstory AS
SELECT w.url, w.foto_principal, w.foto_cita, w.foto_link, w.video, w.habilitado, p.identificador, p.titulo_simple, p.idpropuesta, w.publica_inv, w.link_publicacion, wl.*
FROM Webstory w 
JOIN Webstory_lang wl ON w.idwebstory=wl.idwebstory AND wl.codlang='es'
LEFT JOIN v_Propuesta p ON p.idpropuesta=w.idpropuesta;

CREATE TABLE Webstory_adjunto(
	idwebstory INTEGER NOT NULL,
	idadjunto INTEGER NOT NULL,
	PRIMARY KEY(idwebstory, idadjunto)
);
ALTER TABLE Webstory_adjunto ADD FOREIGN KEY (idwebstory) REFERENCES Webstory(idwebstory);
ALTER TABLE Webstory_adjunto ADD FOREIGN KEY (idadjunto) REFERENCES Adjunto(idadjunto);

CREATE OR REPLACE VIEW v_Adjunto AS
SELECT a.*, al.nombre, al.descripcion, ta.nombre as tipo, 
CASE WHEN wa.idwebstory IS NOT NULL THEN wa.idwebstory ELSE pa.idpropuesta END AS idmodelo,
CASE WHEN wa.idwebstory IS NOT NULL THEN 'webstory' ELSE 'propuesta' END AS modelo
FROM Adjunto a 
JOIN Adjunto_lang al ON a.idadjunto=al.idadjunto AND al.codlang='es'
JOIN TipoAdjunto ta ON ta.idtipo=a.idtipo
LEFT JOIN Webstory_adjunto wa ON wa.idadjunto=a.idadjunto
LEFT JOIN Propuesta_adjunto pa ON pa.idadjunto=a.idadjunto;

CREATE TABLE Webstory_Indicador(
	idwebstoryindicador INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idwebstory INTEGER NOT NULL,
	icono VARCHAR(50) NOT NULL,
	valor VARCHAR(10) NOT NULL,
	prefijo VARCHAR(2) NOT NULL DEFAULT '',
	unidad VARCHAR(10) NOT NULL DEFAULT ''
);
ALTER TABLE Webstory_Indicador ADD FOREIGN KEY (idwebstory) REFERENCES Webstory(idwebstory);

CREATE TABLE Webstory_Indicador_lang(
	idwebstoryindicador INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NULL,
	PRIMARY KEY (codlang, idwebstoryindicador)
);
ALTER TABLE Webstory_Indicador_lang ADD FOREIGN KEY (idwebstoryindicador) REFERENCES Webstory_Indicador(idwebstoryindicador);

CREATE OR REPLACE VIEW v_Webstory_Indicador AS
SELECT i.*, il.nombre
FROM Webstory_Indicador i 
JOIN Webstory_Indicador_lang il ON i.idwebstoryindicador=il.idwebstoryindicador AND il.codlang='es';

CREATE TABLE BadgeODS(
	idbadgeods INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY	
);

CREATE TABLE BadgeODS_lang(
	idbadgeods INTEGER NOT NULL ,
	codlang char(2) NOT NULL,
	nombre VARCHAR(100) NOT NULL,
	descripcion TEXT NOT NULL,
	foto VARCHAR(100) NOT NULL,
	PRIMARY KEY (codlang, idbadgeods)
);
ALTER TABLE BadgeODS_lang ADD FOREIGN KEY (idbadgeods) REFERENCES BadgeODS(idbadgeods);

CREATE OR REPLACE VIEW v_BadgeODS AS
SELECT idbadgeods, nombre, foto, descripcion
FROM BadgeODS_lang bl WHERE bl.codlang='es';

CREATE TABLE Webstory_BadgeODS(
	idbadgeods INTEGER NOT NULL, 
	idwebstory INTEGER NOT NULL,
	PRIMARY KEY(idbadgeods, idwebstory)
);
ALTER TABLE Webstory_BadgeODS ADD FOREIGN KEY (idbadgeods) REFERENCES BadgeODS(idbadgeods);
ALTER TABLE Webstory_BadgeODS ADD FOREIGN KEY (idwebstory) REFERENCES Webstory(idwebstory);


CREATE TABLE Info(
	codigo VARCHAR(100) NOT NULL,
	codlang char(2) NOT NULL, /*NI para ninguno*/
	valor TEXT NULL,
	indice VARCHAR(20) NOT NULL,
	PRIMARY KEY (codigo, codlang),
	INDEX(indice)
);


CREATE TABLE Organismo(
	idorganismo INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(100) NOT NULL,
	logo VARCHAR(100) NULL,
	link VARCHAR(100) NULL,
	habilitado BOOL NOT NULL DEFAULT 1,
	nombre_largo VARCHAR(100) NULL,
	idpais INTEGER NULL,
	tipo_institucion INTEGER NULL,
	UNIQUE(nombre, idpais)
);

CREATE OR REPLACE VIEW v_Organismo AS
SELECT o.*, i.nombre as tipo, pl.nombre as pais, CASE WHEN oe.idorganismo IS NOT NULL THEN 'enuso' ELSE NULL END enuso
FROM Organismo o
LEFT JOIN Institucion_lang i ON o.tipo_institucion=i.id AND i.codlang='es'
LEFT JOIN Pais_lang pl ON o.idpais=pl.id AND pl.codlang='es'
LEFT JOIN v_Organismo_EnUso oe ON o.idorganismo=oe.idorganismo;

CREATE TABLE Donante(
	iddonante INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idorganismo INTEGER NOT NULL,
	idpropuesta INTEGER NOT NULL,
	orden INTEGER NOT NULL DEFAULT 0,
	UNIQUE(idorganismo, idpropuesta)
);


CREATE TABLE Logs(
	idlogs INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	entidad VARCHAR(100) NOT NULL,
	sentencia TEXT NOT NULL,
	idusuario INTEGER NOT NULL,
	idprincipal INTEGER NULL,
	funcion VARCHAR(100) NULL,
	created timestamp NOT NULL default CURRENT_TIMESTAMP	
);

--MAPAS

CREATE TABLE Mapa(
	idmapa INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idpropuesta INTEGER NOT NULL,	
	created timestamp NOT NULL default CURRENT_TIMESTAMP,
	deleted DATETIME NULL
);

CREATE TABLE Mapa_lang(
	idmapa INTEGER NOT NULL ,
	codlang char(2) NOT NULL,
	nombre VARCHAR(100) NOT NULL,
	descripcion TEXT NULL,
	PRIMARY KEY (codlang, idmapa)
);

CREATE OR REPLACE VIEW v_Mapa AS
SELECT m.idpropuesta, m.created, ml.*
FROM Mapa m
JOIN Mapa_lang ml ON m.idmapa=ml.idmapa AND codlang='es'
WHERE deleted IS NULL;

ALTER TABLE Mapa_lang ADD FOREIGN KEY (idmapa) REFERENCES Mapa(idmapa);

CREATE TABLE MapaElemento(
	idmapaelemento INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,	
	idmapa INTEGER NOT NULL,
	tipo VARCHAR(25) NOT NULL,
	latlng TEXT NOT NULL,
	foto VARCHAR(100) NULL,
	link VARCHAR(255) NULL,
	deleted DATETIME NULL,
	esppal BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE MapaElemento_lang(
	idmapaelemento INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NULL,
	descripcion TEXT NULL,
	PRIMARY KEY (codlang, idmapaelemento)
);

CREATE OR REPLACE VIEW v_MapaElemento AS
SELECT m.*, ml.nombre, ml.descripcion
FROM MapaElemento m
JOIN MapaElemento_lang ml ON m.idmapaelemento=ml.idmapaelemento AND codlang='es'
WHERE deleted IS NULL;

ALTER TABLE MapaElemento ADD FOREIGN KEY (idmapa) REFERENCES Mapa(idmapa);
ALTER TABLE MapaElemento_lang ADD FOREIGN KEY (idmapaelemento) REFERENCES MapaElemento(idmapaelemento);


CREATE TABLE Noticia(
	idnoticia INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idusuario INTEGER NOT NULL,
	idpropuesta INTEGER NOT NULL,
	publicada DATETIME NULL,
	hasta DATETIME NULL,
	foto VARCHAR(100) NULL,
	deleted DATETIME NULL,
	idtiponoticia INTEGER NOT NULL DEFAULT 1,
	publica_inv BOOLEAN NOT NULL DEFAULT 1,
	aprobada_admin BOOLEAN NOT NULL DEFAULT 1
);

CREATE TABLE Noticia_lang(
	idnoticia INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	titulo VARCHAR(255) NOT NULL,
	bajada TEXT,
	url VARCHAR(255) NULL,
	contenido TEXT,
	PRIMARY KEY (codlang, idnoticia)
);

CREATE OR REPLACE VIEW v_Noticia_Publicada AS
SELECT * FROM Noticia
WHERE publicada IS NOT NULL 
AND aprobada_admin=1
AND (hasta IS NULL OR hasta>=now())
AND (publicada<=now())
AND deleted IS NULL;

CREATE OR REPLACE VIEW v_Noticia AS
SELECT n.*, nl.titulo, nl.contenido, nl.bajada, nl.url, p.identificador,
CASE WHEN np.idnoticia IS NULL THEN 0 ELSE 1 END AS actualmente_publicada,
CASE WHEN n.idtiponoticia=1 THEN 'Noticia' ELSE 'Blog' END AS tiponoticia,
CASE WHEN n.aprobada_admin=1 THEN 'Aprobada' ELSE 'Desaprobada' END AS aprobada
FROM Noticia n 
JOIN Noticia_lang nl ON nl.idnoticia=n.idnoticia AND nl.codlang='es'
JOIN Propuesta p ON n.idpropuesta=p.idpropuesta
LEFT JOIN v_Noticia_Publicada np ON np.idnoticia=n.idnoticia
WHERE n.deleted IS NULL;


CREATE TABLE Propuesta_BadgeODS(
	idbadgeods INTEGER NOT NULL, 
	idpropuesta INTEGER NOT NULL,
	PRIMARY KEY(idbadgeods, idpropuesta)
);


CREATE TABLE Propuesta_adjunto(
	idpropuesta INTEGER NOT NULL,
	idadjunto INTEGER NOT NULL,
	PRIMARY KEY(idpropuesta, idadjunto)
);
ALTER TABLE Propuesta_adjunto ADD FOREIGN KEY (idpropuesta) REFERENCES Propuesta(idpropuesta);
ALTER TABLE Propuesta_adjunto ADD FOREIGN KEY (idadjunto) REFERENCES Adjunto(idadjunto);


CREATE TABLE Webstory_organismos(
	idwebstoryorganismo INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idwebstory INTEGER NOT NULL,
	idorganismo INTEGER NULL,
	pais INTEGER NULL	
);
ALTER TABLE Webstory_organismos ADD FOREIGN KEY (idwebstory) REFERENCES Webstory(idwebstory);
ALTER TABLE Webstory_organismos ADD FOREIGN KEY (idorganismo) REFERENCES Organismo(idorganismo);
ALTER TABLE Webstory_organismos ADD FOREIGN KEY (pais) REFERENCES Pais(id);

CREATE OR REPLACE VIEW v_Webstory_organismos AS
SELECT wo.*, o.nombre as organismo, p.nombre as nombre_pais 
FROM Webstory_organismos wo
LEFT JOIN Organismo o ON o.idorganismo=wo.idorganismo
LEFT JOIN Pais_lang p ON p.id=wo.pais AND p.codlang='es';

--------UPDATES

--PROPUESTAS FALTANTE




CREATE TABLE Propuesta_tema(
	idpropuesta INTEGER NOT NULL,
	idtema INTEGER NOT NULL,
	PRIMARY KEY(idpropuesta, idtema)
);
ALTER TABLE Propuesta_tema ADD FOREIGN KEY (idpropuesta) REFERENCES Propuesta(idpropuesta);
ALTER TABLE Propuesta_tema ADD FOREIGN KEY (idtema) REFERENCES Tema(idtema);

CREATE TABLE Propuesta_pais(
	idpropuesta INTEGER NOT NULL,
	idpais INTEGER NOT NULL,
	PRIMARY KEY(idpropuesta, idpais)
); /*TODO importar desde Item*/
ALTER TABLE Propuesta_pais ADD FOREIGN KEY (idpropuesta) REFERENCES Propuesta(idpropuesta);
ALTER TABLE Propuesta_pais ADD FOREIGN KEY (idpais) REFERENCES Pais(id);

ALTER TABLE Propuesta ADD nv_monto_solicitado INTEGER NULL;
ALTER TABLE Propuesta ADD nv_monto_contrapartida INTEGER NULL;
ALTER TABLE Propuesta ADD nv_plazo_ejecucion INTEGER NULL;
ALTER TABLE Propuesta_lang ADD nv_resumen_ejecutivo TEXT NULL;
ALTER TABLE Propuesta_lang ADD nv_impacto TEXT NULL;
ALTER TABLE Propuesta_lang ADD nv_beneficiarios TEXT NULL;

CREATE TABLE Propuesta_usuario(
	idpropuesta INTEGER NOT NULL,
	idusuario INTEGER NOT NULL,
	rol INTEGER NOT NULL DEFAULT 1,/*1 Cargador inicial*/
	PRIMARY KEY (idpropuesta, idusuario)
);
ALTER TABLE Propuesta_usuario ADD FOREIGN KEY (idpropuesta) REFERENCES Propuesta(idpropuesta);
ALTER TABLE Propuesta_usuario ADD FOREIGN KEY (idusuario) REFERENCES usuario(idusuario);


ALTER TABLE Propuesta ADD idtipoproyecto INTEGER NOT NULL DEFAULT 1;
ALTER TABLE Propuesta ADD FOREIGN KEY (idtipoproyecto) REFERENCES TipoProyecto(idtipoproyecto);




//---------TECH
ALTER TABLE Webstory_lang ADD tech_solucion TEXT NULL;
ALTER TABLE Webstory_lang ADD tech_descripcion TEXT NULL;
ALTER TABLE Webstory_lang ADD tech_resultados TEXT NULL;
ALTER TABLE Webstory_lang ADD tech_titulo VARCHAR(255) NULL;

CREATE TABLE Tech(
	idtech INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idwebstory INTEGER NOT NULL,
	habilitado BOOL NOT NULL,
 	publica_inv BOOLEAN NOT NULL DEFAULT 1,
	deleted DATETIME NULL, 
	UNIQUE(idwebstory)
);

CREATE OR REPLACE VIEW v_Tech AS
SELECT t.idtech, t.habilitado as tech_habilitado, w.*
FROM v_Webstory w 
JOIN Tech t ON w.idwebstory=t.idwebstory;


---UPDATES PERFILES

CREATE TABLE Iniciativa(
	idiniciativa INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idoperacion INTEGER NOT NULL,
	fecha_desde DATETIME NULL,
	fecha_hasta DATETIME NULL,
	fecha_preseleccion DATETIME NULL,
	foto VARCHAR(100) NULL,
	idestado INTEGER NOT NULL DEFAULT 1,
	link_preseleccionados VARCHAR(255) NULL,
	link_ganadores VARCHAR(255) NULL,
	identificador VARCHAR(100) NULL,
	deleted DATETIME NULL
);

CREATE TABLE Iniciativa_lang(
	idiniciativa INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	titulo VARCHAR(255) NOT NULL,
	descripcion TEXT NULL,
	link_terminos VARCHAR(255) NULL,
	html_parte1 TEXT NULL,
	html_parte2 TEXT NULL,
	html_intro TEXT NULL,
	PRIMARY KEY (codlang, idiniciativa)
);

CREATE OR REPLACE VIEW v_IniciativaEstado AS 
SELECT i.*, 
CASE 
	WHEN fecha_desde<=now() AND fecha_hasta>=now() THEN 1
	WHEN fecha_preseleccion>=now() THEN 2
	WHEN idestado<3 THEN 3
	ELSE idestado
END idestadoreal
FROM Iniciativa i
WHERE deleted IS NULL;

CREATE OR REPLACE VIEW v_Iniciativa AS 
SELECT i.*, il.titulo, il.descripcion, op.nombre as tipo, e.nombre AS estado
FROM v_IniciativaEstado i 
JOIN Iniciativa_lang il ON il.idiniciativa=i.idiniciativa AND codlang='es'
JOIN v_Operacion op ON op.id=i.idoperacion
JOIN v_Estado_Iniciativa e ON i.idestadoreal=e.id;


CREATE TABLE Perfil(
	idperfil INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idusuario INTEGER NOT NULL,
	idiniciativa INTEGER NOT NULL, 
	idoperacion INTEGER NOT NULL,
	titulo VARCHAR(500) NULL,	
	titulo_corto VARCHAR(500) NULL,	

	linea_estrategica INTEGER NULL,
	tipo_investigacion INTEGER NULL,
	tipo_innovacion INTEGER NULL,
	solucion_tecnologica INTEGER NULL,

	monto DECIMAL(14,4) NULL,
	monto_contrapartida DECIMAL(14,4) NULL, 
	monto_total DECIMAL(14,4) NULL, 
	plazo INTEGER NULL,

	congruencia TEXT NULL, 
	regionalidad TEXT NULL, 
	capacidad TEXT NULL, 
	articulacion TEXT NULL, 

	impacto TEXT NULL, 
	beneficiarios TEXT NULL, 

	antecedentes TEXT NULL, 
	fin_proyecto TEXT NULL, 
	proposito TEXT NULL, 

	evidencia_capacidad TEXT NULL,
	evidencia_compromiso BOOLEAN NULL,
	evidencia_articulacion TEXT NULL,
	evidencia_mecanismos TEXT NULL,

	marco_logico TEXT NULL,

	adicional_cientifica TEXT NULL,
	adicional_potencial TEXT NULL,
	adicional_escalamiento TEXT NULL,
	adicional_transferencia TEXT NULL,
	adicional_riesgos TEXT NULL,
	adicional_pmp TEXT NULL,

	actualizado DATETIME NULL,
	enviado DATETIME NULL,
	leyo_manual BOOLEAN NOT NULL DEFAULT 0,
	porcentaje INTEGER NOT NULL DEFAULT 0,

	idestadoperfil INTEGER NOT NULL DEFAULT 1,
	
	adjunto_pre_propuesta VARCHAR(100) NULL,
	adjunto_pre_presupuesto VARCHAR(100) NULL,
	adjunto_seleccion VARCHAR(100) NULL
);
ALTER TABLE Perfil ADD INDEX(idusuario);
ALTER TABLE Perfil ADD INDEX(idiniciativa);
ALTER TABLE Perfil ADD INDEX(idoperacion);

CREATE TABLE Perfil_Estado(
	idestadoperfil INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(100) NOT NULL
);
INSERT INTO Perfil_Estado(idestadoperfil, nombre) VALUES (1,'Inicial'), (2,'Pre-seleccionado'), (3,'Seleccionado');

CREATE OR REPLACE VIEW v_Perfil AS
SELECT p.*, u.nombre, u.email, u.somosnosotros, e.nombre estado
FROM Perfil p 
JOIN usuario u ON p.idusuario=u.idusuario
JOIN Perfil_Estado e ON e.idestadoperfil=p.idestadoperfil;


CREATE TABLE Perfil_BadgeODS(
	idbadgeods INTEGER NOT NULL, 
	idperfil INTEGER NOT NULL,
	PRIMARY KEY(idbadgeods, idperfil)
);
ALTER TABLE Perfil_BadgeODS ADD FOREIGN KEY (idbadgeods) REFERENCES BadgeODS(idbadgeods);
ALTER TABLE Perfil_BadgeODS ADD FOREIGN KEY (idperfil) REFERENCES Perfil(idperfil);


CREATE TABLE Rubro(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Rubro_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Rubro AS
SELECT * FROM Rubro_lang WHERE codlang='es'; 

ALTER TABLE Propuesta ADD idrubro INTEGER NULL;
ALTER TABLE Propuesta ADD INDEX (idrubro);


CREATE TABLE Areainvestigacion(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Areainvestigacion_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Areainvestigacion AS
SELECT * FROM Areainvestigacion_lang WHERE codlang='es'; 

ALTER TABLE Propuesta ADD idareainvestigacion INTEGER NULL;
ALTER TABLE Propuesta ADD INDEX (idareainvestigacion);


CREATE TABLE Sector(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Sector_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Sector AS
SELECT * FROM Sector_lang WHERE codlang='es'; 


CREATE TABLE Tema(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
); 
CREATE TABLE Tema_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id),
	UNIQUE (codlang, nombre)
);
CREATE OR REPLACE VIEW v_Tema AS
SELECT * FROM Tema_lang WHERE codlang='es'; 

CREATE TABLE Propuesta_Tema(
	idtema INTEGER NOT NULL,
	idpropuesta INTEGER NOT NULL,
	PRIMARY KEY(idtema, idpropuesta)
);


CREATE TABLE Perfil_Tema(
	idtema INTEGER NOT NULL,
	idperfil INTEGER NOT NULL,
	PRIMARY KEY (idperfil, idtema)
);


CREATE TABLE Perfil_Organismo(
	idperfilorganismo INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idperfil INTEGER NOT NULL,
	idorganismo INTEGER NOT NULL,
	participacion INTEGER NOT NULL DEFAULT 0,
	orden INTEGER NOT NULL,
	visible BOOLEAN NOT NULL,
	idpais INTEGER NULL,
	nombre_contacto VARCHAR(100) NULL,
	cargo_contacto VARCHAR(100) NULL,
	email_contacto VARCHAR(100) NULL,
	telefono_contacto VARCHAR(100) NULL,
	nombre_autoridad VARCHAR(100) NULL,
	UNIQUE(idperfil, participacion, orden)
);

CREATE TABLE Organismo_Sugerido(
	idsugerido INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idusuario INTEGER NOT NULL,
	nombre VARCHAR(100) NOT NULL,
	nombre_largo VARCHAR(100) NOT NULL,
	link VARCHAR(100) NOT NULL,
	idpais INTEGER NOT NULL,
	aprobado BOOLEAN NULL,
	motivo TEXT NULL,
	created timestamp NOT NULL default CURRENT_TIMESTAMP,
	tipo_institucion INTEGER NULL
);


CREATE OR REPLACE VIEW v_Organismo_Sugerido AS
SELECT os.*, CONCAT(u.nombre, ' - ', u.email) usuario, pl.nombre pais, u.email, i.nombre as tipo
FROM Organismo_Sugerido os
JOIN usuario u ON u.idusuario=os.idusuario
JOIN Pais_lang pl ON pl.id=os.idpais AND pl.codlang='es'
LEFT JOIN Institucion_lang i ON os.tipo_institucion=i.id AND i.codlang='es'
WHERE aprobado IS NULL;


CREATE TABLE Perfil_Componente(
	idperfilcomponente INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idperfil INTEGER NOT NULL,
	orden INTEGER NOT NULL,
	nombre TEXT NULL,
	actividad TEXT NULL,
	producto TEXT NULL,
	resultado TEXT NULL,
	UNIQUE(idperfil, orden)
);

DROP TABLE Perfil_C_Actividad;
CREATE TABLE Perfil_C_Actividad(
	idactividad INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idperfilcomponente INTEGER NOT NULL,
	nombre TEXT NULL,
	index(idperfilcomponente)
);

DROP TABLE Perfil_C_Producto;
CREATE TABLE Perfil_C_Producto(
	idproducto INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idperfilcomponente INTEGER NOT NULL,
	nombre TEXT NULL,
	index(idperfilcomponente)
);

DROP TABLE Perfil_C_Resultado;
CREATE TABLE Perfil_C_Resultado(
	idresultado INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idperfilcomponente INTEGER NOT NULL,
	nombre TEXT NULL,
	index(idperfilcomponente)
);


CREATE TABLE Propuesta_Sector(
	idpropuesta INTEGER NOT NULL,
	idsector INTEGER NOT NULL,
	PRIMARY KEY(idpropuesta, idsector)
);

CREATE OR REPLACE VIEW v_Sectores AS
SELECT idpropuesta, GROUP_CONCAT(sl.nombre SEPARATOR ', ') nombre
FROM Sector_lang sl
JOIN Propuesta_Sector ps ON sl.id=ps.idsector
WHERE sl.codlang='es'
GROUP BY ps.idpropuesta;

CREATE OR REPLACE VIEW v_Sectores_lang AS
SELECT idpropuesta, sl.codlang, GROUP_CONCAT(sl.nombre SEPARATOR ', ') nombre
FROM Sector_lang sl
JOIN Propuesta_Sector ps ON sl.id=ps.idsector
GROUP BY ps.idpropuesta, sl.codlang;

DROP TABLE Perfil_Sector;
CREATE TABLE Perfil_Sector(
	idperfil INTEGER NOT NULL,
	idsector INTEGER NOT NULL,
	orden INTEGER NOT NULL,
	PRIMARY KEY(idperfil, orden)
);

CREATE TABLE Subsector(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idsector INTEGER NOT NULL,
	INDEX(idsector)
);
CREATE TABLE Subsector_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	PRIMARY KEY(codlang, id)
);

CREATE OR REPLACE VIEW v_Subsector AS
SELECT ss.id, ss.idsector, GROUP_CONCAT(sssl.nombre ORDER BY sssl.codlang DESC SEPARATOR ', ') nombre
FROM Subsector ss 
JOIN Subsector_lang sssl ON sssl.id=ss.id 
GROUP BY ss.id, ss.idsector; 

CREATE TABLE Propuesta_Subsector(
	idpropuesta INTEGER NOT NULL,
	idsubsector INTEGER NOT NULL,
	PRIMARY KEY(idpropuesta, idsubsector)
);

CREATE TABLE Perfil_Subsector(
	idperfil INTEGER NOT NULL,
	idsubsector INTEGER NOT NULL,
	PRIMARY KEY(idperfil, idsubsector)
);


CREATE TABLE Log_Perfil(
	idlogperfil INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	created timestamp NOT NULL default CURRENT_TIMESTAMP,
	idusuario INTEGER NOT NULL,
	idperfil INTEGER NOT NULL,
	data LONGTEXT NULL,
	extra LONGTEXT NULL
);


--
ALTER TABLE Organismo ADD nombre_largo VARCHAR(100) NULL;
ALTER TABLE Organismo ADD idpais INTEGER NULL;

CREATE TABLE Alerta(
	idalerta INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	created timestamp NOT NULL default CURRENT_TIMESTAMP,	
	titulo VARCHAR(255) NOT NULL,
	contenido TEXT NULL,
	link VARCHAR(255) NULL
);

CREATE TABLE Alerta_Usuario(
	idalerta INTEGER NOT NULL,
	idusuario INTEGER NOT NULL,
	leido DATETIME NULL,
	cerrada BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY(idalerta, idusuario)	
);

--
UPDATE Organismo o JOIN Item i ON o.idorganismo=i.idorganismo SET o.tipo_institucion=i.tipo_institucion
UPDATE Organismo o JOIN Item i ON o.idorganismo=i.idorganismo SET o.idpais=i.pais WHERE o.idpais IS NULL;


CREATE OR REPLACE VIEW v_puntosPpales AS
SELECT pe.idpropuesta, me.latlng, pl.codlang, pl.titulo_simple, pe.estado, pal.nombre as pais, pe.organismo, pe.identificador, pe.total, pe.web_url url, pe.web_publicado, pe.urlvieja
FROM v_PropuestaEjecutor pe 
JOIN Propuesta_lang pl ON pl.idpropuesta=pe.idpropuesta
JOIN Mapa m ON m.idpropuesta=pe.idpropuesta
JOIN MapaElemento me ON me.idmapa=m.idmapa
JOIN Pais_lang pal ON pal.id=pe.pais AND pal.codlang='es'
WHERE pe.deleted IS NULL AND me.deleted IS NULL AND me.esppal=1 AND pe.web_publicado=1;

CREATE OR REPLACE VIEW v_puntosEstimados AS
SELECT pe.idpropuesta, pa.latitud, pa.longitud, pl.codlang, pl.titulo_simple, pe.estado, pal.nombre as pais, pe.organismo, pe.identificador, pe.total, pe.web_url url, pe.web_publicado, pe.urlvieja
FROM v_PropuestaEjecutor pe
JOIN Propuesta_lang pl ON pl.idpropuesta=pe.idpropuesta 
JOIN Pais pa ON pa.id=pe.pais
JOIN Pais_lang pal ON pal.id=pe.pais AND pal.codlang='es'
WHERE pe.idpropuesta NOT IN (SELECT idpropuesta FROM v_puntosPpales) AND pe.web_publicado=1;



CREATE TABLE Estado_Iniciativa(
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);
CREATE TABLE Estado_Iniciativa_lang(
	id INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	descripcion TEXT NULL,
	PRIMARY KEY(codlang, id)
);
CREATE OR REPLACE VIEW v_Estado_Iniciativa AS
SELECT * FROM Estado_Iniciativa_lang WHERE codlang='es';
ALTER TABLE Estado_Iniciativa_lang ADD FOREIGN KEY (id) REFERENCES Estado_Iniciativa(id);

INSERT INTO Estado_Iniciativa(id) VALUES (1),(2),(3),(4);
INSERT INTO Estado_Iniciativa_lang(id, codlang, nombre) VALUES (1,'es','Abierto'), (1,'en','Open'), (2,'es','Pre-seleccion'), (2,'en','Pre-selection'), (3,'es','Propuesta'), (3,'en','Proposal'), (4,'es','Cerrada'), (4,'en','Closed'); 


CREATE TABLE Callista(
	idcallista INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	fecha_desde DATETIME NULL,
	fecha_hasta DATETIME NULL
);

CREATE OR REPLACE VIEW v_CallistaEstado AS 
SELECT c.*, 
CASE WHEN fecha_desde<=now() AND fecha_hasta>=now() THEN 1 ELSE 2 END idestadoreal
FROM Callista c;

CREATE TABLE Callista_lang(
	idcallista INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	titulo VARCHAR(255) NOT NULL,
	descripcion TEXT NULL,
	antecedentes TEXT NULL,
	objetivos TEXT NULL,
	metodologia TEXT NULL,
	calendario TEXT NULL,
	normas TEXT NULL,
	PRIMARY KEY (codlang, idcallista)
);

CREATE OR REPLACE VIEW v_Callista AS
SELECT cl.*, c.fecha_desde, c.fecha_hasta, c.idestadoreal, el.nombre as estado
FROM v_CallistaEstado c
JOIN Callista_lang cl ON c.idcallista=cl.idcallista AND cl.codlang='es'
JOIN Estado_lang el ON c.idestadoreal=el.id AND el.codlang='es'; 

CREATE TABLE Ista(
	idista INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idpropuesta INTEGER NOT NULL,
	idcallista INTEGER NOT NULL,
	leyo_manual BOOLEAN NOT NULL DEFAULT 0,

	investigador VARCHAR(255) NULL, 	/*1*/
	objetivo TEXT NULL,			/*1*/
	resumen_ejecutivo TEXT NULL,		/*2*/
	resultados TEXT NULL,			/*2*/
	productos TEXT NULL,			/*2*/
	hallazgos TEXT NULL,			/*3*/
	innovaciones TEXT NULL,			/*3*/
	historias TEXT NULL,			/*4*/
	oportunidades TEXT NULL,		/*4*/
	articulacion TEXT NULL,			/*5*/
	gestion TEXT NULL,			/*5*/
	adjunto VARCHAR(100),			/*6*/

	created timestamp NOT NULL default CURRENT_TIMESTAMP, 
	porcentaje INTEGER NOT NULL DEFAULT 0,
	actualizado DATETIME NULL,
	enviado DATETIME NULL,
	UNIQUE(idpropuesta, idcallista)
);

CREATE OR REPLACE VIEW v_Ista AS
SELECT i.*, pl.titulo_simple, p.identificador
FROM Ista i 
JOIN Propuesta p ON i.idpropuesta=p.idpropuesta
JOIN Propuesta_lang pl ON i.idpropuesta=pl.idpropuesta AND pl.codlang='es';

CREATE TABLE Log_Ista(
	idlogista INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	created timestamp NOT NULL default CURRENT_TIMESTAMP,
	idusuario INTEGER NOT NULL,
	idista INTEGER NOT NULL,
	data LONGTEXT NULL,
	extra LONGTEXT NULL
);


SELECT i.iditem, i.idorganismo, i.organismo, pli.nombre, pli.id, plo.nombre, plo.id  
FROM Item i
JOIN Organismo o ON i.idorganismo=o.idorganismo
LEFT JOIN Pais_lang pli ON pli.id=i.pais AND pli.codlang='es'
LEFT JOIN Pais_lang plo ON plo.id=o.idpais AND plo.codlang='es'
WHERE o.idpais<>i.pais

CREATE TABLE Ista_Rechazo(
	idistarechazo INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idista INTEGER NOT NULL,
	created timestamp NOT NULL default CURRENT_TIMESTAMP, 
	comentario TEXT NOT NULL,
	idusuario INTEGER NULL,
    	INDEX(idista)
);


------
CREATE TABLE ProductoTipo(
	idtipo INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE ProductoTipo_lang(
	idtipo INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(100) NULL,
	PRIMARY KEY (codlang, idtipo)
);
INSERT INTO ProductoTipo(idtipo) VALUES (NULL),(NULL),(NULL),(NULL),(NULL),(NULL),(NULL),(NULL);

INSERT INTO ProductoTipo_lang(idtipo, nombre, codlang) VALUES 
	(1, 'Memoria de taller','es'), 
	(2, 'Nota técnica','es'), 
	(3, 'Monografía', 'es'), 
	(4, 'Catálogos y folletos','es'), 
	(5, 'Libro', 'es'), 
	(6, 'Boletín', 'es'), 
	(7, 'Base de datos', 'es'), 
	(8, 'Artículo científico', 'es');

INSERT INTO ProductoTipo_lang(idtipo, nombre, codlang) VALUES 
	(1, 'Workshop memory','en'), 
	(2, 'Technical note','en'), 
	(3, 'Monograph', 'en'), 
	(4, 'Catalogs and brochures','en'), 
	(5, 'Book', 'en'), 
	(6, 'Newsletter', 'en'), 
	(7, 'Database', 'en'), 
	(8, 'Scientific article', 'en');


CREATE TABLE Producto(
	idproducto INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idpropuesta INTEGER NOT NULL,
	idtipo INTEGER NOT NULL,	
	orden INTEGER NOT NULL DEFAULT 0,
	archivo VARCHAR(100) NOT NULL,
	numero VARCHAR(20) NULL,
	publicado BOOLEAN NULL,
	created timestamp NOT NULL default CURRENT_TIMESTAMP
);

CREATE TABLE Producto_lang(
	idproducto INTEGER NOT NULL,
	codlang char(2) NOT NULL,
	nombre VARCHAR(255) NULL,
	PRIMARY KEY (codlang, idproducto)
);

CREATE OR REPLACE VIEW v_Producto AS
SELECT a.*, al.nombre, ta.nombre as tipo
FROM Producto a 
JOIN Producto_lang al ON a.idproducto=al.idproducto AND al.codlang='es'
JOIN ProductoTipo_lang ta ON ta.idtipo=a.idtipo AND ta.codlang='es'
WHERE a.publicado IS NULL OR a.publicado=1;

CREATE OR REPLACE VIEW v_Organismo_EnUso AS
select distinct idorganismo FROM Item UNION
select distinct idorganismo FROM Donante UNION
select distinct idorganismo FROM Webstory_organismos UNION
select distinct idorganismo FROM Perfil_Organismo po JOIN Perfil p ON p.idperfil=po.idperfil WHERE idestadoperfil>1;

