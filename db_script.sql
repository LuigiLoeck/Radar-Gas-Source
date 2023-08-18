create database radargas;

use radargas;


-- Tabela Usuario

create table usuario (
cod_pessoa int unsigned auto_increment primary key,
nm_pessoa varchar(100) not null,
email varchar(100) not null,
cpf char(11) unique not null,
senha varchar(512) not null,
status boolean default false);


-- Tabela Bandeira

create table bandeiras (
cod_band int unsigned auto_increment primary key,
nm_band varchar(100) not null,
img_band varchar(300) not null
);



-- Tabela Postos

create table postos (
cod_posto int unsigned auto_increment primary key,
nm_posto varchar(200) not null,
cnpj char(14) unique not null,
endereco varchar(500) not null,
nota numeric(2,1) not null,
cod_band int unsigned not null,
foreign key (cod_band) references bandeiras(cod_band) on update cascade on delete cascade
);


-- Tabela Combustiveis

create table combustiveis (
cod_comb int unsigned auto_increment primary key,
nm_comb varchar(100) not null);


-- Tabelas de associações entre tabelas

-- Tabela Usuarios <-> Postos = Favoritos

create table favoritos (
cod_pessoa int unsigned,
cod_posto int unsigned,
foreign key (cod_pessoa) references usuario(cod_pessoa) on update cascade on delete cascade,
foreign key (cod_posto) references postos(cod_posto) on update cascade on delete cascade
);

-- Tabela Postos <-> Combustiveis = Vende

create table vende (
dt_registro timestamp default current_timestamp(),
cod_posto int unsigned,
cod_comb int unsigned,
valor numeric(4,3) not null,
primary key(dt_registro,cod_posto,cod_comb),
foreign key (cod_posto) references postos(cod_posto) on update cascade on delete cascade,
foreign key (cod_comb) references combustiveis(cod_comb) on update cascade on delete cascade
);


-- Tabela Recuperação de senha

create table recuperacao (
  user  varchar(255) NOT NULL,
  user_key varchar(255) NOT NULL,
  KEY(user, user_key)
)








-- Aula 10/05

-- 1
select i.descricao, vi.quantidade 
from itens i join venda_itens vi using (codigo)
where vi.quantidade > 20 order by i.descricao;

select i.descricao, sum(vi.quantidade)
from itens i join venda_itens vi using (codigo)
group by (i.descricao) having sum(vi.quantidade) > 20 order by i.descricao;
-- 2
select to_char(cp.data_lancamento,'MM/YYYY'), sum(cp.valor) 
from contas_pagar cp group by (to_char(cp.data_lancamento,'MM/YYYY')) 
having sum(cp.valor)>10000;

-- 3
select c.nome, sum(v.valor_total_venda)
from clientes c join vendas v using (codcliente)
group by (c.nome) having sum(v.valor_total_venda)>2000;

-- 5
select i.descricao, count(vi.quantidade)
from itens i join venda_itens vi using (codigo)
group by (i.descricao) having count(vi.quantidade) > 2 order by i.descricao; 

-- 6
select i.descricao, to_char(sum(vi.valor),'L9G999G990D99')
from itens i join venda_itens vi using (codigo)
group by (i.descricao);

-- 7
select f.descricao, count(c.codigo) 
from fornecedores f join compras c on (f.codigo=c.codfornecedor)
group by (f.descricao);



-- Aula 24/05

-- 1
select os.numero 
from ordens_servico os 
where exists 
(select * from vendas v where v.numero=os.numero);

-- 2
select os.numero 
from ordens_servico os 
where not exists 
(select * from vendas v where v.numero=os.numero);

-- 3
select f.nome, v.count 
from funcionarios f left join 
(select count(v.codigo), v.codfunc from vendas v where to_char(v.dt_venda,'MM')='04' group by v.codfunc) as v 
on v.codfunc = f.codfunc; 

select f.nome, v.count 
from funcionarios f left join 
(select count(v.codigo), v.codfunc from vendas v where dt_venda > (current_date - interval '1' month) group by v.codfunc) as v 
on v.codfunc = f.codfunc; 

-- 4
select to_char(dt_venda,'MM'),count(v.codigo), to_char(sum(v.valor_total_venda),'L9G999G990D99') 
from vendas v where dt_venda > (current_date - interval '1' month) 
group by to_char(dt_venda,'MM');

