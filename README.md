# mongodb

## 参考协议
- https://docs.mongodb.com/manual/reference/mongodb-wire-protocol/
- https://github.com/mongodb/mongo-php-library

## BSON

php没有自带的bson等转换工具，因此我们可以要求用户安装 mongodb的官方拓展，我们用协成客户端重写收发包即可。

```
$array = [
    'a'=>1
];

use function MongoDB\BSON\fromPHP;
use function MongoDB\BSON\toPHP;


$binary = fromPHP($array);
var_dump(toPHP($binary));
```
