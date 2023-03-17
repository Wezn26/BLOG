# ADMIN
```
LOGIN: admin
PASSWORD: 12345
hash: $2y$10$PpixGwQd3x1wXWqKKbsV0eFd7c3VdoBT9hLyEl4gvP0c5CKgA/ftq
```
```
$str = '12345';
$password = password_hash($str, PASSWORD_DEFAULT);
var_dump($password);
```