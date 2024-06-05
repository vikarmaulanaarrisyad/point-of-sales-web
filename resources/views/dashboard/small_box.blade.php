 <div class="row">

     @can('Total Produk')
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
     @endcan

     @can('Total Kategori')
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
     @endcan

     @can('Total Pelanggan')
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
     @endcan

     @can('Total Karyawan')
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
     @endcan
 </div>


 <div class="row">
     @can('Total Penjualan Harian')
         <div class="col-lg-6 col-6">
             <div class="small-box bg-primary">
                 <div class="inner">
                     <h3>{{ format_uang($totalSalesToday) }}</h3> <!-- Contoh akses nilai untuk tanggal tertentu -->
                     <p>Total Penjualan Harian</p>
                 </div>
                 <div class="icon">
                     <i class="fas fa-shopping-cart"></i>
                 </div>
                 <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
     @endcan
     @can('Total Laba Harian')
         <div class="col-lg-6 col-6">
             <div class="small-box bg-secondary">
                 <div class="inner">
                     <h3>{{ format_uang($dailyProfit) }}</h3> <!-- Sesuaikan dengan variabel yang menyimpan laba perhari -->
                     <p>Total Laba Harian</p>
                 </div>
                 <div class="icon">
                     <i class="fas fa-dollar-sign"></i>
                 </div>
                 <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
     @endcan
 </div>
