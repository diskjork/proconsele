CREATE TRIGGER `cobranzas` AFTER INSERT ON `detallecobranza`
 FOR EACH ROW BEGIN
DECLARE ident INT;
DECLARE idasiento INT;
DECLARE importetotal INT;
DECLARE nomcliente VARCHAR(45);
DECLARE fechacobranza DATE;
DECLARE cuentacaja INT;
DECLARE cuentactabancaria INT;

SET ident= (SELECT ctactecliente.cliente_idcliente as client FROM ctactecliente, cobranza,detallecobranza
WHERE detallecobranza.cobranza_idcobranza=NEW.cobranza_idcobranza
AND detallecobranza.cobranza_idcobranza=cobranza.idcobranza 
AND cobranza.ctactecliente_idctactecliente=ctactecliente.idctactecliente limit 1);


SET nomcliente= (SELECT cliente.nombre FROM cliente WHERE cliente.idcliente=ident);
SET importetotal= (SELECT cobranza.importe FROM cobranza WHERE cobranza.idcobranza = NEW.cobranza_idcobranza);
SET fechacobranza=(SELECT cobranza.fecha FROM cobranza WHERE cobranza.idcobranza=NEW.cobranza_idcobranza);
SET idasiento= (SELECT asiento.idasiento FROM asiento WHERE asiento.cobranza_idcobranza=NEW.cobranza_idcobranza);
IF NEW.caja_idcaja != NULL THEN
SET cuentacaja=(SELECT cuenta_idcuenta FROM caja WHERE idcaja=NEW.caja_idcaja);
END IF;
IF NEW.transferenciabanco != NULL THEN
SET cuentactabancaria=(SELECT cuenta_idcuenta FROM ctabancaria WHERE idctabancaria=NEW.transferenciabanco);
END IF;
IF NEW.tipocobranza=0 THEN
INSERT INTO `movimientocaja` (`descripcion`, `fecha`, `debeohaber`, `debe`, `caja_idcaja`,  `id_de_trabajo`) 
VALUES (CONCAT('Cobranza N°',NEW.cobranza_idcobranza,'-',nomcliente), fechacobranza, 0,NEW.importe, NEW.caja_idcaja,  NEW.cobranza_idcobranza);


INSERT INTO `detalleasiento` (`cuenta_idcuenta`, `debe`, `asiento_idasiento`,`cliente_idcliente`,`iddocumento`)
VALUES (cuentacaja, NEW.importe, idasiento, ident, NEW.cobranza_idcobranza);

ELSEIF NEW.tipocobranza=1 THEN
INSERT INTO `cheque` (`nrocheque`, `titular`, `cuittitular`, `fechaingreso`, `fechacobro`, `debe`, `debeohaber`, `Banco_idBanco`,`estado`,`cliente_idcliente`,`cobranza_idcobranza`) 
VALUES (NEW.nrocheque, NEW.chequetitular, NEW.chequecuittitular,NEW.chequefechaingreso, NEW.chequefechacobro,NEW.importe, 0, NEW.chequebanco,2,ident, NEW.cobranza_idcobranza);
INSERT INTO `detalleasiento` (`cuenta_idcuenta`, `debe`, `asiento_idasiento`,`cliente_idcliente`,`iddocumento`)
VALUES (5, NEW.importe, idasiento, ident, NEW.cobranza_idcobranza);


ELSEIF NEW.tipocobranza=2 THEN
INSERT INTO `movimientobanco` (`descripcion`, `fecha`, `debeohaber`, `debe`, `ctabancaria_idctabancaria`,  `id_de_trabajo`) 
VALUES (CONCAT('Cobranza N°',NEW.cobranza_idcobranza,'-',nomcliente), fechacobranza,0, NEW.importe,  NEW.transferenciabanco, NEW.cobranza_idcobranza);


INSERT INTO `detalleasiento` (`cuenta_idcuenta`, `debe`, `asiento_idasiento`,`cliente_idcliente`,`iddocumento`)
VALUES (cuentactabancaria, NEW.importe, idasiento, ident, NEW.cobranza_idcobranza);


END IF;
END