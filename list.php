<?php 
 $content=json_decode(file_get_contents('data.json'),true);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>音乐列表</title>
  <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
  <div class="container py-5">
    <h1 class="display-4">音乐列表</h1>
    <hr>
    <div class="mb-3">
      <a href="add.php" class="btn btn-secondary btn-sm">添加</a>
    </div>
    <table class="table table-bordered table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th class="text-center">标题</th>
          <th class="text-center">歌手</th>
          <th class="text-center">海报</th>
          <th class="text-center">音乐</th>
          <th class="text-center">操作</th>
        </tr>
      </thead>
      <tbody class="text-center">
      <?php foreach ($content as $value): ?>
        <tr>
          <td> <?php echo $value['title'];?></td>
          <td> <?php echo $value['artist']; ?></td>
          <td>
          <?php foreach ($value['images'] as $item): ?>
           <img src="<?php echo $item; ?>" alt=""> 
          <?php endforeach ?>
           </td>
          <td><audio src="<?php echo $value['source']; ?>" controls></audio></td>
          <td class="btn btn-danger btn-sm"><a href="delete.php?id=<?php echo $value['id'];?>">删除</a></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</body>
</html>
