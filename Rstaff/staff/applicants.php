<div class="adminP applicants text-center">
  <h3>المتقدمين</h3>
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
	foreach($allp as $p){
		?>
       <tr class="ap-<?= $p['id']; ?>">
        <th scope="row"><?=$p['id'];?></th>
        <td><?=$p['username'];?></td>
        <td><?=$p['email'];?></td>
        <td><a onclick="getinfo(<?= $p['id']; ?>)"><i class="fas fa-info-circle" style="color:blue" title="معلومات"></i></a> &nbsp; 
            <a onclick="switcher(<?= $p['id']; ?>,2)"><i class="fas fa-check-circle" style="color:green" title="موافقة"></i></a> 
     &nbsp; <a onclick="switcher(<?= $p['id']; ?>,3)"><i class="fas fa-times-circle" style="color:red" title="رفض"></i></a>
		</td>
      </tr>
	<?php
	  
	}
	
	?>
    </tbody>
  </table>
</div>
