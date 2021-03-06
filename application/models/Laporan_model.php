<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getProdukName()
  {
    // $this->db->select('nama_jenis');
    // $this->db->from('inm_jenis_produk');
    // return $this->db->get();
    return $this->db->get('inm_jenis_produk');
  }

  public function allLaporan($dari, $sampai){

    $str="SELECT
            Sum(IF( inm_produk.jenis_produk_id = 1, inm_transaksi_detail.lembar, 0)) AS PLN,
            Sum(IF( inm_produk.jenis_produk_id = 1, inm_transaksi_detail.total_tagihan, 0)) AS TotalTagihan_PLN,
            Sum(IF( inm_produk.jenis_produk_id = 2, inm_transaksi_detail.lembar, 0)) AS PDAM,
            Sum(IF( inm_produk.jenis_produk_id = 2, inm_transaksi_detail.total_tagihan, 0)) AS TotalTagihan_PDAM,

            inm_transaksi.user_id,
            inm_users.username
          FROM
            inm_transaksi_detail
          INNER JOIN inm_transaksi_detail_status ON inm_transaksi_detail_status.id = inm_transaksi_detail.status_id
          INNER JOIN inm_transaksi ON inm_transaksi_detail.transaksi_id = inm_transaksi.id
          INNER JOIN inm_produk ON inm_transaksi_detail.produk_id = inm_produk.id
          INNER JOIN inm_users ON inm_transaksi.user_id = inm_users.id
          WHERE DATE(inm_transaksi.tgl_transaksi)>='".$dari."' AND DATE(inm_transaksi.tgl_transaksi) <= '".$sampai."'
          GROUP BY
            inm_transaksi.user_id";
            // inm_transaksi.tgl_transaksi,
      return $this->db->query($str);
  }
  
  public function allLaporanPeriode($dari_, $sampai_){

  $str="SELECT
        Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_detail.lembar,0)) AS PLN,
        Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_detail.total_tagihan,0)) AS TotalTagihan_PLN,
        Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_detail.lembar,0)) AS PDAM,
        Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_detail.total_tagihan,0)) AS TotalTagihan_PDAM,
        inm_transaksi.tgl_transaksi
      FROM
        inm_transaksi_detail
      INNER JOIN inm_transaksi_detail_status ON inm_transaksi_detail_status.id = inm_transaksi_detail.status_id
      INNER JOIN inm_transaksi ON inm_transaksi_detail.transaksi_id = inm_transaksi.id
      INNER JOIN inm_produk ON inm_transaksi_detail.produk_id = inm_produk.id
      INNER JOIN inm_users ON inm_transaksi.user_id = inm_users.id
      WHERE
      DATE(inm_transaksi.tgl_transaksi) >= '".$dari_."' AND DATE(inm_transaksi.tgl_transaksi) <= '".$sampai_."'
      GROUP BY
        inm_transaksi.tgl_transaksi";
      return $this->db->query($str);
  }

  public function getAllLaporanToday($dari)
  {
      $this->datatables->select('td.id_pelanggan,p.nama_lengkap,td.nama_pelanggan,t.tgl_transaksi,td.lembar,td.jumlah_tagihan,td.total_tagihan,td.biaya_admin');
      $this->datatables->from('inm_transaksi_detail'. ' td');
      $this->datatables->join('inm_transaksi'. ' t', 'td.transaksi_id = t.id');
      $this->datatables->join('inm_produk'. ' p', 'td.produk_id = p.id');
      $this->datatables->where('DATE(t.tgl_transaksi) >=', $dari);
      return $this->datatables->generate();

  }  

  public function laporan_giry_bayar_per_tanggal($from, $to, $datas){

  // $str="SELECT
  //       Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.jumlah_transaksi,0)) AS PLN,
  //       Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PLN,
  //       Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.jumlah_transaksi,0)) AS PDAM,
  //       Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PDAM,
  //       inm_transaksi_griya.tanggal
  //     FROM
  //       inm_transaksi_griya
  //     INNER JOIN inm_produk ON inm_transaksi_griya.produk_id = inm_produk.id
  //     WHERE
  //     DATE(inm_transaksi_griya.tanggal) >= '".$dari_."' AND DATE(inm_transaksi_griya.tanggal) <= '".$sampai_."'
  //     GROUP BY
  //       inm_transaksi_griya.tanggal";
  //     return $this->db->query($str);

      $str="";
    $str .="SELECT ";
    
    foreach($datas as $data){
      $str .=" Sum(IF(produk_id =".$data->id.", jumlah_transaksi, 0)) AS 'Jumlah ".$data->nama_produk."', ";
      $str .=" Sum(IF(produk_id =".$data->id.", rupiah_transaksi, 0)) AS 'Rupiah ".$data->nama_produk."', ";
    }
    $str .="inm_transaksi_griya.tanggal";

    $str .=" FROM inm_transaksi_griya
          WHERE inm_transaksi_griya.tanggal >= '".$from."' AND inm_transaksi_griya.tanggal <= '".$to."'
          GROUP BY inm_transaksi_griya.tanggal";
    // echo $str;
    return $this->db->query($str);
  }

  public function laporan_giry_bayar_per_user($from, $to, $datas){
    $str="";
    $str .="SELECT ";
    
    foreach($datas as $data){
      $str .=" Sum(IF(produk_id =".$data->id.", jumlah_transaksi, 0)) AS 'Jumlah ".$data->nama_produk."', ";
      $str .=" Sum(IF(produk_id =".$data->id.", rupiah_transaksi, 0)) AS 'Rupiah ".$data->nama_produk."', ";
    }
    $str .="inm_transaksi_griya.nama";

    $str .=" FROM inm_transaksi_griya
          WHERE inm_transaksi_griya.tanggal >= '".$from."' AND inm_transaksi_griya.tanggal <= '".$to."'
          GROUP BY inm_transaksi_griya.nama";
    return $this->db->query($str);
          
    // echo $str;

    // $str="SELECT
    //         Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.jumlah_transaksi,0)) AS PLN,
    //         Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PLN,
    //         Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.jumlah_transaksi,0)) AS PDAM,
    //         Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PDAM,
    //         inm_transaksi_griya.nama
    //       FROM
    //         inm_transaksi_griya
    //       INNER JOIN inm_produk ON inm_transaksi_griya.produk_id = inm_produk.id
    //       WHERE
    //       DATE(inm_transaksi_griya.tanggal) >= '".$dari_."' AND DATE(inm_transaksi_griya.tanggal) <= '".$sampai_."'
    //       GROUP BY
    //         inm_transaksi_griya.nama";
    //       return $this->db->query($str);            
  }

  public function getExtraInfo($nama)
  {

    $str ="SELECT
                Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.jumlah_transaksi,0)) AS PLN,
                Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PLN,
                Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.jumlah_transaksi,0)) AS PDAM,
                Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PDAM,
                inm_transaksi_griya.username
              FROM
                inm_transaksi_griya
              INNER JOIN inm_produk ON inm_transaksi_griya.produk_id = inm_produk.id
              WHERE
                inm_transaksi_griya.nama = '".$nama."'
              GROUP BY
                inm_transaksi_griya.username";

      return $this->db->query($str);
  }  

  public function get_nama_produk()
  {
      $this->db->select('*');
      $this->db->from('inm_produk');
      $this->db->where('status_id', 1);
      return $this->db->get();
  }    

  public function get_produk_griya()
  {
      $this->db->select('*');
      $this->db->from('griya_produk');
      return $this->db->get();
  }

  public function get_produk_griya2($nama){
      $this->db->select('*');
      $this->db->from('griya_produk');
      $this->db->where('nama_produk', $nama);
      return $this->db->get();
  }

  public function cek_data_transaksi_griya($id, $tgl){
      $this->db->select('*');
      $this->db->from('inm_transaksi_griya');
      $this->db->where('produk_id', $id);
      $this->db->where('tanggal', $tgl);
      return $this->db->get();
  }

  public function insert_laporan_transaksi_griya($data){
      $insert = $this->db->insert_batch('inm_transaksi_griya', $data);
      if($insert){
        return true;
      }
      else{
        return false;
      }
  }

  public function insert_laporan_bukopin($data){
      $insert = $this->db->insert_batch('inm_transaksi_bukopin', $data);
      if($insert){
        return true;
      }
      else{
        return false;
      }
    }
  
    public function cek_data_bukopin($tgl){
      $this->db->select('*');
      $this->db->from('inm_transaksi_bukopin');
      // $this->db->where('produk_id', $id);
      $this->db->where('tgl_dari', $tgl['from_date']);
      $this->db->where('tgl_sampai', $tgl['to_date']);
      return $this->db->get();
  }

  public function get_name_product_bukopin(){
      $this->db->select('*');
      $this->db->from('bukopin_produk');
      $this->db->order_by('nama_produk', 'ASC');
      return $this->db->get()->result();
  }

  public function get_trx_per_tgl_bukopin($from, $to, $datas){
    $str="";
    $str .="SELECT ";

    foreach($datas as $data){
      $str .=" Sum(IF(produk_id =".$data->id.", lembar, 0)) AS 'Lembar ".$data->nama_produk."', ";
      $str .=" Sum(IF(produk_id =".$data->id.", total, 0)) AS 'Total ".$data->nama_produk."', ";
    }
    $str .="inm_transaksi_bukopin.tgl_dari AS tgl_dari, inm_transaksi_bukopin.tgl_sampai AS tgl_sampai";

    $str .=" FROM inm_transaksi_bukopin
          WHERE inm_transaksi_bukopin.tgl_dari >= '".$from."' AND inm_transaksi_bukopin.tgl_sampai <= '".$to."'
          GROUP BY
          inm_transaksi_bukopin.tgl_dari,
          inm_transaksi_bukopin.tgl_sampai";
    // echo $str;
    return $this->db->query($str);
  }

  public function get_trx_per_user_bukopin($from, $to, $datas){
    $str="";
    $str .="SELECT ";
    // $str ="SELECT
    //         inm_transaksi_bukopin.loket AS loket,
    //         Sum(IF(nama_produk = 'BPJS Kesehatan', lembar, 0)) AS lembar_BPJS_Kesehatan,
    //         Sum(IF(nama_produk = 'BPJS Kesehatan', total, 0)) AS rupiah_BPJS_Kesehatan,
    //         Sum(IF(nama_produk = 'PDAM TIRTAULI KOTA PEMATANGSIANTAR', lembar, 0)) AS lembar_PDAM_TIRTAULI_PEMATANGSIANTAR,
    //         Sum(IF(nama_produk = 'PDAM TIRTAULI KOTA PEMATANGSIANTAR', total, 0)) AS rupiah_PDAM_TIRTAULI_PEMATANGSIANTAR,
    //         Sum(IF(nama_produk = 'PDAM TIRTA UMBU KAB. NIAS', lembar, 0)) AS lembar_PDAM_TIRTA_UMBU,
    //         Sum(IF(nama_produk = 'PDAM TIRTA UMBU KAB. NIAS', total, 0)) AS rupiah_PDAM_TIRTA_UMBU,
    //         Sum(IF(nama_produk = 'PDAM TIRTANADI', lembar, 0)) AS lembar_PDAM_TIRTANADI,
    //         Sum(IF(nama_produk = 'PDAM TIRTANADI', total, 0)) AS rupiah_PDAM_TIRTANADI,
    //         Sum(IF(nama_produk = 'PDAM TIRTA BULIAN TB.TINGGI SUMUT', lembar, 0)) AS lembar_PDAM_TIRTA_BULIAN,
    //         Sum(IF(nama_produk = 'PDAM TIRTA BULIAN TB.TINGGI SUMUT', total, 0)) AS rupiah_PDAM_TIRTA_BULIAN,
    //         Sum(IF(nama_produk = 'PLN Non Taglis', lembar, 0)) AS lembar_PLN_Non_Taglis,
    //         Sum(IF(nama_produk = 'PLN Non Taglis', total, 0)) AS rupiah_PLN_Non_Taglis,
    //         Sum(IF(nama_produk = 'PLN Postpaid', lembar, 0)) AS lembar_PLN_Postpaid,
    //         Sum(IF(nama_produk = 'PLN Postpaid', total, 0)) AS rupiah_PLN_Postpaid,
    //         Sum(IF(nama_produk = 'Pulsa Listrik', lembar, 0)) AS lembar_Pulsa_Listrik,
    //         Sum(IF(nama_produk = 'Pulsa Listrik', total, 0)) AS rupiah_Pulsa_Listrik,
    //         Sum(IF(nama_produk = 'Telkom', lembar, 0)) AS lembar_Telkom,
    //         Sum(IF(nama_produk = 'Telkom', total, 0)) AS rupiah_Telkom,
    //         Sum(IF(nama_produk = 'V Pulsa Telkomsel', lembar, 0)) AS lembar_V_Pulsa_Telkomsel,
    //         Sum(IF(nama_produk = 'V Pulsa Telkomsel', total, 0)) AS rupiah_V_Pulsa_Telkomsel
    //       FROM inm_transaksi_bukopin
    //       WHERE inm_transaksi_bukopin.tgl_dari >= '".$from."' AND inm_transaksi_bukopin.tgl_sampai <= '".$to."'
    //       GROUP BY inm_transaksi_bukopin.loket";
    foreach($datas as $data){
      $str .=" Sum(IF(produk_id =".$data->id.", lembar, 0)) AS 'Lembar ".$data->nama_produk."', ";
      $str .=" Sum(IF(produk_id =".$data->id.", total, 0)) AS 'Total ".$data->nama_produk."', ";
    }
    $str .="inm_transaksi_bukopin.loket AS loket";
    
    $str .=" FROM inm_transaksi_bukopin
          WHERE inm_transaksi_bukopin.tgl_dari >= '".$from."' AND inm_transaksi_bukopin.tgl_sampai <= '".$to."'
          GROUP BY inm_transaksi_bukopin.loket";

    // echo $str;
    return $this->db->query($str); 
  }

  public function get_detail_trx_loket_bukopin($loket, $dari, $sampai){
    $this->db->select("*");
    $this->db->from("inm_transaksi_bukopin");
    $this->db->where("loket", $loket);
    $this->db->where("tgl_dari >=", $dari);
    $this->db->where("tgl_sampai <=", $sampai);
    return $this->db->get()->result();
  }

  public function get_produk_bukopin($nama)
  {
    $this->db->select('id, nama_produk');
    $this->db->from('bukopin_produk');
    $this->db->where('nama_produk', $nama);
    return $this->db->get()->num_rows();
  }

  public function insert_produk_bukopin($data)
  {
    return $this->db->insert('bukopin_produk', $data);
  }

  public function get_produk_id_bukopin($nama)
  {
    $this->db->select('id');
    $this->db->from('bukopin_produk');
    $this->db->where('nama_produk', $nama);
    return $this->db->get()->row_array();
  }  
}
