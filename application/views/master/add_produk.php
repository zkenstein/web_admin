<div class="col-md-12 mb-4 mt-4" id="add_produk">
  <div class="card">
    <div class="card-header">
<<<<<<< HEAD
      <strong>Daftar Produk</strong>
    </div>

    <div class="card-body table-responsive col-md-8">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Nama Produk</label>
        <div class="col-md-3">
          <input type="text" id="nama_produk" name="nama_produk" class="form-control">
        </div>

        <label class="col-md-3 col-form-label" for="text-input">Nama Vendor</label>
        <div class="col-md-3">
          <select class="form-control" name="vendor" id="vendor">
            <option value=''>Select</option>
=======
      <a href="javascript:getPageMaster('produk')"><strong>Daftar Produk</strong></a>
      |
      <a href="javascript:getPageMaster('tambah')"><strong>Input Produk</strong></a>
    </div>

    <form action="" method="post" id="produk_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body table-responsive col-md-12">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Nama Produk</label>
        <div class="col-md-4">
          <input type="text" id="nama_produk" name="nama_produk" class="form-control">
        </div>

        <label class="col-md-2 col-form-label" for="text-input">Nama Vendor</label>
        <div class="col-md-4">
          <select class="form-control" name="vendor" id="vendor">
            <option value=''>Select</option>
            <?php
              foreach($vendor as $result)
              {
                echo "<option value='".$result->id."'>".$result->nama_vendor."</option>";
              }
            ?>
>>>>>>> am
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Singkatan</label>
<<<<<<< HEAD
        <div class="col-md-3">
          <input type="text" id="singkatan" name="singkatan" class="form-control">
        </div>

        <label class="col-md-3 col-form-label" for="text-input">Kode Produk Vendor</label>
        <div class="col-md-3">
=======
        <div class="col-md-4">
          <input type="text" id="singkatan" name="singkatan" class="form-control">
        </div>

        <label class="col-md-2 col-form-label" for="text-input">Kode Produk Vendor</label>
        <div class="col-md-4">
>>>>>>> am
          <input type="text" id="kd_vendor" name="kd_vendor" class="form-control">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Jenis Produk</label>
<<<<<<< HEAD
        <div class="col-md-3">
          <select class="form-control" name="jenis_produk" id="jenis_produk">
            <option value=''>Select</option>
          </select>
        </div>

        <label class="col-md-3 col-form-label" for="text-input">Kode Produk</label>
        <div class="col-md-3">
=======
        <div class="col-md-4">
          <select class="form-control" name="jenis_produk" id="jenis_produk">
            <option value=''>Select</option>
            <?php
              foreach($jenisproduk as $result)
              {
                echo "<option value='".$result->id."'>".$result->nama_jenis."</option>";
              }
            ?>
          </select>
        </div>

        <label class="col-md-2 col-form-label" for="text-input">Kode Produk</label>
        <div class="col-md-4">
>>>>>>> am
          <input type="text" id="kd_produk" name="kd_produk" class="form-control">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Keterangan</label>
<<<<<<< HEAD
        <div class="col-md-9">
          <textarea id="keterangan" name="keterangan" rows="3" class="form-control"></textarea>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-md-3">
          <button type="submit" id="produk_submit" class="btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
          <button type="reset" id="produk_reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
        </div>
      </div>
    </div>

    <div class="card-body table-responsive col-md-8">
      <table class="table table-bordered" id="tabelProduk">
          <thead>
            <tr>
              <th>Nama Produk</th>
              <th>Singkatan</th>
              <th>Jenis Produk</th>
              <th>Vendor</th>
              <th>Status</th>
            </tr>
          </thead>
        </table>
    </div>

    <div class="card-footer">

=======
        <div class="col-md-10">
          <textarea id="keterangan" name="keterangan" rows="3" class="form-control"></textarea>
        </div>

<!--         <label class="col-md-2 col-form-label" for="text-input">Status</label>
        <div class="col-md-4">
          <select class="form-control" name="jenis_produk" id="jenis_produk">
            <option value=''>Select</option>
            <option value='1'>Aktif</option>
            <option value='2'>Tidak Aktif</option>
          </select>
        </div>
 -->      </div>

    </div>
    </form>

    <div class="card-footer">
          <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="add_produk_form(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
          <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" onclick="resetProduk(event)"><i class="fa fa-ban"></i> Reset</button>
>>>>>>> am
    </div>
  </div>
</div>