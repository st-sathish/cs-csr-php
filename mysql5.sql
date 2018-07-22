CREATE TABLE `csr`.`csr_user` (
  u_id BIGINT(20) NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  mobile VARCHAR(255) NULL,
  device_token TEXT NULL DEFAULT NULL,
  PRIMARY KEY (u_id)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE csr_role (
  r_id bigint(20) NOT NULL,
  description varchar(255) DEFAULT NULL,
  name varchar(128) DEFAULT NULL,
  PRIMARY KEY (r_id),
  CONSTRAINT UNQ_csr_role UNIQUE (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into csr_role(`r_id`,`name`,`description`) values(1,'ROLE_ADMIN', 'admin role');

CREATE TABLE csr_user_role (
  user_id bigint(20) NOT NULL,
  role_id bigint(20) NOT NULL,
  PRIMARY KEY (user_id,role_id),
  CONSTRAINT UNQ_csr_user_role UNIQUE (user_id, role_id),
  CONSTRAINT FK_csr_user_role_role_id FOREIGN KEY (role_id) REFERENCES csr_role (r_id),
  CONSTRAINT FK_csr_user_role_user_id FOREIGN KEY (user_id) REFERENCES csr_user (u_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE csr_categories (
  c_id bigint(20) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  created_by varchar(255) DEFAULT NULL,
  created_at DATETIME DEFAULT NULL,
  PRIMARY KEY (c_id),
  CONSTRAINT UNQ_csr_categories UNIQUE (c_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE csr_items (
  p_id bigint(20) NOT NULL AUTO_INCREMENT,
  item_name varchar(255) NOT NULL,
  barcode varchar(255),
  price varchar(255),
  expiry_date varchar(255),
  is_sold tinyint(1) DEFAULT 0,
  created_by varchar(255) DEFAULT NULL,
  created_at DATETIME DEFAULT NULL,
  category bigint(20) NOT NULL,
  is_removed tinyint(1) DEFAULT 0,
  modified_by varchar(255) DEFAULT NULL,
  modified_at DATETIME DEFAULT NULL
  PRIMARY KEY (p_id),
  CONSTRAINT FK_csr_items_category FOREIGN KEY (category) REFERENCES csr_categories (c_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into csr_user(`u_id`,`username`,`password`,`first_name`,`last_name`,`mobile`) values 
  (1, 'admin@gmail.com',MD5('admin'), 'Sathish', 'Thangathurai', '9944717544');

  CREATE TABLE `csr`.`csr_notification` (
  `n_id` INT NOT NULL AUTO_INCREMENT,
  `item_ids` TEXT NULL DEFAULT NULL,
  `event_date` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`n_id`));