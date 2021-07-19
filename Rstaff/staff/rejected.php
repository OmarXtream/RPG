<div class="adminP rejected text-center d-none">
  <h3>المرفوضين</h3>
  <br>
  <table class="table table-responsive-sm">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">الإسم</th>
        <th scope="col">البريد</th>
        <th scope="col">الإجرائات</th>
      </tr>
    </thead>
    <tbody>
	<?php
	foreach($AReject as $p){

		?>
       <tr class="ap-<?= $p['id']; ?>">
        <th scope="row"><?=$p['id'];?></th>
        <td><?=$p['username'];?></td>
        <td><?=$p['email'];?></td>
        <td> <a onclick="getinfo(<?= $p['id']; ?>)"><i class="fas fa-info-circle" style="color:blue" title="معلومات"></i></a>
      &nbsp; <a onclick="switcher(<?= $p['id']; ?>,1)"><i class="fas fa-arrow-right" style="color:grey" title="إرجاع"></i></a>
		</td>
      </tr>
	<?php
	  
	}
	
	?>
    </tbody>
  </table>
</div>
