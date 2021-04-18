<?php
//   //实列化
//   $redis=new Redis();
// //链接地址和端口
//   $host='192.168.1.8';
//   $post=6379;
// //链接redis服务器
//   $redis->connect($host,$post);
// //设置值
//   $redis->set('windows','windows testing');
// //获取值
//   $data=$redis->get('windows');
//   echo  $data;
//   
// /链接数据库
		$link=mysqli_connect("127.0.0.1","root","root","php46_tp5");
		  mysqli_query($link,'set names utf8');
		  $sql='select * from tp5_goods';
		
function inquiry_redis($sql)
{

	
    //实例化redis对象
      $redis = new Redis();
      $host='192.168.1.8';
      $post=6379;
    //连接redis
    $redis->connect($host,$post);
 
    $key = md5($sql);
    $data = $redis->get($key);//如果有data,此时应该是一个json字符串
    dump($data);die;
    if(!$data)
          {
 
        try{
        	echo'1222';
        }catch(PDOException $e)
          {
            die("pdo连接失败:".$e->getMessage());
        }
 
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = json_encode($stmt->fetchAll(2));//将从数据库取到的数据转化为json字符串(为了存储到redis中)
        $redis->set($key,$data);
 
    }
    return json_decode($data);//返回数组格式的数据
 
}
 
inquiry_redis($sql);
 

?>