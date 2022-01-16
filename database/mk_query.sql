CREATE TABLE `crud_usuarios`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `apellidos` VARCHAR(150) NOT NULL,
  `imagen` VARCHAR(250) NOT NULL,
  `telefono` VARCHAR(30) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `fecha_creacion` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
