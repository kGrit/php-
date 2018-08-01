
<?php 
function add(){
  // $date=array();
  //验证文本文件
  $date['id']=uniqid();
  if(empty($_POST['title'])){
    $GLOBALS['error_message']='请输入音乐标题';
    return;
  }
  if(empty($_POST['artist'])){
    $GLOBALS['error_message']='请输入歌手名称';
    return;
  }
  $date['title']=$_POST['title'];
  $date['artist']=$_POST['artist'];



//========验证图片提交==========
//1.验证文本域
//2。验证错误信息
//3.大小
//4.类型
//5.移动文件

if(empty($_FILES['images'])){
  $GLOBALS['error_message']='请正常使用表单';
  return;
}

$images = $_FILES['images'];
  // $data['images'] = array();
// var_dump($images);
for($i=0;$i<count($images['name']);$i++){

  if($images['error'][$i]!==UPLOAD_ERR_OK){
    $GLOBALS['error_message']='上传文件失败';
    return;
  }

  if($images['size'][$i]> 5 * 1024 *1024){
    $GLOBALS['error_message']='上传文件过大';
    return;
  }
  
  if(strpos($images['type'][$i],'image/')!==0){
    $GLOBALS['error_message']='无法识别格式';
    return;
  }

  $target='./uploads/'.uniqid().$images['name'][$i];
  if(!move_uploaded_file($images['tmp_name'][$i],$target)){
    $GLOBALS['error_message']='移动文件失败';
    return;
  }
  $date['images'][]='/music-last'. substr($target,1);
}
// $dest = './uploads/' . uniqid() . $images['name'][$i];
//     if (!move_uploaded_file($images['tmp_name'][$i], $dest)) {
//       $GLOBALS['error_message'] = '上传海报文件失败2';
//       return;
//     }

//     $date['images'][] ='/music-last'. substr($dest, 2);
//   }

//==========音乐文件=========
//判断存在 错误 大小 类型 移动
if(empty($_FILES['source'])){
  $GLOBALS['error_message']='请正常使用表单';
  return;
}

$source=$_FILES['source'];

if($source['error']!==UPLOAD_ERR_OK){
  $GLOBALS['error_message']='上传文件有误';
  return;
}
if($source['size']> 10 *1024 *1024){
  $GLOBALS['error_message']='上传文件过大';
  return;
}

if(strpos($source['type'],'audio/')!==0){
  $GLOBALS['error_message']='音乐文件类型不识别';
  return;
}

$target='./uploads/' . uniqid() . $source['name'];
if(!move_uploaded_file($source['tmp_name'],$target)){
  $GLOBALS['error_message']='移动文件失败';
  return;
}
 $date['source']='/music-last'. substr($target,1);
// var_dump($date);
//将JSON文件拿来
// $content=json_decode(file_get_contents('data.json'),true);
// array_push($content,$date);
// $new_con=json_encode($content);
// file_put_contents('data.json',$new_con);
 $json = file_get_contents('data.json');
  $old = json_decode($json, true);
  array_push($old, $date);
  $new_json = json_encode($old);
  file_put_contents('data.json', $new_json);

//网页重定向
header('Location: list.php');
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
 add();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>添加新音乐</title>
  <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
  <div class="container py-5">
    <h1 class="display-4">添加新音乐</h1>
    <hr>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="form-group">
        <label for="title">标题</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="form-group">
        <label for="artist">歌手</label>
        <input type="text" class="form-control" id="artist" name="artist">
      </div>
      <div class="form-group">
        <label for="images">海报</label>
        <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
      </div>
      <div class="form-group">
        <label for="source">音乐</label>
        <input type="file" class="form-control" id="source" name="source" accept="audio/*">
      </div>
      <button class="btn btn-primary btn-block">保存</button>
      
     <?php  if(isset($error_message)): ?>
      <div>
      <?php echo $error_message; ?>
      </div>
    <?php endif ?>
    </form>
  </div>
</body>
</html>
