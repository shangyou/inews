# 环境要求

- PHP 5.3.9+
  - php-mcrypt
  - php-pdo
  - php-pdo-mysql
  - php-mbstring
- Composer (`brew install composer` or [composer](http://getcomposer.org))
- Apache/Nginx
- Mysql 5.1+

# 安装

> 如果是cPannel等虚拟主机，需要在相应界面进行修改，不需要操作命令行

## 获取源代码

```
git clone git@github.com:trimidea/inews.git
cd 程序根目录
composer install
```

## 配置环境

```
export PAGON_ENV=production
```

## 修改配置

```
cd 程序根目录
cp config/default.php config/production.php
vim config/production.php
```

> 具体说明可以参照 [配置说明](./Setup.md)

## 初始化

```
./bin/task db:init
./bin/task db:migrate
```

> 用来初始化和升级数据库表

## 定时任务

```
*/10 * * * * 程序根目录/bin/task job:point
```

> 用来计算积分和排名

## 配置主机

### 如果是Apache

```
<VirtualHost *:80>
    DocumentRoot "程序根目录/public"
    ServerName example.com
    SetEnv PAGON_ENV production

    <Directory 程序根目录>
        Options FollowSymLinks
        AllowOverride All
        Order deny,allow
        Allow from all
    </Directory>
</VirtualHost>
```

### 如果是Nginx+FPM

```
server {
    listen 80;

	root 程序根目录/public;
	index index.php index.html index.htm;

	server_name example.com;

	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~* \.(?:ico|css|js|gif|jpe?g|png)$ {
		expires 30d;
 		add_header Pragma public;
		add_header Cache-Control "public";
	}

	location ~ \.php$ {
		fastcgi_pass 127.0.0.1:9001;
		fastcgi_index index.php;
		include fastcgi_params;
	}

	location ~ /\.ht {
		deny all;
	}
}
```

FPM配置添加环境变量

```
env[PAGON_ENV] = production
```

问题
-----

Q: Windows下可否安装？
> Window下没做测试，理论上可以安装成功，但可能会存在一定问题

Q: 如果页面没有任何输出怎么办？
> 配置文件中开启Debug模式，添加`"debug" => true`，检查问题，无法解决反馈给我

Q: 页面输出不完整或者接口响应失败?
> 大部分情况是UTF-8 BOM造成，不要使用记事本编辑，如果造成，建议拷贝出内容使用其它编辑器编辑