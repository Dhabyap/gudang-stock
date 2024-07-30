<?php
defined('BASEPATH') or exit('No direct script access allowed');

define('ENCRYPTION_KEY', 'dhaby');

function encrypt($data)
{
  $cipher = "aes-256-cbc";
  $key = hash('sha256', ENCRYPTION_KEY, true);
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
  $encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);

  return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($iv . $encrypted));
}

function decrypt($data)
{
  $cipher = "aes-256-cbc";
  $key = hash('sha256', ENCRYPTION_KEY, true);

  $data = str_replace(['-', '_'], ['+', '/'], $data);
  $data = base64_decode($data);

  $iv_length = openssl_cipher_iv_length($cipher);
  $iv = substr($data, 0, $iv_length);
  $encrypted = substr($data, $iv_length);

  return openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);
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

