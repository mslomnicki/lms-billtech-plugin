<?php
$this->Execute("
create table billtech_payment_links (
    id serial primary key,
    customer_id integer not null references customers(id) on delete cascade,
    src_cash_id integer not null references cash(id) on delete cascade,
    type varchar(255) not null,
    link varchar(2000) not null,
    short_link varchar(160) not null,
    token varchar(1000) not null,
    amount numeric(9,2) not null
);
");

$this->Execute("create index billtech_payment_links__customer_id on billtech_payment_links (customer_id);");
$this->Execute("create index billtech_payment_links__src_cash_id on billtech_payment_links (src_cash_id);");
$this->Execute("create index billtech_payment_links__token on billtech_payment_links (token);");

$this->Execute("alter table billtech_payments add column token varchar(1000);");
$this->Execute("create index billtech_payments__reference_number on billtech_payments(reference_number);");
$this->Execute("create index billtech_payments__closed_cdate on billtech_payments(closed, cdate);");
$this->Execute("create index billtech_payments__token on billtech_payments(token);");

$this->Execute("create table billtech_customer_info
(
    customer_id     	int    primary key,
    balance_update_time int
);

create index billtech_customer_info__customer_id on billtech_customer_info (customer_id);");

$this->Execute("UPDATE dbinfo SET keyvalue = ? WHERE keytype = ?", array('2020091900', 'dbversion_BillTech'));