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

9.原因
采用的epoll 网络I/O模型
处理大量的连接的读写，Apache所采用的select网络I/O模型非常低效。

假设你在大学读书，住的宿舍楼有很多间房间，你的朋友要来找你。

select版宿管大妈就会带着你的朋友挨个房间去找，直到找到你为止。

而epoll版宿管大妈会先记下每位同学的房间号，

你的朋友来时，只需告诉你的朋友你住在哪个房间即可，不用亲自带着你的朋友满大楼找人。

如果来了10000个人，都要找自己住这栋楼的同学时，select版和epoll版宿管大妈，谁的效率更高，不言自明。

同理，在高并发服务器中，轮询I/O是最耗时间的操作之一，select和epoll的性能谁的性能更高，同样十分明了。

在linux的网络编程中，很长的时间都在使用select来做事件触发。

在linux新的内核中，有了一种替换它的机制，就是epoll。

相比于select，epoll最大的好处在于它不会随着监听fd数目的增长而降低效率。

因为在内核中的select实现中，它是采用轮询来处理的，轮询的fd数目越多，自然耗时越多。




