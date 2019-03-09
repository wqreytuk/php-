这个代码的主要作用就是对于相同的页面进行缓存，这样就用不着每次用户去访问的时候都生成新的页面

在实际过程中，生成页面的过程可能需要查询数据库，这是很浪费服务器资源的

我们对于同样的html页面，只要不超过一小时就让其访问之前已经存在的html文件

如果该html文件是第一次访问，那么久进行动态的生成

我们在第一开始虚构了不存在的html文件，使用.htaccess控制其被转到staticfile.php进行处理

内容如下：

  RewriteEngine on
  RewriteRule ([a-z0-9]+\.html)$ /staticfile.php?$1
  
  $1代表的就是()中的那个html文件

然后我们把这个.htaccess文件放入post文件夹下，访问

  localhost/post/test.html

重写之后的url就变成了:

  localhost/staticfile.php?test.html
  
 staticfile.php文件取出 $_SERVER中的QUERY_STRING所对应的值，也就是test.html，之后创建test.html，然后将特定的内容写入到test.html文件中
