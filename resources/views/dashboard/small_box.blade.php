 <div class="row">
     <div class="col-lg-3 col-6">

         <div class="small-box bg-info">
             <div class="inner">
                 <h3>{{ $totalProduk }}</h3>
                 <p>Total Produk</p>
             </div>
             <div class="icon">
                 <i class="fas fa-cubes"></i>
             </div>
             <a href="{{ route('product.index') }}" class="small-box-footer">More info <i
                     class="fas fa-arrow-circle-right"></i></a>
         </div>
     </div>

     <div class="col-lg-3 col-6">

         <div class="small-box bg-success">
             <div class="inner">
                 <h3>{{ $totalKategori }}</h3>
                 <p>Total Kategori</p>
             </div>
             <div class="icon">
                 <i class="fas fa-cube"></i>
             </div>
             <a href="{{ route('category.index') }}" class="small-box-footer">More info <i
                     class="fas fa-arrow-circle-right"></i></a>
         </div>
     </div>

     <div class="col-lg-3 col-6">
         <div class="small-box bg-warning">
             <div class="inner">
                 <h3>{{ $totalPelanggan }}</h3>
                 <p>Total Pelanggan</p>
             </div>
             <div class="icon">
                 <i class="fas fa-users"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
         </div>
     </div>

     <div class="col-lg-3 col-6">

         <div class="small-box bg-danger">
             <div class="inner">
                 <h3>{{ $totalKaryawan }}</h3>
                 <p>Total Karyawan</p>
             </div>
             <div class="icon">
                 <i class="fas fa-user-friends"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
         </div>
     </div>

 </div>
