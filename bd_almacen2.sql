-- MySQL Script generated by MySQL Workbench
-- Mon May 15 17:25:13 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema bd_almacen2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bd_almacen2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bd_almacen2` DEFAULT CHARACTER SET utf8 ;
USE `bd_almacen2` ;

-- -----------------------------------------------------
-- Table `bd_almacen2`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_almacen2`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`productos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(50) NOT NULL,
  `categoria_id` INT NOT NULL,
  `stock` INT NULL,
  `imagen_producto` VARCHAR(200) NULL,
  `precio_costo` DECIMAL(10,2) NOT NULL,
  `ganancia` DECIMAL(10,2) NOT NULL,
  `precio_unitarioVenta` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_productos_categoria_idx` (`categoria_id` ASC) VISIBLE,
  CONSTRAINT `fk_productos_categoria`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `bd_almacen2`.`categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_almacen2`.`proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`proveedor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_almacen2`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`clientes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_almacen2`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `clientes_id` INT NOT NULL,
  `fecha_pedido` DATE NOT NULL,
  `precioTotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pedidos_clientes1_idx` (`clientes_id` ASC) VISIBLE,
  CONSTRAINT `fk_pedidos_clientes1`
    FOREIGN KEY (`clientes_id`)
    REFERENCES `bd_almacen2`.`clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_almacen2`.`solicitudes_compra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`solicitudes_compra` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `proveedor_id` INT NOT NULL,
  `fecha_solicitud` DATE NOT NULL,
  `precioTotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_solicitudes_compra_proveedor1_idx` (`proveedor_id` ASC) VISIBLE,
  CONSTRAINT `fk_solicitudes_compra_proveedor1`
    FOREIGN KEY (`proveedor_id`)
    REFERENCES `bd_almacen2`.`proveedor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_almacen2`.`detalle_solicitud`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`detalle_solicitud` (
  `productos_id` INT NOT NULL,
  `solicitudes_compra_id` INT NOT NULL,
  `cantidad_entrada` INT NOT NULL,
  `precio_unitario` DECIMAL(10,2) NOT NULL,
  `precio_compra` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`productos_id`, `solicitudes_compra_id`),
  INDEX `fk_detalle_solicitud_solicitudes_compra1_idx` (`solicitudes_compra_id` ASC) VISIBLE,
  INDEX `fk_detalle_solicitud_productos1_idx` (`productos_id` ASC) VISIBLE,
  CONSTRAINT `fk_detalle_solicitud_solicitudes_compra1`
    FOREIGN KEY (`solicitudes_compra_id`)
    REFERENCES `bd_almacen2`.`solicitudes_compra` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_solicitud_productos1`
    FOREIGN KEY (`productos_id`)
    REFERENCES `bd_almacen2`.`productos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_almacen2`.`detalle_pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`detalle_pedidos` (
  `productos_id` INT NOT NULL,
  `pedidos_id` INT NOT NULL,
  `cantidad_salida` INT NOT NULL,
  `precio_unitario` DECIMAL(10,2) NOT NULL,
  `precio_venta` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`productos_id`, `pedidos_id`),
  INDEX `fk_detalle_pedidos_pedidos1_idx` (`pedidos_id` ASC) VISIBLE,
  CONSTRAINT `fk_detalle_pedidos_productos1`
    FOREIGN KEY (`productos_id`)
    REFERENCES `bd_almacen2`.`productos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_pedidos_pedidos1`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `bd_almacen2`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_almacen2`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_almacen2`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(50) NOT NULL,
  `password` CHAR(60) NOT NULL,
  `nombre` VARCHAR(15) NULL,
  `apellido` VARCHAR(20) NULL,
  `rol` VARCHAR(20) NOT NULL,
  `telefono` CHAR(9) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
