<div class="wrapper">
  <div class="admin">
    <div class="container">
	<div class="jumbotron">
  <div class="row">
    <div class="col-md-6 col-lg-3 mt-2 mb-2">
      <div class="admin-card text-center">
        <h3><i class="fas fa-clipboard-list"></i> المتقدمين</h3>
        <h5><span class="badge badge-secondary"><?=$homeInfo['Py'];?></span></h5>
      </div>
    </div>

    <div class="col-md-6 col-lg-3 mt-2 mb-2">
      <div class="admin-card text-center">
        <h3><i class="fas fa-clipboard-check"></i> المقبولين</h3>
        <h5><span class="badge badge-success"><?=$homeInfo['Paccept'];?></span></h5>
      </div>
    </div>

    <div class="col-md-6 col-lg-3 mt-2 mb-2">
      <div class="admin-card text-center">
        <h3><i class="fas fa-sad-tear"></i> المرفوضين</h3>
        <h5><span class="badge badge-danger"><?=$homeInfo['Preject'];?></span></h5>
      </div>
    </div>

    <div class="col-md-6 col-lg-3 mt-2 mb-2">
      <div class="admin-card text-center">
        <h3><i class="fa fa-user-secret" aria-hidden="true"></i> الداعمين</h3>
        <h5><span class="badge badge-info"><?=$homeInfo['donaters'];?></span></h5>
      </div>
    </div>
  </div>
</div>