-- 5
select os.count, v.count 
from (select count(os.numero) from ordens_servico os where os.data > (current_date - interval '1' month)) os,
(select count(v.codigo) from vendas v where v.dt_venda > (current_date - interval '1' month)) v;

-- 6
select sum(v.valor_total_venda),to_char(v.dt_venda,'MM')
		from vendas v where to_char(v.dt_venda,'YYYY')='2023' 
		group by to_char(v.dt_venda,'MM')
		order by sum desc
		limit 1;
	
select v.to_char from 
(select sum(v.valor_total_venda),to_char(v.dt_venda,'MM')
		from vendas v where to_char(v.dt_venda,'YYYY')='2023' 
		group by to_char(v.dt_venda,'MM')) as v 
		where (v.sum = (select max(v.sum) from 
		(select sum(v.valor_total_venda),to_char(v.dt_venda,'MM')
		from vendas v where to_char(v.dt_venda,'YYYY')='2023' 
		group by to_char(v.dt_venda,'MM')) v));	




-- Aula 31/05

-- 1
select string_agg(nome,', ') from funcionarios f ;

-- 2
select c.nome, array_agg(fc.num_telefone) from clientes c left join fones_clientes fc on (c.codcliente=fc.cliente) group by c.nome; 

-- 3
select f.nome, array_agg(v.codigo) from funcionarios f join vendas v using (codfunc) group by f.nome; 

-- 4
select c.nome, array_agg(i.descricao) from clientes c 
join vendas v using (codcliente) 
join venda_itens vi on (v.codigo=vi.codvenda) 
join itens i on (vi.codigo=i.codigo)
where to_char(v.dt_venda,'YYYY') = '2020'
group by c.nome;

-- 5
select i.descricao , sum(vi.quantidade) as soma from venda_itens vi 
join vendas v on (v.codigo=vi.codvenda)
join itens i on (vi.codigo = i.codigo)
where to_char(v.dt_venda,'YYYY') = '2020' 
group by i.descricao  order by soma desc limit 3

-- 6 
select to_char(v.dt_venda,'TMDay') from vendas v where to_char(v.dt_venda,'MM/YYYY') = '03/2023' group by dt_venda order by count(v.codigo) desc limit 1

select v.to_char from 
(select count(v.codigo),to_char(v.dt_venda,'TMDay')
		from vendas v where to_char(v.dt_venda,'YYYY')='2023' 
		group by v.dt_venda) as v 
		where (v.count = (select max(v.count) from 
		(select count(v.codigo)
		from vendas v where to_char(v.dt_venda,'YYYY')='2023' 
		group by v.dt_venda) v));	
		
		
-- Aula 14/06

-- 1
select i.descricao , sum(vi.quantidade) from itens i join venda_itens vi using (codigo) where i.descricao = 'tesoura cirúrgica 15 cm' group by i.descricao ;

-- 2
select i.descricao , to_char(sum(vi.quantidade  * i.valor),'L9G999G990D99') from itens i join venda_itens vi using (codigo) where i.descricao = 'tesoura cirúrgica 15 cm' group by i.descricao ;

-- 3
select i.descricao , sum(vi.quantidade) from itens i join venda_itens vi using (codigo) join vendas v on (v.codigo = vi.codvenda) where to_char(v.dt_venda,'yy') = '23' group by i.descricao ;

-- 4
select i.descricao from itens i join 
(select i2.codigo as codigo, sum(vi.quantidade) as qntd from itens i2
join venda_itens vi using (codigo) 
join vendas v on (v.codigo = vi.codvenda) 
where to_char(v.dt_venda,'yy') = '23' group by i2.codigo) as sub
on (i.codigo = sub.codigo) where sub.qntd < 5;

-- 5
select v.codigo , to_char(v.valor_total_venda,'L9G999G990D99') from vendas v 
join (select count(vi.sequencial), vi.codvenda from venda_itens vi group by vi.codvenda) as veit
on (v.codigo = veit.codvenda) where to_char(v.dt_venda,'yy') = '23' and veit.count > 1;

-- 6
select v.codigo from vendas v 
where to_char(v.dt_venda,'yy') = '23' 
and exists (select * from venda_itens vi join itens i using (codigo)
			where v.codigo = vi.codvenda and i.descricao = 'aparelho de pressão'); 
			
-- 7
select f.nome, string_agg(c.nome,', ') from funcionarios f 
join vendas v using(codfunc) join clientes c using (codcliente) 
 group by f.nome order by f.nome; 