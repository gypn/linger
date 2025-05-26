<?php

use Linger\NoahBuscher\Macaw\Macaw;

// 路由项避免使用public目录中存在同名目录：pages、static、upload、examples... 


// 默认首页 /
Macaw::get('/', function () {
    echo 'hello, world!';
});
