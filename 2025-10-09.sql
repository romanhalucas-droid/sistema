CREATE TABLE `convidados` (
  `id` char(36) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `confirmado` tinyint(4) NOT NULL,
  `celular` varchar(12) NOT NULL,
  `dtExpiracao` date NOT NULL,
  `vistoPorUltimo` datetime DEFAULT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `convidados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_convidados_usuarios` (`idusuario`);

ALTER TABLE `convidados`
  ADD CONSTRAINT `fk_convidados_usuarios` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`);