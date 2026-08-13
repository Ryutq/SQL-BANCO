create database if not exists folhapag;
use folhapag;

create table if not exists folhapag(
	id_funcionario int(11) not null auto_increment,
    nome varchar(50) not null,
    salariobase float(10,2) not null,
    horasextras int(11) not null,
    valorhoras float(10,2) not null,
    dependentes int(11) not null,
    salbruto float(10,2) not null,
    salliquido float(10,2) not null,
    inss float(10,2) not null,
    Irenda float(10,2) not null,
    primary key(id_funcionario)
);

insert into folhapag values(null, 'Hamilton', 1000.00, 0,0,0,1000.00,900.00,30.00,70.00);

select * from folhapag;