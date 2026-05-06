create table disciplina (
    id_disciplina serial primary key,
	id_usuario int not null,
    nome varchar(50) not null,
    importancia smallint check (importancia between 1 and 3),
	cor varchar(15)  default '#D3D3D3' not null,
	tempo_de_estudo int default 0 not null,
	foreign key(id_usuario) references usuario(id_usuario)
);

create table auditoria_estudo(
	id_auditoria_estudo serial primary key,
	id_disciplina int not null,
	dia_hora_inicio timestamp not null,
	dia_hora_fim timestamp not null,
	foreign key(id_disciplina) references disciplina(id_disciplina)
);