1.nginx 相对于apache 的优点
轻量级,同样的web服务,比apache占用更少的内存和资源
抗并发,nginx 处理请求是异步非阻塞的,而apache是阻塞型的,在高并发下nginx能保持低资源低消耗高性能
高度模块化的设计,编写模块相对简单

2.apache相对于nginx的有点
rewrite 比nginx的rewrite强大
模块超多
稳定

3.作为web服务器,相比apache,nginx 使用更少的资源,支持更多的并发连接,体现更高的效率


4.nginx 配置简洁,apache 配置负杂

5.最核心的区别在于apache是同步多进程模型,一个连接对应一个进程;nginx 是异步的,多个连接(万级别的)可以对应一个进程


6.nginx 处理静态文件好,耗费内存少

7.nginx 负载能力比apache高很多

8.nginx本身一个反向代理服务器,nginx支持7层负载均衡,
