-- https://app.sqldbm.com/SQLServer/Share/OUowjyeG8Xw6QvHAP8TIZkGFrngIE8md_DYjF4jNYw0

-- Base de données: `beautifen`
--

-- --------------------------------------------------------

--
-- Structure de la table `CART`
--

CREATE TABLE IF NOT EXISTS `CART` (
  `id_cart` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_cart`,`id_product`,`id_user`),
  KEY `FK_cart_product` (`id_product`),
  KEY `FK_cart_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ORDERS`
--

CREATE TABLE IF NOT EXISTS `ORDERS` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `date_order` date NOT NULL,
  `total_amount` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id_order`,`id_user`,`id_product`),
  KEY `FK_order_user` (`id_user`),
  KEY `FK_order_product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `PRODUCT`
--

CREATE TABLE IF NOT EXISTS `PRODUCT` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `new` bit(1) NOT NULL,
  `sale` bit(1) NOT NULL,
  `sale_price` decimal(6,2) NOT NULL,
  `image_path` varchar(200) NOT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `PRODUCT`
--

INSERT INTO `PRODUCT` (`id_product`, `type`, `name`, `brand`, `price`, `new`, `sale`, `sale_price`, `image_path`) VALUES
(1, 'hlt', 'Blossom', 'Lime Crime', '42.00', b'0', b'1', '29.00', 'path'),
(2, 'hlt', 'iluvsarahii', 'Dose of Colors', '28.99', b'0', b'0', '0.00', 'path'),
(3, 'hlt', 'Liquid Frost', 'Jeffree Star Cosmetics', '35.00', b'0', b'0', '0.00', 'path'),
(4, 'hlt', 'Face Quad Ignite', 'Makeup revolution', '12.99', b'0', b'0', '0.00', 'path'),
(5, 'hlt', 'SKIN FROST: Ice Cold', 'Jeffree Star Cosmetics', '25.00', b'0', b'0', '0.00', 'path'),
(6, 'hlt', 'Subtle Summer Glow', 'Makeup revolution', '9.95', b'0', b'0', '0.00', 'path'),
(7, 'hlt', 'Revolution Pro Glow 2', 'Makeup revolution', '11.99', b'0', b'0', '0.00', 'path'),
(8, 'hlt', 'Dew Dreamer', 'Laura Geller', '34.00', b'0', b'0', '0.00', 'path'),
(9, 'hlt', 'Gleam That Glow', 'Anastasia Beverlyhills', '36.90', b'0', b'0', '0.00', 'path'),
(10, 'hlt', 'Dream Glow Kit', 'Anastasia Beverlyhills', '34.99', b'0', b'0', '0.00', 'path'),
(11, 'hlt', 'Love You So Mochi', 'NYX', '9.95', b'0', b'0', '0.00', 'path');

-- --------------------------------------------------------

--
-- Structure de la table `USER`
--

CREATE TABLE IF NOT EXISTS `USER` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `firstname` varchar(15) NOT NULL,
  `name` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `password` varchar(150) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `CART`
--
ALTER TABLE `CART`
  ADD CONSTRAINT `FK_cart_product` FOREIGN KEY (`id_product`) REFERENCES `PRODUCT` (`id_product`),
  ADD CONSTRAINT `FK_cart_user` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id_user`);

--
-- Contraintes pour la table `ORDERS`
--
ALTER TABLE `ORDERS`
  ADD CONSTRAINT `FK_order_user` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id_user`),
  ADD CONSTRAINT `FK_order_product` FOREIGN KEY (`id_product`) REFERENCES `PRODUCT` (`id_product`);
--
-- Base de données: `c9`
--