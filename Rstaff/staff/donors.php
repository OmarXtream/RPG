 <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">


<div class="adminP donors text-center d-none">
  <h3>الداعمين</h3>
  <br>
  <table class="table table-responsive-sm js-dataTable-full" data-order='[[ 1, "desc" ]]'>
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">البريد</th>
        <th scope="col">الدسكورد</th>
        <th scope="col">الباقة</th>
      </tr>
    </thead>
    <tbody>
	
			<?php
	foreach($dons as $p){
		?>
		<tr>
        <th scope="row"><?=$p['id'];?></th>
        <td><?=$p['email'];?></td>
        <td><?=$p['discord'];?></td>
        <td><?=$p['amount'];?></td>
      </tr>
	<?php
	  
	}
	
	?>
    </tbody>
  </table>
</div>
