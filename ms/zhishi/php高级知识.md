#php底层运行机制与原理

php是一个用C语言实现的包含大量组件的软件框架

##1.php的设计理念和特别

1. 多线程模式，不同请求互不相干，保证了一个请求挂掉不会对全盘富足造成影响
2. 弱类型语言：
3. 引擎（zend） + 组件的模式降低内部的耦合
4. 中间层（sapi）（*服务端应用编程接口，提供了一个接口，是php与其他应用进行交互数据*） 隔绝web server 和php
	
##2.php的四层体系

APPLOCATION (APACHE,CLI)

SAPI

PHP  PHP API(STRAMS OUTPUT)
	 EXTENSIONS(MYSQL ...)
	 
ZEND API  ZEND EXTENSION API

ZEND ENGINE

脚本执行的开始都是以SAPI接口实现开始的。只是不同的SAPI接口实现会完成他们特定的工作， 例如Apache的mod_php SAPI实现需要初始化从Apache获取的一些信息，在输出内容是将内容返回给Apache， 其他的SAPI实现也类似。

### php四层结构解析
* zend 引擎： 用c 实现，是php 内核部分，他将php代码翻译为可执行的opcode的处理并实现相应的处理方法，实现了基本的数据结构，内存分配和管理，提供了相应的api方法供外部调用，是一切的核心。
* extensions：围绕zend引擎，extensions通过组件式的方式提供了各种基础服务，我们常见的各种内置函数，标准库都是通过extension来实现
* sapi ，服务端应用编程接口，sapi通过一些列钩子函数，是php可以和外围交互数据
* 上层应用：平时编写的

###SAPI 提供了一个和外部通信的接口，默认提供了很多SAPI 

1. **CLI : 命令行运行**
	php 的命令行模式，大家经常会用到它
	
2. **CGI ：通用网关接口**
	通俗的讲，CGI就像一座桥，把网页和web服务器中的执行程序连接起来，它把html接受的指令传给服务器的执行程序，再把服务器执行程序的结果返回给html

3. **FAST-CGI： 常驻型的通用网关接口**
	fast-cgi 是cgi 的升级版本，fastcgi 像是一个常驻型的cgi，他可以一直执行，只要激活后，不会每次都花时间去fork一次
	
	** 工作原理 **
	
	1. web server 启动时载入fastcgi 进程管理器（fpm）
	2. fast-cgi 进程管理器自身初始化，启动多个cgi解释器进程（在任务管理器中可见多个php-cgi.ext），并等待来自webserver 的链接
	3. 当客户端请求达到webserver 时，fastcgi进程管理器选择连接到一个cgi解释器，webserver 将cgi环境变量和标准输入发送到fastcgi子进程php-cgj
	4. fascgi子进程，完成处理后，将标准结果和错误信息从同一连接返回webserver	
	
4. **WEB 模块模式:**
	模块模式是以mod_php5 模块的形式集成，此时mod_php5模块的作用是接受apache 传递过来的php文件请求，并处理这些请求，然后将结果返回给apache；
	apache2handler：这是以apache作为webserver，采用mod_PHP模式运行时候的处理方式，也是现在应用最广泛的一种


#php 执行opcode

**开始** -> **将php语言转换为语言片段**->**将tokens 转换成简单而有意义的表达式**->**将表达式编译成opcode**->**顺次执行opcode，从而实现php脚本的功能**


#hashTable 核心数据结构
1. hashTable 中包含两种数据结构，一个链表散列，一个双线量表，前者用于进行快速键值查找，后者方便现行遍历和排序，一个bucket同时存在于这两个数据结构中

	
	
	