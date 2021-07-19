<div class="adminP question text-center d-none">
  <h3>اسئلة التقديم</h3>
  <br>
  <table class="table table-responsive-sm">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">السؤال</th>
        <th scope="col">الحالة</th>
      </tr>
    </thead>
    <tbody>
		<?php
  	$data = $questions->fetchAll();
	$last_key =array_key_last($data);
	foreach($data as $p){
		?>
      <tr>
        <th scope="row"><?=$p['id'];?></th>
        <td><?=$p['text'];?></td>
		<td> <a onclick="edit(<?=$p['id'];?>)"><i class="fas fa-edit"></i></a>
		<?php if($p['id'] - 1 == $last_key){?>
         <a href="#"><i class="fas fa-window-close"></i></a>
		 <a href="#"><i class="fas fa-plus"></i></a>
		<?php
		}
		?>
		</td>
      </tr>
	<?php
	  
	}
	
	?>

    </tbody>
  </table>
</div>
