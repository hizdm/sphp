# SPHP（A Simple PHP Framework） 一个简洁的PHP框架 ....

## 1.目录结构

```
sphp/
├── config
├── default
│   ├── controller
│   │   ├── base.class.php
│   │   └── index.class.php
│   ├── module
│   │   └── base.class.php
│   └── templates
│       └── index.html
├── framework
│   ├── controller
│   ├── include
│   ├── lib
│   ├── module
│   └── third
│       └── smarty-2.6.30
├── index.php
├── README.md
├── _templates_c
└── _templates_cache
```

结构说明：
* config（配置目录）
* default（默认项目可自由定义名称）
* framework（框架核心程序）
* _templates_c（smarty编译目录）
* _templates_cache（smarty缓存目录）
* index.php（单入口访问程序）

## 2.访问路径
* eg：http://example.com/index.php?site=default&ctl=index&act=index
* site：项目名称
* ctl：控制器名称
* act：方法名称

## 3.控制器命名规则
* eg：product.class.php（文件命名）
* /项目名称/controller/ （存放路径）

```
class controller_product extends controller_base
{
   public function __construct() {
      parent::__construct()
   }
}
```

## 4.模型命名规则
* eg：product.class.php（文件名称）
* /项目名称/module/ （存放路径）

```
class module_product extends module_base
{
   public function __construct() {
      parent::__construct()
   }
}
```

## 5.模板命名规则
模板文件存放路径为：/项目名称/templates/，文件后缀可遵循Smarty或自己设置

## 6.将引入Composer