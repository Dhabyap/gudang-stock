<?php
defined('BASEPATH') or exit('No direct script access allowed');

define('ENCRYPTION_KEY', 'dhaby');

function encrypt($data)
{
  if ($data) {
    $cipher = "aes-256-cbc";
    $key = hash('sha256', ENCRYPTION_KEY, true);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($iv . $encrypted));
  } else {
    return 0;
  }
}

function decrypt($data)
{
  if ($data) {
    $cipher = "aes-256-cbc";
    $key = hash('sha256', ENCRYPTION_KEY, true);

    $data = str_replace(['-', '_'], ['+', '/'], $data);
    $data = base64_decode($data);

    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);

    return openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);
  } else {
    return 0;
  }
}

function staticPath()
{
  $ci = &get_instance();
  return $ci->config->item('static_path');
}

function rupiah($nilai)
{
  return "Rp. " . number_format($nilai, 0, ',', '.');
}

function tgl_indo($tgl)
{
  $ubah = gmdate($tgl, time() + 60 * 60 * 8);
  $pisah = explode(" ", $ubah);
  $pecah = explode("-", $pisah[0]);
  $tanggal = $pecah[2];
  $bulan = nama_bulan($pecah[1]);
  $tahun = $pecah[0];
  return $tanggal . ' ' . $bulan . ' ' . $tahun . ' pukul ' . substr($pisah[1], 0, 5);
}

function month()
{
  return [
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December',
  ];
  ;
}

function nama_bulan($bln)
{
  $CI = &get_instance();

  switch ($bln) {
    case 1:
      return "Januari";
      break;
    case 2:
      return "Februari";
      break;
    case 3:
      return "Maret";
      break;
    case 4:
      return "April";
      break;
    case 5:
      return "Mei";
      break;
    case 6:
      return "Juni";
      break;
    case 7:
      return "Juli";
      break;
    case 8:
      return "Agustus";
      break;
    case 9:
      return "September";
      break;
    case 10:
      return "Oktober";
      break;
    case 11:
      return "November";
      break;
    case 12:
      return "Desember";
      break;
  }
}

function format_date_with_day($date)
{
  if ($date) {
    date_default_timezone_set('Asia/Jakarta');

    $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl = substr($date, 8, 2);
    $hari = date("w", strtotime($date));
    $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int) $bulan - 1] . " " . $tahun;

    return $result;

  }
}

