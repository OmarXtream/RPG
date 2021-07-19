<div class="adminP search d-none text-center">
  <h3>البحث المتقدم</h3>
  <br>
  <!-- <div class="searchForm">
    <form>
      <div class="form-row">
        <div class="col-md-3">
          <select class="custom-select mr-sm-2" id="sectionChoose">
            <option selected disabled>القسم</option>
            <option value="1">تحت المراجعة</option>
            <option value="2">المقبولين</option>
            <option value="3">المرفوضين</option>
            <option value="4">الداعمين</option>
          </select>
        </div>
        <div class="col-md-3">
          <select class="custom-select mr-sm-2" id="searchType">
            <option selected disabled>نوع البحث</option>
            <option value="1">الإسم</option>
            <option value="2">البريد الإلكتروني</option>
          </select>
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" placeholder="نص البحث">
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary">بحث</button>
        </div>
      </div>
    </form>
  </div> -->

  <table class="table table-responsive-sm js-dataTable-full">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">الإسم</th>
        <th scope="col">البريد</th>
        <th scope="col">الحالة</th>
		<th scope="col">الإجرائات </th>
      </tr>
    </thead>
<tbody>
    <?php
foreach ($All as $p) {
?>
       <tr class="ap-<?= $p['id']; ?>">
            <th scope="row">
                <?= $p['id']; ?>
           </th>
            <td>
                <?= $p['username']; ?>
           </td>
            <td>
                <?= $p['email']; ?>
           </td>
            <td>
                <?= Cstatus($p['status']); ?>
           </td>
            <td>
                <a onclick="getinfo(<?= $p['id']; ?>)"><i class="fas fa-info-circle" style="color:blue" title="معلومات"></i></a>
                <?php
    if ($p['status'] == 1) {
?>
                   &nbsp; <a onclick="switcher(<?= $p['id']; ?>,2)"><i class="fas fa-check-circle" style="color:green" title="موافقة"></i></a> 
				   &nbsp; <a onclick="switcher(<?= $p['id']; ?>,3)"><i class="fas fa-times-circle" style="color:red" title="رفض"></i></a>
                    <?php
    } else {
?>
                       &nbsp; <a onclick="switcher(<?= $p['id']; ?>,1)"><i class="fas fa-arrow-right" style="color:grey" title="إرجاع"></i></a>

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
