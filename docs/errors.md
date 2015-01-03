Errors when developing
====

sql escape
----
### Desc
do not escape input value before insert, and cause insert error
### Resolve
use pdo prepare and execute function, it will escape automatically