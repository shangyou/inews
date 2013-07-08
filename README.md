iNews
=====

要求
-----

- PHP 5.3.9+
- Composer (`brew install composer` or [composer](http://getcomposer.org))
- Apache
- Mysql 5.0+
- Git

安装
-----

- `git clone git@github.com:sofish/iNews.git`
- 配置Apache到`public`目录，并且对该目录打开`AllowOverride All`
- 配置环境
  - 开发环境检查`config/develop.php`，如果数据库配置跟本地一样就无需配置
  - 如果不同，否则新建`config/环境名.php`
  - 如果是Apache新增`SetEnv PAGON_ENV 环境名`，如果是Nginx+FPM，则需要在FPM设置`env[PAGON_ENV] = 环境名`
  - 命令行`export PAGON_ENV=环境名`
  - 公网环境配置相同
- `cd 程序目录`
- 安装依赖：`composer update`
- 初始化数据库：`./bin/task db:init`
- 升级数据库：`./bin/task db:migrate`


其他用法：

```
usage: ./bin/task db:init [-h|--help] [-f|--force] [-d|--data]

optional arguments:
    -h, --help          help of the command
    -f, --force         Force create database
    -d, --data          Insert test data
```

- 安装完成
